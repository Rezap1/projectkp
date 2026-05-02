@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-[#0f172a] px-6 pt-36 pb-16 text-slate-100">
    <div class="mx-auto max-w-7xl space-y-8">
        
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.24em] text-emerald-300">SuperAdmin</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-white md:text-4xl">Data Kelas</h1>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach([4, 5, 6] as $kelas)
                @php
                    $statKelas = $kelasStats->firstWhere('kelas', $kelas);
                    $totalSiswa = $statKelas ? $statKelas->total_siswa : 0;
                    
                    $statKategori = $kategoriStats->get($kelas);
                    $totalKategori = $statKategori ? $statKategori->total_kategori : 0;
                @endphp
                <div class="rounded-lg border border-emerald-400/15 bg-slate-900/80 p-6 shadow-xl shadow-emerald-950/20 transition hover:border-emerald-400/40">
                    <div class="flex items-center justify-between border-b border-white/10 pb-4">
                        <h2 class="text-2xl font-black text-white">Kelas {{ $kelas }}</h2>
                        <div class="rounded-full bg-emerald-500/10 p-3 text-emerald-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                    </div>
                    
                    <div class="mt-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-slate-400">Total Siswa Terdaftar</span>
                            <span class="text-lg font-black text-cyan-300">{{ $totalSiswa }} Siswa</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold text-slate-400">Kategori / Mapel Aktif</span>
                            <span class="text-lg font-black text-emerald-300">{{ $totalKategori }} Mapel</span>
                        </div>
                    </div>
                    
                    <div class="mt-8 border-t border-white/10 pt-4">
                        <a href="{{ route('superadmin.users', ['kelas' => $kelas, 'role' => 'siswa']) }}" class="flex items-center justify-center gap-2 rounded-lg bg-emerald-500/10 px-4 py-3 text-sm font-bold text-emerald-300 transition hover:bg-emerald-500/20">
                            Lihat Siswa Kelas {{ $kelas }}
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
