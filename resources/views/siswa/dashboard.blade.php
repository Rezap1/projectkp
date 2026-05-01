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
                        <div class="absolute -inset-1 bg-gradient-to-r {{ $badgeColor }} rounded-2xl blur opacity-60 group-hover:opacity-100 transition duration-500"></div>

                        <div class="relative flex items-center gap-3 bg-slate-950/90 text-white px-5 py-3 rounded-2xl uppercase tracking-tight border border-white/20 shadow-2xl">
                            <x-tier-emblem :tier="$tier" size="sm" />
                            <div class="leading-tight">
                                <p class="text-[10px] font-black tracking-[0.22em] text-slate-500">CURRENT TIER</p>
                                <p class="text-lg font-black">{{ $badge }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative group hidden">
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
                    <div class="mb-8 rounded-2xl border border-white/10 bg-slate-950/60 p-5">
                        <x-tier-emblem :tier="$tier" size="md" show-label="true" />
                    </div>

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
@if(session('rankUp'))
    <template id="rank-up-template">
        <div class="rank-award">
            <div class="rank-rays"></div>
            <span class="rank-spark rank-spark-1"></span>
            <span class="rank-spark rank-spark-2"></span>
            <span class="rank-spark rank-spark-3"></span>
            <span class="rank-spark rank-spark-4"></span>

            <div class="rank-emblem-pop">
                <x-tier-emblem :tier="session('rankUp.tier')" size="xl" />
            </div>

            <p class="rank-kicker">Rank Promotion</p>
            <h2 class="rank-title">{{ session('rankUp.tier.name') }}</h2>
            <div class="rank-stars">{{ str_repeat('*', session('rankUp.tier.stars', 1)) }}</div>
            <p class="rank-copy">{{ session('rankUp.pesan') }}</p>

            <div class="rank-score">
                <span>Total XP</span>
                <strong>{{ number_format(session('rankUp.score', 0)) }}</strong>
            </div>
        </div>
    </template>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const rankTemplate = document.getElementById('rank-up-template');

        Swal.fire({
            title: '',
            html: rankTemplate ? rankTemplate.innerHTML : '',
            background: 'transparent',
            color: '#fff',
            buttonsStyling: false,
            confirmButtonText: 'LANJUTKAN',
            padding: 0,
            width: 520,
            backdrop: 'rgba(2, 6, 23, 0.92)',
            showClass: { popup: 'rank-popup-in' },
            hideClass: { popup: 'rank-popup-out' },
            customClass: {
                popup: 'rank-popup',
                htmlContainer: 'rank-html',
                confirmButton: 'rank-confirm'
            }
        });
    });
    </script>
@endif
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(false && session('rankUp'))
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
<style>
    .rank-popup {
        border-radius: 28px;
        background: linear-gradient(145deg, rgba(15, 23, 42, 0.98), rgba(49, 46, 129, 0.94));
        border: 1px solid rgba(125, 211, 252, 0.28);
        box-shadow: 0 0 70px rgba(34, 211, 238, 0.24), inset 0 0 32px rgba(255, 255, 255, 0.05);
        overflow: hidden;
    }

    .rank-html {
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden;
    }

    .rank-award {
        position: relative;
        min-height: 520px;
        padding: 54px 36px 34px;
        text-align: center;
        isolation: isolate;
    }

    .rank-award::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 50% 22%, rgba(250, 204, 21, 0.22), transparent 26%),
            radial-gradient(circle at 16% 18%, rgba(34, 211, 238, 0.20), transparent 25%),
            radial-gradient(circle at 84% 26%, rgba(217, 70, 239, 0.22), transparent 23%);
        z-index: -2;
    }

    .rank-rays {
        position: absolute;
        inset: -90px;
        background: conic-gradient(from 0deg, transparent 0 10deg, rgba(255,255,255,0.12) 10deg 16deg, transparent 16deg 30deg);
        animation: rank-spin 12s linear infinite;
        z-index: -1;
        opacity: 0.68;
    }

    .rank-emblem-pop {
        display: inline-flex;
        justify-content: center;
        animation: rank-rise 850ms cubic-bezier(.2,.9,.2,1.25) both;
    }

    .rank-kicker {
        margin-top: 22px;
        color: #67e8f9;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.28em;
        text-transform: uppercase;
    }

    .rank-title {
        margin-top: 8px;
        color: #fff;
        font-size: clamp(34px, 8vw, 58px);
        font-weight: 1000;
        line-height: 0.95;
        text-transform: uppercase;
        text-shadow: 0 0 24px rgba(34, 211, 238, 0.45);
    }

    .rank-stars {
        margin-top: 14px;
        color: #fde68a;
        font-size: 26px;
        font-weight: 1000;
        letter-spacing: 0.42em;
        text-indent: 0.42em;
    }

    .rank-copy {
        margin: 16px auto 0;
        max-width: 360px;
        color: #cbd5e1;
        font-size: 15px;
        font-weight: 800;
        line-height: 1.6;
    }

    .rank-score {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        margin-top: 24px;
        padding: 12px 18px;
        border: 1px solid rgba(125, 211, 252, 0.24);
        border-radius: 14px;
        background: rgba(2, 6, 23, 0.45);
    }

    .rank-score span {
        color: #64748b;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }

    .rank-score strong {
        color: #67e8f9;
        font-size: 22px;
        font-weight: 1000;
    }

    .rank-confirm {
        margin: 0 0 34px !important;
        border-radius: 14px !important;
        background: linear-gradient(90deg, #22d3ee, #a855f7, #facc15) !important;
        color: #020617 !important;
        padding: 14px 34px !important;
        font-size: 13px !important;
        font-weight: 1000 !important;
        letter-spacing: 0.16em !important;
        box-shadow: 0 14px 36px rgba(34, 211, 238, 0.24) !important;
    }

    .rank-spark {
        position: absolute;
        width: 9px;
        height: 9px;
        border-radius: 999px;
        background: #fde68a;
        box-shadow: 0 0 24px #fde68a;
        animation: rank-float 1.9s ease-in-out infinite alternate;
    }

    .rank-spark-1 { left: 18%; top: 20%; animation-delay: 0ms; }
    .rank-spark-2 { right: 18%; top: 18%; animation-delay: 280ms; background: #67e8f9; box-shadow: 0 0 24px #67e8f9; }
    .rank-spark-3 { left: 20%; bottom: 25%; animation-delay: 520ms; background: #e879f9; box-shadow: 0 0 24px #e879f9; }
    .rank-spark-4 { right: 22%; bottom: 28%; animation-delay: 740ms; }

    .rank-popup-in {
        animation: rank-popup-in 460ms cubic-bezier(.18,.9,.28,1.18);
    }

    .rank-popup-out {
        animation: rank-popup-out 220ms ease-in forwards;
    }

    @keyframes rank-spin {
        to { transform: rotate(360deg); }
    }

    @keyframes rank-rise {
        0% { opacity: 0; transform: translateY(24px) scale(0.72) rotate(-8deg); }
        70% { opacity: 1; transform: translateY(-4px) scale(1.08) rotate(2deg); }
        100% { opacity: 1; transform: translateY(0) scale(1) rotate(0); }
    }

    @keyframes rank-float {
        from { transform: translateY(0) scale(0.8); opacity: 0.6; }
        to { transform: translateY(-22px) scale(1.2); opacity: 1; }
    }

    @keyframes rank-popup-in {
        from { opacity: 0; transform: scale(0.88) translateY(22px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    @keyframes rank-popup-out {
        to { opacity: 0; transform: scale(0.92) translateY(12px); }
    }
</style>
@endsection
