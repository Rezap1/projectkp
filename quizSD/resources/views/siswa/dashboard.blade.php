@extends('layout.master')

@section('konten')
<div class="min-h-screen pt-32 pb-12 px-6 bg-slate-50">
    <div class="max-w-7xl mx-auto">
        {{-- Header Section --}}
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex flex-col gap-2">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-2xl font-bold text-center animate-bounce">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Bagian Nama & Rank (DI-PERBESAR) --}}
                <div class="flex flex-wrap items-center gap-4">
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight">Halo, {{ Auth::user()->name }}!</h1>
                    {{-- Badge Rank yang Diperbesar dengan Gradasi --}}
                    <span class="{{ $badgeColor }} text-indigo-600 text-xl font-black px-8 py-3 rounded-2xl uppercase tracking-widest shadow-2xl animate-bounce border-2 border-white/30 transform hover:scale-110 transition-all">
                        {{ $badge }}
                    </span>
                </div>
                <p class="text-slate-500 font-medium mt-2 text-lg">Siap untuk petualangan belajar hari ini?</p>
            </div>

            {{-- Skor Tertinggi Badge --}}
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
            {{-- Main Content: List Kuis --}}
            <div class="md:col-span-2 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                <h3 class="text-xl font-black text-slate-900 mb-6 border-b border-slate-50 pb-4">Misi Hari Ini 📝</h3>
                <div class="space-y-4">
                    @forelse($listKuis as $kuis)
                        <div class="group flex items-center justify-between p-5 rounded-3xl bg-slate-50 hover:bg-indigo-50 border border-transparent hover:border-indigo-100 transition-all">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 transition-all">
                                    @php
                                        $emojis = ['📚', '📖', '✏️', '🧪', '🌍', '📐'];
                                        echo $emojis[$loop->index % count($emojis)];
                                    @endphp
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-lg">{{ $kuis->nama_kategori }}</h4>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] bg-slate-200 text-slate-600 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Kelas {{ Auth::user()->kelas }}</span>
                                        @if($kuis->is_done)
                                            <span class="text-[10px] bg-emerald-500 text-white px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Selesai</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-2">
                                @if($kuis->is_done)
                                    @php
                                        $sisaMenit = 5 - \Carbon\Carbon::parse($kuis->last_result_time)->diffInMinutes(now());
                                    @endphp
                                    <span class="text-[10px] text-amber-600 font-bold bg-amber-50 px-3 py-1 rounded-full border border-amber-100">
                                        ⏳ Hasil hilang dlm {{ max($sisaMenit, 0) }} mnt
                                    </span>
                                    <a href="{{ route('kuis.review', $kuis->id) }}" class="inline-flex items-center gap-2 bg-white border-2 border-indigo-600 text-indigo-600 px-6 py-2 rounded-2xl font-black text-xs hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                        LIHAT HASIL →
                                    </a>
                                @else
                                    <a href="{{ route('kuis.show', $kuis->id) }}" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl font-bold text-sm hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all active:scale-95">
                                        Mulai Misi
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <div class="text-6xl mb-4">📭</div>
                            <h4 class="text-slate-800 font-black text-xl">Misi hari ini sudah selesai!</h4>
                            <p class="text-slate-400 font-medium">Kuis baru akan muncul setiap hari. Semangat!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Sidebar: Statistik --}}
            <div class="space-y-8">
                <div class="bg-slate-900 p-8 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden">
                    <h3 class="text-lg font-bold mb-6 text-indigo-400 relative z-10 flex items-center gap-2">
                        Papan Skor 📊
                    </h3>

                    <div class="space-y-6 relative z-10">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/5 p-4 rounded-3xl border border-white/10">
                                <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest mb-1">Rata-rata</p>
                                <p class="text-2xl font-bold text-white">{{ number_format($rataRata, 1) }}%</p>
                            </div>
                            <div class="bg-white/5 p-4 rounded-3xl border border-white/10">
                                <p class="text-slate-400 text-[10px] uppercase font-black tracking-widest mb-1">Peringkat</p>
                                <p class="text-2xl font-bold text-yellow-400">#{{ $peringkat }}</p>
                            </div>
                        </div>

                        {{-- Progress Level (BATAS 5000) --}}
                        <div class="mt-2 bg-white/5 p-4 rounded-3xl border border-white/10">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-[10px] text-indigo-300 font-black uppercase tracking-tight">Menuju Mythical Glory</p>
                                <p class="text-[10px] text-white font-bold">{{ $totalSkorSiswa }} / 5000</p>
                            </div>
                            <div class="w-full bg-white/20 h-3 rounded-full overflow-hidden">
                                {{-- Progress bar dihitung dari 5000 --}}
                                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-full transition-all duration-1000 shadow-[0_0_15px_rgba(251,191,36,0.5)]"
                                     style="width: {{ min(($totalSkorSiswa / 5000) * 100, 100) }}%">
                                </div>
                            </div>
                            <p class="text-[9px] text-slate-400 mt-2 italic text-center">Butuh {{ max(5000 - $totalSkorSiswa, 0) }} poin lagi untuk menuju Puncak!</p>
                        </div>
                    </div>
                </div>

                {{-- Info Sekolah --}}
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 text-center shadow-sm">
                    <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner animate-pulse">🏛️</div>
                    <h4 class="font-black text-slate-800 tracking-tight text-lg uppercase">SDN CIBINONG 2</h4>
                    <p class="text-sm text-slate-400 mt-2 font-medium italic leading-relaxed">
                        "Giat Belajar,<br>Raih Prestasi!"
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
