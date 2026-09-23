@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <p><a href="{{ route('members.index') }}">&larr; Kembali ke daftar anggota</a></p>
    <h1>Edit Anggota</h1>

    <form action="{{ route('members.update', $member['id']) }}" method="POST" class="form-wrap">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama">Nama Anggota</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $member['nama']) }}">
            @error('nama') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" name="nim" id="nim" value="{{ old('nim', $member['nim']) }}">
            @error('nim') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $member['email']) }}">
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="nomor_telepon">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon', $member['nomor_telepon']) }}">
            @error('nomor_telepon') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" rows="3">{{ old('alamat', $member['alamat']) }}</textarea>
            @error('alamat') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="">-- Pilih Status --</option>
                <option value="aktif" @selected(old('status', $member['status']) === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(old('status', $member['status']) === 'nonaktif')>Nonaktif</option>
            </select>
            @error('status') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Perbarui</button>
        </div>
    </form>
@endsection
