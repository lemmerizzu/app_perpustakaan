@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
    <p><a href="{{ route('books.index') }}">&larr; Kembali ke daftar buku</a></p>
    <h1>Tambah Buku</h1>

    <form action="{{ route('books.store') }}" method="POST" class="form-wrap">
        @csrf

        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" placeholder="Judul buku...">
            @error('judul') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="penulis">Penulis</label>
            <input type="text" name="penulis" id="penulis" value="{{ old('penulis') }}" placeholder="Nama penulis...">
            @error('penulis') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="penerbit">Penerbit</label>
            <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit') }}" placeholder="Nama penerbit...">
            @error('penerbit') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="tahun_terbit">Tahun Terbit</label>
            <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit') }}" placeholder="{{ date('Y') }}">
            @error('tahun_terbit') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="isbn">ISBN <span style="font-weight:400;color:#6b7280;">(opsional)</span></label>
            <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" placeholder="978-xxx-xxx-xxxx">
            @error('isbn') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" name="stok" id="stok" value="{{ old('stok', 1) }}" min="0">
            @error('stok') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="category_id">Kategori</label>
            <select name="category_id" id="category_id">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category['id'] }}" @selected(old('category_id') == $category['id'])>
                        {{ $category['nama_kategori'] }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Simpan</button>
        </div>
    </form>
@endsection
