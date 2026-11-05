<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = [
            [
                'title'       => 'CISA: Phishing Guidance and Resources',
                'description' => 'The Cybersecurity and Infrastructure Security Agency (CISA) provides comprehensive guidance on recognizing, avoiding, and reporting phishing attacks targeting individuals and organizations.',
                'source_name' => 'CISA (Cybersecurity and Infrastructure Security Agency)',
                'url'         => 'https://www.cisa.gov',
                'category'   => 'Phishing',
            ],
            [
                'title'       => 'FTC Consumer Information: How to Recognize and Avoid Phishing Scams',
                'description' => 'The Federal Trade Commission offers practical advice on spotting phishing emails, texts, and phone calls, and explains what steps to take if you have been targeted.',
                'source_name' => 'FTC Consumer Information',
                'url'         => 'https://consumer.ftc.gov',
                'category'   => 'Phishing',
            ],
            [
                'title'       => 'SANS Internet Stormcast: Daily Cybersecurity News',
                'description' => 'The SANS Institute provides daily threat intelligence briefings and in-depth security awareness training resources to help individuals and teams stay ahead of evolving cyber threats.',
                'source_name' => 'SANS Institute',
                'url'         => 'https://www.sans.org',
                'category'   => 'Online Security',
            ],
            [
                'title'       => 'NIST Cybersecurity Framework',
                'description' => 'The National Institute of Standards and Technology publishes the widely adopted Cybersecurity Framework, offering guidelines for organizations to manage and reduce cybersecurity risk.',
                'source_name' => 'NIST (National Institute of Standards and Technology)',
                'url'         => 'https://www.nist.gov',
                'category'   => 'Online Security',
            ],
            [
                'title'       => 'Have I Been Pwned: Check if Your Email Has Been Compromised',
                'description' => 'Have I Been Pwned allows users to check whether their email address or phone number has appeared in known data breaches, helping people understand their exposure and take protective action.',
                'source_name' => 'Have I Been Pwned',
                'url'         => 'https://haveibeenpwned.com',
                'category'   => 'Identity Protection',
            ],
            [
                'title'       => 'Krebs on Security: In-Depth Security News and Investigation',
                'description' => 'Written by veteran security journalist Brian Krebs, this blog delivers investigative reporting on cybercrime, data breaches, identity theft, and the criminal underground ecosystem.',
                'source_name' => 'Krebs on Security',
                'url'         => 'https://krebsonsecurity.com',
                'category'   => 'Identity Protection',
            ],
            [
                'title'       => 'Google Safety Center: Staying Safe Online',
                'description' => 'Google\'s Safety Center offers guidance on account security, safe browsing practices, managing privacy settings, and tools to protect your identity and devices from digital threats.',
                'source_name' => 'Google Safety Center',
                'url'         => 'https://safety.google',
                'category'   => 'Safe Browsing',
            ],
            [
                'title'       => 'NCSC UK: Cyber Aware Guidance',
                'description' => 'The UK\'s National Cyber Security Centre provides official government-backed cybersecurity guidance for citizens, covering topics such as password hygiene, phishing, and securing home networks.',
                'source_name' => 'National Cyber Security Centre UK',
                'url'         => 'https://www.ncsc.gov.uk',
                'category'   => 'Safe Browsing',
            ],
            [
                'title'       => 'APWG: Anti-Phishing Working Group Reports',
                'description' => 'The Anti-Phishing Working Group (APWG) publishes quarterly eCrime trend reports and maintains a global repository of phishing data to help researchers, law enforcement, and the public understand phishing at scale.',
                'source_name' => 'APWG (Anti-Phishing Working Group)',
                'url'         => 'https://apwg.org',
                'category'   => 'Scam Awareness',
            ],
            [
                'title'       => 'PhishTank: Community Anti-Phishing Database',
                'description' => 'PhishTank is a free community site where anyone can submit, verify, track, and share phishing data. It is used by developers and researchers to identify and block known phishing URLs.',
                'source_name' => 'PhishTank',
                'url'         => 'https://www.phishtank.org',
                'category'   => 'Scam Awareness',
            ],
            [
                'title'       => 'NIST: Digital Identity Guidelines (SP 800-63)',
                'description' => 'NIST Special Publication 800-63 provides technical guidelines for digital identity verification, authentication, and federation. Essential reading for understanding how identity systems should be built securely.',
                'source_name' => 'NIST (National Institute of Standards and Technology)',
                'url'         => 'https://www.nist.gov',
                'category'   => 'Password Security',
            ],
            [
                'title'       => 'NCSC UK: Password Security Guidance',
                'description' => 'The NCSC UK shares evidence-based guidance on creating strong passwords, using password managers, enabling multi-factor authentication, and avoiding common password pitfalls.',
                'source_name' => 'National Cyber Security Centre UK',
                'url'         => 'https://www.ncsc.gov.uk',
                'category'   => 'Password Security',
            ],
        ];

        foreach ($resources as $resource) {
            Resource::firstOrCreate(
                ['title' => $resource['title']],
                $resource
            );
        }
    }
}
