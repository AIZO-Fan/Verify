<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SimulatorController extends Controller
{
    /**
     * Display the phishing simulator page with all scenarios.
     */
    public function index(): View
    {
        $scenarios = $this->getScenariosArray();

        // Strip correct_answer, explanation, warning_signs, recommended_actions
        // from the client-side data to prevent cheating; they are only used in answer()
        $publicScenarios = array_map(function ($scenario) {
            return [
                'id'      => $scenario['id'],
                'title'   => $scenario['title'],
                'type'    => $scenario['type'],
                'content' => $scenario['content'],
            ];
        }, $scenarios);

        return view('simulator.index', [
            'scenarios'       => $publicScenarios,
            'totalScenarios'  => count($scenarios),
        ]);
    }

    /**
     * Validate a user's answer for a simulator scenario.
     * Returns JSON with correctness, explanation, warning signs, and recommended actions.
     */
    public function answer(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'scenario_id' => ['required', 'integer', 'min:1'],
            'answer'      => ['required', 'string', 'in:legitimate,suspicious'],
        ]);

        $scenarios = $this->getScenariosArray();

        // Find the matching scenario
        $scenario = collect($scenarios)->firstWhere('id', $validated['scenario_id']);

        if (!$scenario) {
            return response()->json([
                'error' => 'Scenario not found.',
            ], 404);
        }

        $correct = $validated['answer'] === $scenario['correct_answer'];

        return response()->json([
            'correct'              => $correct,
            'correct_answer'       => $scenario['correct_answer'],
            'explanation'          => $scenario['explanation'],
            'warning_signs'        => $scenario['warning_signs'],
            'recommended_actions'  => $scenario['recommended_actions'],
        ]);
    }

    /**
     * Return all simulator scenarios with their full data (including answers).
     * This data never leaves the server in its complete form.
     */
    private function getScenariosArray(): array
    {
        return [
            [
                'id'             => 1,
                'title'         => 'Fake Bank SMS',
                'type'          => 'SMS',
                'content'       => "Pesan masuk dari +62-800-BNI-FAKE:\n\n\"Yth. Nasabah BNI, akun Anda telah dikunci sementara karena aktivitas mencurigakan. Klik tautan berikut untuk memulihkan akses Anda segera: http://bni-secure-verify.tk/unlock\n\nAbaikan pesan ini jika akun Anda tidak bermasalah. — Tim Keamanan BNI\"",
                'correct_answer' => 'suspicious',
                'explanation'   => 'Ini adalah serangan smishing (SMS phishing). BNI atau bank resmi mana pun TIDAK PERNAH mengirimkan tautan pemulihan akun melalui SMS. Domain ".tk" adalah domain gratis yang sering digunakan penipu, bukan domain resmi BNI (bni.co.id).',
                'warning_signs' => [
                    'Domain mencurigakan menggunakan ".tk" (domain gratis), bukan "bni.co.id"',
                    'Menciptakan rasa urgensi palsu ("segera") untuk memaksa tindakan cepat',
                    'Bank resmi tidak pernah mengirim tautan pemulihan akun via SMS',
                    'Nomor pengirim tidak resmi (bukan nomor layanan resmi BNI 1500046)',
                    'URL berisi kata "verify" dan "secure" untuk terlihat meyakinkan padahal palsu',
                ],
                'recommended_actions' => [
                    'Jangan klik tautan apapun dalam pesan tersebut',
                    'Hubungi BNI langsung di 1500046 untuk memverifikasi kondisi akun',
                    'Laporkan nomor pengirim sebagai spam/phishing',
                    'Periksa akun melalui aplikasi resmi BNI Mobile Banking',
                    'Blokir nomor pengirim pesan tersebut',
                ],
            ],
            [
                'id'             => 2,
                'title'         => 'Phishing Email Google',
                'type'          => 'Email',
                'content'       => "Dari: support@g00gle-account.com\nKepada: Anda\nSubjek: [PENTING] Aktivitas masuk mencurigakan terdeteksi pada akun Anda\n\n\"Kami mendeteksi upaya masuk yang tidak biasa ke akun Google Anda dari lokasi baru:\n• Lokasi: Jakarta, Indonesia\n• Waktu: Hari ini, 03:14\n• Perangkat: Windows PC\n\nJika ini bukan Anda, segera amankan akun Anda sekarang dengan mengklik tautan di bawah ini:\n[AMANKAN AKUN SAYA]\n\nJika tidak diverifikasi dalam 24 jam, akun Anda akan ditangguhkan.\n\n— Tim Keamanan Google\"",
                'correct_answer' => 'suspicious',
                'explanation'   => 'Ini adalah email phishing klasik yang meniru Google. Perhatikan alamat pengirim "g00gle-account.com" — menggunakan angka "0" (nol) sebagai pengganti huruf "o". Domain asli Google adalah "google.com". Teknik ini disebut typosquatting.',
                'warning_signs' => [
                    'Alamat email pengirim "g00gle-account.com" menggunakan angka 0, bukan huruf o',
                    'Menciptakan rasa panik dan urgensi dengan ancaman penangguhan akun 24 jam',
                    'Google mengirim notifikasi keamanan langsung ke perangkat terdaftar, bukan via email seperti ini',
                    'Tidak ada detail spesifik yang hanya diketahui Google (misalnya nama lengkap)',
                    'Tombol CTA yang mendorong klik segera tanpa waktu berpikir',
                ],
                'recommended_actions' => [
                    'Jangan klik tautan apapun dalam email tersebut',
                    'Periksa aktivitas akun Google Anda langsung di myaccount.google.com',
                    'Aktifkan verifikasi 2 langkah (2FA) di akun Google Anda',
                    'Tandai email sebagai phishing di klien email Anda',
                    'Periksa alamat email pengirim dengan teliti sebelum mempercayai pesan apapun',
                ],
            ],
            [
                'id'             => 3,
                'title'         => 'Penipuan Hadiah Shopee',
                'type'          => 'Notifikasi',
                'content'       => "🎉 SELAMAT! Anda terpilih sebagai pemenang undian SHOPEE ANNIVERSARY!\n\nHadiah: Rp 5.000.000,-\n\nAnda adalah 1 dari 10 pelanggan beruntung yang terpilih secara acak dari seluruh Indonesia!\n\nKlaim hadiah Anda SEKARANG sebelum kedaluwarsa dalam 2 jam:\n👉 http://shopee-hadiah-anniversary.blogspot.com/klaim-rp5juta\n\nSyarat: Isi data diri lengkap dan bayar biaya administrasi Rp 150.000 untuk proses pengiriman hadiah.\n\n*Shopee Official Anniversary Program*",
                'correct_answer' => 'suspicious',
                'explanation'   => 'Ini adalah penipuan berhadiah (prize scam). Shopee tidak pernah menggunakan domain Blogspot untuk program resmi. "Biaya administrasi" untuk menerima hadiah adalah tanda merah terbesar — ini adalah modus umum di mana korban membayar untuk hadiah yang tidak pernah ada.',
                'warning_signs' => [
                    'Domain tidak resmi: menggunakan "blogspot.com" bukan "shopee.co.id"',
                    'Meminta biaya administrasi untuk menerima hadiah — tanda penipuan klasik',
                    'Tekanan waktu ekstrem: "kedaluwarsa dalam 2 jam"',
                    'Anda tidak pernah mendaftar untuk undian apapun',
                    'Pesan dikirim melalui saluran tidak resmi, bukan dari aplikasi Shopee',
                    'Hadiah terlalu besar dan tiba-tiba tanpa alasan jelas',
                ],
                'recommended_actions' => [
                    'Jangan klik tautan dan jangan bayar biaya administrasi apapun',
                    'Hadiah resmi Shopee hanya dikirim melalui aplikasi/email resmi Shopee',
                    'Laporkan ke Shopee melalui fitur bantuan resmi di aplikasi',
                    'Blokir dan laporkan akun/nomor yang mengirim pesan',
                    'Ingat: hadiah resmi tidak pernah meminta pembayaran di awal',
                ],
            ],
            [
                'id'             => 4,
                'title'         => 'Tawaran Kerja Palsu',
                'type'          => 'Pesan Teks',
                'content'       => "Halo! Perkenalkan saya dari HRD PT. MAJU BERSAMA SEJAHTERA.\n\nKami sedang membuka lowongan pekerjaan:\n📌 Posisi: Data Entry & Admin Online (WFH)\n💰 Gaji: Rp 15.000.000/bulan\n⏰ Jam kerja: Fleksibel (2-3 jam/hari)\n📋 Syarat: Min. SMA, bisa smartphone, tidak perlu pengalaman\n\nTertarik? Daftar sekarang!\nSyarat pendaftaran:\n1. Isi formulir data diri (link terlampir)\n2. Bayar biaya registrasi sebesar Rp 500.000 untuk seragam & modul pelatihan\n3. Konfirmasi ke nomor ini setelah transfer\n\nKesempatan terbatas! Hanya 5 slot tersisa.",
                'correct_answer' => 'suspicious',
                'explanation'   => 'Ini adalah penipuan lowongan kerja palsu (job scam). Tanda paling jelas adalah permintaan "biaya registrasi" — perusahaan resmi TIDAK PERNAH meminta calon karyawan membayar untuk melamar. Gaji Rp 15 juta untuk 2-3 jam kerja/hari tanpa pengalaman juga tidak realistis.',
                'warning_signs' => [
                    'Meminta biaya registrasi Rp 500.000 — perusahaan resmi tidak pernah melakukan ini',
                    'Gaji tidak realistis (Rp 15 juta) untuk pekerjaan minimal tanpa pengalaman',
                    'Jam kerja sangat singkat (2-3 jam/hari) untuk gaji sangat besar',
                    'Dikirim melalui pesan pribadi, bukan melalui platform rekrutmen resmi',
                    'Tekanan "kesempatan terbatas" dan "5 slot tersisa" untuk memaksa keputusan cepat',
                    'Tidak ada alamat kantor, website resmi, atau identitas perusahaan yang dapat diverifikasi',
                ],
                'recommended_actions' => [
                    'Jangan transfer uang apapun dengan alasan apapun untuk melamar kerja',
                    'Verifikasi keberadaan perusahaan melalui Google, LinkedIn, atau Kemenaker',
                    'Cek lowongan kerja hanya di platform resmi (LinkedIn, JobStreet, Glints, Kalibrr)',
                    'Laporkan penipuan ke Kementerian Ketenagakerjaan atau Bareskrim Polri',
                    'Bagikan informasi ini kepada orang-orang di sekitar Anda agar tidak menjadi korban',
                ],
            ],
            [
                'id'             => 5,
                'title'         => 'Penipuan OTP GoPay via WhatsApp',
                'type'          => 'WhatsApp',
                'content'       => "Pesan WhatsApp dari nomor tidak dikenal:\n\n\"Halo, saya dari Tim Keamanan GoPay. Kami mendeteksi akun GoPay Anda (082xxx-xxxx) akan dinonaktifkan dalam 24 jam karena tidak memenuhi syarat KYC terbaru.\n\nUntuk mencegah penonaktifan, Anda harus memverifikasi akun segera:\n\n1. Kami akan mengirim kode OTP ke nomor Anda\n2. Bagikan kode OTP tersebut kepada kami untuk verifikasi\n3. Proses selesai dalam 5 menit\n\nJika tidak diverifikasi, saldo GoPay Anda akan hangus. Hubungi kami sekarang!\"\n\n[Penipu sedang menunggu Anda membalas dengan kode OTP]",
                'correct_answer' => 'suspicious',
                'explanation'   => 'Ini adalah serangan social engineering untuk mencuri OTP. OTP (One-Time Password) adalah kode rahasia yang TIDAK PERNAH boleh dibagikan kepada siapapun — termasuk pihak yang mengaku dari GoPay, bank, atau layanan apapun. Pihak resmi GoPay tidak pernah meminta OTP melalui WhatsApp.',
                'warning_signs' => [
                    'GoPay/perusahaan resmi TIDAK PERNAH meminta OTP melalui WhatsApp atau telepon',
                    'OTP bersifat rahasia dan hanya untuk digunakan oleh pemilik akun sendiri',
                    'Pesan dikirim dari nomor WhatsApp pribadi, bukan akun bisnis resmi GoPay',
                    'Ancaman "saldo hangus" untuk menciptakan ketakutan dan kepanikan',
                    'Meminta Anda untuk memulai proses (membalas pesan) — taktik manipulasi sosial',
                    'GoPay berkomunikasi melalui aplikasi resmi, email, atau nomor CS resmi 1500-181',
                ],
                'recommended_actions' => [
                    'JANGAN bagikan kode OTP kepada siapapun dengan alasan apapun',
                    'Hentikan komunikasi dengan nomor tersebut segera',
                    'Blokir dan laporkan nomor sebagai penipuan di WhatsApp',
                    'Hubungi CS GoPay resmi di 1500-181 untuk memverifikasi kondisi akun',
                    'Aktifkan PIN GoPay dan autentikasi biometrik sebagai lapisan keamanan tambahan',
                    'Laporkan ke GoJek melalui aplikasi atau email resmi mereka',
                ],
            ],
        ];
    }
}
