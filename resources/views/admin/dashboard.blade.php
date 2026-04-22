@extends('layout.master')

@section('konten')
{{-- x-data: search untuk filter nama, activeTab & rankTab untuk navigasi kelas --}}
<div class="max-w-7xl mx-auto px-6 md:px-10 pt-44 pb-20 min-h-screen" x-data="{ activeTab: 'kelas4', rankTab: 'r4', search: '' }">

    {{-- Header Section --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-12 no-print">
        <div class="space-y-2">
            <h1 class="text-5xl font-black text-slate-900 tracking-tight leading-tight">
                Panel Guru <span class="text-indigo-600">🏫</span>
            </h1>
            <p class="text-slate-500 font-bold italic">SDN Cibinong 2 - Dashboard Aktivitas Harian</p>
        </div>

        <div class="flex flex-wrap gap-3">
            {{-- Tombol Cetak Laporan --}}
            <button onclick="window.print()"
                    class="group inline-flex items-center justify-center gap-3 bg-white border-2 border-slate-200 text-slate-700 px-8 py-5 rounded-[2.5rem] font-black transition-all hover:bg-slate-50 active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400 group-hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span class="text-lg tracking-tight">Cetak Laporan</span>
            </button>

            {{-- Tombol Tambah Soal --}}
            <a href="{{ route('questions.create') }}"
               class="group inline-flex items-center justify-center gap-3 bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-5 rounded-[2.5rem] font-black shadow-2xl shadow-indigo-200 transition-all hover:-translate-y-2 active:scale-95">
                <div class="bg-white/20 p-2 rounded-xl group-hover:rotate-180 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="text-lg tracking-tight">Tambah Soal Baru</span>
            </a>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <div class="bg-indigo-600 p-10 rounded-[3rem] shadow-lg group hover:scale-[1.02] transition-transform duration-300 relative overflow-hidden">
            <p class="text-indigo-100 font-black text-xs uppercase tracking-[0.2em] mb-4">Siswa Aktif Hari Ini</p>
            <div class="flex items-baseline gap-3">
                <h3 class="text-6xl font-black text-white">{{ $totalSiswaHariIni }}</h3>
                <span class="text-white font-bold">Orang</span>
            </div>
            <div class="absolute -right-4 -bottom-4 text-white/10 text-8xl font-black group-hover:scale-110 transition-transform">👥</div>
        </div>

        <div class="bg-blue-600 p-10 rounded-[3rem] shadow-lg group hover:scale-[1.02] transition-transform duration-300 relative overflow-hidden">
            <p class="text-blue-100 font-black text-xs uppercase tracking-[0.2em] mb-4">Materi Tersedia</p>
            <div class="flex items-baseline gap-3">
                <h3 class="text-6xl font-black text-white">{{ $totalSoal }}</h3>
                <span class="text-white font-bold">Materi</span>
            </div>
            <div class="absolute -right-4 -bottom-4 text-white/10 text-8xl font-black group-hover:scale-110 transition-transform">📚</div>
        </div>

        <div class="bg-emerald-600 p-10 rounded-[3rem] shadow-lg group hover:scale-[1.02] transition-transform duration-300 relative overflow-hidden">
            <p class="text-emerald-100 font-black text-xs uppercase tracking-[0.2em] mb-4">Rata-rata Skor</p>
            <div class="flex items-baseline gap-3">
                <h3 class="text-6xl font-black text-white">{{ round($rataRataNilai) }}</h3>
                <span class="text-white font-bold">Poin</span>
            </div>
            <div class="absolute -right-4 -bottom-4 text-white/10 text-8xl font-black group-hover:scale-110 transition-transform">📈</div>
        </div>
    </div>

    {{-- SECTION 1: Aktivitas Terbaru --}}
    <div class="bg-white rounded-[3.5rem] shadow-sm border border-slate-100 overflow-hidden mb-20">
        <div class="p-10 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center bg-slate-50/30 gap-6 no-print">
            <div>
                <h2 class="text-2xl font-black text-slate-900 italic">Aktivitas Terbaru 📝</h2>
                <p class="text-slate-400 text-sm font-bold">Data otomatis direset setiap hari</p>

                {{-- Input Pencarian Real-time --}}
                <div class="mt-4 relative min-w-[300px]">
                    <input type="text" x-model="search" placeholder="Cari nama siswa..."
                           class="w-full bg-white border border-slate-200 rounded-2xl px-6 py-3 text-sm font-bold focus:ring-4 focus:ring-indigo-100 focus:border-indigo-600 transition-all outline-none">
                </div>
            </div>

            <div class="flex bg-slate-200/50 p-2 rounded-[2rem] border border-slate-100">
                <button @click="activeTab = 'kelas4'" :class="activeTab === 'kelas4' ? 'bg-white text-indigo-600 shadow-md' : 'text-slate-500'" class="px-8 py-3 rounded-[1.5rem] font-black text-xs uppercase tracking-widest transition-all">Kelas 4</button>
                <button @click="activeTab = 'kelas5'" :class="activeTab === 'kelas5' ? 'bg-white text-indigo-600 shadow-md' : 'text-slate-500'" class="px-8 py-3 rounded-[1.5rem] font-black text-xs uppercase tracking-widest transition-all">Kelas 5</button>
                <button @click="activeTab = 'kelas6'" :class="activeTab === 'kelas6' ? 'bg-white text-indigo-600 shadow-md' : 'text-slate-500'" class="px-8 py-3 rounded-[1.5rem] font-black text-xs uppercase tracking-widest transition-all">Kelas 6</button>
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
            <table x-show="activeTab === '{{ $key }}'" class="w-full text-left" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                <thead class="bg-slate-900">
                    <tr class="text-white text-[10px] uppercase tracking-[0.3em] font-black">
                        <th class="px-10 py-6">Siswa</th>
                        <th class="px-10 py-6">Mata Pelajaran</th>
                        <th class="px-10 py-6 text-center">Skor</th>
                        <th class="px-10 py-6">Status</th>
                        <th class="px-10 py-6 text-right">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($data as $res)
                    {{-- Row Filter berdasarkan input pencarian --}}
                    <tr x-show="search === '' || '{{ strtolower($res->user->name ?? '') }}'.includes(search.toLowerCase())"
                        class="hover:bg-slate-50 transition-all group">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center font-black text-sm">
                                    {{ substr($res->user->name ?? 'S', 0, 1) }}
                                </div>
                                <span class="font-bold text-slate-700">{{ $res->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <span class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-wider">
                                {{ $res->category->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-10 py-8 text-center">
                            <span class="text-xl font-black {{ $res->skor >= 75 ? 'text-emerald-500' : 'text-orange-500' }}">
                                {{ $res->skor }}
                            </span>
                        </td>
                        <td class="px-10 py-8">
                            @if($res->skor >= 75)
                                <span class="px-4 py-1.5 bg-emerald-100 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-widest">Lulus</span>
                            @else
                                <span class="px-4 py-1.5 bg-orange-100 text-orange-600 rounded-full text-[10px] font-black uppercase tracking-widest">Remedial</span>
                            @endif
                        </td>
                        <td class="px-10 py-8 text-right text-slate-400 font-bold text-xs italic">
                            {{ $res->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-24 text-center">
                            <p class="text-slate-300 font-black italic">Belum ada aktivitas di {{ strtoupper($key) }} hari ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @endforeach
        </div>
    </div>

    {{-- SECTION 2: Leaderboard --}}
    <div class="mt-20">
        <div class="flex flex-col md:flex-row items-end justify-between mb-10 gap-4 no-print">
            <div>
                <h2 class="text-4xl font-black text-slate-900 tracking-tight">Papan Peringkat 🏆</h2>
                <p class="text-slate-500 font-bold">10 Siswa dengan nilai tertinggi di mata pelajaran Anda</p>
            </div>

            <div class="flex bg-amber-100 p-1.5 rounded-2xl border border-amber-200 shadow-sm">
                <button @click="rankTab = 'r4'" :class="rankTab === 'r4' ? 'bg-white text-amber-600 shadow-sm' : 'text-amber-500'" class="px-6 py-2 rounded-xl font-black text-xs transition-all uppercase tracking-tighter">Kelas 4</button>
                <button @click="rankTab = 'r5'" :class="rankTab === 'r5' ? 'bg-white text-amber-600 shadow-sm' : 'text-amber-500'" class="px-6 py-2 rounded-xl font-black text-xs transition-all uppercase tracking-tighter">Kelas 5</button>
                <button @click="rankTab = 'r6'" :class="rankTab === 'r6' ? 'bg-white text-amber-600 shadow-sm' : 'text-amber-500'" class="px-6 py-2 rounded-xl font-black text-xs transition-all uppercase tracking-tighter">Kelas 6</button>
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
        <div x-show="rankTab === '{{ $key }}'" class="grid grid-cols-1 gap-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
            @forelse($ranks as $index => $rank)
            <div class="flex items-center justify-between p-8 bg-white rounded-[2.5rem] border-2 {{ $index == 0 ? 'border-amber-400 bg-amber-50/20' : 'border-slate-50' }} shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-center gap-8">
                    <div class="flex items-center justify-center w-14 h-14 rounded-2xl font-black text-2xl
                        {{ $index == 0 ? 'bg-amber-400 text-white shadow-lg shadow-amber-200' : ($index == 1 ? 'bg-slate-300 text-slate-600' : ($index == 2 ? 'bg-orange-300 text-white' : 'bg-slate-100 text-slate-400')) }}">
                        {{ $index + 1 }}
                    </div>
                    <div>
                        <h4 class="font-black text-slate-800 text-xl">{{ $rank->user->name }}</h4>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Update: {{ \Carbon\Carbon::parse($rank->last_attempt)->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-1">Skor Tertinggi</span>
                    <span class="text-4xl font-black text-indigo-600">{{ $rank->high_score }}</span>
                </div>
            </div>
            @empty
            <div class="p-24 text-center bg-slate-50/50 rounded-[3.5rem] border-2 border-dashed border-slate-200">
                <p class="text-slate-400 font-black italic">Belum ada peringkat untuk kelas ini.</p>
            </div>
            @endforelse
        </div>
        @endforeach
    </div>

    {{-- Footer Info --}}
    <div class="mt-20 p-10 bg-slate-900 rounded-[3rem] text-white flex flex-col md:flex-row items-center justify-between gap-8 no-print">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 bg-white/10 rounded-3xl flex items-center justify-center text-3xl">💡</div>
            <div>
                <h4 class="font-black text-xl">Standar Kelulusan</h4>
                <p class="text-slate-400 text-sm">Siswa dianggap <b>Lulus</b> jika mendapatkan skor minimal <b>75</b>.</p>
            </div>
        </div>
        <div class="text-center md:text-right">
            <p class="text-[10px] font-black uppercase tracking-[0.4em] text-indigo-400 mb-2">Sistem Monitoring</p>
            <p class="text-xs text-slate-500 italic">Aplikasi SDN Cibinong 2</p>
        </div>
    </div>
</div>

{{-- CSS KHUSUS UNTUK CETAK --}}
<style>
    @media print {
        .no-print, button, a, .flex.bg-slate-200\/50, .flex.bg-amber-100, input {
            display: none !important;
        }
        body { background: white !important; padding-top: 0 !important; }
        .max-w-7xl { max-width: 100% !important; padding-top: 20px !important; }
        .bg-white { border: none !important; box-shadow: none !important; }
        table { width: 100% !important; border: 1px solid #e2e8f0 !important; }
        th { background-color: #0f172a !important; color: white !important; -webkit-print-color-adjust: exact; }
        .rounded-\[3\.5rem\] { border-radius: 0 !important; }
    }
</style>

{{-- Script Alpine.js --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
