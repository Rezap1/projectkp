@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-slate-50 pt-28 pb-12 px-6">
    <div class="max-w-3xl mx-auto">

        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 mb-8">
            <h1 class="text-2xl font-black text-slate-900 leading-tight">
                Kuis: {{ $category->nama_kategori }}
            </h1>
            <p class="text-slate-500 mt-2 text-sm">Jawablah pertanyaan di bawah ini dengan teliti.</p>
        </div>

        <form action="{{ route('kuis.submit') }}" method="POST">
            @csrf
            {{-- Mengirim ID kategori agar skor tersimpan di tempat yang benar --}}
            <input type="hidden" name="category_id" value="{{ $category->id }}">

            @foreach($category->questions as $index => $soal)
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 mb-6">
                <div class="flex items-start mb-6">
                    <span class="bg-indigo-600 text-white w-8 h-8 rounded-lg flex items-center justify-center font-bold mr-4 flex-shrink-0">
                        {{ $index + 1 }}
                    </span>
                    <p class="text-lg font-bold text-slate-800 leading-relaxed">
                        {{ $soal->pertanyaan }}
                    </p>
                </div>

                <div class="grid gap-3">
                    @foreach(['a', 'b', 'c', 'd'] as $opsi)
                    <label class="flex items-center p-5 bg-slate-50 rounded-2xl border border-slate-100 cursor-pointer hover:border-indigo-600 hover:bg-indigo-50 transition-all group">
                        <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ $opsi }}" class="w-5 h-5 text-indigo-600 border-slate-300 focus:ring-indigo-500" required>
                        <span class="ml-4 text-slate-700 group-hover:text-indigo-900">
                            <span class="font-black mr-1">{{ strtoupper($opsi) }}.</span>
                            {{ $soal->{'opsi_' . $opsi} }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach

            <button type="submit" class="w-full bg-indigo-600 text-white font-black py-5 rounded-[2rem] shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all text-xl mt-4">
                Selesaikan Kuis & Lihat Skor
            </button>
        </form>

    </div>
</div>
@endsection
