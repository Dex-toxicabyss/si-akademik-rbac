@extends('layouts.app', ['title' => 'Login Portal Akademik'])
@section('content')
<div class="max-w-md mx-auto bg-[#16171C] border border-white/10 rounded-xl p-6 mt-8">
    <h1 class="text-lg font-semibold mb-1">Autentikasi Portal Akademik</h1>
    <p class="text-xs text-[#9CA3AF] mb-5">Gunakan akun Admin, Dosen, atau Mahasiswa untuk menguji Middleware CheckRole.</p>
    <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs text-[#9CA3AF] mb-1">Email Sivitas</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2 rounded-md bg-[#08090A] border border-white/10 text-sm">
            @error('email') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-xs text-[#9CA3AF] mb-1">Password</label>
            <input type="password" name="password" required class="w-full px-3 py-2 rounded-md bg-[#08090A] border border-white/10 text-sm">
        </div>
        <button type="submit" class="w-full py-2 bg-[#5E6AD2] hover:bg-[#4F5BC0] text-white rounded-md text-sm font-medium transition">
            Masuk ke Sistem
        </button>
    </form>
</div>
@endsection
