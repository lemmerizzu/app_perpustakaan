<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private array $members = [
        [
            'id' => 1,
            'nama' => 'Rizki Kurniawan',
            'nim' => '3125500043',
            'email' => 'kour.awan@example.com',
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jojoran GG 3',
            'status' => 'aktif',
        ],
        [
            'id' => 2,
            'nama' => 'Rian Saputri',
            'nim' => '3125500045',
            'email' => 'rian.saputri@example.com',
            'nomor_telepon' => '082345678901',
            'alamat' => 'Jl. Gebang Wetan No. 5, Surabaya',
            'status' => 'aktif',
        ],
        [
            'id' => 3,
            'nama' => 'Rama Listianto',
            'nim' => '3125500053',
            'email' => 'listi.rama@example.com',
            'nomor_telepon' => '083456789012',
            'alamat' => 'Jl. Keputih Perintis No. 8, Surabaya',
            'status' => 'nonaktif',
        ],
    ];

    public function index()
    {
        $members = $this->members;

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();

        return redirect()->route('members.index')
            ->with('success', "Anggota \"{$validated['nama']}\" berhasil ditambahkan (data dummy, belum tersimpan ke database).");
    }

    public function show(string $id)
    {
        return "MemberController@show, id: {$id}";
    }

    public function edit(string $id)
    {
        return "MemberController@edit, id: {$id}";
    }

    public function update(Request $request, string $id)
    {
        return "MemberController@update, id: {$id}";
    }

    public function destroy(string $id)
    {
        return redirect()->route('members.index')
            ->with('success', "Anggota dengan id {$id} berhasil dihapus (data dummy, belum tersimpan ke database).");
    }
}

