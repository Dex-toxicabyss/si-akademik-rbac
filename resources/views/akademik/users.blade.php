@extends('layouts.app', ['title' => 'Manajemen Pengguna'])
@section('content')
<div class="bg-[#16171C] border border-white/10 rounded-xl p-5">
    <h2 class="text-base font-semibold mb-4">Manajemen Pengguna (Terlindungi Middleware role:admin)</h2>
    <table class="w-full text-left text-sm border-collapse">
        <thead>
            <tr class="border-b border-white/10 text-[#9CA3AF] text-xs">
                <th class="py-2">Nama</th>
                <th class="py-2">NIM / NIP</th>
                <th class="py-2">Email</th>
                <th class="py-2">Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $u)
            <tr class="border-b border-white/5">
                <td class="py-2.5">{{ $u->name }}</td>
                <td class="py-2.5 font-mono text-xs">{{ $u->identifier }}</td>
                <td class="py-2.5">{{ $u->email }}</td>
                <td class="py-2.5 font-mono text-xs text-[#A78BFA]">{{ $u->role }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
