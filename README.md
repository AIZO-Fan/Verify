# VERIFY — Digital Scam Awareness & Link Verification Platform

VERIFY adalah platform edukasi keamanan digital dan verifikasi tautan yang dibangun menggunakan **Laravel 13**, **PHP 8.3+**, **Blade Templates**, **Tailwind CSS**, **Alpine.js**, dan **MySQL**.

Platform ini mengusung pendekatan **Guest First, Account Optional**: pengguna dapat langsung mengakses semua fitur utama (pemeriksaan tautan, modul pembelajaran, sumber daya, dan scam simulator) tanpa harus mendaftar atau login terlebih dahulu. Autentikasi opsional disediakan bagi pengguna yang ingin menyimpan dan menyinkronkan riwayat pengecekan tautan secara permanen lintas perangkat.

---

## 🚀 Fitur Utama

1. **Guest First, Account Optional**
   - Tamu dapat mengecek tautan, mencoba simulator, dan membaca modul secara instan.
   - Riwayat tamu disimpan di `localStorage` peramban.
   - Tersedia tombol sekali klik untuk menyinkronkan riwayat lokal tamu ke akun setelah login.

2. **Deteksi & Verifikasi Tautan (URL Checker)**
   - Proteksi multi-lapis: validasi skema HTTP/HTTPS, pencegahan SSRF (Server-Side Request Forgery) memblokir localhost, IP privat, dan metadata AWS/Google Cloud.
   - Integrasi Google Safe Browsing API v4 bila `GOOGLE_SAFE_BROWSING_KEY` dikonfigurasi.
   - Analisis heuristik cerdas (TLD berisiko, kata kunci phishing, brand impersonation, obfuscation).
   - Label status transparan: **Safe**, **Suspicious**, **Dangerous**, dan **Unknown** disertai disclaimer keamanan.

3. **8 Modul Pembelajaran Interaktif**
   - Phishing Scams, Online Shopping Scams, Investment Scams, Social Engineering, Fake Websites, Account Takeover, OTP Scams, Digital Identity Theft.
   - Dilengkapi penjelasan komprehensif, karakteristik umum, contoh fiktif realistis, metode pencegahan, dan ringkasan.

4. **Pusat Sumber Daya Keamanan Terverifikasi**
   - Menggunakan rujukan dari lembaga resmi dunia (CISA, FTC, NIST, SANS Institute, Have I Been Pwned, APWG).

5. **Scam Simulator Interaktif**
   - 5 skenario nyata (SMS perbankan palsu, email phishing akun Google, promo hadiah marketplace fiktif, tawaran lowongan kerja penipu, manipulasi kode OTP WhatsApp).
   - Umpan balik real-time, analisis Red Flags, dan aksi pencegahan yang direkomendasikan.

6. **Panel Administrator (Role-Based Access Control)**
   - Terproteksi oleh middleware `admin` dan verifikasi peran pengguna.
   - Manajemen penuh CRUD Modul Pembelajaran (dengan upload gambar) dan Sumber Daya.
   - Pemantauan metrik pengguna terdaftar dan 10 aktivitas pengecekan tautan terakhir.

---

## 📂 Struktur Direktori Proyek

```
verify/
├── api/
│   └── index.php                    # Front controller serverless untuk Vercel
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/               # AdminDashboard, AdminModule, AdminResource, AdminUserController
│   │   │   ├── Auth/                # Login, Register, Forgot Password, Reset Password
│   │   │   ├── CheckLinkController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── HistoryController.php
│   │   │   ├── HowItWorksController.php
│   │   │   ├── ModuleController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── ResourceController.php
│   │   │   ├── SettingsController.php
│   │   │   └── SimulatorController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php  # Proteksi role admin
│   ├── Models/
│   │   ├── CheckHistory.php
│   │   ├── Module.php
│   │   ├── Resource.php
│   │   └── User.php
│   ├── Policies/
│   │   └── CheckHistoryPolicy.php
│   └── Services/
│       └── UrlVerificationService.php # Layanan utama analisis keamanan tautan & SSRF check
├── database/
│   ├── migrations/                  # Skema database users, modules, resources, check_histories
│   └── seeders/                     # Seeder 8 modul, 10+ referensi, akun Admin & Demo User
├── resources/
│   └── views/
│       ├── admin/                   # Tampilan Admin Dashboard & CRUD
│       ├── auth/                    # Tampilan Login, Register, Reset Password
│       ├── check-link/              # Tampilan Form Pengecekan & Hasil Verifikasi
│       ├── components/              # Navbar, Footer, Module Card, Alert, URL Checker
│       ├── errors/                  # Halaman 403 & 404 kustom
│       ├── history/                 # Riwayat pengecekan & impor riwayat tamu
│       ├── how-it-works/            # Panduan edukasi cara kerja sistem
│       ├── layouts/                 # app.blade.php & admin.blade.php
│       ├── modules/                 # Indeks modul & detail materi
│       ├── profile/                 # Profil pengguna & ubah kata sandi
│       ├── resources/               # Katalog referensi keamanan
│       ├── settings/                # Preferensi tampilan, bahasa, tentang sistem
│       └── simulator/               # Simulator scam interaktif (Alpine.js)
├── routes/
│   ├── auth.php                     # Rute autentikasi
│   └── web.php                      # Rute aplikasi & rute admin terproteksi
├── vercel.json                      # Konfigurasi deployment serverless Vercel
└── .vercelignore                    # Proteksi file privat saat build Vercel
```

---

## ⚙️ Persyaratan Sistem

- **PHP**: Versi 8.3 atau yang lebih baru (dengan ekstensi `pdo`, `pdo_mysql` / `pdo_sqlite`, `curl`, `mbstring`, `openssl`).
- **Composer**: Versi 2.x
- **MySQL**: Versi 8.0+ atau MariaDB 10.4+ (atau SQLite untuk uji coba instan).
- **Node.js & npm** (opsional untuk aset lokal; platform memanfaatkan Tailwind & Alpine CDN).

---

## 🛠️ Langkah Instalasi Lokal

### 1. Masuk ke Direktori Proyek
```bash
cd verify
```

### 2. Instalasi Dependensi PHP
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file konfigurasi lingkungan:
```bash
copy .env.example .env
php artisan key:generate
```

Ubah pengaturan database di file `.env` sesuai server MySQL Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=verify_db
DB_USERNAME=root
DB_PASSWORD=

# Opsional: Google Safe Browsing API v4
GOOGLE_SAFE_BROWSING_KEY=
```

> **Catatan Uji Coba Cepat:** Jika server MySQL lokal Anda belum dinyalakan, Anda dapat menggunakan SQLite secara instan dengan mengatur:
> `DB_CONNECTION=sqlite`

### 4. Migrasi & Seeder Database
Jalankan migrasi seluruh tabel serta isi data bawaan:
```bash
php artisan migrate:fresh --seed
```

### 5. Hubungkan Folder Upload Media
```bash
php artisan storage:link
```

### 6. Jalankan Server Lokal
```bash
php artisan serve
```
Akses platform melalui peramban di: **`http://127.0.0.1:8000`**

---

## 👤 Akun Bawaan untuk Pengujian

Database seeder telah menyiapkan dua akun uji coba:

| Peran | Alamat Email | Kata Sandi | Hak Akses |
|---|---|---|---|
| **Administrator** | `admin@verify.com` | `admin123` | Akses penuh: `/admin` (Manajemen Modul, Sumber Daya, Daftar User, Metrik) |
| **Pengguna Biasa** | `user@verify.com` | `user123` | Akses fitur publik, simpan riwayat di MySQL, kelola profil |

---

## 🌐 Panduan Deployment (GitHub & Vercel)

### 1. Setup GitHub
Inisialisasi dan push kode ke repositori GitHub Anda:
```bash
git remote add origin https://github.com/<username>/verify.git
git branch -M main
git push -u origin main
```

### 2. Deployment ke Vercel

> ⚠️ **Catatan Arsitektur Vercel & PHP:**
> Vercel dirancang native untuk Node.js, Next.js, dan edge functions, sehingga **tidak memiliki official native PHP runtime**. 
> Proyek VERIFY telah dilengkapi dengan file bridge `vercel.json` dan `api/index.php` yang menggunakan community serverless runtime `vercel-php@0.7.3`.

#### Ketentuan Deployment Vercel:
1. **Database Wajib Eksternal (Cloud MySQL):** Lingkungan serverless Vercel bersifat *stateless* dan *ephemeral* (file SQLite lokal akan terhapus tiap invocations). Gunakan layanan MySQL cloud seperti **PlanetScale**, **Aiven MySQL**, **Railway MySQL**, atau **Supabase Postgres/MySQL**.
2. **Atur Environment Variables di Vercel Dashboard:**
   - `APP_ENV`: `production`
   - `APP_DEBUG`: `false`
   - `APP_KEY`: *(Salin nilai APP_KEY dari file .env lokal)*
   - `DB_CONNECTION`: `mysql`
   - `DB_HOST`: *(Host database cloud Anda)*
   - `DB_PORT`: `3306`
   - `DB_DATABASE`: *(Nama database cloud Anda)*
   - `DB_USERNAME`: *(Username database cloud Anda)*
   - `DB_PASSWORD`: *(Password database cloud Anda)*
   - `SESSION_DRIVER`: `cookie`
   - `CACHE_STORE`: `array`
   - `GOOGLE_SAFE_BROWSING_KEY`: *(Kunci API Safe Browsing)*

### 3. Alternatif Produksi Terbaik: Laravel Cloud & VPS
Jika menginginkan performa Laravel PHP yang 100% native tanpa batasan runtime serverless Vercel (seperti background queues, CRON schedules, dan persistent worker), gunakan opsi resmi:
- **Laravel Cloud** (Platform PaaS resmi tim Laravel)
- **Railway / Render** dengan Dockerfile PHP 8.3
- **VPS (DigitalOcean / AWS EC2 / Hetzner)** dengan Nginx + PHP-FPM 8.3

---

## 🔒 Fitur Keamanan yang Diterapkan

- **SSRF Protection:** Blokir otomatis terhadap IP loopback (127.0.0.1, localhost), IP jaringan lokal (10.x, 172.16-31.x, 192.168.x), dan metadata endpoint cloud (169.254.169.254).
- **Rate Limiting:** Throttle 10 kali pengecekan per menit untuk mencegah penyalahgunaan API (`middleware('throttle:10,1')`).
- **CSRF Token:** Setiap formulir POST, PUT, dan DELETE dilindungi oleh token CSRF Laravel.
- **Role Authorization & Policies:** Kebijakan kepemilikan data pada `CheckHistoryPolicy` memastikan pengguna hanya dapat melihat dan menghapus riwayat milik mereka sendiri.
- **XSS Sanitization & Blade Escaping:** Semua output teks pengguna diescape secara default melalui Blade `{{ }}`.
