@extends('layout.master')

@section('konten')
<div class="min-h-screen pt-32 pb-12 px-6 bg-slate-50">
    <div class="max-w-3xl mx-auto">

        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 mb-10 text-center">
            <h1 class="text-2xl font-black text-slate-900 mb-2">Hasil Review: {{ $category->nama_kategori }}</h1>
            <div class="flex justify-center gap-8 mt-4">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Skor Kamu</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ number_format($result->skor, 0) }}</p>
                </div>
                <div class="w-px h-10 bg-slate-100"></div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Benar</p>
                    <p class="text-3xl font-bold text-emerald-500">{{ $result->benar }}</p>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            @foreach($category->questions as $index => $soal)
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <div class="flex gap-4 mb-6">
                        <span class="flex-none w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center font-bold text-slate-500">
                            {{ $index + 1 }}
                        </span>
                        <p class="text-xl font-bold text-slate-800 leading-relaxed">
                            {{ $soal->pertanyaan }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        @foreach(['a', 'b', 'c', 'd'] as $opsi)
                            @php
                                $labelOpsi = "opsi_" . $opsi;
                                $pilihanSiswa = $jawabanSiswa[$soal->id] ?? null;
                                $isSelected = $pilihanSiswa === $opsi;
                                $isCorrect = $soal->jawaban_benar === $opsi;

                                // Logika Warna: Hanya warnai jika itu pilihan siswa
                                $class = 'border-slate-50 bg-slate-50 text-slate-500';
                                if ($isSelected) {
                                    if ($isCorrect) {
                                        $class = 'border-emerald-500 bg-emerald-50 text-emerald-700'; // Siswa pilih & Benar
                                    } else {
                                        $class = 'border-red-500 bg-red-50 text-red-700'; // Siswa pilih & Salah
                                    }
                                }
                            @endphp

                            <div class="relative flex items-center p-4 rounded-2xl border-2 transition-all {{ $class }}">
                                <div class="flex items-center justify-between w-full">
                                    <p class="font-bold">
                                        <span class="uppercase mr-2">{{ $opsi }}.</span> {{ $soal->$labelOpsi }}
                                    </p>

                                    @if($isSelected)
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] font-black uppercase px-3 py-1 rounded-full {{ $isCorrect ? 'bg-emerald-200 text-emerald-800' : 'bg-red-200 text-red-800' }}">
                                                {{ $isCorrect ? 'Jawaban Kamu Benar ✓' : 'Jawaban Kamu Salah ✗' }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('siswa.dashboard') }}" class="inline-block bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold hover:bg-slate-800 transition-all">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
