@extends('layout.master')

@section('konten')
{{-- Container utama dengan padding atas ekstra untuk menghindari navbar fixed --}}
<div class="max-w-7xl mx-auto px-6 md:px-10 pt-44 pb-20 min-h-screen">

    {{-- Header Section: Judul & Tombol Tambah --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
        <div class="space-y-2">
            <h1 class="text-5xl font-black text-slate-900 tracking-tight leading-tight">
                Panel Guru <span class="text-indigo-600">🏫</span>
            </h1>
        </div>

        {{-- Tombol Tambah Soal dengan Efek Hover Keren --}}
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

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <div class="relative overflow-hidden bg-indigo-600 p-10 rounded-[3rem] shadow-sm border border-slate-100 group hover:shadow-2xl hover:shadow-indigo-100 transition-all duration-500">
            <div class="relative">
                <p class="text-white font-black text-xs uppercase tracking-[0.2em] mb-4">Siswa Aktif</p>
                <div class="flex items-baseline gap-3">
                    <h3 class="text-6xl font-black text-slate-900 leading-none">{{ $totalSiswa }}</h3>
                    <span class="text-white font-bold">Orang</span>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden bg-blue-600 p-10 rounded-[3rem] shadow-sm border border-slate-100 group hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500">
            <div class="relative">
                <p class="text-white font-black text-xs uppercase tracking-[0.2em] mb-4">Bank Soal</p>
                <div class="flex items-baseline gap-3">
                    <h3 class="text-6xl font-black text-slate-900 leading-none">{{ $totalSoal }}</h3>
                    <span class="text-white font-bold">Materi</span>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden bg-emerald-600 p-10 rounded-[3rem] shadow-sm border border-slate-100 group hover:shadow-2xl hover:shadow-emerald-100 transition-all duration-500">
            <div class="relative">
                <p class="text-white font-black text-xs uppercase tracking-[0.2em] mb-4">Rata-rata Skor</p>
                <div class="flex items-baseline gap-3">
                    <h3 class="text-6xl font-black text-slate-900 leading-none">{{ round($rataRataNilai) }}</h3>
                    <span class="text-white font-bold">Poin</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Aktivitas Terbaru --}}
    <div class="bg-white rounded-[3.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight italic">Aktivitas Siswa Terbaru 📝</h2>
            <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-slate-100 shadow-sm text-xs font-bold text-slate-500">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                Update Real-time
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-500">
                    <tr class="text-white text-[10px] uppercase tracking-[0.3em] font-black">
                        <th class="px-10 py-6">Nama Siswa</th>
                        <th class="px-10 py-6">Kategori Kuis</th>
                        <th class="px-10 py-6">Skor Akhir</th>
                        <th class="px-10 py-6">Status</th>
                        <th class="px-10 py-6 text-right">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentResults as $res)
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center font-black text-sm">
                                    {{ substr($res->user->name ?? 'S', 0, 1) }}
                                </div>
                                <span class="font-bold text-slate-700">{{ $res->user->name ?? 'Siswa Anonim' }}</span>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <span class="px-5 py-2 bg-slate-100 text-slate-600 rounded-2xl text-xs font-black uppercase tracking-wider group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                {{ $res->category->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-10 py-8">
                            <span class="text-2xl font-black {{ $res->skor >= 75 ? 'text-emerald-500' : 'text-orange-500' }}">
                                {{ $res->skor }}
                            </span>
                        </td>
                        <td class="px-10 py-8">
                            @if($res->skor >= 75)
                                <span class="inline-flex items-center gap-2 text-emerald-600 font-black text-xs uppercase tracking-widest">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Lulus
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 text-orange-600 font-black text-xs uppercase tracking-widest">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    Remedial
                                </span>
                            @endif
                        </td>
                        <td class="px-10 py-8 text-right text-slate-400 font-bold text-sm">
                            {{ $res->created_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-32 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-4xl mb-6">📭</div>
                                <p class="text-slate-400 font-black text-lg">Belum ada siswa yang mengerjakan kuis.</p>
                                <p class="text-slate-300 text-sm">Hasil kuis akan otomatis muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
