@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-[#0f172a] px-6 pt-36 pb-16 text-slate-100">
    <div class="mx-auto max-w-7xl space-y-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.24em] text-emerald-300">Detail Kelas</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-white md:text-4xl">Kelas {{ $kelas }}</h1>
                <p class="mt-3 max-w-2xl text-sm font-semibold leading-6 text-slate-400">
                    Data lengkap siswa, mapel, guru pengampu, rekap hasil, dan aktivitas evaluasi kelas {{ $kelas }}.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('superadmin.classes') }}" class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-sm font-black text-slate-200 transition hover:bg-white/10">
                    Kembali
                </a>
                <a href="{{ route('superadmin.results', ['kelas' => $kelas]) }}" class="inline-flex items-center gap-2 rounded-lg bg-emerald-400 px-4 py-3 text-sm font-black text-slate-950 transition hover:bg-emerald-300">
                    Lihat Semua Hasil
                </a>
            </div>
        </div>

        <section class="grid gap-4 md:grid-cols-3 lg:grid-cols-6">
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Siswa</p>
                <p class="mt-3 text-3xl font-black text-white">{{ $summary['total_siswa'] }}</p>
            </div>
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Mapel</p>
                <p class="mt-3 text-3xl font-black text-cyan-300">{{ $summary['total_kategori'] }}</p>
            </div>
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Hasil</p>
                <p class="mt-3 text-3xl font-black text-fuchsia-300">{{ $summary['total_hasil'] }}</p>
            </div>
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Rata-rata</p>
                <p class="mt-3 text-3xl font-black text-emerald-300">{{ $summary['rata_rata'] }}</p>
            </div>
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Lulus</p>
                <p class="mt-3 text-3xl font-black text-emerald-300">{{ $summary['lulus'] }}</p>
            </div>
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Remedial</p>
                <p class="mt-3 text-3xl font-black text-orange-300">{{ $summary['remedial'] }}</p>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1.4fr_0.6fr]">
            <div class="rounded-lg border border-white/10 bg-slate-900/80">
                <div class="flex flex-col gap-3 border-b border-white/10 p-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-cyan-300">Siswa Kelas {{ $kelas }}</p>
                        <h2 class="mt-2 text-xl font-black text-white">Daftar Siswa dan Performa</h2>
                    </div>
                    <a href="{{ route('superadmin.users', ['role' => 'siswa', 'kelas' => $kelas]) }}" class="text-sm font-black text-cyan-300 hover:text-cyan-200">Kelola siswa</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-950/60 text-xs uppercase tracking-widest text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Nama</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4 text-center">Pengerjaan</th>
                                <th class="px-6 py-4 text-center">Rata-rata</th>
                                <th class="px-6 py-4 text-center">Tertinggi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($students as $student)
                                <tr class="hover:bg-white/[0.03]">
                                    <td class="px-6 py-4 font-bold text-white">{{ $student->name }}</td>
                                    <td class="px-6 py-4 text-slate-400">{{ $student->email }}</td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-300">{{ $student->results_count }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="rounded-md px-3 py-1 text-xs font-black {{ ($student->results_avg_skor ?? 0) >= 75 ? 'bg-emerald-500/10 text-emerald-300' : 'bg-orange-500/10 text-orange-300' }}">
                                            {{ round($student->results_avg_skor ?? 0, 1) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-black text-cyan-300">{{ $student->results_max_skor ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-14 text-center font-bold text-slate-500">Belum ada siswa di kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($students->hasPages())
                    <div class="border-t border-white/10 p-6">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>

            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-6">
                <div class="border-b border-white/10 pb-4">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-emerald-300">Ranking</p>
                    <h2 class="mt-2 text-xl font-black text-white">Siswa Teratas</h2>
                </div>
                <div class="mt-5 space-y-3">
                    @forelse($topStudents as $index => $student)
                        <div class="flex items-center justify-between rounded-lg bg-white/[0.04] p-4">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-emerald-400/10 text-sm font-black text-emerald-300">{{ $index + 1 }}</span>
                                <div>
                                    <p class="font-black text-white">{{ $student->name }}</p>
                                    <p class="text-xs font-bold text-slate-500">Tertinggi {{ $student->results_max_skor ?? 0 }}</p>
                                </div>
                            </div>
                            <span class="text-lg font-black text-cyan-300">{{ round($student->results_avg_skor ?? 0, 1) }}</span>
                        </div>
                    @empty
                        <p class="rounded-lg border border-dashed border-white/10 p-6 text-center font-bold text-slate-500">Belum ada ranking.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="rounded-lg border border-white/10 bg-slate-900/80">
                <div class="border-b border-white/10 p-6">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-fuchsia-300">Mapel dan Guru</p>
                    <h2 class="mt-2 text-xl font-black text-white">Kategori Kuis Kelas {{ $kelas }}</h2>
                </div>
                <div class="divide-y divide-white/5">
                    @forelse($categories as $category)
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-black text-white">{{ $category->nama_kategori }}</p>
                                    <p class="mt-1 text-xs font-bold text-slate-500">Guru: {{ $category->user->name ?? '-' }} | {{ $category->durasi }} menit</p>
                                </div>
                                <span class="rounded-md bg-fuchsia-400/10 px-3 py-1 text-xs font-black text-fuchsia-300">{{ $category->results_count }} hasil</span>
                            </div>
                            <div class="mt-4 grid grid-cols-2 gap-3">
                                <div class="rounded-lg bg-white/[0.04] p-3">
                                    <p class="text-xs font-bold uppercase text-slate-500">Soal</p>
                                    <p class="mt-1 text-xl font-black text-cyan-300">{{ $category->questions_count }}</p>
                                </div>
                                <div class="rounded-lg bg-white/[0.04] p-3">
                                    <p class="text-xs font-bold uppercase text-slate-500">Pengerjaan</p>
                                    <p class="mt-1 text-xl font-black text-emerald-300">{{ $category->results_count }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="p-8 text-center font-bold text-slate-500">Belum ada mapel untuk kelas ini.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-lg border border-white/10 bg-slate-900/80">
                <div class="flex items-center justify-between border-b border-white/10 p-6">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-cyan-300">Aktivitas Terbaru</p>
                        <h2 class="mt-2 text-xl font-black text-white">Hasil Evaluasi</h2>
                    </div>
                    <a href="{{ route('superadmin.results', ['kelas' => $kelas]) }}" class="text-sm font-black text-cyan-300 hover:text-cyan-200">Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-950/60 text-xs uppercase tracking-widest text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Siswa</th>
                                <th class="px-6 py-4">Mapel</th>
                                <th class="px-6 py-4 text-center">Skor</th>
                                <th class="px-6 py-4 text-right">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($recentResults as $result)
                                <tr class="hover:bg-white/[0.03]">
                                    <td class="px-6 py-4 font-bold text-white">{{ $result->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-slate-400">{{ $result->category->nama_kategori ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="rounded-md px-3 py-1 text-xs font-black {{ $result->skor >= 75 ? 'bg-emerald-500/10 text-emerald-300' : 'bg-orange-500/10 text-orange-300' }}">{{ $result->skor }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-xs font-bold text-slate-500">{{ $result->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-14 text-center font-bold text-slate-500">Belum ada hasil evaluasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
