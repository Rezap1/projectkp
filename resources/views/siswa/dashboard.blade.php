@extends('layout.master')

@section('konten')
<div class="min-h-screen pt-32 pb-12 px-6 bg-[#0f172a] text-slate-200 relative overflow-hidden">

    {{-- Ambient Background FX --}}
    <div class="absolute top-10 left-10 w-72 h-72 bg-cyan-500/10 blur-[120px] rounded-full animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-72 h-72 bg-fuchsia-500/10 blur-[120px] rounded-full animate-pulse"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        {{-- Header Section --}}
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex flex-col gap-2">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-cyan-500 text-white rounded-xl font-black text-center shadow-[0_0_20px_rgba(6,182,212,0.5)] animate-pulse">
                        🎉 MISSION ACCOMPLISHED: {{ session('success') }} ⚡
                    </div>
                @endif

                <div class="flex flex-wrap items-center gap-4">
                    <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase italic">
                        PLAYER: <span class="text-cyan-400 drop-shadow-[0_0_12px_rgba(34,211,238,0.4)]">{{ Auth::user()->name }}</span>
                    </h1>

                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-fuchsia-600 to-cyan-600 rounded-xl blur opacity-75 group-hover:opacity-100 transition duration-500"></div>

                        <span class="relative flex items-center gap-2 bg-slate-900 text-white text-xl font-black px-6 py-3 rounded-xl uppercase tracking-tighter border border-white/20">
                            <span class="text-2xl animate-pulse">⚔️</span>
                            {{ $badge }}
                        </span>
                    </div>
                </div>

                <p class="text-slate-400 font-bold mt-2 text-lg tracking-wide uppercase">
                    Arena sudah siap. Tunjukkan kemampuan terbaikmu!
                </p>
            </div>

            {{-- High Score --}}
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 px-8 py-5 rounded-2xl border-2 border-cyan-500/50 shadow-[0_0_30px_rgba(6,182,212,0.2)] flex items-center gap-5 transform hover:scale-105 transition-all">
                <div class="bg-cyan-500 p-3 rounded-lg shadow-[0_0_15px_rgba(6,182,212,0.6)] animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-900" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-cyan-400 text-xs font-black uppercase tracking-[0.2em]">Skor Tertinggi</p>
                    <p class="text-white text-3xl font-black italic">
                        {{ number_format($skorTertinggi, 0) }}
                        <span class="text-sm font-normal text-slate-400 whitespace-nowrap">PTS</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Quiz List --}}
            <div class="md:col-span-2 bg-slate-800/50 backdrop-blur-xl p-8 rounded-3xl border border-white/10 shadow-2xl">
                <div class="flex items-center justify-between mb-8 border-b border-white/5 pb-6">
                    <h3 class="text-2xl font-black text-white tracking-widest uppercase italic">
                        Pilih Arena Kuis 🎮
                    </h3>
                    <span class="bg-slate-700 text-cyan-400 text-xs font-black px-4 py-2 rounded-md border border-cyan-500/30">
                        ONLINE: {{ date('d.M.Y') }}
                    </span>
                </div>

                <div class="space-y-6">
                    @forelse($listKuis as $kuis)
                        <div class="group flex flex-col sm:flex-row items-start sm:items-center justify-between p-6 rounded-2xl bg-slate-900/50 border border-white/5 hover:border-cyan-500/50 hover:bg-slate-800 transition-all duration-300 relative overflow-hidden hover:scale-[1.02]">

                            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10 pointer-events-none"></div>

                            <div class="flex items-center gap-6 mb-4 sm:mb-0 relative z-10">
                                <div class="w-16 h-16 bg-slate-800 rounded-xl border border-white/10 flex items-center justify-center text-3xl shadow-inner group-hover:border-fuchsia-500 group-hover:text-fuchsia-400 transition-all duration-500">
                                    @php
                                        $emojis = ['🏹', '🛡️', '⚔️', '🔮', '🧿', '🧬', '👾', '🕹️'];
                                        echo $emojis[$loop->index % count($emojis)];
                                    @endphp
                                </div>

                                <div>
                                    <h4 class="font-black text-white text-xl group-hover:text-cyan-400 transition-colors uppercase tracking-tight">
                                        {{ $kuis->nama_kategori }}
                                    </h4>

                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-[11px] bg-slate-700 text-slate-300 px-3 py-1 rounded font-black border border-white/10">
                                            Level {{ Auth::user()->kelas }}
                                        </span>

                                        @if($kuis->is_done)
                                            <span class="text-[11px] bg-emerald-500/20 text-emerald-400 px-3 py-1 rounded font-black border border-emerald-500/30">
                                                ⭐ Selesai
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-3 w-full sm:w-auto relative z-10">
                                @if($kuis->is_done)
                                    @php
                                        $sisaMenit = 5 - \Carbon\Carbon::parse($kuis->last_result_time)->diffInMinutes(now());
                                    @endphp

                                    <div class="flex flex-col items-end">
                                        @if($sisaMenit > 0)
                                            <span class="text-[10px] text-fuchsia-400 font-bold bg-fuchsia-500/10 px-4 py-1.5 rounded border border-fuchsia-500/30 mb-2 italic">
                                                Review Dibuka {{ max($sisaMenit, 0) }} Menit Lagi
                                            </span>
                                        @endif

                                        <a href="{{ route('kuis.review', $kuis->id) }}"
                                           class="w-full sm:w-auto text-center bg-transparent border-2 border-slate-600 text-slate-400 px-8 py-3 rounded-xl font-black text-sm hover:border-cyan-500 hover:text-cyan-400 transition-all uppercase tracking-widest">
                                            Lihat Hasil
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ route('kuis.show', $kuis->id) }}"
                                       class="w-full sm:w-auto text-center bg-cyan-600 text-white px-10 py-4 rounded-xl font-black text-md hover:bg-cyan-500 shadow-[0_0_20px_rgba(6,182,212,0.4)] transition-all hover:scale-105 active:scale-95 uppercase italic tracking-tighter">
                                        Mulai Kuis
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 border-2 border-dashed border-white/5 rounded-3xl">
                            <div class="text-6xl mb-6 opacity-50">📡</div>
                            <h4 class="text-slate-400 font-black text-2xl uppercase italic">Belum Ada Kuis</h4>
                            <p class="text-slate-500 font-medium max-w-xs mx-auto mt-2 italic">
                                Semua tantangan sudah selesai. Tunggu kuis berikutnya ya!
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-8">

                {{-- Stats --}}
                <div class="bg-[#1e293b] p-8 rounded-3xl text-white shadow-2xl relative overflow-hidden border border-white/5">
                    <h3 class="text-xl font-black mb-8 text-cyan-400 uppercase italic tracking-widest">
                        Statistik Kamu 📊
                    </h3>

                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-900/50 p-5 rounded-2xl text-center">
                                <p class="text-slate-500 text-[10px] uppercase font-black">Rata-rata</p>
                                <p class="text-3xl font-black text-white">{{ number_format($rataRata, 0) }}%</p>
                            </div>

                            <div class="bg-slate-900/50 p-5 rounded-2xl text-center">
                                <p class="text-slate-500 text-[10px] uppercase font-black">Peringkat</p>
                                <p class="text-3xl font-black text-fuchsia-500">#{{ $peringkat }}</p>
                            </div>
                        </div>

                        <div class="bg-slate-900/80 p-6 rounded-2xl border border-cyan-500/20">
                            <div class="flex justify-between items-end mb-4">
                                <p class="text-cyan-400 font-black uppercase text-xs">Progress XP</p>
                                <p class="text-xs text-slate-500">{{ number_format($totalSkorSiswa) }}/5000</p>
                            </div>

                            <div class="w-full bg-slate-800 h-4 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-cyan-500 to-fuchsia-500 h-full rounded-full animate-pulse"
                                     style="width: {{ min(($totalSkorSiswa / 5000) * 100, 100) }}%">
                                </div>
                            </div>

                            <p class="text-[10px] text-slate-500 mt-4 text-center uppercase">
                                {{ number_format(max(5000 - $totalSkorSiswa, 0)) }} XP Lagi Untuk Rank Berikutnya
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Leaderboard --}}
                <div class="bg-slate-800/40 backdrop-blur-md p-8 rounded-3xl border border-white/10">
                    <h3 class="text-xl font-black text-white mb-6 uppercase italic">
                        Hall of Fame 🏆
                    </h3>

                    <div class="space-y-4">
                        @foreach($leaderboard as $index => $item)
                            <div class="flex items-center justify-between p-3 rounded-xl {{ $item->user_id == Auth::id() ? 'bg-cyan-500/10 border border-cyan-500/50' : 'hover:bg-white/5' }}">
                                <div class="flex items-center gap-4">
                                    <span class="w-8 h-8 flex items-center justify-center font-black rounded">
                                        {{ $index + 1 }}
                                    </span>

                                    <div>
                                        <p class="text-sm font-black text-slate-200 uppercase">
                                            {{ $item->user->name }}
                                        </p>
                                        <p class="text-[10px] text-slate-500 uppercase">
                                            Kelas {{ $item->user->kelas }}
                                        </p>
                                    </div>
                                </div>

                                <span class="text-sm font-black text-cyan-400">
                                    {{ number_format($item->total_skor) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- School Card --}}
                <div class="bg-gradient-to-tr from-slate-900 to-slate-800 p-8 rounded-3xl text-center border border-white/10">
                    <div class="w-16 h-16 bg-cyan-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl text-cyan-400">
                        🏫
                    </div>
                    <h4 class="font-black text-white uppercase">SDN CIBINONG 2</h4>
                    <p class="text-slate-500 text-xs mt-2">Pusat Komando Belajar</p>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- SweetAlert Rank Up --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('rankUp'))
        Swal.fire({
            title: 'LEVEL UP! ⚡',
            html: '<div class="py-4 text-lg font-black text-cyan-400 uppercase">{{ session('rankUp')['pesan'] }}</div>',
            background: '#1e293b',
            color: '#fff',
            confirmButtonText: 'Lanjut Bermain 🚀',
            confirmButtonColor: '#0891b2',
            padding: '3rem',
            backdrop: `rgba(15, 23, 42, 0.9)`
        });
    @endif
});
</script>
@endsection
