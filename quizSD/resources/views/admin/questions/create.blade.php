@extends('layout.master')

@section('konten')
<div class="max-w-4xl mx-auto px-6 pt-44 pb-20 min-h-screen bg-[#0A0F1F] text-white">

    {{-- Tombol Kembali & Judul --}}
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('admin.dashboard') }}"
           class="group flex items-center justify-center w-12 h-12 bg-white/5 rounded-2xl border border-cyan-400/20 shadow-[0_0_15px_rgba(34,211,238,0.08)] hover:bg-cyan-500 hover:text-white transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        <div>
            <h2 class="text-3xl font-black tracking-tight text-white">
                Bank Soal Kuis 📚
            </h2>
            <p class="text-slate-400 font-medium italic">
                Silakan isi soal di bawah ini
            </p>
        </div>
    </div>

    <form action="{{ route('questions.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">

            {{-- Kategori --}}
            <div class="bg-gradient-to-br from-cyan-500 to-cyan-700 rounded-[2.5rem] shadow-[0_0_30px_rgba(34,211,238,0.25)] p-8 border border-cyan-300/20">
                <label class="block text-xs font-black text-cyan-100 mb-3 tracking-[0.2em]">
                    1. PILIH MATA PELAJARAN
                </label>

                <div class="relative">
                    <select name="category_id"
                            class="w-full px-6 py-5 rounded-2xl border-none bg-white/10 text-white focus:ring-4 focus:ring-white/20 appearance-none cursor-pointer font-bold text-lg"
                            required>
                        <option value="" class="text-slate-900">-- Klik untuk Memilih --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" class="text-slate-900">
                                {{ $cat->nama_kategori }} - (Kelas {{ $cat->kelas }})
                            </option>
                        @endforeach
                    </select>

                    <div class="absolute inset-y-0 right-0 flex items-center px-5 pointer-events-none text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Durasi --}}
            <div class="bg-gradient-to-br from-purple-500 to-indigo-700 rounded-[2.5rem] shadow-[0_0_30px_rgba(139,92,246,0.25)] p-8 border border-purple-300/20 flex flex-col justify-center text-white">
                <label class="block text-xs font-black text-purple-100 mb-3 tracking-[0.2em]">
                    2. DURASI WAKTU (MENIT)
                </label>

                <div class="flex items-center gap-4 bg-white/10 p-2 rounded-2xl border border-white/20">
                    <div class="bg-white p-3 rounded-xl shadow-inner text-purple-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <input type="number"
                           name="durasi"
                           value="60"
                           min="1"
                           class="w-full bg-transparent border-none outline-none font-black text-2xl text-white"
                           placeholder="60">
                </div>

                <p class="mt-3 text-[10px] font-bold text-purple-100 italic">
                    *Setiap kelas mungkin butuh waktu berbeda
                </p>
            </div>
        </div>

        {{-- Loop 30 Soal --}}
        @for ($i = 1; $i <= 30; $i++)
        <div class="bg-white/5 backdrop-blur-xl rounded-[3rem] shadow-[0_0_20px_rgba(34,211,238,0.05)] p-10 border border-cyan-400/10 mb-10 relative overflow-hidden">

            {{-- Header Soal --}}
            <div class="flex items-center gap-3 mb-8">
                <div class="flex items-center justify-center w-10 h-10 bg-cyan-500/10 text-cyan-300 rounded-xl font-black border border-cyan-400/20">
                    {{ $i }}
                </div>

                <div class="h-[2px] flex-1 bg-cyan-400/10 rounded-full"></div>

                <span class="text-[10px] font-black text-cyan-300 uppercase tracking-widest">
                    Question Item
                </span>
            </div>

            {{-- Pertanyaan --}}
            <div class="mb-8">
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3 italic">
                    Tulis Pertanyaan
                </label>

                <textarea name="questions[{{ $i }}][pertanyaan]"
                          rows="3"
                          class="w-full p-6 bg-white/5 border border-cyan-400/10 rounded-[2rem] focus:border-cyan-400 focus:bg-white/10 outline-none transition-all font-bold text-white placeholder-slate-500"
                          placeholder="Ketik soal kuis di sini..."></textarea>
            </div>

            {{-- Opsi Jawaban --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10">
                @foreach(['a', 'b', 'c', 'd'] as $o)
                <div class="group/option">
                    <div class="flex items-center bg-white/5 rounded-2xl border border-cyan-400/10 group-focus-within/option:border-cyan-400 transition-all overflow-hidden">
                        <span class="px-5 py-4 bg-cyan-500/10 text-cyan-300 font-black uppercase text-xs">
                            {{ $o }}
                        </span>

                        <input type="text"
                               name="questions[{{ $i }}][opsi_{{ $o }}]"
                               class="w-full p-4 bg-transparent border-none outline-none font-bold text-white placeholder-slate-500"
                               placeholder="Isi jawaban...">
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Kunci Jawaban --}}
            <div class="p-8 bg-emerald-500/5 rounded-[2.5rem] border border-emerald-400/10">
                <label class="block text-xs font-black text-emerald-300 mb-5 uppercase tracking-widest">
                    Pilih Kunci Jawaban:
                </label>

                <div class="grid grid-cols-4 gap-4">
                    @foreach(['a', 'b', 'c', 'd'] as $ans)
                    <label class="relative cursor-pointer">
                        <input type="radio"
                               name="questions[{{ $i }}][jawaban_benar]"
                               value="{{ $ans }}"
                               class="hidden peer">

                        <div class="py-4 bg-white/5 border border-cyan-400/10 rounded-2xl text-center font-black uppercase text-slate-400 peer-checked:bg-emerald-500 peer-checked:text-white peer-checked:border-emerald-400 peer-checked:shadow-[0_0_20px_rgba(16,185,129,0.35)] transition-all duration-300">
                            {{ $ans }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        @endfor

        {{-- Submit --}}
        <div class="sticky bottom-8 z-50">
            <button type="submit"
                    class="w-full bg-gradient-to-r from-cyan-500 to-purple-600 text-white font-black py-7 rounded-[2.5rem] shadow-[0_0_35px_rgba(34,211,238,0.35)] flex items-center justify-center gap-4 group hover:scale-[1.02] transition-all">
                <span class="text-lg tracking-tight">
                    KONFIRMASI & SIMPAN 30 SOAL
                </span>

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
