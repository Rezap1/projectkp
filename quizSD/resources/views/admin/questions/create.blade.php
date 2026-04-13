@extends('layout.master')

@section('konten')
{{-- Mengubah bg-white menjadi bg-slate-50 untuk mengurangi pantulan cahaya --}}
<div class="max-w-4xl mx-auto px-6 pt-44 pb-20 min-h-screen bg-slate-50">

    {{-- Tombol Kembali & Judul --}}
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('admin.dashboard') }}"
           class="group flex items-center justify-center w-12 h-12 bg-white rounded-2xl border border-slate-200 shadow-sm hover:bg-slate-900 hover:text-white transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Bank Soal Kuis 📚</h2>
            <p class="text-slate-500 font-medium italic">Silakan isi soal di bawah ini</p>
        </div>
    </div>

    <form action="{{ route('questions.store') }}" method="POST">
        @csrf

        {{-- Section Kategori dengan warna Indigo --}}
        <div class="bg-indigo-600 rounded-[2.5rem] shadow-lg p-8 mb-12 border-4 border-white">
            <label class="block text-xs font-black text-indigo-100 mb-3 tracking-[0.2em]">1. PILIH MATA PELAJARAN</label>
            <div class="relative">
                <select name="category_id" class="w-full px-6 py-5 rounded-2xl border-none bg-white/10 text-white placeholder-white/60 focus:ring-4 focus:ring-white/20 transition-all appearance-none cursor-pointer font-bold text-lg" required>
                    <option value="" class="text-slate-900">-- Klik untuk Memilih --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" class="text-slate-900">{{ $cat->nama_kategori }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-5 pointer-events-none text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Looping 30 Soal --}}
        @for ($i = 1; $i <= 30; $i++)
        <div class="bg-slate-900/90 rounded-[3rem] shadow-sm p-10 border border-slate-200 mb-10 relative overflow-hidden transition-all hover:shadow-md">

            {{-- Header Soal dengan warna Slate --}}
            <div class="flex items-center gap-3 mb-8">
                <div class="flex items-center justify-center w-10 h-10 bg-slate-100 text-indigo-500 rounded-xl font-black shadow-inner">
                    {{ $i }}
                </div>
                <div class="h-[2px] flex-1 bg-slate-100 rounded-full"></div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Question Item</span>
            </div>

            {{-- Isi Pertanyaan --}}
            <div class="mb-8">
                <label class="block text-xs font-black text-white uppercase tracking-widest mb-3 italic">Tulis Pertanyaan</label>
                <textarea name="questions[{{ $i }}][pertanyaan]" rows="3" class="w-full p-6 bg-slate-50 border-2 border-slate-100 rounded-[2rem] focus:border-indigo-500 focus:bg-white outline-none transition-all font-bold text-slate-700" placeholder="Ketik soal kuis di sini..."></textarea>
            </div>

            {{-- Opsi Jawaban dengan background abu-abu tipis --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10">
                @foreach(['a', 'b', 'c', 'd'] as $o)
                <div class="group">
                    <div class="flex items-center bg-slate-50 rounded-2xl border-2 border-slate-50 group-focus-within:border-indigo-500 group-focus-within:bg-white transition-all overflow-hidden">
                        <span class="px-5 py-4 bg-slate-200 text-slate-500 font-black uppercase text-xs">{{ $o }}</span>
                        <input type="text" name="questions[{{ $i }}][opsi_{{ $o }}]"
                               class="w-full p-4 bg-transparent border-none outline-none font-bold text-slate-600"
                               placeholder="Isi jawaban...">
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Kunci Jawaban dengan warna Emerald lembut --}}
            <div class="p-8 bg-emerald-50/50 rounded-[2.5rem] border-2 border-emerald-100">
                <label class="block text-xs font-black text-slate-900/90 mb-5 flex items-center gap-2 uppercase tracking-widest">
                    Pilih Kunci Jawaban:
                </label>
                <div class="grid grid-cols-4 gap-4">
                    @foreach(['a', 'b', 'c', 'd'] as $ans)
                    <label class="relative cursor-pointer">
                        <input type="radio" name="questions[{{ $i }}][jawaban_benar]" value="{{ $ans }}" class="hidden peer">
                        <div class="py-4 bg-white border-2 border-slate-100 rounded-2xl text-center font-black uppercase text-slate-400 peer-checked:bg-emerald-500 peer-checked:text-white peer-checked:border-emerald-500 peer-checked:shadow-lg transition-all duration-300">
                            {{ $ans }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endfor

        {{-- Action Button --}}
        <div class="sticky bottom-8 z-50">
            <button type="submit" class="w-full bg-slate-900 text-white font-black py-7 rounded-[2.5rem] hover:bg-indigo-600 transition-all shadow-2xl flex items-center justify-center gap-4 group border-4 border-white">
                <span class="text-lg tracking-tight">KONFIRMASI & SIMPAN 30 SOAL</span>
                <div class="bg-white/20 p-2 rounded-xl group-hover:rotate-12 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </div>
            </button>
        </div>
    </form>
</div>
@endsection
