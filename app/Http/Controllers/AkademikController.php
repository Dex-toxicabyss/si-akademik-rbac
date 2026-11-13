<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AkademikController extends Controller
{
    public function dashboard(): View
    {
        return view('akademik.dashboard', [
            'user' => Auth::user(),
            'totalUsers' => User::count(),
            'totalMateri' => Materi::count(),
            'totalNilai' => Nilai::count(),
        ]);
    }

    // 1. Manajemen Pengguna — Hanya Admin (role:admin)
    public function usersIndex(): View
    {
        return view('akademik.users', [
            'users' => User::orderBy('role')->get(),
        ]);
    }

    public function usersStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'identifier' => ['required', 'string', 'max:50', 'unique:users,identifier'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'in:admin,dosen,mahasiswa'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        User::create([
            'name' => $validated['name'],
            'identifier' => $validated['identifier'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.index')->with('status', 'Akun pengguna baru berhasil ditambahkan.');
    }

    // 2. Materi Perkuliahan — Lihat: Admin, Dosen, Mahasiswa | Kelola: Admin, Dosen
    public function materiIndex(): View
    {
        return view('akademik.materi', [
            'materis' => Materi::with('author')->latest()->get(),
        ]);
    }

    public function materiStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_mk' => ['required', 'string', 'max:20'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kategori' => ['required', 'string', 'max:50'],
        ]);

        Materi::create([
            ...$validated,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('materi.index')->with('status', 'Materi perkuliahan berhasil diunggah.');
    }

    public function materiDestroy(Materi $materi): RedirectResponse
    {
        $materi->delete();
        return redirect()->route('materi.index')->with('status', 'Materi berhasil dihapus.');
    }

    // 3. Nilai Akademik — Lihat Transkrip: Admin, Dosen, Mahasiswa | Input/Kelola: Admin, Dosen
    public function nilaiIndex(): View
    {
        $user = Auth::user();
        $query = Nilai::with(['mahasiswa', 'dosen']);

        if ($user->isMahasiswa()) {
            $query->where('mahasiswa_id', $user->id);
        }

        return view('akademik.nilai', [
            'nilais' => $query->latest()->get(),
            'mahasiswas' => User::where('role', 'mahasiswa')->get(),
        ]);
    }

    public function nilaiStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'mahasiswa_id' => ['required', 'exists:users,id'],
            'mata_kuliah' => ['required', 'string', 'max:100'],
            'komponen' => ['required', 'string', 'max:100'],
            'skor' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $skor = (int) $validated['skor'];
        $indeks = match (true) {
            $skor >= 80 => 'A',
            $skor >= 75 => 'AB',
            $skor >= 65 => 'B',
            $skor >= 60 => 'BC',
            $skor >= 50 => 'C',
            $skor >= 40 => 'D',
            default => 'E',
        };

        Nilai::create([
            'mahasiswa_id' => $validated['mahasiswa_id'],
            'mata_kuliah' => $validated['mata_kuliah'],
            'komponen' => $validated['komponen'],
            'skor' => $skor,
            'indeks' => $indeks,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('nilai.index')->with('status', 'Data nilai akademik berhasil disimpan.');
    }
}
