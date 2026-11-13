@extends('layouts.app', ['title' => 'Materi Perkuliahan'])
@section('content')
<div class="bg-[#16171C] border border-white/10 rounded-xl p-5">
    <h2 class="text-base font-semibold mb-4">Daftar Materi Perkuliahan</h2>
    @foreach ($materis as $m)
    <div class="p-3 mb-3 rounded-lg bg-[#1E1F25] border border-white/5 flex justify-between items-center">
        <div>
            <span class="text-xs font-mono text-[#A78BFA]">{{ $m->kode_mk }} · {{ $m->kategori }}</span>
            <h3 class="text-sm font-medium mt-0.5">{{ $m->judul }}</h3>
            <p class="text-xs text-[#9CA3AF]">{{ $m->deskripsi }}</p>
        </div>
    </div>
    @endforeach
</div>
@endsection
