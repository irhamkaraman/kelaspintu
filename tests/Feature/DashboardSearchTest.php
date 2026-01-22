<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Keanggotaan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardSearchTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $instructor;
    protected $kelas1;
    protected $kelas2;
    protected $kelas3;

    protected function setUp(): void
    {
        parent::setUp();

        // Create users
        $this->user = User::factory()->create();
        $this->instructor = User::factory()->create();

        // Create classes
        $this->kelas1 = Kelas::create([
            'nama' => 'Pemrograman Web Lanjut',
            'deskripsi' => 'Belajar Laravel dan Vue.js',
            'pembuat_id' => $this->instructor->id,
        ]);

        $this->kelas2 = Kelas::create([
            'nama' => 'Database Design',
            'deskripsi' => 'Desain database dengan MySQL',
            'pembuat_id' => $this->instructor->id,
        ]);

        $this->kelas3 = Kelas::create([
            'nama' => 'Mobile Development',
            'deskripsi' => 'Belajar Flutter dan React Native',
            'pembuat_id' => $this->instructor->id,
        ]);

        // Add instructor to classes
        Keanggotaan::create([
            'kelas_id' => $this->kelas1->id,
            'user_id' => $this->instructor->id,
            'sebagai' => 'instruktur',
        ]);

        Keanggotaan::create([
            'kelas_id' => $this->kelas2->id,
            'user_id' => $this->instructor->id,
            'sebagai' => 'instruktur',
        ]);

        Keanggotaan::create([
            'kelas_id' => $this->kelas3->id,
            'user_id' => $this->instructor->id,
            'sebagai' => 'instruktur',
        ]);
    }

    /** @test */
    public function user_can_access_search_page()
    {
        $response = $this->actingAs($this->user)
            ->get(route('dashboard.search'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard-search');
    }

    /** @test */
    public function search_by_class_name()
    {
        $response = $this->actingAs($this->user)
            ->get(route('dashboard.search', ['q' => 'Pemrograman']));

        $response->assertStatus(200);
        $response->assertViewHas('hasilCari');
        $response->assertSee('Pemrograman Web Lanjut');
    }

    /** @test */
    public function search_by_description()
    {
        $response = $this->actingAs($this->user)
            ->get(route('dashboard.search', ['q' => 'Laravel']));

        $response->assertStatus(200);
        $response->assertSee('Pemrograman Web Lanjut');
    }

    /** @test */
    public function search_by_class_code()
    {
        $response = $this->actingAs($this->user)
            ->get(route('dashboard.search', ['q' => $this->kelas1->kode_unik]));

        $response->assertStatus(200);
        $response->assertSee('Pemrograman Web Lanjut');
    }

    /** @test */
    public function search_returns_no_results_for_non_matching_query()
    {
        $response = $this->actingAs($this->user)
            ->get(route('dashboard.search', ['q' => 'NonExistentClass']));

        $response->assertStatus(200);
        $response->assertDontSee('Pemrograman Web Lanjut');
    }

    /** @test */
    public function user_cannot_see_classes_they_already_joined()
    {
        // User joins kelas1
        Keanggotaan::create([
            'kelas_id' => $this->kelas1->id,
            'user_id' => $this->user->id,
            'sebagai' => 'mahasiswa',
        ]);

        // Search for all classes
        $response = $this->actingAs($this->user)
            ->get(route('dashboard.search', ['q' => 'Pemrograman']));

        $response->assertStatus(200);
        // Should not see kelas1 in results
        $response->assertDontSee('Pemrograman Web Lanjut');
    }

    /** @test */
    public function user_can_join_class_from_search_results()
    {
        $response = $this->actingAs($this->user)
            ->post(route('kelas.join.store'), [
                'kode_unik' => $this->kelas1->kode_unik,
            ]);

        $response->assertRedirect(route('kelas.show', $this->kelas1->kode_unik));

        // Verify user is now member of the class
        $this->assertTrue(
            Keanggotaan::where('kelas_id', $this->kelas1->id)
                ->where('user_id', $this->user->id)
                ->exists()
        );
    }

    /** @test */
    public function pagination_works_correctly()
    {
        // Create 15 more classes to test pagination
        for ($i = 0; $i < 15; $i++) {
            Kelas::create([
                'nama' => "Test Class {$i}",
                'deskripsi' => 'Test description',
                'pembuat_id' => $this->instructor->id,
            ]);
        }

        $response = $this->actingAs($this->user)
            ->get(route('dashboard.search', ['q' => 'Test']));

        $response->assertStatus(200);
        $response->assertViewHas('hasilCari');
        // Should have pagination
        $this->assertTrue($response->viewData('hasilCari')->hasPages());
    }

    /** @test */
    public function search_query_is_preserved_in_pagination()
    {
        $response = $this->actingAs($this->user)
            ->get(route('dashboard.search', ['q' => 'Pemrograman']));

        $response->assertStatus(200);
        // Check that query parameter is in pagination links
        $this->assertStringContainsString('q=Pemrograman', $response->getContent());
    }

    /** @test */
    public function unauthenticated_user_cannot_access_search()
    {
        $response = $this->get(route('dashboard.search'));

        $response->assertRedirect(route('login'));
    }
}
