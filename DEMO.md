# Skenario Demo UAS - App Perpustakaan

Dokumen ini berisi urutan langkah demo aplikasi Sistem Perpustakaan Digital Kampus untuk UAS (Pertemuan 11). Urutan mengikuti skenario demo resmi: login, dashboard, kategori, buku, anggota, peminjaman, daftar peminjaman aktif, pengembalian, laporan, lalu demo API di Postman.

## Persiapan Sebelum Demo

1. Pastikan MySQL sudah menyala dan database `app_perpustakaan` bisa diakses sesuai konfigurasi `.env`.
2. Reset database ke kondisi demo yang bersih:
   ```bash
   php artisan migrate:fresh --seed
   ```
   Hasilnya: 3 user, 5 kategori, 20 buku, 15 anggota, dan 10 transaksi peminjaman.
3. Nyalakan **dua** server di dua terminal terpisah:
   ```bash
   # Terminal 1 - server utama untuk browser
   php artisan serve --port=8000

   # Terminal 2 - server kedua khusus panggilan API internal (INTERNAL_API_URL)
   php artisan serve --port=8011
   ```
   Kalau server kedua tidak jalan, Dashboard tampil angka 0 dan Laporan Peminjaman tampil kosong.
4. Buka browser di `http://127.0.0.1:8000/login` dan Postman dengan collection API yang sudah disiapkan.

Kredensial login (dari `UserSeeder`, password semua akun `password`):

| Nama | Email | Role |
|---|---|---|
| Bambang Sutrisno | `admin@pens.ac.id` | admin |
| Siti Rahmawati | `petugas1@pens.ac.id` | petugas |
| Ahmad Fauzi | `petugas2@pens.ac.id` | petugas |

Demo memakai akun **admin**, karena menu Kategori hanya bisa diakses role admin.

## Langkah Demo

### 1. Login sebagai admin

- Buka `http://127.0.0.1:8000/login`.
- Masuk dengan `admin@pens.ac.id` / `password`.
- Tunjukkan: setelah login langsung diarahkan ke Dashboard (`/`), muncul pesan "Login berhasil, selamat datang Bambang Sutrisno.", dan navbar menampilkan "Bambang Sutrisno (Admin)".
- Poin penjelasan: autentikasi session-based lewat `AuthController`, route terlindungi middleware `auth`.

### 2. Tampilkan dashboard statistik

- Tunjukkan tiga kartu: Total Buku (20), Total Anggota (15), dan Peminjaman Aktif (jumlah transaksi berstatus `dipinjam`).
- Poin penjelasan: angka ini tidak di-query langsung dari database oleh `DashboardController`, melainkan diambil lewat `Http::get()` ke `GET /api/stats` di server kedua (port 8011). Dua server dibutuhkan karena `php artisan serve` hanya memproses satu request pada satu waktu, jadi memanggil port yang sama akan deadlock.

### 3. Tambah kategori baru

- Klik menu **Kategori**, lalu **Tambah Kategori**.
- Isi contoh: Nama Kategori `Filsafat`, Deskripsi `Buku seputar pemikiran dan etika.`
- Simpan, tunjukkan flash message sukses dan kategori baru muncul di daftar.
- Opsional: login sebagai petugas di jendela private untuk menunjukkan `/categories` ditolak (403) oleh middleware `admin`.

### 4. Tambah buku dengan kategori

- Klik menu **Buku**, lalu **Tambah Buku**.
- Isi contoh: Judul `Filsafat Ilmu Pengetahuan`, Penulis `Jujun Suriasumantri`, Penerbit `Pustaka Sinar Harapan`, Tahun Terbit `2020`, ISBN `9789794161001`, Stok `3`, Kategori `Filsafat` (kategori dari langkah 3).
- Simpan, tunjukkan buku tampil di daftar dengan **nama kategori** (bukan `category_id` mentah).
- Tunjukkan juga pagination teks di bawah tabel (20 buku seed + 1 buku baru = 3 halaman).

### 5. Tambah anggota baru

- Klik menu **Anggota**, lalu **Tambah Anggota**.
- Isi contoh: Nama `Rizki Kurniawan`, NIM `3125500043`, Email `rizki.kurniawan@pens.ac.id`, Nomor Telepon `081234567890`, Alamat `Jl. Keputih, Surabaya`, Status `aktif`.
- Simpan, tunjukkan flash message sukses.
- Uji validasi: coba tambah anggota lagi dengan NIM atau email yang sama, tunjukkan pesan error unik.
- Opsional: pakai kotak **Cari nama anggota** untuk menemukan anggota yang baru ditambahkan.

### 6. Buat transaksi peminjaman

- Klik menu **Peminjaman**, lalu buat transaksi baru (`/loans/create`).
- Pilih anggota `Rizki Kurniawan` (dari langkah 5), centang buku `Filsafat Ilmu Pengetahuan` (dari langkah 4) dan satu buku lain, isi tanggal pinjam hari ini dan tanggal kembali 7 hari lagi.
- Simpan, tunjukkan flash message sukses.
- Poin penjelasan: `user_id` petugas diisi otomatis dari `auth()->id()` (user yang sedang login), bukan input manual di form.

### 7. Lihat daftar peminjaman aktif

- Di halaman **Peminjaman** (`/loans`), buka halaman terakhir pagination (transaksi baru punya ID terbesar).
- Tunjukkan transaksi baru berstatus `dipinjam` (badge kuning), lengkap dengan nama anggota, nama petugas, dan daftar judul buku.
- Poin penjelasan: data relasi dimuat dengan eager loading `Loan::with(['member', 'user', 'loanItems.book'])`, sehingga tidak terjadi N+1 query.

### 8. Proses pengembalian buku

- Masih di daftar peminjaman, klik tombol **Kembalikan** pada transaksi dari langkah 6.
- Tunjukkan status berubah menjadi `dikembalikan` dan tanggal dikembalikan terisi tanggal hari ini.
- Alternatif lewat API (Postman): `PUT http://127.0.0.1:8000/api/loans/{id}/kembalikan` dengan header `Accept: application/json`.

### 9. Tampilkan halaman laporan

- Klik menu **Laporan** atau tombol **Lihat Laporan Peminjaman** di Dashboard (`/loans/report`).
- Tunjukkan tabel transaksi lengkap (anggota, petugas, buku, tanggal, status) dan navigasi "Halaman X dari Y", termasuk transaksi yang baru dikembalikan di langkah 8 (ada di halaman 2).
- Poin penjelasan: data diambil dari `GET /api/loans` lewat `Http::get()`, jadi Blade membaca array JSON (`$loan['member']['nama']`), bukan objek Eloquent.
- Opsional: matikan server port 8011, refresh Dashboard dan Laporan. Kedua halaman tetap tampil (angka 0 dan tabel kosong), bukan error 500, karena `ConnectionException` ditangkap `try/catch`. Nyalakan lagi server 8011 setelahnya.

### 10. Demo API di Postman

Semua request memakai header `Accept: application/json`.

- `GET http://127.0.0.1:8000/api/books`: tunjukkan response JSON format `BookResource` (kategori ter-nested) beserta `links` dan `meta` pagination.
- `GET http://127.0.0.1:8000/api/books?judul=Filsafat`: tunjukkan filter judul menemukan buku dari langkah 4.
- `GET http://127.0.0.1:8000/api/stats`: tunjukkan `total_buku`, `total_anggota`, dan `peminjaman_aktif` sesuai data terkini (sama dengan angka di Dashboard).
- Opsional: `POST /api/books` dengan body kosong untuk menunjukkan response `422` berisi pesan validasi.

Daftar lengkap endpoint ada di `API.md`.

### 11. Tanya jawab konseptual

Siapkan jawaban untuk topik Pertemuan 1 sampai 10: MVC, request lifecycle dan middleware, validasi server-side, migration, N+1 query dan eager loading, autentikasi vs otorisasi, REST API dan API Resource, alasan dua server untuk konsumsi API internal, serta fungsi Seeder dan Factory.
