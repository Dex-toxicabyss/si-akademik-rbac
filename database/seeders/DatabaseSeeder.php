<?php

namespace Database\Seeders;

use App\Models\Materi;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Role Admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@telkomuniversity.ac.id'],
            [
                'name' => 'Admin Akademik FRI',
                'identifier' => 'ADM-FRI-001',
                'role' => 'admin',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Akun Role Dosen
        $dosen = User::updateOrCreate(
            ['email' => 'dosen@telkomuniversity.ac.id'],
            [
                'name' => 'Dr. Hendra Wijaya, S.Kom., M.T.',
                'identifier' => 'NIP-19880412',
                'role' => 'dosen',
                'password' => Hash::make('password123'),
            ]
        );

        // 3. Akun Role Mahasiswa (Raffata Izacky Yuargya Aletama)
        $mahasiswa = User::updateOrCreate(
            ['email' => 'raffata@student.telkomuniversity.ac.id'],
            [
                'name' => 'Raffata Izacky Yuargya Aletama',
                'identifier' => '102042500123',
                'role' => 'mahasiswa',
                'password' => Hash::make('password123'),
            ]
        );

        // Tambahan mahasiswa sampel untuk daftar nilai
        $alvin = User::updateOrCreate(
            ['email' => 'alvin@student.telkomuniversity.ac.id'],
            [
                'name' => 'Alvin Isatoni',
                'identifier' => '102042500124',
                'role' => 'mahasiswa',
                'password' => Hash::make('password123'),
            ]
        );

        // Seed Materi Perkuliahan
        Materi::updateOrCreate(
            ['kode_mk' => 'CS-301'],
            [
                'judul' => 'Autentikasi Multi-Role & Middleware CheckRole pada Laravel 11',
                'deskripsi' => 'Implementasi pembatasan akses route menggunakan custom Middleware CheckRole untuk Admin, Dosen, dan Mahasiswa.',
                'kategori' => 'Materi Perkuliahan',
                'uploaded_by' => $dosen->id,
            ]
        );

        Materi::updateOrCreate(
            ['kode_mk' => 'CS-302'],
            [
                'judul' => 'Eloquent ORM Relationships & Database Seeding',
                'deskripsi' => 'Pemodelan relasi One-to-Many dan Many-to-Many serta pengujian integritas referensi pada aplikasi akademik.',
                'kategori' => 'Slide Perkuliahan',
                'uploaded_by' => $dosen->id,
            ]
        );

        // Seed Nilai Praktikum
        Nilai::updateOrCreate(
            ['mahasiswa_id' => $mahasiswa->id, 'komponen' => 'Ujian Tengah Semester & Proyek Sistem'],
            [
                'mata_kuliah' => 'Rekayasa Perangkat Lunak & Web',
                'skor' => 95,
                'indeks' => 'A',
                'updated_by' => $dosen->id,
            ]
        );

        Nilai::updateOrCreate(
            ['mahasiswa_id' => $alvin->id, 'komponen' => 'Ujian Tengah Semester & Proyek Sistem'],
            [
                'mata_kuliah' => 'Rekayasa Perangkat Lunak & Web',
                'skor' => 88,
                'indeks' => 'A',
                'updated_by' => $dosen->id,
            ]
        );
    }
}
