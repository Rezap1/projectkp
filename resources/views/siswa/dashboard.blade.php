@extends('layout.master')

@section('konten')
<div class="min-h-screen px-6 pb-14 pt-32 text-[#223f35]">
    <div class="mx-auto max-w-7xl">
        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-[#9dbd8c] bg-[#dce8d7] px-5 py-4 text-center text-sm font-black text-[#285f43]">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-8 flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.24em] text-[#6d5f44]">Dashboard Siswa</p>
                <h1 class="mt-2 text-4xl font-black tracking-tight text-[#1f342d] md:text-5xl">
                    Halo, {{ Auth::user()->name }}
                </h1>
                <p class="mt-3 max-w-2xl text-base font-semibold leading-7 text-[#5e6963]">
                    Pilih kuis yang tersedia hari ini, pantau progres XP, dan lihat posisi kamu di leaderboard.
                </p>
            </div>

            <div class="rounded-2xl border border-[#d3c6b3] bg-[#efe8db] px-6 py-4 shadow-lg shadow-stone-400/10">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#6d5f44]">Skor Tertinggi</p>
                <p class="mt-1 text-3xl font-black text-[#223f35]">
                    {{ number_format($skorTertinggi, 0) }}
                    <span class="text-sm font-bold text-[#6d746f]">PTS</span>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-[1.65fr_0.95fr]">
            <section class="rounded-[2rem] border border-[#d3c6b3] bg-[#efe8db]/95 p-6 shadow-xl shadow-stone-400/10 md:p-8">
                <div class="mb-7 flex flex-col gap-4 border-b border-[#d7cdbc] pb-5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-[#6d5f44]">Kuis Hari Ini</p>
                        <h2 class="mt-2 text-2xl font-black tracking-tight text-[#1f342d] md:text-3xl">
                            Pilih Kuis
                        </h2>
                    </div>
                    <span class="inline-flex w-fit items-center rounded-xl border border-[#c8b99f] bg-[#e3d8c6] px-4 py-2 text-xs font-black uppercase tracking-widest text-[#4c4638]">
                        {{ now()->format('d M Y') }}
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse($listKuis as $kuis)
                        @php
                            $sisaMenit = null;
                            if ($kuis->is_done && isset($kuis->last_result_time)) {
                                $sisaMenit = 5 - \Carbon\Carbon::parse($kuis->last_result_time)->diffInMinutes(now());
                            }
                        @endphp

                        <article class="group rounded-2xl border border-[#d7cdbc] bg-[#f5eee2] p-5 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#223f35] hover:bg-[#e9dfce] hover:shadow-lg hover:shadow-stone-500/10">
                            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex min-w-0 items-center gap-4">
                                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-[#c8b99f] bg-[#223f35] text-xl font-black text-[#cfe66a] shadow-md shadow-stone-500/10">
                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                    </div>

                                    <div class="min-w-0">
                                        <h3 class="truncate text-xl font-black tracking-tight text-[#1f342d]">
                                            {{ $kuis->nama_kategori }}
                                        </h3>

                                        <div class="mt-2 flex flex-wrap items-center gap-2">
                                            <span class="rounded-lg border border-[#c8b99f] bg-[#e5dac8] px-3 py-1 text-[11px] font-black uppercase tracking-widest text-[#4c4638]">
                                                Kelas {{ Auth::user()->kelas }}
                                            </span>

                                            @if(isset($kuis->durasi))
                                                <span class="rounded-lg border border-[#c8b99f] bg-[#e5dac8] px-3 py-1 text-[11px] font-black uppercase tracking-widest text-[#4c4638]">
                                                    {{ $kuis->durasi }} Menit
                                                </span>
                                            @endif

                                            @if($kuis->is_done)
                                                <span class="rounded-lg border border-[#9dbd8c] bg-[#dce8d7] px-3 py-1 text-[11px] font-black uppercase tracking-widest text-[#285f43]">
                                                    Selesai
                                                </span>
                                            @else
                                                <span class="rounded-lg border border-[#b8cf56] bg-[#eef5c4] px-3 py-1 text-[11px] font-black uppercase tracking-widest text-[#405018]">
                                                    Siap Dikerjakan
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="flex w-full flex-col gap-2 sm:w-auto sm:items-end">
                                    @if($kuis->is_done)
                                        @if($sisaMenit !== null && $sisaMenit > 0)
                                            <span class="text-xs font-bold text-[#6d5f44]">
                                                Review dibuka {{ max($sisaMenit, 0) }} menit lagi
                                            </span>
                                        @endif

                                        <a href="{{ route('kuis.review', $kuis->id) }}"
                                           class="inline-flex w-full items-center justify-center rounded-xl border border-[#223f35] bg-transparent px-6 py-3 text-sm font-black uppercase tracking-widest text-[#223f35] transition hover:bg-[#223f35] hover:text-[#f8f2e7] sm:w-auto">
                                            Lihat Hasil
                                        </a>
                                    @else
                                        <a href="{{ route('kuis.show', $kuis->id) }}"
                                           class="inline-flex w-full items-center justify-center rounded-xl border border-[#223f35] bg-[#223f35] px-7 py-3 text-sm font-black uppercase tracking-widest text-[#f8f2e7] shadow-md shadow-stone-500/10 transition hover:bg-[#2d5749] hover:text-white sm:w-auto">
                                            Mulai Kuis
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-2xl border-2 border-dashed border-[#c8b99f] bg-[#f5eee2] px-6 py-16 text-center">
                            <h3 class="text-2xl font-black text-[#1f342d]">Belum Ada Kuis</h3>
                            <p class="mx-auto mt-2 max-w-md text-sm font-semibold leading-6 text-[#6d746f]">
                                Belum ada kuis yang tersedia untuk kelas kamu hari ini. Silakan cek kembali nanti.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>

            <aside class="space-y-6">
                <section class="rounded-[2rem] border border-[#d3c6b3] bg-[#efe8db]/95 p-6 shadow-xl shadow-stone-400/10">
                    <div class="mb-5">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-[#6d5f44]">Statistik Bulan Ini</p>
                        <h2 class="mt-1 text-2xl font-black text-[#1f342d]">Performa Kamu</h2>
                    </div>

                    <div class="mb-5 rounded-2xl border border-[#d7cdbc] bg-[#f5eee2] p-4">
                        <div class="flex items-center gap-4">
                            <x-tier-emblem :tier="$tier" size="sm" />
                            <div class="min-w-0">
                                <p class="text-[10px] font-black uppercase tracking-widest text-[#6d746f]">Tier Saat Ini</p>
                                <p class="truncate text-lg font-black uppercase text-[#1f342d]">{{ $badge }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-[#d7cdbc] bg-[#f5eee2] p-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-[#6d746f]">Rata-rata</p>
                            <p class="mt-2 text-3xl font-black text-[#223f35]">{{ number_format($rataRata, 0) }}%</p>
                        </div>

                        <div class="rounded-2xl border border-[#d7cdbc] bg-[#f5eee2] p-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-[#6d746f]">Peringkat</p>
                            <p class="mt-2 text-3xl font-black text-[#223f35]">#{{ $peringkat }}</p>
                        </div>
                    </div>

                    <div class="mt-3 rounded-2xl border border-[#d7cdbc] bg-[#f5eee2] p-4">
                        <div class="mb-3 flex items-end justify-between gap-4">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-[#6d746f]">Total XP</p>
                                <p class="mt-1 text-2xl font-black text-[#223f35]">{{ number_format($totalSkorSiswa) }}</p>
                            </div>
                            <p class="text-xs font-bold text-[#6d746f]">{{ number_format($targetSkor) }}</p>
                        </div>

                        <div class="h-3 overflow-hidden rounded-full bg-[#dfd2bd]">
                            <div class="h-full rounded-full bg-[#223f35] transition-all duration-500"
                                 style="width: {{ min(($totalSkorSiswa / max($targetSkor, 1)) * 100, 100) }}%">
                            </div>
                        </div>

                        <p class="mt-3 text-xs font-semibold text-[#6d746f]">
                            {{ number_format(max($targetSkor - $totalSkorSiswa, 0)) }} XP lagi menuju target.
                        </p>
                    </div>
                </section>

                <section class="rounded-[2rem] border border-[#d3c6b3] bg-[#efe8db]/95 p-6 shadow-xl shadow-stone-400/10">
                    <div class="mb-5">
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-[#6d5f44]">Leaderboard</p>
                        <h2 class="mt-1 text-xl font-black text-[#1f342d]">Top Siswa</h2>
                    </div>

                    <div class="space-y-3">
                        @forelse($leaderboard as $index => $item)
                            <div class="flex items-center justify-between gap-3 rounded-2xl border p-3 transition {{ $item->user_id == Auth::id() ? 'border-[#223f35] bg-[#dce8d7]' : 'border-[#d7cdbc] bg-[#f5eee2] hover:border-[#a98f6b] hover:bg-[#e9dfce]' }}">
                                <div class="flex min-w-0 items-center gap-3">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $index < 3 ? 'bg-[#cfe66a] text-[#223f35]' : 'bg-[#e5dac8] text-[#4c4638]' }} text-sm font-black">
                                        {{ $index + 1 }}
                                    </span>

                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-black uppercase text-[#1f342d]">
                                            {{ $item->user->name ?? 'Siswa' }}
                                        </p>
                                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#6d746f]">
                                            Kelas {{ $item->user->kelas ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <span class="shrink-0 rounded-lg bg-[#223f35] px-3 py-1 text-xs font-black text-[#f8f2e7]">
                                    {{ number_format($item->total_skor) }}
                                </span>
                            </div>
                        @empty
                            <p class="rounded-2xl border border-dashed border-[#c8b99f] bg-[#f5eee2] p-5 text-center text-sm font-semibold text-[#6d746f]">
                                Belum ada data leaderboard bulan ini.
                            </p>
                        @endforelse
                    </div>
                </section>
            </aside>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('rankUp'))
    <template id="rank-up-template">
        <div class="rank-award">
            <div class="rank-emblem-pop">
                <x-tier-emblem :tier="session('rankUp.tier')" size="xl" />
            </div>

            <p class="rank-kicker">Selamat, rank kamu naik</p>
            <h2 class="rank-title">{{ session('rankUp.tier.name') }}</h2>
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
            color: '#f8f2e7',
            buttonsStyling: false,
            confirmButtonText: 'LANJUTKAN',
            padding: 0,
            width: 520,
            backdrop: 'rgba(34, 63, 53, 0.82)',
            customClass: {
                popup: 'rank-popup',
                htmlContainer: 'rank-html',
                confirmButton: 'rank-confirm'
            }
        });
    });
    </script>
@endif

<style>
    .rank-popup {
        border: 1px solid rgba(207, 230, 106, 0.42);
        border-radius: 28px;
        background: linear-gradient(145deg, #223f35, #2b4d42);
        box-shadow: 0 28px 80px rgba(34, 63, 53, 0.32);
        overflow: hidden;
    }

    .rank-html {
        margin: 0 !important;
        padding: 0 !important;
    }

    .rank-award {
        padding: 44px 34px 28px;
        text-align: center;
    }

    .rank-emblem-pop {
        display: inline-flex;
        justify-content: center;
    }

    .rank-kicker {
        margin-top: 20px;
        color: #cfe66a;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.22em;
        text-transform: uppercase;
    }

    .rank-title {
        margin-top: 8px;
        color: #f8f2e7;
        font-size: clamp(34px, 8vw, 56px);
        font-weight: 1000;
        line-height: 1;
        text-transform: uppercase;
    }

    .rank-copy {
        margin: 16px auto 0;
        max-width: 360px;
        color: #d8e1dc;
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
        border: 1px solid rgba(207, 230, 106, 0.28);
        border-radius: 14px;
        background: rgba(24, 52, 43, 0.62);
    }

    .rank-score span {
        color: #b9c8c1;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }

    .rank-score strong {
        color: #cfe66a;
        font-size: 22px;
        font-weight: 1000;
    }

    .rank-confirm {
        margin: 0 0 32px !important;
        border-radius: 14px !important;
        background: #cfe66a !important;
        color: #223f35 !important;
        padding: 14px 34px !important;
        font-size: 13px !important;
        font-weight: 1000 !important;
        letter-spacing: 0.16em !important;
    }
</style>
@endsection
