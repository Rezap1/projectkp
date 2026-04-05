@extends('layout.master')

@section('konten')
{{-- pt-44 untuk memastikan konten berada di bawah navbar fixed --}}
<div class="max-w-4xl mx-auto px-6 pt-44 pb-20 min-h-screen">

    {{-- Tombol Kembali & Judul --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.dashboard') }}"
           class="group flex items-center justify-center w-12 h-12 bg-white rounded-2xl border border-slate-100 shadow-sm hover:bg-slate-900 hover:text-white transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Tambah Soal Baru ➕</h2>
            <p class="text-slate-500 font-medium">Kembali ke Panel Guru</p>
        </div>
    </div>

    <div class="bg-white rounded-[3rem] shadow-2xl p-10 border border-slate-100">
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf

            {{-- Mata Pelajaran --}}
            <div class="mb-6">
    <label class="block text-sm font-black text-slate-700 mb-2">MATA PELAJARAN</label>
    <div class="relative">
        <select name="category_id" class="w-full px-5 py-4 rounded-2xl border border-slate-200 bg-white text-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all appearance-none cursor-pointer">
            <option value="" class="text-slate-900">-- Pilih Mata Pelajaran --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" class="text-slate-900">
                    {{ $cat->nama_kategori }} {{-- Pastikan nama kolom di database sesuai, misal 'name' atau 'nama_kategori' --}}
                </option>
            @endforeach
        </select>

        {{-- Tambahkan ikon panah ini agar dropdown kelihatan bisa diklik --}}
        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>
</div>

            {{-- Isi Pertanyaan --}}
            <div class="mb-8">
                <label class="block text-sm font-black text-slate-400 uppercase tracking-widest mb-3 italic">Isi Pertanyaan</label>
                <textarea name="pertanyaan" rows="3" class="w-full p-5 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:border-indigo-500 focus:bg-white outline-none transition-all font-bold text-slate-700 shadow-sm" placeholder="Tulis soal di sini..."></textarea>
            </div>

            {{-- Opsi Jawaban --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                @foreach(['a', 'b', 'c', 'd'] as $o)
                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Opsi {{ $o }}</label>
                    <input type="text" name="opsi_{{ $o }}"
                           class="w-full p-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:border-indigo-500 focus:bg-white outline-none transition-all font-bold shadow-sm group-hover:border-slate-200"
                           required>
                </div>
                @endforeach
            </div>

            {{-- Kunci Jawaban Benar --}}
            <div class="mb-12 p-8 bg-indigo-50 rounded-[2.5rem] border-2 border-dashed border-indigo-200">
                <label class="block text-sm font-black text-indigo-700 mb-5 flex items-center gap-2">
                    <span class="w-2 h-2 bg-indigo-600 rounded-full animate-pulse"></span>
                    Kunci Jawaban Benar:
                </label>
                <div class="grid grid-cols-4 gap-4">
                    @foreach(['a', 'b', 'c', 'd'] as $ans)
                    <label class="relative cursor-pointer">
                        <input type="radio" name="jawaban_benar" value="{{ $ans }}" class="hidden peer" required>
                        <div class="py-4 bg-white border-2 border-white rounded-2xl text-center font-black uppercase text-slate-400 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 peer-checked:shadow-lg peer-checked:shadow-indigo-200 transition-all duration-300">
                            {{ $ans }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white font-black py-6 rounded-[2rem] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200 flex items-center justify-center gap-3 group">
                <span>Simpan Soal ke Bank Data</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>
    </div>
</div>
@endsection
