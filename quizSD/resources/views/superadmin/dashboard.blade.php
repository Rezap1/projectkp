@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-[#0f172a] px-6 pt-36 pb-16 text-slate-100">
    <div class="mx-auto max-w-7xl space-y-8">
        @if(session('success'))
            <div class="rounded-lg border border-emerald-400/30 bg-emerald-500/10 px-5 py-4 text-sm font-bold text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <section class="grid gap-6 lg:grid-cols-[1.5fr_0.9fr]">
            <div class="rounded-lg border border-fuchsia-400/15 bg-slate-900/80 p-7 shadow-2xl shadow-fuchsia-950/20">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-fuchsia-300">System Administrator</p>
                        <h1 class="mt-3 text-4xl font-black tracking-tight text-white md:text-5xl">SuperAdmin</h1>
                        <p class="mt-3 max-w-2xl text-sm font-semibold leading-6 text-slate-400">
                            Kelola semua pengguna, kelas, dan pantau hasil evaluasi seluruh sekolah dari satu tempat.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('superadmin.users') }}" class="inline-flex items-center gap-2 rounded-lg border border-fuchsia-400/20 bg-fuchsia-400/10 px-4 py-3 text-sm font-black text-fuchsia-200 transition hover:bg-fuchsia-400/20">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            Kelola Pengguna
                        </a>
                    </div>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-4">
                    <div class="rounded-lg border border-white/10 bg-white/[0.04] p-5">
                        <p class="text-xs font-black uppercase tracking-widest text-slate-500">Guru</p>
                        <p class="mt-3 text-4xl font-black text-white">{{ $totalGuru }}</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/[0.04] p-5">
                        <p class="text-xs font-black uppercase tracking-widest text-slate-500">Siswa</p>
                        <p class="mt-3 text-4xl font-black text-cyan-300">{{ $totalSiswa }}</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/[0.04] p-5">
                        <p class="text-xs font-black uppercase tracking-widest text-slate-500">Total Kelas</p>
                        <p class="mt-3 text-4xl font-black text-emerald-300">{{ $totalKelas }}</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/[0.04] p-5">
                        <p class="text-xs font-black uppercase tracking-widest text-slate-500">Total Hasil</p>
                        <p class="mt-3 text-4xl font-black text-fuchsia-300">{{ $totalHasil }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-cyan-300">Akses Cepat</p>
                        <h2 class="mt-2 text-xl font-black text-white">Menu Utama</h2>
                    </div>
                </div>

                <div class="mt-6 grid gap-3">
                    <a href="{{ route('superadmin.users') }}" class="flex items-center justify-between rounded-lg border border-white/10 bg-white/[0.04] px-4 py-4 font-bold text-slate-200 transition hover:border-cyan-400/40 hover:bg-cyan-400/10">
                        <span>Daftar Pengguna</span>
                        <span class="text-sm text-cyan-300">{{ $totalGuru + $totalSiswa }} total</span>
                    </a>
                    <a href="{{ route('superadmin.classes') }}" class="flex items-center justify-between rounded-lg border border-white/10 bg-white/[0.04] px-4 py-4 font-bold text-slate-200 transition hover:border-emerald-400/40 hover:bg-emerald-400/10">
                        <span>Data Kelas</span>
                        <span class="text-sm text-emerald-300">{{ $totalKelas }} kelas</span>
                    </a>
                    <a href="{{ route('superadmin.results') }}" class="flex items-center justify-between rounded-lg border border-white/10 bg-white/[0.04] px-4 py-4 font-bold text-slate-200 transition hover:border-fuchsia-400/40 hover:bg-fuchsia-400/10">
                        <span>Semua Hasil Evaluasi</span>
                        <span class="text-sm text-fuchsia-300">{{ $totalHasil }} hasil</span>
                    </a>
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1fr_1fr]">
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-6">
                <div class="flex items-center justify-between border-b border-white/10 pb-4">
                    <h2 class="text-xl font-black text-white">Pengguna Terbaru</h2>
                    <a href="{{ route('superadmin.users') }}" class="text-sm font-black text-cyan-300 hover:text-cyan-200">Lihat semua</a>
                </div>
                <div class="mt-4 space-y-3">
                    @forelse($recentUsers as $user)
                        <div class="rounded-lg bg-white/[0.03] p-4 flex justify-between items-center">
                            <div>
                                <p class="font-bold text-slate-200">{{ $user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $user->email }}</p>
                            </div>
                            <span class="rounded-md px-2 py-1 text-xs font-black {{ $user->role === 'guru' ? 'bg-emerald-500/10 text-emerald-300' : 'bg-cyan-500/10 text-cyan-300' }}">
                                {{ strtoupper($user->role) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada pengguna.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-6">
                <div class="flex items-center justify-between border-b border-white/10 pb-4">
                    <h2 class="text-xl font-black text-white">Hasil Evaluasi Terbaru</h2>
                    <a href="{{ route('superadmin.results') }}" class="text-sm font-black text-cyan-300 hover:text-cyan-200">Lihat semua</a>
                </div>
                <div class="mt-4 space-y-3">
                    @forelse($recentResults as $res)
                        <div class="rounded-lg bg-white/[0.03] p-4 flex justify-between items-center">
                            <div>
                                <p class="font-bold text-slate-200">{{ $res->user->name ?? 'Siswa' }} <span class="text-xs text-slate-500">(Kelas {{ $res->user->kelas ?? '-' }})</span></p>
                                <p class="text-xs text-slate-500">{{ $res->category->nama_kategori ?? 'Kuis' }}</p>
                            </div>
                            <span class="rounded-md px-3 py-1 text-xs font-black {{ $res->skor >= 75 ? 'bg-emerald-500/10 text-emerald-300' : 'bg-orange-500/10 text-orange-300' }}">
                                {{ $res->skor }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada hasil.</p>
                    @endforelse
                </div>
            </div>
        </section>

    </div>
</div>
@endsection
