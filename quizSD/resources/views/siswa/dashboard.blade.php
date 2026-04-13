@extends('layout.master')

@section('konten')
<div class="min-h-screen pt-32 pb-12 px-6 bg-slate-50">
    <div class="max-w-7xl mx-auto">
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-2xl font-bold text-center">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-2xl font-bold text-center">
                        {{ session('error') }}
                    </div>
                @endif
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-slate-500 font-medium mt-2 text-lg">Siap untuk menguji kemampuanmu hari ini?</p>
            </div>

            <div class="bg-indigo-600 px-6 py-4 rounded-[2rem] shadow-xl shadow-indigo-100 flex items-center gap-4">
                <div class="bg-white/20 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-indigo-100 text-xs font-black uppercase tracking-widest">Skor Tertinggi</p>
                    <p class="text-white text-xl font-bold">{{ number_format($skorTertinggi, 0) }} Poin</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <h3 class="text-xl font-black text-slate-900 mb-6">Kuis Tersedia 📝</h3>
                <div class="space-y-4">
                    @forelse($listKuis as $kuis)
                        <div class="group flex items-center justify-between p-5 rounded-3xl bg-slate-50 hover:bg-indigo-50 border border-transparent hover:border-indigo-100 transition-all">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 transition-all">📚</div>
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $kuis->nama_kategori }}</h4>
                                    <p class="text-sm text-slate-500">Mata Pelajaran</p>
                                </div>
                            </div>

                            {{-- LOGIKA TOMBOL: Cek apakah sudah dikerjakan --}}
                            @if($kuis->is_done)
                                <div class="flex items-center gap-2 bg-emerald-100 text-emerald-700 px-6 py-3 rounded-2xl font-bold text-sm border border-emerald-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Selesai
                                </div>
                            @else
                                <a href="{{ route('kuis.show', $kuis->id) }}" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl font-bold text-sm hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all">Mulai</a>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <div class="text-5xl mb-4">📭</div>
                            <p class="text-slate-500 font-bold">Belum ada kuis yang tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="space-y-8">
                <div class="bg-slate-900 p-8 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden">
                    <h3 class="text-lg font-bold mb-4 text-indigo-400 relative z-10">Statistik Kamu</h3>
                    <div class="space-y-6 relative z-10">
                        <div class="pt-4 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Rata-rata</p>
                                <p class="text-2xl font-bold text-white">{{ number_format($rataRata, 1) }}%</p>
                            </div>
                            <div>
                                <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest">Peringkat</p>
                                <p class="text-2xl font-bold text-yellow-400">#{{ $peringkat }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 text-center shadow-sm">
                    <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner">🏛️</div>
                    <h4 class="font-black text-slate-800 tracking-tight">SDN CIBINONG 2</h4>
                    <p class="text-sm text-slate-500 mt-1 font-medium italic">"Giat Belajar, Raih Prestasi!"</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
