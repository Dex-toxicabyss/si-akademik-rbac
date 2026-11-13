@extends('layouts.app', ['title' => 'Nilai Akademik'])
@section('content')
<div class="bg-[#16171C] border border-white/10 rounded-xl p-5">
    <h2 class="text-base font-semibold mb-4">Data Nilai Akademik</h2>
    <table class="w-full text-left text-sm border-collapse">
        <thead>
            <tr class="border-b border-white/10 text-[#9CA3AF] text-xs">
                <th class="py-2">Mahasiswa</th>
                <th class="py-2">Mata Kuliah</th>
                <th class="py-2">Komponen</th>
                <th class="py-2 text-right">Skor</th>
                <th class="py-2 text-right">Indeks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nilais as $n)
            <tr class="border-b border-white/5">
                <td class="py-2.5">{{ $n->mahasiswa->name ?? '-' }}</td>
                <td class="py-2.5">{{ $n->mata_kuliah }}</td>
                <td class="py-2.5">{{ $n->komponen }}</td>
                <td class="py-2.5 text-right font-mono">{{ $n->skor }}</td>
                <td class="py-2.5 text-right font-mono text-[#A78BFA]">{{ $n->indeks }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
