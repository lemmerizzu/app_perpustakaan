@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <p><a href="{{ route('categories.index') }}">&larr; Kembali ke daftar kategori</a></p>
    <h1>Tambah Kategori</h1>

    <form action="{{ route('categories.store') }}" method="POST" class="form-wrap">
        @csrf

        <div class="form-group">
            <label for="nama_kategori">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori') }}" placeholder="Contoh: Fiksi, Teknologi...">
            @error('nama_kategori') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi <span style="font-weight:400;color:#6b7280;">(opsional)</span></label>
            <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Deskripsi singkat kategori...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Simpan</button>
        </div>
    </form>
@endsection
