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

        <section class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-6">
                <div class="flex flex-col gap-4 border-b border-white/10 pb-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-emerald-300">Perkembangan Kelas</p>
                        <h2 class="mt-2 text-2xl font-black text-white">Grafik Rata-rata Nilai 7 Hari</h2>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs font-black">
                        <span class="rounded-md bg-cyan-400/10 px-3 py-1 text-cyan-300">Kelas 4</span>
                        <span class="rounded-md bg-emerald-400/10 px-3 py-1 text-emerald-300">Kelas 5</span>
                        <span class="rounded-md bg-fuchsia-400/10 px-3 py-1 text-fuchsia-300">Kelas 6</span>
                    </div>
                </div>

                @php
                    $lineColors = [4 => '#67e8f9', 5 => '#6ee7b7', 6 => '#f0abfc'];
                    $pointsByClass = [];
                    foreach ([4, 5, 6] as $kelas) {
                        $values = collect($classProgress[$kelas] ?? []);
                        $lastIndex = max($values->count() - 1, 1);
                        $points = [];
                        foreach ($values as $index => $value) {
                            $x = 42 + (($index * 632) / $lastIndex);
                            $y = 190 - ((min(100, max(0, $value)) / 100) * 150);
                            $points[] = round($x, 2) . ',' . round($y, 2);
                        }
                        $pointsByClass[$kelas] = implode(' ', $points);
                    }
                @endphp

                <div class="mt-6 overflow-x-auto">
                    <svg viewBox="0 0 720 230" class="h-72 min-w-[720px] w-full" role="img" aria-label="Grafik perkembangan nilai kelas 4, 5, dan 6">
                        @foreach([40, 77.5, 115, 152.5, 190] as $gridY)
                            <line x1="42" y1="{{ $gridY }}" x2="674" y2="{{ $gridY }}" stroke="rgba(148,163,184,0.14)" stroke-width="1" />
                        @endforeach

                        @foreach([100, 75, 50, 25, 0] as $index => $score)
                            <text x="16" y="{{ 44 + ($index * 37.5) }}" fill="#64748b" font-size="11" font-weight="800">{{ $score }}</text>
                        @endforeach

                        @foreach([4, 5, 6] as $kelas)
                            <polyline points="{{ $pointsByClass[$kelas] }}" fill="none" stroke="{{ $lineColors[$kelas] }}" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                            @foreach(collect($classProgress[$kelas] ?? []) as $index => $value)
                                @php
                                    $lastIndex = max(collect($classProgress[$kelas] ?? [])->count() - 1, 1);
                                    $x = 42 + (($index * 632) / $lastIndex);
                                    $y = 190 - ((min(100, max(0, $value)) / 100) * 150);
                                @endphp
                                <circle cx="{{ $x }}" cy="{{ $y }}" r="5" fill="#0f172a" stroke="{{ $lineColors[$kelas] }}" stroke-width="3" />
                            @endforeach
                        @endforeach

                        @foreach($progressLabels as $index => $label)
                            @php
                                $lastIndex = max($progressLabels->count() - 1, 1);
                                $x = 42 + (($index * 632) / $lastIndex);
                            @endphp
                            <text x="{{ $x }}" y="220" fill="#94a3b8" font-size="11" font-weight="800" text-anchor="middle">{{ $label }}</text>
                        @endforeach
                    </svg>
                </div>
            </div>

            <div class="grid gap-4">
                @foreach([4, 5, 6] as $kelas)
                    <a href="{{ route('superadmin.classes.show', $kelas) }}" class="rounded-lg border border-white/10 bg-slate-900/80 p-5 transition hover:border-emerald-400/40 hover:bg-emerald-400/5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Ringkasan</p>
                                <h3 class="mt-1 text-2xl font-black text-white">Kelas {{ $kelas }}</h3>
                            </div>
                            <span class="rounded-md bg-white/5 px-3 py-1 text-xs font-black text-emerald-300">Detail</span>
                        </div>
                        <div class="mt-4 grid grid-cols-4 gap-3 text-center">
                            <div class="rounded-lg bg-white/[0.04] p-3">
                                <p class="text-lg font-black text-white">{{ $kelasDashboard[$kelas]['siswa'] }}</p>
                                <p class="mt-1 text-[10px] font-bold uppercase text-slate-500">Siswa</p>
                            </div>
                            <div class="rounded-lg bg-white/[0.04] p-3">
                                <p class="text-lg font-black text-cyan-300">{{ $kelasDashboard[$kelas]['mapel'] }}</p>
                                <p class="mt-1 text-[10px] font-bold uppercase text-slate-500">Mapel</p>
                            </div>
                            <div class="rounded-lg bg-white/[0.04] p-3">
                                <p class="text-lg font-black text-fuchsia-300">{{ $kelasDashboard[$kelas]['hasil'] }}</p>
                                <p class="mt-1 text-[10px] font-bold uppercase text-slate-500">Hasil</p>
                            </div>
                            <div class="rounded-lg bg-white/[0.04] p-3">
                                <p class="text-lg font-black text-emerald-300">{{ $kelasDashboard[$kelas]['rata'] }}</p>
                                <p class="mt-1 text-[10px] font-bold uppercase text-slate-500">Rata</p>
                            </div>
                        </div>
                    </a>
                @endforeach
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
