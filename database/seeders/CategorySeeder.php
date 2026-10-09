<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Teknologi Informasi', 'deskripsi' => 'Pemrograman, jaringan, dan sistem informasi.'],
            ['nama_kategori' => 'Matematika', 'deskripsi' => 'Kalkulus, aljabar, statistika, dan matematika diskrit.'],
            ['nama_kategori' => 'Elektronika', 'deskripsi' => 'Rangkaian listrik, mikrokontroler, dan sistem tertanam.'],
            ['nama_kategori' => 'Fisika', 'deskripsi' => 'Mekanika, gelombang, dan fisika dasar.'],
            ['nama_kategori' => 'Bisnis & Manajemen', 'deskripsi' => 'Kewirausahaan, manajemen proyek, dan pemasaran.'],
            ['nama_kategori' => 'Bahasa', 'deskripsi' => 'Bahasa Indonesia, Bahasa Inggris, dan penulisan ilmiah.'],
            ['nama_kategori' => 'Novel', 'deskripsi' => 'Fiksi karya penulis dalam dan luar negeri.'],
            ['nama_kategori' => 'Komik', 'deskripsi' => 'Komik dan novel grafis.'],
            ['nama_kategori' => 'Sejarah', 'deskripsi' => 'Sejarah Indonesia dan dunia.'],
            ['nama_kategori' => 'Desain', 'deskripsi' => 'Desain grafis, UI/UX, dan multimedia.'],
            ['nama_kategori' => 'Pengembangan Diri', 'deskripsi' => 'Motivasi, produktivitas, dan soft skill.'],
            ['nama_kategori' => 'Referensi', 'deskripsi' => 'Kamus, ensiklopedia, dan buku pegangan.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['nama_kategori' => $category['nama_kategori']],
                $category
            );
        }
    }
}
