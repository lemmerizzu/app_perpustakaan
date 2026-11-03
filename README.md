# App Perpustakaan

Aplikasi Sistem Perpustakaan Digital Kampus, dibuat untuk tugas mata kuliah pemrograman web berbasis framework Laravel.

## Tujuan

Aplikasi ini dipakai oleh petugas/admin perpustakaan untuk mengelola data buku, kategori, anggota, dan transaksi peminjaman. Project dikerjakan bertahap dari Pertemuan 1 sampai Pertemuan 10, dan sekarang sudah lengkap secara fungsional.

## Fitur

- Login/logout petugas dan admin (session-based), menu Kategori khusus role admin
- Dashboard statistik (total buku, total anggota, peminjaman aktif) yang diambil dari `GET /api/stats`
- CRUD kategori, buku, anggota, dan transaksi peminjaman (termasuk pengembalian buku)
- Laporan peminjaman yang diambil dari `GET /api/loans`
- Profil petugas dan ganti password
- REST API untuk books, members, loans, dan stats (dokumentasi di `API.md`)
- Seeder dan Factory untuk data dummy bergaya Indonesia

## Teknologi

- PHP 8.2 atau lebih baru
- Laravel 12
- MySQL
- Composer

## Cara Menjalankan di Lokal

1. Clone repository ini
   ```bash
   git clone https://github.com/lemmerizzu/app_perpustakaan.git
   cd app_perpustakaan
   ```
2. Install dependency lewat Composer
   ```bash
   composer install
   ```
3. Copy file `.env.example` jadi `.env`, lalu generate application key
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Sesuaikan konfigurasi di `.env`
   ```env
   APP_FAKER_LOCALE=id_ID

   # Base URL server kedua khusus panggilan API internal (wajib beda port dari server utama)
   INTERNAL_API_URL=http://127.0.0.1:8011

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=app_perpustakaan
   DB_USERNAME=root
   DB_PASSWORD=
   ```
5. Buat database kosong bernama `app_perpustakaan` di MySQL/phpMyAdmin
6. Jalankan migration sekaligus seeder
   ```bash
   php artisan migrate:fresh --seed
   ```
   Seeder mengisi 3 user, 5 kategori, 20 buku, 15 anggota, dan 10 transaksi peminjaman.
7. Jalankan **dua** server di dua terminal terpisah
   ```bash
   # Terminal 1 - server utama untuk browser
   php artisan serve --port=8000

   # Terminal 2 - server kedua untuk panggilan API internal (INTERNAL_API_URL)
   php artisan serve --port=8011
   ```
8. Buka `http://127.0.0.1:8000` di browser, lalu login

### Kenapa Butuh Dua Server?

Halaman Dashboard dan Laporan Peminjaman mengambil data lewat Laravel HTTP Client (`Http::get()`) ke API milik aplikasi ini sendiri. `php artisan serve` hanya memproses satu request pada satu waktu, jadi kalau aplikasi memanggil port yang sama dengan dirinya sendiri, kedua request saling menunggu (deadlock). Karena itu panggilan API internal diarahkan ke server kedua di port `8011` lewat `INTERNAL_API_URL` (dibaca dari `config('services.internal_api.base_url')`).

Kalau server kedua tidak dinyalakan, aplikasi tetap berjalan: Dashboard menampilkan angka 0 dan Laporan Peminjaman menampilkan tabel kosong, karena kegagalan koneksi ditangkap dengan `try/catch ConnectionException`. Di server produksi (Nginx/Apache + PHP-FPM) masalah ini tidak muncul karena banyak request bisa diproses bersamaan.

## Akun Login (hasil seeding)

Password semua akun: `password`

| Nama | Email | Role |
|---|---|---|
| Bambang Sutrisno | `admin@pens.ac.id` | admin |
| Siti Rahmawati | `petugas1@pens.ac.id` | petugas |
| Ahmad Fauzi | `petugas2@pens.ac.id` | petugas |

## Menjalankan Test

```bash
php artisan test
```

Test memakai database SQLite in-memory (lihat `phpunit.xml`), jadi tidak mengubah isi database MySQL.

## Dokumen Lain

- `API.md` - dokumentasi endpoint REST API
- `DEMO.md` - skenario demo tertulis untuk UAS

## Model, View, Controller (menurut pemahaman saya)

Model adalah bagian yang mengurus data, misalnya struktur tabel buku, anggota, dan peminjaman di database. View adalah bagian yang mengurus tampilan yang dilihat pengguna, isinya HTML tanpa logika bisnis yang rumit. Controller adalah penghubung antara keduanya, yaitu menerima permintaan dari pengguna, mengambil atau mengubah data lewat Model, lalu mengirim data itu ke View untuk ditampilkan.

Nama  : Rizki Kurniawan
NRP   : 3125500043
Kelas : 2D3ITB
