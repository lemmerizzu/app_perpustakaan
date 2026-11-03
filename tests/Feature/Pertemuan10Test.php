<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class Pertemuan10Test extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        $this->admin = User::where('email', 'admin@pens.ac.id')->first();
    }

    public function test_seeder_creates_expected_demo_data(): void
    {
        $this->assertSame(5, Category::count());
        $this->assertSame(20, Book::count());
        $this->assertSame(15, Member::count());
        $this->assertSame(10, Loan::count());
        $this->assertSame('Bambang Sutrisno', $this->admin->name);
        $this->assertTrue(Member::all()->every(fn ($m) => str_ends_with($m->email, '@pens.ac.id')));
    }

    public function test_dashboard_shows_stats_from_internal_api(): void
    {
        Http::fake([
            '*/api/stats' => Http::response([
                'total_buku' => 20,
                'total_anggota' => 15,
                'peminjaman_aktif' => 4,
            ]),
        ]);

        $response = $this->actingAs($this->admin)->get('/');

        $response->assertStatus(200)
            ->assertSee('Total Buku')
            ->assertSeeInOrder(['20', '15', '4']);
    }

    public function test_dashboard_falls_back_to_zero_when_api_unreachable(): void
    {
        Http::fake(fn () => throw new ConnectionException('down'));

        $response = $this->actingAs($this->admin)->get('/');

        $response->assertStatus(200)->assertSee('Peminjaman Aktif');
        $this->assertSame(['total_buku' => 0, 'total_anggota' => 0, 'peminjaman_aktif' => 0], $response->viewData('stats'));
    }

    public function test_report_route_is_not_swallowed_by_loan_show(): void
    {
        Http::fake(fn () => throw new ConnectionException('down'));

        $this->actingAs($this->admin)->get('/loans/report')
            ->assertStatus(200)
            ->assertSee('Laporan Peminjaman')
            ->assertSee('Belum ada data peminjaman.');
    }

    public function test_report_shows_loans_from_internal_api(): void
    {
        Http::fake([
            '*/api/loans*' => Http::response([
                'data' => [[
                    'id' => 7,
                    'member' => ['id' => 1, 'nama' => 'Dewi Lestari'],
                    'petugas' => ['id' => 1, 'name' => 'Bambang Sutrisno'],
                    'books' => [['id' => 1, 'judul' => 'Laskar Pelangi'], ['id' => 2, 'judul' => 'Pulang']],
                    'tanggal_pinjam' => '2026-10-01',
                    'tanggal_kembali' => '2026-10-08',
                    'tanggal_dikembalikan' => null,
                    'status' => 'dipinjam',
                ]],
                'meta' => ['current_page' => 1, 'last_page' => 2],
            ]),
        ]);

        $this->actingAs($this->admin)->get('/loans/report')
            ->assertStatus(200)
            ->assertSee('Dewi Lestari')
            ->assertSeeInOrder(['Laskar Pelangi', 'Pulang'])
            ->assertSee('Halaman 1 dari 2');
    }

    public function test_login_redirects_to_dashboard(): void
    {
        $this->post('/login', ['email' => 'admin@pens.ac.id', 'password' => 'password'])
            ->assertRedirect(route('dashboard'));
    }
}
