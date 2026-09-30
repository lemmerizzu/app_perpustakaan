@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
    <style>
        table.info th { width: 160px; background: #f3f4f6; }
    </style>

    <h1>Detail Anggota</h1>
    <p><a href="{{ route('members.index') }}">&larr; Kembali ke daftar anggota</a></p>

    <table class="info">
        <tr>
            <th>ID</th>
            <td>{{ $member['id'] }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $member['nama'] }}</td>
        </tr>
        <tr>
            <th>NIM</th>
            <td>{{ $member['nim'] }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $member['email'] }}</td>
        </tr>
        <tr>
            <th>No. Telepon</th>
            <td>{{ $member['nomor_telepon'] }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $member['alamat'] }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="{{ $member['status'] === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                    {{ ucfirst($member['status']) }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Terdaftar Sejak</th>
            <td>{{ $member->created_at ? $member->created_at->format('d M Y, H:i') : '-' }}</td>
        </tr>
    </table>

    <div style="margin-top: 20px;">
        <a href="{{ route('members.edit', $member['id']) }}" class="btn">Edit Anggota</a>
    </div>

    <h2 style="margin-top: 32px;">Riwayat Peminjaman</h2>
    <p><em>Diambil lewat relasi <code>$member->loans</code>: satu anggota bisa punya banyak transaksi peminjaman.</em></p>

    <table>
        <thead>
            <tr>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Petugas</th>
                <th>Buku</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($member['loans'] as $loan)
                <tr>
                    <td>{{ $loan['tanggal_pinjam'] }}</td>
                    <td>{{ $loan['tanggal_kembali'] }}</td>
                    <td>{{ $loan['user']['name'] }}</td>
                    <td>
                        @foreach ($loan['loanItems'] as $item)
                            {{ $item['book']['judul'] }}@if (!$loop->last), @endif
                        @endforeach
                    </td>
                    <td>{{ ucfirst($loan['status']) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Anggota ini belum pernah meminjam buku.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
