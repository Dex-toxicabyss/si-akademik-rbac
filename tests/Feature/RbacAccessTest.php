<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacAccessTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $dosen;
    protected User $mahasiswa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Akademik FRI',
            'identifier' => 'ADM-FRI-001',
            'email' => 'admin@telkomuniversity.ac.id',
            'role' => 'admin',
        ]);

        $this->dosen = User::factory()->create([
            'name' => 'Dr. Hendra Wijaya',
            'identifier' => 'NIP-19880412',
            'email' => 'dosen@telkomuniversity.ac.id',
            'role' => 'dosen',
        ]);

        $this->mahasiswa = User::factory()->create([
            'name' => 'Raffata Izacky Yuargya Aletama',
            'identifier' => '102042500123',
            'email' => 'raffata@student.telkomuniversity.ac.id',
            'role' => 'mahasiswa',
        ]);
    }

    /** @test */
    public function admin_dapat_mengakses_seluruh_route_manajemen_pengguna_materi_dan_nilai(): void
    {
        $this->actingAs($this->admin)->get('/dashboard')->assertStatus(200);
        $this->actingAs($this->admin)->get('/users')->assertStatus(200);
        $this->actingAs($this->admin)->get('/materi')->assertStatus(200);
        $this->actingAs($this->admin)->get('/nilai')->assertStatus(200);
        $this->actingAs($this->admin)->get('/nilai/manage')->assertStatus(200);
    }

    /** @test */
    public function dosen_ditolak_pada_manajemen_pengguna_namun_diizinkan_pada_materi_dan_nilai(): void
    {
        // Ditolak (403 Forbidden) pada /users
        $this->actingAs($this->dosen)->get('/users')->assertStatus(403);
        $this->actingAs($this->dosen)->post('/users', [])->assertStatus(403);

        // Berhasil (200 OK) pada /materi dan /nilai
        $this->actingAs($this->dosen)->get('/materi')->assertStatus(200);
        $this->actingAs($this->dosen)->get('/nilai')->assertStatus(200);
        $this->actingAs($this->dosen)->get('/nilai/manage')->assertStatus(200);
    }

    /** @test */
    public function mahasiswa_ditolak_pada_manajemen_pengguna_serta_modifikasi_materi_dan_nilai(): void
    {
        // Ditolak (403 Forbidden) pada /users, POST /materi, dan /nilai/manage
        $this->actingAs($this->mahasiswa)->get('/users')->assertStatus(403);
        $this->actingAs($this->mahasiswa)->post('/materi', [
            'kode_mk' => 'PAW-99',
            'judul' => 'Uji Ilegal',
            'deskripsi' => 'Harus ditolak middleware',
            'kategori' => 'Modul',
        ])->assertStatus(403);
        $this->actingAs($this->mahasiswa)->get('/nilai/manage')->assertStatus(403);

        // Berhasil (200 OK) pada lihat /materi dan lihat transkrip /nilai
        $this->actingAs($this->mahasiswa)->get('/materi')->assertStatus(200);
        $this->actingAs($this->mahasiswa)->get('/nilai')->assertStatus(200);
    }
}
