@extends('layouts.app', ['title' => 'Dashboard Akademik'])
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-[#16171C] border border-white/10 rounded-xl p-4">
        <div class="text-xs text-[#9CA3AF]">Total Pengguna Terdaftar</div>
        <div class="text-2xl font-semibold mt-1">{{ $totalUsers }}</div>
    </div>
    <div class="bg-[#16171C] border border-white/10 rounded-xl p-4">
        <div class="text-xs text-[#9CA3AF]">Total Materi Perkuliahan</div>
        <div class="text-2xl font-semibold mt-1">{{ $totalMateri }}</div>
    </div>
    <div class="bg-[#16171C] border border-white/10 rounded-xl p-4">
        <div class="text-xs text-[#9CA3AF]">Total Entri Nilai</div>
        <div class="text-2xl font-semibold mt-1">{{ $totalNilai }}</div>
    </div>
</div>
@endsection
