<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class UrlVerificationService
{
    private array $suspiciousPatterns = [
        // Suspicious TLDs
        '/\.(tk|ml|ga|cf|gq|xyz|top|pw|cc|su|nu|click|download|stream|zip|mov)$/i',
        // IP address URLs
        '/^https?:\/\/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/i',
        // Excessive subdomains (phishing pattern)
        '/([a-z0-9-]+\.){4,}/i',
        // Brand impersonation keywords
        '/\b(paypa1|g00gle|faceb00k|amaz0n|apple-id|microsoft-secure|banking-secure|verify-account|account-suspended|update-payment|confirm-identity)\b/i',
        // Obfuscated URLs
        '/(%[0-9a-f]{2}){5,}/i',
        // Suspicious keywords in URL path
        '/(login|signin|account|verify|secure|update|confirm|password|credential|banking).*\.(tk|ml|ga|cf|gq|xyz|pw)/i',
    ];

    private array $dangerousPatterns = [
        // Known malware distribution paths
        '/\/(malware|virus|trojan|keylogger|ransomware)\//i',
        // Executable file downloads
        '/\.(exe|bat|cmd|vbs|ps1|msi|dmg|apk|deb)(\?.*)?$/i',
        // Phishing-specific patterns
        '/[a-z0-9-]+(paypal|amazon|apple|google|microsoft|facebook|instagram|tiktok|tokopedia|shopee|gojek|grab|bca|mandiri|bni|bri)[a-z0-9-]*\.(tk|ml|ga|cf|gq|xyz|top|pw|info|biz|site|online|store)/i',
    ];

    /**
     * Verify a URL and return a structured result.
     */
    public function verify(string $url): array
    {
        // 1. Validate URL format
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->buildResult('unknown', 'Invalid URL format.', [], $url);
        }

        // 2. Parse URL
        $parsed = parse_url($url);
        if (!$parsed || !isset($parsed['host'])) {
            return $this->buildResult('unknown', 'Could not parse URL.', [], $url);
        }

        // 3. Validate scheme (only http/https)
        $scheme = strtolower($parsed['scheme'] ?? '');
        if (!in_array($scheme, ['http', 'https'])) {
            return $this->buildResult('dangerous', 'URL uses a non-HTTP scheme which may be dangerous.', [
                'Non-standard protocol detected',
                'Only http:// and https:// URLs are supported',
            ], $url);
        }

        // 4. SSRF prevention: block private/loopback IPs and reserved hostnames
        $host = strtolower($parsed['host']);
        $ssrfBlock = $this->checkSsrf($host);
        if ($ssrfBlock) {
            return $this->buildResult('dangerous', 'URL targets a private or reserved network address.', [
                'Private/loopback IP or hostname detected',
                'This type of URL can be used in Server-Side Request Forgery attacks',
            ], $url);
        }

        // 5. Cache result for 1 hour to avoid repeated API calls
        $cacheKey = 'url_check_' . md5($url);
        $cached = Cache::get($cacheKey);
        if ($cached) {
            $cached['from_cache'] = true;
            return $cached;
        }

        // 6. Check against Google Safe Browsing API if key is configured
        $apiKey = config('services.google_safe_browsing.key');
        if ($apiKey) {
            try {
                $gsbResult = $this->checkGoogleSafeBrowsing($url, $apiKey);
                if ($gsbResult !== null) {
                    $result = $this->buildResult(
                        $gsbResult['status'],
                        $gsbResult['message'],
                        $gsbResult['threats'],
                        $url,
                        'Google Safe Browsing'
                    );
                    Cache::put($cacheKey, $result, 3600);
                    return $result;
                }
            } catch (\Exception $e) {
                Log::warning('Google Safe Browsing API error: ' . $e->getMessage());
                // Fall through to heuristic checks
            }
        }

        // 7. Heuristic pattern matching
        $heuristicResult = $this->runHeuristicChecks($url, $host);
        Cache::put($cacheKey, $heuristicResult, 1800); // 30 min cache for heuristics
        return $heuristicResult;
    }

    /**
     * Check for SSRF-risky hosts.
     */
    private function checkSsrf(string $host): bool
    {
        // Block localhost variants
        if (in_array($host, ['localhost', '127.0.0.1', '::1', '0.0.0.0'])) {
            return true;
        }
        // Block .local domains
        if (str_ends_with($host, '.local') || str_ends_with($host, '.internal')) {
            return true;
        }
        // Block private IP ranges if host is an IP
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            if (filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
                return true;
            }
        }
        // Block cloud metadata endpoints
        if (in_array($host, ['169.254.169.254', 'metadata.google.internal'])) {
            return true;
        }
        return false;
    }

    /**
     * Query Google Safe Browsing API v4.
     */
    private function checkGoogleSafeBrowsing(string $url, string $apiKey): ?array
    {
        $endpoint = 'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . $apiKey;

        $payload = [
            'client' => [
                'clientId'      => 'verify-platform',
                'clientVersion' => '1.0.0',
            ],
            'threatInfo' => [
                'threatTypes'      => ['MALWARE', 'SOCIAL_ENGINEERING', 'UNWANTED_SOFTWARE', 'POTENTIALLY_HARMFUL_APPLICATION'],
                'platformTypes'    => ['ANY_PLATFORM'],
                'threatEntryTypes' => ['URL'],
                'threatEntries'    => [['url' => $url]],
            ],
        ];

        $response = Http::timeout(5)->post($endpoint, $payload);

        if (!$response->successful()) {
            return null; // API unavailable
        }

        $data = $response->json();

        if (empty($data['matches'])) {
            return [
                'status'  => 'safe',
                'message' => 'No threats detected by Google Safe Browsing. Note: this does not guarantee the URL is completely safe.',
                'threats' => [],
            ];
        }

        $threats    = array_map(fn($m) => $m['threatType'], $data['matches']);
        $hasMalware = in_array('MALWARE', $threats);

        return [
            'status'  => $hasMalware ? 'dangerous' : 'suspicious',
            'message' => 'Threats detected by Google Safe Browsing: ' . implode(', ', $threats),
            'threats' => $threats,
        ];
    }

    /**
     * Run heuristic pattern matching checks.
     */
    private function runHeuristicChecks(string $url, string $host): array
    {
        $warnings       = [];
        $dangerScore    = 0;
        $suspiciousScore = 0;

        // Check dangerous patterns first
        foreach ($this->dangerousPatterns as $pattern) {
            if (preg_match($pattern, $url)) {
                $dangerScore += 2;
                $warnings[] = 'URL matches a known dangerous pattern';
            }
        }

        // Check suspicious patterns
        foreach ($this->suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $url)) {
                $suspiciousScore++;
                $warnings[] = match (true) {
                    str_contains($pattern, 'tk|ml')   => 'URL uses a free/suspicious top-level domain',
                    str_contains($pattern, '\d{1,3}') => 'URL uses an IP address instead of a domain name',
                    str_contains($pattern, '{4,}')    => 'URL has an unusual number of subdomains',
                    str_contains($pattern, 'paypa1')  => 'URL contains brand impersonation keywords',
                    str_contains($pattern, '%')       => 'URL contains excessive URL encoding (obfuscation)',
                    default                           => 'URL matches a suspicious pattern',
                };
            }
        }

        // Check HTTPS
        if (!str_starts_with($url, 'https://')) {
            $suspiciousScore++;
            $warnings[] = 'URL does not use HTTPS encryption';
        }

        // Check domain length (very long domains are suspicious)
        if (strlen($host) > 50) {
            $suspiciousScore++;
            $warnings[] = 'Domain name is unusually long';
        }

        $warnings = array_unique($warnings);

        if ($dangerScore >= 2) {
            return $this->buildResult('dangerous', 'This URL shows multiple high-risk indicators and may be dangerous.', array_values($warnings), $url, 'Heuristic Analysis');
        }

        if ($suspiciousScore >= 2) {
            return $this->buildResult('suspicious', 'This URL has several characteristics commonly associated with phishing or scam websites.', array_values($warnings), $url, 'Heuristic Analysis');
        }

        if ($suspiciousScore === 1) {
            return $this->buildResult('suspicious', 'This URL has at least one characteristic that may indicate a risk. Exercise caution.', array_values($warnings), $url, 'Heuristic Analysis');
        }

        return $this->buildResult('unknown', 'No threat patterns detected. However, automated checks cannot guarantee safety. Always verify the source independently. Note: Google Safe Browsing API is not configured.', [], $url, 'Heuristic Analysis');
    }

    /**
     * Build a standardized result array.
     */
    private function buildResult(string $status, string $message, array $warnings, string $url, string $source = 'VERIFY'): array
    {
        return [
            'status'      => $status,
            'url'         => $url,
            'message'     => $message,
            'warnings'    => $warnings,
            'source'      => $source,
            'checked_at'  => now()->toISOString(),
            'disclaimer'  => 'Automated URL verification is not 100% reliable. No threat match does not guarantee a URL is completely safe. Use multiple verification methods for critical decisions.',
            'from_cache'  => false,
        ];
    }
}
