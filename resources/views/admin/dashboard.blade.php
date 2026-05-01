@extends('layout.master')

@section('konten')
<div class="max-w-7xl mx-auto px-6 md:px-10 pt-44 pb-20 min-h-screen bg-[#0A0F1F] text-white"
     x-data="{ activeTab: 'kelas4', rankTab: 'r4', search: '' }">

    {{-- Header Section --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-12 no-print">
        <div class="space-y-2">
            <h1 class="text-5xl font-black tracking-tight leading-tight">
                Panel Guru <span class="text-cyan-400">🏫</span>
            </h1>
            <p class="text-slate-400 font-bold italic">SDN Cibinong 2 - Dashboard Arena Pembelajaran</p>
        </div>

        <div class="flex flex-wrap gap-3">
            <button onclick="window.print()"
                    class="group inline-flex items-center justify-center gap-3 bg-white/5 border border-cyan-400/20 text-cyan-300 px-8 py-5 rounded-[2.5rem] font-black transition-all hover:bg-cyan-500/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span class="text-lg tracking-tight">Cetak Laporan</span>
            </button>

            <a href="{{ route('questions.create') }}"
               class="group inline-flex items-center justify-center gap-3 bg-gradient-to-r from-cyan-500 to-purple-600 text-white px-8 py-5 rounded-[2.5rem] font-black shadow-[0_0_25px_rgba(34,211,238,0.35)] transition-all hover:scale-105">
                <div class="bg-white/20 p-2 rounded-xl group-hover:rotate-180 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span class="text-lg tracking-tight">Tambah Soal Baru</span>
            </a>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">

        <div class="bg-gradient-to-br from-cyan-500 to-cyan-700 p-10 rounded-[3rem] shadow-[0_0_30px_rgba(34,211,238,0.25)] relative overflow-hidden">
            <p class="text-cyan-100 font-black text-xs uppercase tracking-[0.2em] mb-4">Siswa Aktif Hari Ini</p>
            <div class="flex items-baseline gap-3">
                <h3 class="text-6xl font-black">{{ $totalSiswaHariIni }}</h3>
                <span class="font-bold">Orang</span>
            </div>
            <div class="absolute -right-4 -bottom-4 text-white/10 text-8xl font-black">👥</div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-indigo-700 p-10 rounded-[3rem] shadow-[0_0_30px_rgba(139,92,246,0.25)] relative overflow-hidden">
            <p class="text-purple-100 font-black text-xs uppercase tracking-[0.2em] mb-4">Materi Tersedia</p>
            <div class="flex items-baseline gap-3">
                <h3 class="text-6xl font-black">{{ $totalSoal }}</h3>
                <span class="font-bold">Materi</span>
            </div>
            <div class="absolute -right-4 -bottom-4 text-white/10 text-8xl font-black">📚</div>
        </div>

        <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 p-10 rounded-[3rem] shadow-[0_0_30px_rgba(16,185,129,0.25)] relative overflow-hidden">
            <p class="text-emerald-100 font-black text-xs uppercase tracking-[0.2em] mb-4">Rata-rata Skor</p>
            <div class="flex items-baseline gap-3">
                <h3 class="text-6xl font-black">{{ round($rataRataNilai) }}</h3>
                <span class="font-bold">Poin</span>
            </div>
            <div class="absolute -right-4 -bottom-4 text-white/10 text-8xl font-black">📈</div>
        </div>

    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="bg-white/5 backdrop-blur-xl rounded-[3.5rem] border border-cyan-400/10 overflow-hidden mb-20">

        <div class="p-10 border-b border-cyan-400/10 flex flex-col md:flex-row justify-between items-center gap-6 no-print">
            <div>
                <h2 class="text-2xl font-black text-cyan-300 italic">Aktivitas Terbaru 📝</h2>
                <p class="text-slate-400 text-sm font-bold">Data otomatis direset setiap hari</p>

                <div class="mt-4 relative min-w-[300px]">
                    <input type="text"
                           x-model="search"
                           placeholder="Cari nama siswa..."
                           class="w-full bg-white/5 border border-cyan-400/20 rounded-2xl px-6 py-3 text-sm font-bold text-white placeholder-slate-500 focus:ring-4 focus:ring-cyan-500/20 outline-none">
                </div>
            </div>

            <div class="flex bg-white/5 p-2 rounded-[2rem] border border-cyan-400/10">
                <button @click="activeTab = 'kelas4'" :class="activeTab === 'kelas4' ? 'bg-cyan-500 text-white' : 'text-slate-400'" class="px-8 py-3 rounded-[1.5rem] font-black text-xs uppercase tracking-widest">Kelas 4</button>
                <button @click="activeTab = 'kelas5'" :class="activeTab === 'kelas5' ? 'bg-cyan-500 text-white' : 'text-slate-400'" class="px-8 py-3 rounded-[1.5rem] font-black text-xs uppercase tracking-widest">Kelas 5</button>
                <button @click="activeTab = 'kelas6'" :class="activeTab === 'kelas6' ? 'bg-cyan-500 text-white' : 'text-slate-400'" class="px-8 py-3 rounded-[1.5rem] font-black text-xs uppercase tracking-widest">Kelas 6</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            @php
                $tabData = [
                    'kelas4' => $aktivitasKelas4,
                    'kelas5' => $aktivitasKelas5,
                    'kelas6' => $aktivitasKelas6
                ];
            @endphp

            @foreach($tabData as $key => $data)
            <table x-show="activeTab === '{{ $key }}'" class="w-full text-left">
                <thead class="bg-[#111827]">
                    <tr class="text-cyan-300 text-[10px] uppercase tracking-[0.3em] font-black">
                        <th class="px-10 py-6">Siswa</th>
                        <th class="px-10 py-6">Mata Pelajaran</th>
                        <th class="px-10 py-6 text-center">Skor</th>
                        <th class="px-10 py-6">Status</th>
                        <th class="px-10 py-6 text-right">Waktu</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-cyan-400/5">
                    @forelse($data as $res)
                    <tr x-show="search === '' || '{{ strtolower($res->user->name ?? '') }}'.includes(search.toLowerCase())"
                        class="hover:bg-cyan-500/5 transition-all">

                        <td class="px-10 py-8">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-cyan-500/10 text-cyan-300 rounded-full flex items-center justify-center font-black text-sm border border-cyan-400/20">
                                    {{ substr($res->user->name ?? 'S', 0, 1) }}
                                </div>
                                <span class="font-bold text-white">{{ $res->user->name }}</span>
                            </div>
                        </td>

                        <td class="px-10 py-8">
                            <span class="px-4 py-2 bg-white/5 text-cyan-300 rounded-xl text-[10px] font-black uppercase tracking-wider border border-cyan-400/10">
                                {{ $res->category->nama_kategori }}
                            </span>
                        </td>

                        <td class="px-10 py-8 text-center">
                            <span class="text-xl font-black {{ $res->skor >= 75 ? 'text-emerald-400' : 'text-orange-400' }}">
                                {{ $res->skor }}
                            </span>
                        </td>

                        <td class="px-10 py-8">
                            @if($res->skor >= 75)
                                <span class="px-4 py-1.5 bg-emerald-500/10 text-emerald-300 rounded-full text-[10px] font-black uppercase">Lulus</span>
                            @else
                                <span class="px-4 py-1.5 bg-orange-500/10 text-orange-300 rounded-full text-[10px] font-black uppercase">Remedial</span>
                            @endif
                        </td>

                        <td class="px-10 py-8 text-right text-slate-500 font-bold text-xs italic">
                            {{ $res->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-24 text-center">
                            <p class="text-slate-500 font-black italic">Belum ada aktivitas di {{ strtoupper($key) }} hari ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @endforeach
        </div>
    </div>

    {{-- Leaderboard --}}
    <div class="mt-20">
        <div class="flex flex-col md:flex-row items-end justify-between mb-10 gap-4 no-print">
            <div>
                <h2 class="text-4xl font-black tracking-tight text-white">Papan Peringkat 🏆</h2>
                <p class="text-slate-400 font-bold">10 Siswa terbaik di arena pembelajaran</p>
            </div>

            <div class="flex bg-white/5 p-1.5 rounded-2xl border border-cyan-400/10">
                <button @click="rankTab = 'r4'" :class="rankTab === 'r4' ? 'bg-yellow-400 text-black' : 'text-slate-400'" class="px-6 py-2 rounded-xl font-black text-xs">Kelas 4</button>
                <button @click="rankTab = 'r5'" :class="rankTab === 'r5' ? 'bg-yellow-400 text-black' : 'text-slate-400'" class="px-6 py-2 rounded-xl font-black text-xs">Kelas 5</button>
                <button @click="rankTab = 'r6'" :class="rankTab === 'r6' ? 'bg-yellow-400 text-black' : 'text-slate-400'" class="px-6 py-2 rounded-xl font-black text-xs">Kelas 6</button>
            </div>
        </div>

        @php
            $rankData = [
                'r4' => $rankKelas4,
                'r5' => $rankKelas5,
                'r6' => $rankKelas6
            ];
        @endphp

        @foreach($rankData as $key => $ranks)
        <div x-show="rankTab === '{{ $key }}'" class="grid grid-cols-1 gap-4">
            @forelse($ranks as $index => $rank)
            <div class="flex items-center justify-between p-8 bg-white/5 rounded-[2.5rem] border {{ $index == 0 ? 'border-yellow-400 shadow-[0_0_20px_rgba(250,204,21,0.2)]' : 'border-cyan-400/10' }}">
                <div class="flex items-center gap-8">
                    <div class="flex items-center justify-center w-14 h-14 rounded-2xl font-black text-2xl
                        {{ $index == 0 ? 'bg-yellow-400 text-black' : ($index == 1 ? 'bg-slate-300 text-black' : ($index == 2 ? 'bg-orange-400 text-black' : 'bg-white/10 text-slate-400')) }}">
                        {{ $index + 1 }}
                    </div>

                    <div>
                        <h4 class="font-black text-white text-xl">{{ $rank->user->name }}</h4>
                        <p class="text-slate-500 text-xs font-bold uppercase">Update: {{ \Carbon\Carbon::parse($rank->last_attempt)->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="text-right">
                    <span class="text-[10px] font-black text-slate-500 uppercase block mb-1">Skor Tertinggi</span>
                    <span class="text-4xl font-black text-cyan-300">{{ $rank->high_score }}</span>
                </div>
            </div>
            @empty
            <div class="p-24 text-center bg-white/5 rounded-[3.5rem] border border-dashed border-cyan-400/10">
                <p class="text-slate-500 font-black italic">Belum ada peringkat untuk kelas ini.</p>
            </div>
            @endforelse
        </div>
        @endforeach
    </div>

    {{-- Footer --}}
    <div class="mt-20 p-10 bg-[#111827] rounded-[3rem] border border-cyan-400/10 flex flex-col md:flex-row items-center justify-between gap-8 no-print">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-cyan-500/10 rounded-3xl flex items-center justify-center text-3xl border border-cyan-400/20">💡</div>
            <div>
                <h4 class="font-black text-xl text-cyan-300">Standar Kelulusan</h4>
                <p class="text-slate-400 text-sm">Siswa dianggap <b>Lulus</b> jika mendapatkan skor minimal <b>75</b>.</p>
            </div>
        </div>

        <div class="text-center md:text-right">
            <p class="text-[10px] font-black uppercase tracking-[0.4em] text-cyan-400 mb-2">Sistem Monitoring</p>
            <p class="text-xs text-slate-500 italic">Aplikasi SDN Cibinong 2</p>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print, button, a, input {
            display: none !important;
        }

        body {
            background: white !important;
            color: black !important;
        }

        table {
            width: 100% !important;
            border: 1px solid #ddd !important;
        }

        th {
            background: #111827 !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
        }
    }
</style>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
