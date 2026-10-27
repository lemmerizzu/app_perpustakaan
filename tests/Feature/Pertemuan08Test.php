<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class Pertemuan08Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }

    public function test_guest_is_redirected_to_login_when_accessing_protected_routes(): void
    {
        $this->get('/books')->assertRedirect('/login');
        $this->get('/categories')->assertRedirect('/login');
        $this->get('/members')->assertRedirect('/login');
        $this->get('/loans')->assertRedirect('/login');
        $this->get('/profil')->assertRedirect('/login');
    }

    public function test_user_can_view_login_page(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login Perpustakaan');
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'admin@pens.ac.id',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@pens.ac.id',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertAuthenticated();
    }

    public function test_user_can_logout(): void
    {
        $user = User::where('email', 'admin@pens.ac.id')->first();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $response->assertSessionHas('success', 'Logout berhasil.');
        $this->assertGuest();
    }

    public function test_admin_can_access_categories(): void
    {
        $admin = User::where('email', 'admin@pens.ac.id')->first();

        $response = $this->actingAs($admin)->get('/categories');
        $response->assertStatus(200);
    }

    public function test_petugas_cannot_access_categories(): void
    {
        $petugas = User::where('email', 'petugas1@pens.ac.id')->first();

        $response = $this->actingAs($petugas)->get('/categories');
        $response->assertStatus(403);
    }

    public function test_authenticated_user_can_view_profile(): void
    {
        $petugas = User::where('email', 'petugas1@pens.ac.id')->first();

        $response = $this->actingAs($petugas)->get('/profil');

        $response->assertStatus(200);
        $response->assertSee($petugas->name);
        $response->assertSee($petugas->email);
        $response->assertSee(ucfirst($petugas->role));
        $response->assertSee('Ganti Password');
    }

    public function test_change_password_fails_if_old_password_is_incorrect(): void
    {
        $petugas = User::where('email', 'petugas1@pens.ac.id')->first();

        $response = $this->actingAs($petugas)
            ->from('/profil')
            ->put('/profil/password', [
                'password_lama' => 'salah',
                'password_baru' => 'newpassword123',
                'password_baru_confirmation' => 'newpassword123',
            ]);

        $response->assertRedirect('/profil');
        $response->assertSessionHasErrors('password_lama');
        $this->assertTrue(Hash::check('password', $petugas->fresh()->password));
    }

    public function test_change_password_fails_if_new_password_is_too_short(): void
    {
        $petugas = User::where('email', 'petugas1@pens.ac.id')->first();

        $response = $this->actingAs($petugas)
            ->from('/profil')
            ->put('/profil/password', [
                'password_lama' => 'password',
                'password_baru' => 'short',
                'password_baru_confirmation' => 'short',
            ]);

        $response->assertRedirect('/profil');
        $response->assertSessionHasErrors('password_baru');
    }

    public function test_change_password_fails_if_confirmation_does_not_match(): void
    {
        $petugas = User::where('email', 'petugas1@pens.ac.id')->first();

        $response = $this->actingAs($petugas)
            ->from('/profil')
            ->put('/profil/password', [
                'password_lama' => 'password',
                'password_baru' => 'newpassword123',
                'password_baru_confirmation' => 'different123',
            ]);

        $response->assertRedirect('/profil');
        $response->assertSessionHasErrors('password_baru');
    }

    public function test_change_password_succeeds_with_valid_data(): void
    {
        $petugas = User::where('email', 'petugas1@pens.ac.id')->first();

        $response = $this->actingAs($petugas)
            ->from('/profil')
            ->put('/profil/password', [
                'password_lama' => 'password',
                'password_baru' => 'newpassword123',
                'password_baru_confirmation' => 'newpassword123',
            ]);

        $response->assertRedirect('/profil');
        $response->assertSessionHas('success', 'Password berhasil diperbarui.');

        // Pastikan password baru tersimpan dan ter-hash
        $petugasFresh = $petugas->fresh();
        $this->assertTrue(Hash::check('newpassword123', $petugasFresh->password));
        $this->assertFalse(Hash::check('password', $petugasFresh->password));
    }
}
