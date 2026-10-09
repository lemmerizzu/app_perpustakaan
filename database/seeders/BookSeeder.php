<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            ['Dasar Pemrograman Web dengan Laravel', 'Rizal Pratama', 'Informatika Bandung', 2023, '9786230011001', 5, 'Teknologi Informasi'],
            ['Struktur Data dan Algoritma', 'Dewi Lestari Putri', 'Andi Offset', 2021, '9786230011002', 4, 'Teknologi Informasi'],
            ['Jaringan Komputer Modern', 'Bambang Hariyanto', 'Informatika Bandung', 2022, '9786230011003', 3, 'Teknologi Informasi'],
            ['Kalkulus Jilid 1', 'Purcell Varberg', 'Erlangga', 2019, '9786230011004', 6, 'Matematika'],
            ['Matematika Diskrit', 'Rinaldi Munir', 'Informatika Bandung', 2020, '9786230011005', 4, 'Matematika'],
            ['Pemrograman Mikrokontroler Arduino', 'Agus Setiawan', 'Andi Offset', 2022, '9786230011006', 3, 'Elektronika'],
            ['Fisika Dasar untuk Teknik', 'Sri Wahyuni', 'Erlangga', 2018, '9786230011007', 5, 'Fisika'],
            ['Manajemen Proyek Perangkat Lunak', 'Hendra Gunawan', 'Salemba Empat', 2021, '9786230011008', 2, 'Bisnis & Manajemen'],
            ['Bahasa Inggris untuk Teknik', 'Maria Ulfa', 'Gramedia', 2020, '9786230011009', 4, 'Bahasa'],
            ['Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, '9786230011010', 3, 'Novel'],
            ['Si Juki: Lika-Liku Anak Kos', 'Faza Meonk', 'Bukune', 2016, '9786230011011', 2, 'Komik'],
            ['Desain UI/UX untuk Pemula', 'Nadia Rahmawati', 'Elex Media', 2023, '9786230011012', 3, 'Desain'],
        ];

        foreach ($books as [$judul, $penulis, $penerbit, $tahun, $isbn, $stok, $kategori]) {
            Book::updateOrCreate(
                ['isbn' => $isbn],
                [
                    'judul' => $judul,
                    'penulis' => $penulis,
                    'penerbit' => $penerbit,
                    'tahun_terbit' => $tahun,
                    'stok' => $stok,
                    'category_id' => Category::where('nama_kategori', $kategori)->value('id'),
                ]
            );
        }
    }
}
