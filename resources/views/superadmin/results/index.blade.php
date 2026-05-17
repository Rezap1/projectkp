@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-[#0f172a] px-6 pt-36 pb-16 text-slate-100">
    <div class="mx-auto max-w-7xl space-y-8">
        
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.24em] text-fuchsia-300">SuperAdmin</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-white md:text-4xl">Semua Hasil Evaluasi</h1>
            </div>
            <button onclick="window.print()" class="flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-sm font-bold text-slate-300 transition hover:bg-white/10 hover:text-white" title="Cetak laporan">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Rekap
            </button>
        </div>

        <div class="rounded-lg border border-white/10 bg-slate-900/80 p-6 print:hidden">
            <form method="GET" action="{{ route('superadmin.results') }}" class="flex flex-col gap-4 md:flex-row md:items-end">
                <div class="flex-1">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-widest text-slate-400">Pencarian</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama siswa, kelas, atau mapel..." class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-sm font-semibold text-white placeholder-slate-500 focus:border-fuchsia-400 focus:outline-none focus:ring-1 focus:ring-fuchsia-400">
                </div>
                <div class="w-full md:w-48">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-widest text-slate-400">Filter Kelas</label>
                    <select name="kelas" class="w-full rounded-lg border border-white/10 bg-slate-800 px-4 py-3 text-sm font-semibold text-white focus:border-fuchsia-400 focus:outline-none focus:ring-1 focus:ring-fuchsia-400">
                        <option value="">Semua Kelas</option>
                        @foreach($categories as $kelas)
                            <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>Kelas {{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="rounded-lg bg-cyan-500 px-6 py-3 text-sm font-black text-slate-950 transition hover:bg-cyan-400">
                    Filter
                </button>
            </form>
        </div>

        <div class="rounded-lg border border-white/10 bg-slate-900/80">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-950/60 text-xs uppercase tracking-widest text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Siswa</th>
                            <th class="px-6 py-4">Kelas</th>
                            <th class="px-6 py-4">Mata Pelajaran</th>
                            <th class="px-6 py-4 text-center">Skor</th>
                            <th class="px-6 py-4 text-right">Tanggal Pengerjaan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($results as $res)
                            <tr class="hover:bg-white/[0.03]">
                                <td class="px-6 py-4 font-bold text-white">{{ $res->user->name ?? 'Anonim' }}</td>
                                <td class="px-6 py-4 text-slate-400">{{ $res->user->kelas ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-400">{{ $res->category->nama_kategori ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="rounded-md px-3 py-1 text-xs font-black {{ $res->skor >= 75 ? 'bg-emerald-500/10 text-emerald-300' : 'bg-orange-500/10 text-orange-300' }}">
                                        {{ $res->skor }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-xs font-bold text-slate-500">{{ $res->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-14 text-center font-bold text-slate-500">Belum ada hasil evaluasi yang terekam.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($results->hasPages())
                <div class="border-t border-white/10 p-6 print:hidden">
                    {{ $results->links() }}
                </div>
            @endif
        </div>

    </div>
</div>

<style>
    @media print {
        nav, footer, a, button, form, .print\:hidden { display: none !important; }
        body, main, div { background: #fff !important; color: #111827 !important; box-shadow: none !important; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border-bottom: 1px solid #e5e7eb; color: #111827 !important; }
        .text-slate-400, .text-slate-500, .text-slate-100, .text-white { color: #111827 !important; }
        span { background: transparent !important; color: #111827 !important; font-weight: bold; }
    }
</style>
@endsection
