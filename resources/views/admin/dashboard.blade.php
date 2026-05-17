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
            <div class="rounded-lg border border-cyan-400/15 bg-slate-900/80 p-7 shadow-2xl shadow-cyan-950/20">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-cyan-300">Admin Database</p>
                        <h1 class="mt-3 text-4xl font-black tracking-tight text-white md:text-5xl">Panel Guru</h1>
                        <p class="mt-3 max-w-2xl text-sm font-semibold leading-6 text-slate-400">
                            Kelola mata pelajaran, bank soal, durasi kuis, dan hasil siswa dari satu ruang kerja.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-cyan-400/20 bg-cyan-400/10 px-4 py-3 text-sm font-black text-cyan-200 transition hover:bg-cyan-400/20">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                             Mapel
                        </a>
                        <a href="{{ route('questions.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-cyan-400 px-4 py-3 text-sm font-black text-slate-950 shadow-lg shadow-cyan-500/20 transition hover:bg-cyan-300">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M12 4v16m8-8H4"/></svg>
                            Tambah Soal
                        </a>
                    </div>
                </div>

                <div class="mt-8 grid gap-4 md:grid-cols-4">
                    <div class="rounded-lg border border-white/10 bg-white/[0.04] p-5">
                        <p class="text-xs font-black uppercase tracking-widest text-slate-500">Pelajaran</p>
                        <p class="mt-3 text-4xl font-black text-white">{{ $totalKategori }}</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/[0.04] p-5">
                        <p class="text-xs font-black uppercase tracking-widest text-slate-500">Soal</p>
                        <p class="mt-3 text-4xl font-black text-cyan-300">{{ $totalSoal }}</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/[0.04] p-5">
                        <p class="text-xs font-black uppercase tracking-widest text-slate-500">Siswa Hari Ini</p>
                        <p class="mt-3 text-4xl font-black text-fuchsia-300">{{ $totalSiswaHariIni }}</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/[0.04] p-5">
                        <p class="text-xs font-black uppercase tracking-widest text-slate-500">Rata-rata</p>
                        <p class="mt-3 text-4xl font-black text-emerald-300">{{ round($rataRataNilai) }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-fuchsia-300">Kontrol Cepat</p>
                        <h2 class="mt-2 text-xl font-black text-white">Kelola Data</h2>
                    </div>
                    <button onclick="window.print()" class="rounded-lg border border-white/10 bg-white/5 p-3 text-slate-300 transition hover:text-white" title="Cetak laporan">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17h10v4H7v-4Zm0-8V3h10v6M5 17H4a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1"/></svg>
                    </button>
                </div>

                <div class="mt-6 grid gap-3">
                    <a href="{{ route('questions.index') }}" class="flex items-center justify-between rounded-lg border border-white/10 bg-white/[0.04] px-4 py-4 font-bold text-slate-200 transition hover:border-cyan-400/40 hover:bg-cyan-400/10">
                        <span>Bank Soal</span>
                        <span class="text-sm text-cyan-300">{{ $totalSoal }} item</span>
                    </a>
                    <a href="{{ route('results.index') }}" class="flex items-center justify-between rounded-lg border border-white/10 bg-white/[0.04] px-4 py-4 font-bold text-slate-200 transition hover:border-fuchsia-400/40 hover:bg-fuchsia-400/10">
                        <span>Rekap Hasil</span>
                        <span class="text-sm text-fuchsia-300">{{ $totalHasil }} hasil</span>
                    </a>
                    <a href="{{ route('categories.index') }}" class="flex items-center justify-between rounded-lg border border-white/10 bg-white/[0.04] px-4 py-4 font-bold text-slate-200 transition hover:border-emerald-400/40 hover:bg-emerald-400/10">
                        <span>Mata Pelajaran</span>
                        <span class="text-sm text-emerald-300">{{ $totalKategori }} kelas</span>
                    </a>
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-3">
            @foreach([4, 5, 6] as $kelas)
                <div class="rounded-lg border border-white/10 bg-slate-900/75 p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-black text-white">Kelas {{ $kelas }}</h3>
                        <span class="rounded-md bg-cyan-400/10 px-3 py-1 text-xs font-black text-cyan-300">{{ round($kelasStats[$kelas]['rata']) }} rata-rata</span>
                    </div>
                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div class="rounded-lg bg-white/[0.04] p-4">
                            <p class="text-xs font-bold uppercase text-slate-500">Kategori</p>
                            <p class="mt-2 text-2xl font-black text-white">{{ $kelasStats[$kelas]['kategori'] }}</p>
                        </div>
                        <div class="rounded-lg bg-white/[0.04] p-4">
                            <p class="text-xs font-bold uppercase text-slate-500">Soal</p>
                            <p class="mt-2 text-2xl font-black text-cyan-300">{{ $kelasStats[$kelas]['soal'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

        <section class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="rounded-lg border border-white/10 bg-slate-900/80">
                <div class="flex items-center justify-between border-b border-white/10 p-6">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-cyan-300">Aktivitas Hari Ini</p>
                        <h2 class="mt-2 text-2xl font-black text-white">Pengumpulan Terbaru</h2>
                    </div>
                    <a href="{{ route('results.index') }}" class="text-sm font-black text-cyan-300 hover:text-cyan-200">Lihat semua</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-950/60 text-xs uppercase tracking-widest text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Siswa</th>
                                <th class="px-6 py-4">Kuis</th>
                                <th class="px-6 py-4 text-center">Skor</th>
                                <th class="px-6 py-4 text-right">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($aktivitasKelas4->merge($aktivitasKelas5)->merge($aktivitasKelas6)->sortByDesc('created_at')->take(8) as $res)
                                <tr class="hover:bg-white/[0.03]">
                                    <td class="px-6 py-4 font-bold text-white">{{ $res->user->name ?? '-' }} <span class="text-xs text-slate-500">Kelas {{ $res->user->kelas ?? '-' }}</span></td>
                                    <td class="px-6 py-4 text-slate-300">{{ $res->category->nama_kategori ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="rounded-md px-3 py-1 text-xs font-black {{ $res->skor >= 75 ? 'bg-emerald-500/10 text-emerald-300' : 'bg-orange-500/10 text-orange-300' }}">{{ $res->skor }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-xs font-bold text-slate-500">{{ $res->created_at->format('H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-14 text-center font-bold text-slate-500">Belum ada siswa yang mengerjakan hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-lg border border-white/10 bg-slate-900/80 p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-black text-white">Kategori Aktif</h2>
                        <a href="{{ route('categories.index') }}" class="text-sm font-black text-cyan-300 hover:text-cyan-200">Kelola</a>
                    </div>
                    <div class="mt-5 space-y-3">
                        @forelse($categorySummary as $category)
                            <div class="rounded-lg border border-white/10 bg-white/[0.03] p-4">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="font-black text-white">{{ $category->nama_kategori }}</p>
                                        <p class="mt-1 text-xs font-bold text-slate-500">Kelas {{ $category->kelas }} | {{ $category->durasi }} menit</p>
                                    </div>
                                    <div class="text-right text-xs font-black text-cyan-300">{{ $category->questions_count }} soal</div>
                                </div>
                            </div>
                        @empty
                            <p class="rounded-lg border border-dashed border-white/10 p-6 text-center font-bold text-slate-500">Belum ada kategori.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-lg border border-white/10 bg-slate-900/80 p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-black text-white">Soal Terbaru</h2>
                        <a href="{{ route('questions.index') }}" class="text-sm font-black text-cyan-300 hover:text-cyan-200">Bank soal</a>
                    </div>
                    <div class="mt-5 space-y-3">
                        @forelse($recentQuestions as $question)
                            <div class="rounded-lg bg-white/[0.03] p-4">
                                <p class="line-clamp-2 text-sm font-bold text-slate-200">{{ $question->pertanyaan }}</p>
                                <p class="mt-2 text-xs font-bold text-slate-500">{{ $question->category->nama_kategori ?? '-' }}</p>
                            </div>
                        @empty
                            <p class="rounded-lg border border-dashed border-white/10 p-6 text-center font-bold text-slate-500">Belum ada soal.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<style>
    @media print {
        nav, footer, a, button { display: none !important; }
        body, main, div { background: #fff !important; color: #111827 !important; box-shadow: none !important; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border-bottom: 1px solid #e5e7eb; }
    }
</style>
@endsection
