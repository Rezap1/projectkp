@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-[#0f172a] px-6 pt-36 pb-16 text-slate-100">
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-black text-cyan-300 hover:text-cyan-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M15 19 8 12l7-7"/></svg>
                    Dashboard
                </a>
                <p class="mt-6 text-xs font-black uppercase tracking-[0.24em] text-cyan-300">Rekap Nilai</p>
                <h1 class="mt-2 text-4xl font-black tracking-tight text-white">Hasil Siswa</h1>
                <p class="mt-3 max-w-2xl text-sm font-semibold leading-6 text-slate-400">Pantau skor, status kelulusan, waktu pengerjaan, dan bersihkan data hasil bila diperlukan.</p>
            </div>

            <button onclick="window.print()" class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-sm font-black text-slate-200 transition hover:bg-white/10">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17h10v4H7v-4Zm0-8V3h10v6M5 17H4a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1"/></svg>
                Cetak
            </button>
        </div>

        @if(session('success'))
            <div class="rounded-lg border border-emerald-400/30 bg-emerald-500/10 px-5 py-4 text-sm font-bold text-emerald-200">{{ session('success') }}</div>
        @endif

        <section class="grid gap-4 md:grid-cols-4">
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Total Hasil</p>
                <p class="mt-3 text-4xl font-black text-white">{{ $summary['total'] }}</p>
            </div>
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Rata-rata</p>
                <p class="mt-3 text-4xl font-black text-cyan-300">{{ round($summary['avg']) }}</p>
            </div>
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Lulus</p>
                <p class="mt-3 text-4xl font-black text-emerald-300">{{ $summary['passed'] }}</p>
            </div>
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Remedial</p>
                <p class="mt-3 text-4xl font-black text-orange-300">{{ $summary['remedial'] }}</p>
            </div>
        </section>

        <form method="GET" class="rounded-lg border border-white/10 bg-slate-900/80 p-5 no-print">
            <div class="grid gap-4 xl:grid-cols-[1fr_160px_220px_180px_auto] xl:items-end">
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Siswa</label>
                    <input name="q" value="{{ request('q') }}" placeholder="Cari nama siswa..." class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400">
                </div>
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Kelas</label>
                    <select name="kelas" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                        <option value="">Semua</option>
                        @foreach([4, 5, 6] as $kelas)
                            <option value="{{ $kelas }}" @selected(request('kelas') == $kelas)>Kelas {{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Kategori</label>
                    <select name="category_id" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                        <option value="">Semua kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>K{{ $category->kelas }} - {{ $category->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                </div>
                <div class="flex gap-2">
                    <button class="rounded-lg bg-cyan-400 px-5 py-3 text-sm font-black text-slate-950 transition hover:bg-cyan-300">Filter</button>
                    <a href="{{ route('results.index') }}" class="rounded-lg border border-white/10 bg-white/5 px-5 py-3 text-sm font-black text-slate-300 transition hover:text-white">Reset</a>
                </div>
            </div>
        </form>

        <section class="rounded-lg border border-white/10 bg-slate-900/80">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left text-sm">
                    <thead class="bg-slate-950/60 text-xs uppercase tracking-widest text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Siswa</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4 text-center">Benar</th>
                            <th class="px-6 py-4 text-center">Salah</th>
                            <th class="px-6 py-4 text-center">Skor</th>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4 text-right no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($results as $result)
                            <tr class="hover:bg-white/[0.03]">
                                <td class="px-6 py-5">
                                    <p class="font-black text-white">{{ $result->user->name ?? '-' }}</p>
                                    <p class="mt-1 text-xs font-bold text-slate-500">{{ $result->user->email ?? '-' }} | Kelas {{ $result->user->kelas ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="font-bold text-slate-200">{{ $result->category->nama_kategori ?? '-' }}</p>
                                    <p class="mt-1 text-xs font-bold text-slate-500">Kelas {{ $result->category->kelas ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-5 text-center font-black text-emerald-300">{{ $result->benar }}</td>
                                <td class="px-6 py-5 text-center font-black text-orange-300">{{ $result->salah }}</td>
                                <td class="px-6 py-5 text-center">
                                    <span class="rounded-md px-3 py-1 text-xs font-black {{ $result->skor >= 75 ? 'bg-emerald-500/10 text-emerald-300' : 'bg-orange-500/10 text-orange-300' }}">{{ $result->skor }}</span>
                                </td>
                                <td class="px-6 py-5 text-sm font-bold text-slate-500">{{ $result->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-5 text-right no-print">
                                    <form method="POST" action="{{ route('results.destroy', $result) }}" onsubmit="return confirm('Hapus hasil siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-red-400/20 bg-red-500/10 p-3 text-red-300 transition hover:bg-red-500 hover:text-white" title="Hapus hasil">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0A48.108 48.108 0 0 0 16.5 5.5m-9 0a48.11 48.11 0 0 0-2.728.29m0 0A48.667 48.667 0 0 1 12 5.25c2.466 0 4.862.185 7.228.54"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center font-bold text-slate-500">Belum ada hasil sesuai filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-white/10 p-6 no-print">
                {{ $results->links() }}
            </div>
        </section>
    </div>
</div>

<style>
    @media print {
        nav, footer, .no-print, a, button { display: none !important; }
        body, main, div { background: #fff !important; color: #111827 !important; box-shadow: none !important; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border-bottom: 1px solid #e5e7eb; }
    }
</style>
@endsection
