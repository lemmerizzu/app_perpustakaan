<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = [
            ['Andi Saputra', '3125500001', 'andi.saputra@student.pens.ac.id', '081234560001', 'Jl. Keputih No. 10, Surabaya', 'aktif'],
            ['Budi Santoso', '3125500002', 'budi.santoso@student.pens.ac.id', '081234560002', 'Jl. Mulyosari No. 25, Surabaya', 'aktif'],
            ['Citra Ayu Lestari', '3125500003', 'citra.ayu@student.pens.ac.id', '081234560003', 'Jl. Kejawan Putih No. 7, Surabaya', 'aktif'],
            ['Dimas Prasetyo', '3125500004', 'dimas.prasetyo@student.pens.ac.id', '081234560004', 'Jl. Gebang Lor No. 3, Surabaya', 'aktif'],
            ['Eka Wulandari', '3125500005', 'eka.wulandari@student.pens.ac.id', '081234560005', 'Jl. Arif Rahman Hakim No. 51, Surabaya', 'nonaktif'],
            ['Fajar Nugroho', '3125500006', 'fajar.nugroho@student.pens.ac.id', '081234560006', 'Jl. Klampis Jaya No. 12, Surabaya', 'aktif'],
        ];

        foreach ($members as [$nama, $nim, $email, $telepon, $alamat, $status]) {
            Member::updateOrCreate(
                ['nim' => $nim],
                [
                    'nama' => $nama,
                    'email' => $email,
                    'nomor_telepon' => $telepon,
                    'alamat' => $alamat,
                    'status' => $status,
                ]
            );
        }
    }
}
