@extends('layout.master')

@section('konten')
<div class="min-h-screen pt-32 pb-12 px-6 bg-slate-50">
    <div class="max-w-7xl mx-auto">
        {{-- Header Section --}}
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex flex-col gap-2">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-500 text-white rounded-2xl font-bold text-center shadow-lg animate-bounce">
                        {{ session('success') }} 🎉
                    </div>
                @endif

                {{-- Bagian Nama & Rank --}}
                <div class="flex flex-wrap items-center gap-4">
                    <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h1>

                    {{-- Badge Rank: Perbaikan pada pemanggilan class gradient --}}
                    <div class="relative group">
                        {{-- Efek Cahaya --}}
                        <div class="absolute -inset-1 bg-indigo-600 {{ $badgeColor }} rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>

                        {{-- Teks Rank --}}
                        <span class="relative flex items-center gap-2 bg-gradient-to-r {{ $badgeColor }} text-white text-xl font-black px-6 py-3 rounded-2xl uppercase tracking-widest shadow-xl border-2 border-white/30 transform hover:scale-105 transition-all duration-300">
                            <span class="text-2xl">🏆</span>
                            {{ $badge }}
                        </span>
                    </div>
                </div>
                <p class="text-slate-500 font-medium mt-2 text-lg">Siap untuk memenangkan tantangan hari ini?</p>
            </div>

            {{-- Skor Tertinggi Badge --}}
            <div class="bg-indigo-600 px-8 py-5 rounded-[2rem] shadow-2xl shadow-indigo-200 flex items-center gap-5 transform hover:-rotate-2 transition-transform">
                <div class="bg-yellow-400 p-3 rounded-2xl shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-900" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-indigo-200 text-xs font-black uppercase tracking-widest">Rekor Terbaik</p>
                    <p class="text-white text-2xl font-black">{{ number_format($skorTertinggi, 0) }} <span class="text-sm font-normal text-indigo-200">Poin</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Main Content: List Kuis --}}
            <div class="md:col-span-2 bg-white p-8 rounded-[3rem] border border-slate-100 shadow-xl shadow-slate-200/50">
                <div class="flex items-center justify-between mb-8 border-b border-slate-50 pb-6">
                    <h3 class="text-2xl font-black text-slate-900">Misi Belajar 🚀</h3>
                    <span class="bg-slate-100 text-slate-500 text-xs font-bold px-4 py-2 rounded-full">Hari ini: {{ date('d M Y') }}</span>
                </div>

                <div class="space-y-6">
                    @forelse($listKuis as $kuis)
                        <div class="group flex flex-col sm:flex-row items-start sm:items-center justify-between p-6 rounded-[2rem] bg-slate-50 hover:bg-white hover:shadow-2xl hover:shadow-indigo-100 border-2 border-transparent hover:border-indigo-100 transition-all duration-300">
                            <div class="flex items-center gap-6 mb-4 sm:mb-0">
                                <div class="w-16 h-16 bg-white rounded-3xl flex items-center justify-center text-3xl shadow-md group-hover:rotate-12 group-hover:scale-110 transition-all duration-500">
                                    @php
                                        $emojis = ['📚', '📖', '✏️', '🧪', '🌍', '📐', '🎨', '🧠'];
                                        echo $emojis[$loop->index % count($emojis)];
                                    @endphp
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-800 text-xl group-hover:text-indigo-600 transition-colors">{{ $kuis->nama_kategori }}</h4>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="flex items-center gap-1 text-[11px] bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full font-black uppercase">
                                            🏫 Kelas {{ Auth::user()->kelas }}
                                        </span>
                                        @if($kuis->is_done)
                                            <span class="flex items-center gap-1 text-[11px] bg-emerald-100 text-emerald-600 px-3 py-1 rounded-full font-black uppercase">
                                                ✅ Selesai
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-3 w-full sm:w-auto">
                                @if($kuis->is_done)
                                    @php
                                        $sisaMenit = 5 - \Carbon\Carbon::parse($kuis->last_result_time)->diffInMinutes(now());
                                    @endphp
                                    <div class="flex flex-col items-end">
                                        <span class="text-[10px] text-amber-600 font-bold bg-amber-50 px-4 py-1.5 rounded-full border border-amber-200 mb-2 animate-pulse">
                                            🕒 Review: {{ max($sisaMenit, 0) }} Menit Lagi
                                        </span>
                                        <a href="{{ route('kuis.review', $kuis->id) }}" class="w-full sm:w-auto text-center bg-white border-2 border-indigo-600 text-indigo-600 px-8 py-3 rounded-2xl font-black text-sm hover:bg-indigo-600 hover:text-white transition-all shadow-lg shadow-indigo-100">
                                            HASIL KERJA →
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ route('kuis.show', $kuis->id) }}" class="w-full sm:w-auto text-center bg-indigo-600 text-white px-10 py-4 rounded-2xl font-black text-md hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all hover:scale-105 active:scale-95">
                                        MULAI MISI
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20">
                            <div class="text-8xl mb-6 animate-bounce">✨</div>
                            <h4 class="text-slate-800 font-black text-2xl">Semua Misi Tuntas!</h4>
                            <p class="text-slate-400 font-medium max-w-xs mx-auto mt-2">Kamu hebat! Istirahat dulu ya, misi baru akan datang besok pagi.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Sidebar: Statistik --}}
            <div class="space-y-8">
                <div class="bg-slate-900 p-8 rounded-[3rem] text-white shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-all"></div>

                    <h3 class="text-xl font-black mb-8 text-indigo-400 flex items-center gap-3">
                        Statistik Kamu 📊
                    </h3>

                    <div class="space-y-6 relative z-10">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/10 p-5 rounded-[2rem] border border-white/10 hover:bg-white/20 transition-all text-center">
                                <p class="text-indigo-300 text-[10px] uppercase font-black tracking-widest mb-2">Rata-rata</p>
                                <p class="text-3xl font-black text-white">{{ number_format($rataRata, 0) }}<span class="text-sm">%</span></p>
                            </div>
                            <div class="bg-white/10 p-5 rounded-[2rem] border border-white/10 hover:bg-white/20 transition-all text-center">
                                <p class="text-yellow-400 text-[10px] uppercase font-black tracking-widest mb-2">Peringkat</p>
                                <p class="text-3xl font-black text-yellow-400">#{{ $peringkat }}</p>
                            </div>
                        </div>

                        <div class="bg-white/5 p-6 rounded-[2rem] border border-white/10">
                            <div class="flex justify-between items-end mb-4">
                                <div>
                                    <p class="text-[10px] text-indigo-300 font-black uppercase tracking-widest">Total Skor</p>
                                    <p class="text-lg font-black">{{ $badge }}</p>
                                </div>
                                <p class="text-xs font-bold text-white/50">{{ number_format($totalSkorSiswa) }} / 5000</p>
                            </div>
                            <div class="w-full bg-white/10 h-4 rounded-full overflow-hidden p-1">
                                <div class="bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 h-full rounded-full transition-all duration-1000 shadow-[0_0_20px_rgba(245,158,11,0.4)]"
                                     style="width: {{ min(($totalSkorSiswa / 5000) * 100, 100) }}%">
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-4 italic text-center leading-relaxed">
                                "Sisa <b>{{ number_format(max(5000 - $totalSkorSiswa, 0)) }} poin</b> lagi untuk jadi sang juara!"
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card Sekolah --}}
                <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 p-8 rounded-[3rem] text-center shadow-xl relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-white/20 rounded-3xl flex items-center justify-center mx-auto mb-5 text-4xl shadow-lg border border-white/30 transform -rotate-6">
                            🏫
                        </div>
                        <h4 class="font-black text-white tracking-tight text-xl uppercase">SDN CIBINONG 2</h4>
                        <div class="h-1 w-12 bg-yellow-400 mx-auto my-4 rounded-full"></div>
                        <p class="text-indigo-100 text-sm font-medium italic leading-relaxed px-4">
                            "Giat Belajar, Raih Prestasi!"
                        </p>
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 untuk Pop-up Naik Rank --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('rankUp'))
            Swal.fire({
                title: 'RANK UP! 🎉',
                html: '<div class="py-4 text-lg font-bold text-slate-700">{{ session('rankUp')['pesan'] }}</div>',
                icon: 'success',
                confirmButtonText: 'KEREN! 🔥',
                confirmButtonColor: '#4F46E5',
                padding: '3rem',
                backdrop: `rgba(79, 70, 229, 0.4)`,
                showClass: { popup: 'animate__animated animate__zoomInDown' },
                hideClass: { popup: 'animate__animated animate__fadeOutUp' }
            });
        @endif
    });
</script>
@endsection
