<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\LoanItem;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Pertemuan09Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }

    public function test_can_list_books_with_pagination_and_category(): void
    {
        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'judul',
                        'penulis',
                        'penerbit',
                        'tahun_terbit',
                        'isbn',
                        'stok',
                        'sampul',
                        'category' => [
                            'id',
                            'nama_kategori',
                        ],
                        'created_at',
                        'updated_at',
                    ],
                ],
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => ['current_page', 'from', 'last_page', 'links', 'path', 'per_page', 'to', 'total'],
            ]);
    }

    public function test_can_filter_books_by_title_and_category(): void
    {
        $book = Book::first();

        $responseTitle = $this->getJson('/api/books?judul=' . urlencode(substr($book->judul, 0, 4)));
        $responseTitle->assertStatus(200);
        $this->assertTrue(collect($responseTitle->json('data'))->pluck('id')->contains($book->id));

        $responseCategory = $this->getJson('/api/books?category_id=' . $book->category_id);
        $responseCategory->assertStatus(200);
        $this->assertTrue(collect($responseCategory->json('data'))->every(fn ($item) => $item['category']['id'] === $book->category_id));
    }

    public function test_can_show_single_book(): void
    {
        $book = Book::first();

        $response = $this->getJson('/api/books/' . $book->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $book->id,
                    'judul' => $book->judul,
                    'category' => [
                        'id' => $book->category->id,
                        'nama_kategori' => $book->category->nama_kategori,
                    ],
                ],
            ]);
    }

    public function test_show_non_existent_book_returns_404(): void
    {
        $response = $this->getJson('/api/books/99999');

        $response->assertStatus(404);
    }

    public function test_can_create_book(): void
    {
        $category = Category::first();

        $payload = [
            'judul' => 'Clean Architecture',
            'penulis' => 'Robert C. Martin',
            'penerbit' => 'Prentice Hall',
            'tahun_terbit' => 2017,
            'isbn' => '978-0134494166',
            'stok' => 5,
            'category_id' => $category->id,
        ];

        $response = $this->postJson('/api/books', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'judul' => 'Clean Architecture',
                    'category' => [
                        'id' => $category->id,
                        'nama_kategori' => $category->nama_kategori,
                    ],
                ],
            ]);

        $this->assertDatabaseHas('books', [
            'judul' => 'Clean Architecture',
            'isbn' => '978-0134494166',
        ]);
    }

    public function test_create_book_validation_fails(): void
    {
        $response = $this->postJson('/api/books', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['judul', 'penulis', 'penerbit', 'tahun_terbit', 'stok', 'category_id']);
    }

    public function test_can_update_book(): void
    {
        $book = Book::first();

        $payload = [
            'judul' => 'Judul Buku Update',
            'penulis' => $book->penulis,
            'penerbit' => $book->penerbit,
            'tahun_terbit' => $book->tahun_terbit,
            'isbn' => $book->isbn,
            'stok' => 15,
            'category_id' => $book->category_id,
        ];

        $response = $this->putJson('/api/books/' . $book->id, $payload);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $book->id,
                    'judul' => 'Judul Buku Update',
                    'stok' => 15,
                ],
            ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'judul' => 'Judul Buku Update',
            'stok' => 15,
        ]);
    }

    public function test_can_delete_book(): void
    {
        $category = Category::first();
        $book = Book::create([
            'judul' => 'Buku Hapus API',
            'penulis' => 'Penulis X',
            'penerbit' => 'Penerbit Y',
            'tahun_terbit' => 2020,
            'stok' => 2,
            'category_id' => $category->id,
        ]);

        $response = $this->deleteJson('/api/books/' . $book->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Buku berhasil dihapus.',
            ]);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_can_list_members_with_pagination(): void
    {
        $response = $this->getJson('/api/members');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nama',
                        'nim',
                        'email',
                        'nomor_telepon',
                        'alamat',
                        'status',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_can_show_single_member(): void
    {
        $member = Member::first();

        $response = $this->getJson('/api/members/' . $member->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $member->id,
                    'nama' => $member->nama,
                    'nim' => $member->nim,
                ],
            ]);
    }

    public function test_can_list_loans_with_relations(): void
    {
        $response = $this->getJson('/api/loans');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'member' => ['id', 'nama'],
                        'petugas' => ['id', 'name'],
                        'tanggal_pinjam',
                        'tanggal_kembali',
                        'tanggal_dikembalikan',
                        'status',
                        'books' => [
                            '*' => ['id', 'judul'],
                        ],
                    ],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_can_create_loan(): void
    {
        $member = Member::first();
        $user = User::first();
        $book = Book::first();

        $payload = [
            'member_id' => $member->id,
            'user_id' => $user->id,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => now()->addDays(7)->toDateString(),
            'book_ids' => [$book->id],
        ];

        $response = $this->postJson('/api/loans', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'member' => [
                        'id' => $member->id,
                        'nama' => $member->nama,
                    ],
                    'petugas' => [
                        'id' => $user->id,
                        'name' => $user->name,
                    ],
                    'status' => 'dipinjam',
                    'books' => [
                        [
                            'id' => $book->id,
                            'judul' => $book->judul,
                        ],
                    ],
                ],
            ]);
    }

    public function test_can_return_loan(): void
    {
        $loan = Loan::where('status', 'dipinjam')->first();
        if (!$loan) {
            $member = Member::first();
            $user = User::first();
            $book = Book::first();
            $loan = Loan::create([
                'member_id' => $member->id,
                'user_id' => $user->id,
                'tanggal_pinjam' => now()->toDateString(),
                'tanggal_kembali' => now()->addDays(7)->toDateString(),
                'status' => 'dipinjam',
            ]);
            $loan->loanItems()->create(['book_id' => $book->id]);
        }

        $response = $this->putJson('/api/loans/' . $loan->id . '/kembalikan');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $loan->id,
                    'status' => 'dikembalikan',
                    'tanggal_dikembalikan' => now()->toDateString(),
                ],
            ]);

        $this->assertDatabaseHas('loans', [
            'id' => $loan->id,
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => now()->toDateString(),
        ]);
    }

    public function test_can_get_stats(): void
    {
        $response = $this->getJson('/api/stats');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'total_buku',
                'total_anggota',
                'peminjaman_aktif',
            ]);

        $this->assertEquals(Book::count(), $response->json('total_buku'));
        $this->assertEquals(Member::count(), $response->json('total_anggota'));
        $this->assertEquals(Loan::where('status', 'dipinjam')->count(), $response->json('peminjaman_aktif'));
    }
}

