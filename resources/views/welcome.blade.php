@extends('layout.master')

@section('konten')
<div class="max-w-7xl mx-auto px-6 pt-44 pb-28 min-h-[90vh] flex flex-col justify-center relative overflow-hidden bg-[#0A0F1F]">

    {{-- Background Glow --}}
    <div class="absolute -top-10 -right-20 w-[600px] h-[600px] bg-cyan-500/10 rounded-full blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-20 -left-10 w-[400px] h-[400px] bg-fuchsia-500/10 rounded-full blur-[100px] animate-pulse"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-purple-500/5 rounded-full blur-[180px]"></div>

    <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-20 items-center mb-28">

        {{-- Hero Text --}}
        <div class="space-y-8 text-center md:text-left">
            <div class="inline-flex items-center gap-2 bg-cyan-500/10 text-cyan-300 border border-cyan-400/20 px-6 py-2.5 rounded-full text-sm font-black tracking-widest uppercase shadow-[0_0_15px_rgba(34,211,238,0.15)]">
                <span class="w-2 h-2 bg-cyan-400 rounded-full animate-pulse"></span>
                Inovasi Belajar SDN CIBINONG 2
            </div>

            <h1 class="text-6xl md:text-7xl font-black text-white tracking-tighter leading-[1.05]">
                Belajar Seru <br/>
                Sambil <span class="text-cyan-400 italic drop-shadow-[0_0_15px_rgba(34,211,238,0.4)]">Bermain</span> Kuis.
            </h1>

            <p class="text-xl text-slate-300 font-medium leading-relaxed max-w-2xl">
                Platform kuis interaktif modern untuk membantu siswa SDN 2 memahami materi pelajaran
                dengan lebih asyik, cepat, dan tidak membosankan.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-5 pt-5 justify-center md:justify-start">
                <a href="{{ route('login') }}"
                   class="group bg-gradient-to-r from-cyan-500 to-purple-600 hover:scale-105 text-white px-12 py-5 rounded-[2rem] font-black text-lg shadow-[0_0_35px_rgba(34,211,238,0.35)] transition-all flex items-center gap-3 active:scale-95">
                    <span>Mulai Sekarang</span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 group-hover:translate-x-1.5 transition-transform"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="3"
                              d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>

            </div>
        </div>

        {{-- Subject Cards --}}
        <div class="relative flex items-center justify-center p-10 h-full">
            <div class="absolute inset-0 bg-white/5 backdrop-blur-3xl rounded-[3rem] border border-cyan-400/10 shadow-inner"></div>

            <div class="relative grid grid-cols-2 gap-6 rotate-[-5deg]">

                <div class="bg-[#111827]/80 p-8 rounded-3xl border border-cyan-400/10 shadow-[0_0_20px_rgba(34,211,238,0.08)] hover:rotate-6 hover:scale-105 transition-all duration-500 group">
                    <span class="text-5xl group-hover:scale-110 block transition-transform">📐</span>
                    <p class="mt-4 font-black text-white">MTK</p>
                    <p class="text-xs text-cyan-400 font-bold uppercase tracking-widest">Hitung Cepat</p>
                </div>

                <div class="relative overflow-hidden bg-[#111827]/80 p-8 rounded-3xl border border-fuchsia-400/10 shadow-[0_0_20px_rgba(217,70,239,0.08)] hover:-rotate-6 hover:scale-105 transition-all duration-500 group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-fuchsia-500/10 rounded-full group-hover:scale-150 transition-transform"></div>
                    <div class="relative">
                        <span class="text-5xl group-hover:scale-110 block transition-transform">🔬</span>
                        <p class="mt-4 font-black text-white">IPA</p>
                        <p class="text-xs text-fuchsia-400 font-bold uppercase tracking-widest">Uji Alam</p>
                    </div>
                </div>

                <div class="relative overflow-hidden bg-[#111827]/80 p-8 rounded-3xl border border-cyan-400/10 shadow-[0_0_20px_rgba(34,211,238,0.08)] hover:-rotate-3 hover:scale-105 transition-all duration-500 group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-cyan-500/10 rounded-full group-hover:scale-150 transition-transform"></div>
                    <div class="relative">
                        <span class="text-5xl group-hover:scale-110 block transition-transform">🇮🇩</span>
                        <p class="mt-4 font-black text-white">IPS</p>
                        <p class="text-xs text-cyan-400 font-bold uppercase tracking-widest">Sejarah Kita</p>
                    </div>
                </div>

                <div class="relative overflow-hidden bg-[#111827]/80 p-8 rounded-3xl border border-purple-400/10 shadow-[0_0_20px_rgba(168,85,247,0.08)] hover:rotate-3 hover:scale-105 transition-all duration-500 group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-purple-500/10 rounded-full group-hover:scale-150 transition-transform"></div>
                    <div class="relative">
                        <span class="text-5xl group-hover:scale-110 block transition-transform">📖</span>
                        <p class="mt-4 font-black text-white">BIND</p>
                        <p class="text-xs text-fuchsia-400 font-bold uppercase tracking-widest">Teks Cerita</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Features --}}
    <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-10 mt-20">

        <div class="bg-white/5 backdrop-blur-xl p-10 rounded-[2.5rem] border border-cyan-400/10 flex flex-col items-center text-center transition-all hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(34,211,238,0.15)] group">
            <div class="w-20 h-20 bg-cyan-500/10 rounded-3xl flex items-center justify-center text-5xl mb-8 border border-cyan-400/10 group-hover:rotate-12 transition-transform">
                🎮
            </div>
            <h3 class="text-2xl font-black text-white mb-3">Game-Based</h3>
            <p class="text-slate-400 font-medium leading-relaxed">
                Format kuis yang didesain seperti permainan video, membuat siswa ingin terus belajar.
            </p>
        </div>

        <div class="bg-white/5 backdrop-blur-xl p-10 rounded-[2.5rem] border border-fuchsia-400/10 flex flex-col items-center text-center transition-all hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(217,70,239,0.15)] group">
            <div class="w-20 h-20 bg-fuchsia-500/10 rounded-3xl flex items-center justify-center text-5xl mb-8 border border-fuchsia-400/10 group-hover:rotate-12 transition-transform">
                🏫
            </div>
            <h3 class="text-2xl font-black text-white mb-3">Kurikulum SD</h3>
            <p class="text-slate-400 font-medium leading-relaxed">
                Seluruh soal disesuaikan dengan materi pembelajaran resmi di SDN 2 Cibinong.
            </p>
        </div>

        <div class="bg-white/5 backdrop-blur-xl p-10 rounded-[2.5rem] border border-emerald-400/10 flex flex-col items-center text-center transition-all hover:-translate-y-3 hover:shadow-[0_0_30px_rgba(16,185,129,0.15)] group">
            <div class="w-20 h-20 bg-emerald-500/10 rounded-3xl flex items-center justify-center text-5xl mb-8 border border-emerald-400/10 group-hover:rotate-12 transition-transform">
                📊
            </div>
            <h3 class="text-2xl font-black text-white mb-3">Progres Jelas</h3>
            <p class="text-slate-400 font-medium leading-relaxed">
                Nilai kuis akan otomatis tercatat, memudahkan Guru memantau perkembangan siswa.
            </p>
        </div>

    </div>
</div>

@include('layout.partials.footer')
@endsection
