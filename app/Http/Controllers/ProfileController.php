<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil user yang sedang login.
     */
    public function show()
    {
        $user = Auth::user();

        return view('profile.show', compact('user'));
    }

    /**
     * Memproses penggantian password user yang sedang login.
     */
    public function updatePassword(Request $request)
    {
        // Mendukung input nama format Indonesia maupun konvensi Laravel bawaan
        if (! $request->has('password_baru') && $request->has('password')) {
            $request->merge([
                'password_lama' => $request->input('current_password', $request->input('password_lama')),
                'password_baru' => $request->input('password'),
                'password_baru_confirmation' => $request->input('password_confirmation'),
            ]);
        }

        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|string|min:8|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 8 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (! Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors([
                'password_lama' => 'Password lama tidak cocok.',
            ])->onlyInput();
        }

        $user->password = Hash::make($request->password_baru);
        $user->save();

        return redirect()->route('profile.show')
            ->with('success', 'Password berhasil diperbarui.');
    }
}
