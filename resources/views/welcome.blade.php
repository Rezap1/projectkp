@extends('layout.master')

@section('konten')
{{-- Area Utama: PT-44 memberikan ruang untuk Navbar Gelap yang melayang --}}
<div class="max-w-7xl mx-auto px-6 pt-44 pb-28 min-h-[90vh] flex flex-col justify-center relative">

    <div class="absolute -top-10 -right-20 w-[600px] h-[600px] bg-indigo-100/30 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-20 -left-10 w-[400px] h-[400px] bg-blue-100/30 rounded-full blur-[100px]"></div>

    <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-20 items-center mb-28">

        <div class="space-y-8 text-center md:text-left">
            <div class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-700 px-6 py-2.5 rounded-full text-sm font-black tracking-widest uppercase">
                <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
                Inovasi Belajar SDN CIBINONG 2
            </div>

            <h1 class="text-6xl md:text-7xl font-black text-slate-950 tracking-tighter leading-[1.05]">
                <span class="bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent">Belajar Seru</span><br/>
                Sambil <span class="bg-gradient-to-r from-yellow-500 via-orange-500 to-yellow-500 bg-clip-text text-transparent">Bermain</span> Kuis.
            </h1>

            <p class="text-xl text-slate-600 font-medium leading-relaxed max-w-2xl">
                Platform kuis interaktif modern untuk membantu siswa SDN 2 memahami materi pelajaran dengan lebih asyik, cepat, dan tidak membosankan.
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-5 pt-5 justify-center md:justify-start">
                <a href="{{ route('login') }}" class="group bg-indigo-600 hover:bg-indigo-700 text-white px-12 py-5 rounded-[2rem] font-black text-lg shadow-2xl shadow-indigo-200 transition-all hover:-translate-y-2 flex items-center gap-3 active:scale-95">
                    <span>Mulai Belajar Sekarang</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
                <a href="#cara-kerja" class="text-slate-500 hover:text-indigo-600 font-bold transition">Pelajari Selengkapnya &rarr;</a>
            </div>
        </div>

        <div class="relative flex items-center justify-center p-10 h-full">
            <div class="absolute inset-0 bg-white/40 backdrop-blur-3xl rounded-[3rem] border border-white/10 shadow-inner"></div>

            <div class="relative grid grid-cols-2 gap-6 rotate-[-5deg]">
                <div class="bg-white/80 p-8 rounded-3xl border border-white/20 shadow-xl shadow-indigo-100 hover:rotate-6 transition-all duration-500 hover:-translate-y-2">
                    <span class="text-5xl">📐</span>
                    <p class="mt-4 font-black text-slate-900">MTK</p>
                    <p class="text-xs text-slate-500">Hitung Cepat</p>
                </div>
                <div class="relative overflow-hidden bg-white p-8 rounded-3xl border border-slate-100 shadow-xl hover:rotate-[-6deg] transition-all duration-500 group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-50 rounded-full group-hover:scale-150 transition-transform"></div>
                    <div class="relative">
                        <span class="text-5xl">🔬</span>
                        <p class="mt-4 font-black text-slate-900">IPA</p>
                        <p class="text-xs text-slate-500">Uji Alam</p>
                    </div>
                </div>
                <div class="relative overflow-hidden bg-white p-8 rounded-3xl border border-slate-100 shadow-xl hover:-rotate-3 transition-all duration-500 group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform"></div>
                    <div class="relative">
                        <span class="text-5xl">🇮🇩</span>
                        <p class="mt-4 font-black text-slate-900">IPS</p>
                        <p class="text-xs text-slate-500">Sejarah Kita</p>
                    </div>
                </div>
                <div class="relative overflow-hidden bg-white p-8 rounded-3xl border border-slate-100 shadow-xl hover:rotate-3 transition-all duration-500 group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-yellow-50 rounded-full group-hover:scale-150 transition-transform"></div>
                    <div class="relative">
                        <span class="text-5xl">📖</span>
                        <p class="mt-4 font-black text-slate-900">BIND</p>
                        <p class="text-xs text-slate-500">Teks Cerita</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-10 mt-20">
        <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col items-center text-center transition hover:-translate-y-3 hover:shadow-2xl hover:shadow-indigo-100">
            <div class="w-20 h-20 bg-indigo-50 rounded-3xl flex items-center justify-center text-5xl mb-8">🎮</div>
            <h3 class="text-2xl font-black text-slate-950 mb-3 tracking-tight">Game-Based</h3>
            <p class="text-slate-600 font-medium leading-relaxed">Format kuis yang didesain seperti permainan video, membuat siswa ingin terus belajar.</p>
        </div>
        <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col items-center text-center transition hover:-translate-y-3 hover:shadow-2xl hover:shadow-blue-100">
            <div class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center text-5xl mb-8">🏫</div>
            <h3 class="text-2xl font-black text-slate-950 mb-3 tracking-tight">Kurikulum SD</h3>
            <p class="text-slate-600 font-medium leading-relaxed">Seluruh soal disesuaikan dengan materi pembelajaran resmi di SDN 2 Cibinong.</p>
        </div>
        <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col items-center text-center transition hover:-translate-y-3 hover:shadow-2xl hover:shadow-emerald-100">
            <div class="w-20 h-20 bg-emerald-50 rounded-3xl flex items-center justify-center text-5xl mb-8">📊</div>
            <h3 class="text-2xl font-black text-slate-950 mb-3 tracking-tight">Progres Jelas</h3>
            <p class="text-slate-600 font-medium leading-relaxed">Nilai kuis akan otomatis tercatat, memudahkan Guru memantau perkembangan siswa.</p>
        </div>
    </div>
</div>
@endsection
