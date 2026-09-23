@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
    <h1>Daftar Anggota</h1>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
        <a href="{{ route('members.create') }}" class="btn">+ Tambah Anggota</a>

        <form action="{{ route('members.index') }}" method="GET" style="display: flex; gap: 8px;">
            <input type="text" name="search" placeholder="Cari nama anggota..." value="{{ request('search') }}" style="padding: 6px 12px; border: 1px solid #ccc; border-radius: 4px;">
            <button type="submit" class="btn">Cari</button>
            @if(request('search'))
                <a href="{{ route('members.index') }}" class="btn" style="background: #6b7280;">Reset</a>
            @endif
        </form>
    </div>

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

    {{ $members->appends(request()->query())->links() }}
@endsection

