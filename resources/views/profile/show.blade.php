@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
    <h1>Profil Pengguna</h1>

    <table class="info" style="margin-bottom: 30px;">
        <tr>
            <th>Nama</th>
            <td>{{ auth()->user()->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ auth()->user()->email }}</td>
        </tr>
        <tr>
            <th>Role</th>
            <td>{{ ucfirst(auth()->user()->role) }}</td>
        </tr>
    </table>

    <h2>Ganti Password</h2>
    <form action="{{ route('profile.password.update') }}" method="POST" class="form-wrap">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="password_lama">Password Lama</label>
            <input type="password" name="password_lama" id="password_lama" required>
            @error('password_lama')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_baru">Password Baru</label>
            <input type="password" name="password_baru" id="password_baru" minlength="8" required>
            <div class="hint">Minimal 8 karakter.</div>
            @error('password_baru')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_baru_confirmation">Konfirmasi Password Baru</label>
            <input type="password" name="password_baru_confirmation" id="password_baru_confirmation" minlength="8" required>
            @error('password_baru_confirmation')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Perbarui Password</button>
        </div>
    </form>
@endsection
