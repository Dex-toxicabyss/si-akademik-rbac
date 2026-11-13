<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Portal Akademik SI — Telkom University' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#08090A] text-[#F7F8F8] min-h-screen font-sans">
    <header class="border-b border-white/10 bg-[#16171C] px-6 py-3.5 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <span class="font-semibold tracking-tight text-base">SI-AKADEMIK RBAC</span>
            <span class="text-xs font-mono px-2 py-0.5 rounded bg-[#1E1F25] text-[#A78BFA] border border-white/5">
                v1.0 RBAC Portal
            </span>
        </div>
        @auth
        <div class="flex items-center gap-4">
            <div class="text-right">
                <div class="text-sm font-medium">{{ auth()->user()->name }}</div>
                <div class="text-xs font-mono text-[#9CA3AF]">
                    {{ auth()->user()->identifier }} · role:{{ auth()->user()->role }}
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-3 py-1.5 text-xs font-medium bg-[#1E1F25] hover:bg-red-500/20 text-[#F7F8F8] hover:text-red-300 border border-white/10 rounded-md transition">
                    Logout
                </button>
            </form>
        </div>
        @endauth
    </header>
    <div class="max-w-6xl mx-auto p-6">
        @if (session('status'))
            <div class="mb-4 p-3 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-sm">
                {{ session('status') }}
            </div>
        @endif
        <nav class="flex flex-wrap gap-2 mb-6 border-b border-white/10 pb-4">
            <a href="{{ route('dashboard') }}" class="px-3 py-1.5 rounded-md text-sm bg-[#16171C] hover:bg-[#1E1F25] border border-white/10">Dashboard</a>
            <a href="{{ route('users.index') }}" class="px-3 py-1.5 rounded-md text-sm bg-[#16171C] hover:bg-[#1E1F25] border border-white/10">Manajemen Pengguna (/users)</a>
            <a href="{{ route('materi.index') }}" class="px-3 py-1.5 rounded-md text-sm bg-[#16171C] hover:bg-[#1E1F25] border border-white/10">Materi Kuliah (/materi)</a>
            <a href="{{ route('nilai.index') }}" class="px-3 py-1.5 rounded-md text-sm bg-[#16171C] hover:bg-[#1E1F25] border border-white/10">Nilai Akademik (/nilai)</a>
            <a href="{{ route('nilai.manage') }}" class="px-3 py-1.5 rounded-md text-sm bg-[#16171C] hover:bg-[#1E1F25] border border-white/10">Input Nilai (/nilai/manage)</a>
        </nav>
        @yield('content')
    </div>
</body>
</html>
