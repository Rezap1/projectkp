@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-[#0f172a] pt-32 pb-20 px-6 relative overflow-hidden">

    {{-- Background Glow Decoration --}}
    <div class="absolute -top-20 -left-20 w-72 h-72 bg-cyan-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-fuchsia-500/10 rounded-full blur-3xl"></div>

    <div class="max-w-7xl mx-auto relative z-10">

        {{-- Header --}}
        <div class="mb-14 text-center">
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-xs font-black uppercase tracking-[0.25em] mb-5">
                <span class="w-2 h-2 bg-cyan-400 rounded-full animate-pulse"></span>
                Quiz Arena Ready
            </div>

            <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tight uppercase italic">
                Pilih Mata Pelajaran ✏️
            </h1>

            <p class="text-slate-400 text-lg font-medium max-w-2xl mx-auto">
                Pilih arena kuismu dan tunjukkan kemampuan terbaik untuk meraih skor tertinggi!
            </p>
        </div>

        {{-- Grid Mata Pelajaran --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($categories as $cat)
            <div class="group relative bg-slate-800/70 backdrop-blur-xl rounded-[2.5rem] p-8 border border-white/10 shadow-2xl hover:-translate-y-3 hover:border-cyan-500/40 transition-all duration-300 overflow-hidden">

                {{-- Decorative Glow --}}
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-cyan-500/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500"></div>

                {{-- Badge Difficulty / Arena --}}
                <div class="absolute top-5 right-5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-fuchsia-500/10 text-fuchsia-400 border border-fuchsia-500/20">
                    Arena Quiz
                </div>

                {{-- Icon --}}
                <div class="w-20 h-20 bg-cyan-500/10 border border-cyan-500/20 rounded-3xl flex items-center justify-center mb-6 text-4xl group-hover:rotate-6 transition-transform">
                    @php
                        $icons = ['📚','🧮','🧪','🌍','📖','🎨','💡'];
                        echo $icons[$loop->index % count($icons)];
                    @endphp
                </div>

                {{-- Title --}}
                <h2 class="text-2xl font-black text-white mb-3 tracking-tight">
                    {{ $cat->nama_kategori }}
                </h2>

                {{-- Subtitle --}}
                <p class="text-slate-400 text-sm font-medium mb-6">
                    Tantang kemampuanmu dalam mata pelajaran ini dan raih skor terbaik.
                </p>

                {{-- Info Mini --}}
                <div class="flex items-center gap-3 mb-8">
                    <span class="px-3 py-1 rounded-lg bg-slate-700 text-cyan-400 text-[10px] font-black uppercase tracking-widest">
                        Kelas {{ $cat->kelas }}
                    </span>

                    @if(isset($cat->durasi))
                    <span class="px-3 py-1 rounded-lg bg-slate-700 text-amber-400 text-[10px] font-black uppercase tracking-widest">
                        {{ $cat->durasi }} Menit
                    </span>
                    @endif
                </div>

                {{-- Button --}}
                <a href="{{ route('siswa.kuis.show', $cat->slug) }}"
                   class="inline-flex items-center justify-center gap-3 w-full text-center bg-cyan-600 hover:bg-cyan-500 text-white font-black py-4 rounded-2xl shadow-[0_0_20px_rgba(6,182,212,0.35)] transition-all group-hover:scale-[1.02] active:scale-95 uppercase tracking-wider">
                    <span>Masuk Arena</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 group-hover:translate-x-1 transition-transform"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="3"
                              d="M13 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
            @endforeach
        </div>

        {{-- Footer Motivasi --}}
        <div class="mt-16 text-center">
            <div class="inline-block px-6 py-3 rounded-2xl bg-slate-800/60 border border-white/10 text-slate-400 text-sm font-bold">
                🚀 Semakin banyak kuis diselesaikan, semakin tinggi rank kamu!
            </div>
        </div>

    </div>
</div>
@endsection
