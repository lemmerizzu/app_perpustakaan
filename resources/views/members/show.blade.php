@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
    <style>
        th { width: 160px; background: #f3f4f6; }
    </style>

    <h1>Detail Anggota</h1>
    <p><a href="{{ route('members.index') }}">&larr; Kembali ke daftar anggota</a></p>

    <table>
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
@endsection
