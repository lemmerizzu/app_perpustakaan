# Dokumentasi REST API - App Perpustakaan

Dokumentasi ini mencakup 11 endpoint REST API untuk resource **Books**, **Members**, **Loans**, dan **Stats** pada aplikasi perpustakaan.

Base URL: `http://127.0.0.1:8000/api`  
Header wajib: `Accept: application/json`

---

## Ringkasan Endpoint

| No | Method | URL | Body (jika ada) | Status Code | Keterangan |
|---|---|---|---|---|---|
| 1 | `GET` | `/api/books` | - | `200 OK` | Daftar buku terpaginasi (mendukung query `?judul=` & `?category_id=`) |
| 2 | `GET` | `/api/books/{id}` | - | `200 OK` / `404 Not Found` | Detail data buku berdasarkan ID |
| 3 | `POST` | `/api/books` | JSON Data Buku Baru | `201 Created` / `422 Unprocessable` | Menambahkan data buku baru |
| 4 | `PUT` | `/api/books/{id}` | JSON Data Update Buku | `200 OK` / `404 Not Found` / `422 Unprocessable` | Memperbarui data buku |
| 5 | `DELETE` | `/api/books/{id}` | - | `200 OK` / `404 Not Found` | Menghapus data buku |
| 6 | `GET` | `/api/members` | - | `200 OK` | Daftar anggota perpustakaan terpaginasi |
| 7 | `GET` | `/api/members/{id}` | - | `200 OK` / `404 Not Found` | Detail anggota perpustakaan berdasarkan ID |
| 8 | `GET` | `/api/loans` | - | `200 OK` | Daftar transaksi peminjaman terpaginasi |
| 9 | `POST` | `/api/loans` | JSON Data Peminjaman | `201 Created` / `422 Unprocessable` | Membuat transaksi peminjaman baru |
| 10 | `PUT` | `/api/loans/{id}/kembalikan` | - | `200 OK` / `404 Not Found` | Mengubah status peminjaman jadi dikembalikan |
| 11 | `GET` | `/api/stats` | - | `200 OK` | Statistik ringkas total buku, anggota, dan peminjaman aktif |

---

## Rincian Endpoint dan Contoh Response

### 1. `GET /api/books`
Mengambil daftar buku dalam bentuk pagination (10 item per halaman) beserta relasi kategori yang ter-nested.

**Query Parameters (Opsional):**
- `judul`: Filter buku berdasarkan judul (LIKE `%judul%`).
- `category_id`: Filter buku berdasarkan ID kategori.

**Response `200 OK`:**
```json
{
  "data": [
    {
      "id": 1,
      "judul": "Dasar Pemrograman Web dengan Laravel",
      "penulis": "Rizal Pratama",
      "penerbit": "Informatika Bandung",
      "tahun_terbit": 2023,
      "isbn": "9786230011001",
      "stok": 5,
      "sampul": null,
      "category": {
        "id": 1,
        "nama_kategori": "Teknologi Informasi"
      },
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 2,
      "judul": "Struktur Data dan Algoritma",
      "penulis": "Dewi Lestari Putri",
      "penerbit": "Andi Offset",
      "tahun_terbit": 2021,
      "isbn": "9786230011002",
      "stok": 4,
      "sampul": null,
      "category": {
        "id": 1,
        "nama_kategori": "Teknologi Informasi"
      },
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 3,
      "judul": "Jaringan Komputer Modern",
      "penulis": "Bambang Hariyanto",
      "penerbit": "Informatika Bandung",
      "tahun_terbit": 2022,
      "isbn": "9786230011003",
      "stok": 3,
      "sampul": null,
      "category": {
        "id": 1,
        "nama_kategori": "Teknologi Informasi"
      },
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 4,
      "judul": "Kalkulus Jilid 1",
      "penulis": "Purcell Varberg",
      "penerbit": "Erlangga",
      "tahun_terbit": 2019,
      "isbn": "9786230011004",
      "stok": 6,
      "sampul": null,
      "category": {
        "id": 2,
        "nama_kategori": "Matematika"
      },
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 5,
      "judul": "Matematika Diskrit",
      "penulis": "Rinaldi Munir",
      "penerbit": "Informatika Bandung",
      "tahun_terbit": 2020,
      "isbn": "9786230011005",
      "stok": 4,
      "sampul": null,
      "category": {
        "id": 2,
        "nama_kategori": "Matematika"
      },
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 6,
      "judul": "Pemrograman Mikrokontroler Arduino",
      "penulis": "Agus Setiawan",
      "penerbit": "Andi Offset",
      "tahun_terbit": 2022,
      "isbn": "9786230011006",
      "stok": 3,
      "sampul": null,
      "category": {
        "id": 3,
        "nama_kategori": "Elektronika"
      },
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 7,
      "judul": "Fisika Dasar untuk Teknik",
      "penulis": "Sri Wahyuni",
      "penerbit": "Erlangga",
      "tahun_terbit": 2018,
      "isbn": "9786230011007",
      "stok": 5,
      "sampul": null,
      "category": {
        "id": 4,
        "nama_kategori": "Fisika"
      },
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 8,
      "judul": "Manajemen Proyek Perangkat Lunak",
      "penulis": "Hendra Gunawan",
      "penerbit": "Salemba Empat",
      "tahun_terbit": 2021,
      "isbn": "9786230011008",
      "stok": 2,
      "sampul": null,
      "category": {
        "id": 5,
        "nama_kategori": "Bisnis & Manajemen"
      },
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 9,
      "judul": "Bahasa Inggris untuk Teknik",
      "penulis": "Maria Ulfa",
      "penerbit": "Gramedia",
      "tahun_terbit": 2020,
      "isbn": "9786230011009",
      "stok": 4,
      "sampul": null,
      "category": {
        "id": 6,
        "nama_kategori": "Bahasa"
      },
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 10,
      "judul": "Laskar Pelangi",
      "penulis": "Andrea Hirata",
      "penerbit": "Bentang Pustaka",
      "tahun_terbit": 2005,
      "isbn": "9786230011010",
      "stok": 3,
      "sampul": null,
      "category": {
        "id": 7,
        "nama_kategori": "Novel"
      },
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    }
  ],
  "links": {
    "first": "http://localhost/api/books?page=1",
    "last": "http://localhost/api/books?page=2",
    "prev": null,
    "next": "http://localhost/api/books?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 2,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "page": null,
        "active": false
      },
      {
        "url": "http://localhost/api/books?page=1",
        "label": "1",
        "page": 1,
        "active": true
      },
      {
        "url": "http://localhost/api/books?page=2",
        "label": "2",
        "page": 2,
        "active": false
      },
      {
        "url": "http://localhost/api/books?page=2",
        "label": "Next &raquo;",
        "page": 2,
        "active": false
      }
    ],
    "path": "http://localhost/api/books",
    "per_page": 10,
    "to": 10,
    "total": 12
  }
}
```

---

### 2. `GET /api/books/{id}`
Mengambil informasi detail satu buku berdasarkan ID.

**Response `200 OK` (Sukses):**
```json
{
  "data": {
    "id": 1,
    "judul": "Dasar Pemrograman Web dengan Laravel",
    "penulis": "Rizal Pratama",
    "penerbit": "Informatika Bandung",
    "tahun_terbit": 2023,
    "isbn": "9786230011001",
    "stok": 5,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Teknologi Informasi"
    },
    "created_at": "2026-11-03T04:41:20.000000Z",
    "updated_at": "2026-11-03T04:41:20.000000Z"
  }
}
```

**Response `404 Not Found` (Gagal - ID tidak ditemukan):**
```json
{
  "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

### 3. `POST /api/books`
Menambahkan data buku baru ke dalam perpustakaan.

**Request Header:**
- `Content-Type: application/json`

**Request Body:**
```json
{
  "judul": "Sistem Informasi Manajemen",
  "penulis": "Kenneth C. Laudon",
  "penerbit": "Salemba Empat",
  "tahun_terbit": 2021,
  "isbn": "978-979-061-945-8",
  "stok": 7,
  "category_id": 1
}
```

**Response `201 Created` (Sukses):**
```json
{
  "data": {
    "id": 13,
    "judul": "Sistem Informasi Manajemen",
    "penulis": "Kenneth C. Laudon",
    "penerbit": "Salemba Empat",
    "tahun_terbit": 2021,
    "isbn": "978-979-061-945-8",
    "stok": 7,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Teknologi Informasi"
    },
    "created_at": "2026-11-03T04:41:20.000000Z",
    "updated_at": "2026-11-03T04:41:20.000000Z"
  }
}
```

**Response `422 Unprocessable Entity` (Gagal - Validasi Kosong/Salah):**
```json
{
  "message": "Judul buku wajib diisi. (and 5 more errors)",
  "errors": {
    "judul": [
      "Judul buku wajib diisi."
    ],
    "penulis": [
      "Nama penulis wajib diisi."
    ],
    "penerbit": [
      "Nama penerbit wajib diisi."
    ],
    "tahun_terbit": [
      "Tahun terbit wajib diisi."
    ],
    "stok": [
      "Stok wajib diisi."
    ],
    "category_id": [
      "The category id field is required."
    ]
  }
}
```

---

### 4. `PUT /api/books/{id}`
Memperbarui data buku yang sudah ada.

**Request Body:**
```json
{
  "judul": "Dasar Pemrograman Web dengan Laravel (Edisi Revisi)",
  "penulis": "Rizal Pratama",
  "penerbit": "Informatika Bandung",
  "tahun_terbit": 2024,
  "isbn": "9786230011001",
  "stok": 10,
  "category_id": 1
}
```

**Response `200 OK` (Sukses):**
```json
{
  "data": {
    "id": 1,
    "judul": "Dasar Pemrograman Web dengan Laravel (Edisi Revisi)",
    "penulis": "Rizal Pratama",
    "penerbit": "Informatika Bandung",
    "tahun_terbit": 2024,
    "isbn": "9786230011001",
    "stok": 10,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Teknologi Informasi"
    },
    "created_at": "2026-11-03T04:41:20.000000Z",
    "updated_at": "2026-11-03T04:41:20.000000Z"
  }
}
```

---

### 5. `DELETE /api/books/{id}`
Menghapus data buku dari sistem.

**Response `200 OK` (Sukses):**
```json
{
  "message": "Buku berhasil dihapus."
}
```

---

### 6. `GET /api/members`
Mengambil daftar anggota perpustakaan secara terpaginasi.

**Response `200 OK`:**
```json
{
  "data": [
    {
      "id": 1,
      "nama": "Andi Saputra",
      "nim": "3125500001",
      "email": "andi.saputra@student.pens.ac.id",
      "nomor_telepon": "081234560001",
      "alamat": "Jl. Keputih No. 10, Surabaya",
      "status": "aktif",
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 2,
      "nama": "Budi Santoso",
      "nim": "3125500002",
      "email": "budi.santoso@student.pens.ac.id",
      "nomor_telepon": "081234560002",
      "alamat": "Jl. Mulyosari No. 25, Surabaya",
      "status": "aktif",
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 3,
      "nama": "Citra Ayu Lestari",
      "nim": "3125500003",
      "email": "citra.ayu@student.pens.ac.id",
      "nomor_telepon": "081234560003",
      "alamat": "Jl. Kejawan Putih No. 7, Surabaya",
      "status": "aktif",
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 4,
      "nama": "Dimas Prasetyo",
      "nim": "3125500004",
      "email": "dimas.prasetyo@student.pens.ac.id",
      "nomor_telepon": "081234560004",
      "alamat": "Jl. Gebang Lor No. 3, Surabaya",
      "status": "aktif",
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 5,
      "nama": "Eka Wulandari",
      "nim": "3125500005",
      "email": "eka.wulandari@student.pens.ac.id",
      "nomor_telepon": "081234560005",
      "alamat": "Jl. Arif Rahman Hakim No. 51, Surabaya",
      "status": "nonaktif",
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    },
    {
      "id": 6,
      "nama": "Fajar Nugroho",
      "nim": "3125500006",
      "email": "fajar.nugroho@student.pens.ac.id",
      "nomor_telepon": "081234560006",
      "alamat": "Jl. Klampis Jaya No. 12, Surabaya",
      "status": "aktif",
      "created_at": "2026-11-03T04:41:20.000000Z",
      "updated_at": "2026-11-03T04:41:20.000000Z"
    }
  ],
  "links": {
    "first": "http://localhost/api/members?page=1",
    "last": "http://localhost/api/members?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "page": null,
        "active": false
      },
      {
        "url": "http://localhost/api/members?page=1",
        "label": "1",
        "page": 1,
        "active": true
      },
      {
        "url": null,
        "label": "Next &raquo;",
        "page": null,
        "active": false
      }
    ],
    "path": "http://localhost/api/members",
    "per_page": 10,
    "to": 6,
    "total": 6
  }
}
```

---

### 7. `GET /api/members/{id}`
Mengambil informasi detail satu anggota berdasarkan ID.

**Response `200 OK` (Sukses):**
```json
{
  "data": {
    "id": 1,
    "nama": "Andi Saputra",
    "nim": "3125500001",
    "email": "andi.saputra@student.pens.ac.id",
    "nomor_telepon": "081234560001",
    "alamat": "Jl. Keputih No. 10, Surabaya",
    "status": "aktif",
    "created_at": "2026-11-03T04:41:20.000000Z",
    "updated_at": "2026-11-03T04:41:20.000000Z"
  }
}
```

**Response `404 Not Found` (Gagal - ID tidak ditemukan):**
```json
{
  "message": "No query results for model [App\\Models\\Member] 999"
}
```

---

### 8. `GET /api/loans`
Mengambil daftar transaksi peminjaman secara terpaginasi beserta relasi anggota, petugas, dan item buku.

**Response `200 OK`:**
```json
{
  "data": [
    {
      "id": 1,
      "member": {
        "id": 1,
        "nama": "Andi Saputra"
      },
      "petugas": {
        "id": 1,
        "name": "Admin Perpustakaan"
      },
      "tanggal_pinjam": "2026-11-03",
      "tanggal_kembali": "2026-11-10",
      "tanggal_dikembalikan": null,
      "status": "dipinjam",
      "books": [
        {
          "id": 2,
          "judul": "Struktur Data dan Algoritma"
        },
        {
          "id": 3,
          "judul": "Jaringan Komputer Modern"
        }
      ]
    }
  ],
  "links": {
    "first": "http://localhost/api/loans?page=1",
    "last": "http://localhost/api/loans?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "page": null,
        "active": false
      },
      {
        "url": "http://localhost/api/loans?page=1",
        "label": "1",
        "page": 1,
        "active": true
      },
      {
        "url": null,
        "label": "Next &raquo;",
        "page": null,
        "active": false
      }
    ],
    "path": "http://localhost/api/loans",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 9. `POST /api/loans`
Mencatat transaksi peminjaman baru beserta daftar buku yang dipinjam.

**Request Body:**
```json
{
  "member_id": 1,
  "user_id": 1,
  "tanggal_pinjam": "2026-11-03",
  "tanggal_kembali": "2026-11-10",
  "book_ids": [2, 3]
}
```

**Response `201 Created` (Sukses):**
```json
{
  "data": {
    "id": 1,
    "member": {
      "id": 1,
      "nama": "Andi Saputra"
    },
    "petugas": {
      "id": 1,
      "name": "Admin Perpustakaan"
    },
    "tanggal_pinjam": "2026-11-03",
    "tanggal_kembali": "2026-11-10",
    "tanggal_dikembalikan": null,
    "status": "dipinjam",
    "books": [
      {
        "id": 2,
        "judul": "Struktur Data dan Algoritma"
      },
      {
        "id": 3,
        "judul": "Jaringan Komputer Modern"
      }
    ]
  }
}
```

**Response `422 Unprocessable Entity` (Gagal - Validasi):**
```json
{
  "message": "Anggota wajib dipilih. (and 4 more errors)",
  "errors": {
    "member_id": [
      "Anggota wajib dipilih."
    ],
    "user_id": [
      "Petugas (user_id) wajib diisi."
    ],
    "tanggal_pinjam": [
      "Tanggal pinjam wajib diisi."
    ],
    "tanggal_kembali": [
      "Tanggal kembali wajib diisi."
    ],
    "book_ids": [
      "Pilih minimal satu buku."
    ]
  }
}
```

---

### 10. `PUT /api/loans/{id}/kembalikan`
Mengubah status transaksi peminjaman menjadi `dikembalikan` dan mengisi `tanggal_dikembalikan` dengan tanggal hari ini.

**Response `200 OK` (Sukses):**
```json
{
  "data": {
    "id": 1,
    "member": {
      "id": 1,
      "nama": "Andi Saputra"
    },
    "petugas": {
      "id": 1,
      "name": "Admin Perpustakaan"
    },
    "tanggal_pinjam": "2026-11-03",
    "tanggal_kembali": "2026-11-10",
    "tanggal_dikembalikan": "2026-11-03",
    "status": "dikembalikan",
    "books": [
      {
        "id": 2,
        "judul": "Struktur Data dan Algoritma"
      },
      {
        "id": 3,
        "judul": "Jaringan Komputer Modern"
      }
    ]
  }
}
```

---

### 11. `GET /api/stats`
Mengambil ringkasan statistik total buku, total anggota, dan jumlah peminjaman yang sedang aktif.

**Response `200 OK`:**
```json
{
  "total_buku": 12,
  "total_anggota": 6,
  "peminjaman_aktif": 0
}
```
