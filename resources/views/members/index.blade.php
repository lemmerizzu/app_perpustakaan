@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <h1>Daftar Buku</h1>

    <p><a href="{{ route('books.create') }}" class="btn">+ Tambah Buku</a></p>


    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $member)
                <tr>
                    <td>{{ $member['id'] }}</td>
                    <td>{{ $member['nama'] }}</td>
                    <td>{{ $member['nim'] }}</td>
                    <td>{{ $member['email'] }}</td>
                    <td>{{ $member['nomor_telepon'] }}</td>
                    <td>{{ $member['alamat'] ?? '-' }}</td>
                    <td>
                        <span class="{{ $member['status'] === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                            {{ ucfirst($member['status']) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('members.show', $member['id']) }}">Detail</a>
                        |
                        <a href="{{ route('members.edit', $member['id']) }}">Edit</a>
                        |
                        <form class="inline" action="{{ route('members.destroy', $member['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada data anggota.</td>
                </tr>
            @endforelse
        </tbody>
    </table>


    <p><em>Catatan: data di atas masih data dummy (array statis di Controller), belum dari database.</em></p>
@endsection

