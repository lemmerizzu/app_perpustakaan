# App Perpustakaan

Aplikasi Sistem Perpustakaan Digital Kampus, dibuat untuk tugas mata kuliah pemrograman web berbasis framework Laravel.

## Tujuan

Aplikasi ini dipakai oleh petugas/admin perpustakaan untuk mengelola data buku, anggota, dan transaksi peminjaman. Project ini dikerjakan bertahap dari pertemuan ke pertemuan, dimulai dari setup dasar di pertemuan ini sampai jadi aplikasi utuh di akhir semester.

## Teknologi

- PHP
- Laravel 12
- MySQL

## Cara Menjalankan di Lokal

1. Clone repository ini
   ```bash
   git clone https://github.com/[USERNAME]/app-perpustakaan.git
   cd app-perpustakaan
   ```
2. Install dependency lewat Composer
   ```bash
   composer install
   ```
3. Copy file `.env.example` jadi `.env`, lalu sesuaikan konfigurasi database
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_perpustakaan
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Buat database kosong bernama `db_perpustakaan` di MySQL/phpMyAdmin
5. Jalankan development server
   ```bash
   php artisan serve
   ```
6. Buka `http://127.0.0.1:8000` di browser

## Model, View, Controller (menurut pemahaman saya)

Model adalah bagian yang mengurus data, misalnya struktur tabel buku, anggota, dan peminjaman di database. View adalah bagian yang mengurus tampilan yang dilihat pengguna, isinya HTML tanpa logika bisnis yang rumit. Controller adalah penghubung antara keduanya, yaitu menerima permintaan dari pengguna, mengambil atau mengubah data lewat Model, lalu mengirim data itu ke View untuk ditampilkan.