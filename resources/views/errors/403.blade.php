<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden — Akses Ditolak Middleware CheckRole</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#08090A] text-[#F7F8F8] min-h-screen flex items-center justify-center p-6 font-sans">
    <div class="max-w-lg w-full bg-[#16171C] border border-red-500/30 rounded-xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="px-2.5 py-1 text-xs font-mono bg-red-500/15 text-red-400 rounded border border-red-500/30">
                HTTP 403 FORBIDDEN
            </span>
            <span class="text-xs font-mono text-[#9CA3AF]">Middleware: CheckRole</span>
        </div>
        <h1 class="text-xl font-semibold mb-2">Akses Route Ditolak</h1>
        <p class="text-sm text-[#9CA3AF] mb-4">
            {{ $exception->getMessage() ?: 'Akun Anda tidak memiliki otorisasi role untuk mengakses halaman ini.' }}
        </p>
        <div class="bg-[#1E1F25] p-3 rounded-lg font-mono text-xs text-[#A78BFA] mb-5">
            Active User: {{ auth()->check() ? auth()->user()->email . ' (role:' . auth()->user()->role . ')' : 'Guest' }}
        </div>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-[#5E6AD2] hover:bg-[#4F5BC0] text-white text-sm font-medium rounded-md transition">
            Kembali ke Dashboard
        </a>
    </div>
</body>
</html>
