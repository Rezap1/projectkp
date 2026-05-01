@extends('layout.master')

@section('konten')
<div class="min-h-screen pt-32 pb-12 px-6 bg-[#0f172a] text-slate-200 relative overflow-hidden">

    {{-- Background Glow --}}
    <div class="absolute top-0 left-0 w-96 h-96 bg-cyan-500/10 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-fuchsia-500/10 blur-[120px] rounded-full"></div>

    <div class="max-w-3xl mx-auto relative z-10">

        {{-- Header Result --}}
        <div class="bg-slate-900/80 backdrop-blur-xl p-8 rounded-[2.5rem] shadow-2xl border border-cyan-500/20 mb-10 text-center">
            <div class="inline-flex items-center gap-2 bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest mb-5">
                Battle Result
            </div>

            <h1 class="text-3xl font-black text-white mb-3 uppercase italic">
                Review Arena: {{ $category->nama_kategori }}
            </h1>

            <p class="text-slate-400 font-medium italic mb-8">
                Pelajari kembali jawabanmu untuk menjadi lebih kuat ⚔️
            </p>

            <div class="grid grid-cols-2 gap-6">
                <div class="bg-cyan-500/10 border border-cyan-500/20 p-6 rounded-3xl">
                    <p class="text-[10px] font-black text-cyan-400 uppercase tracking-widest">Skor Kamu</p>
                    <p class="text-4xl font-black text-white mt-2">
                        {{ number_format($result->skor, 0) }}
                    </p>
                </div>

                <div class="bg-emerald-500/10 border border-emerald-500/20 p-6 rounded-3xl">
                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Jawaban Benar</p>
                    <p class="text-4xl font-black text-white mt-2">
                        {{ $result->benar }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Review Soal --}}
        <div class="space-y-8">
            @foreach($category->questions as $index => $soal)
                <div class="bg-slate-900/80 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white/10 shadow-xl">

                    {{-- Nomor Soal --}}
                    <div class="flex gap-4 mb-6">
                        <span class="flex-none w-10 h-10 bg-gradient-to-br from-cyan-500 to-fuchsia-500 rounded-full flex items-center justify-center font-bold text-white shadow-lg">
                            {{ $index + 1 }}
                        </span>

                        <p class="text-xl font-bold text-white leading-relaxed">
                            {{ $soal->pertanyaan }}
                        </p>
                    </div>

                    {{-- Opsi Jawaban --}}
                    <div class="grid grid-cols-1 gap-4">
                        @foreach(['a', 'b', 'c', 'd'] as $opsi)
                            @php
                                $labelOpsi = "opsi_" . $opsi;
                                $pilihanSiswa = $jawabanSiswa[$soal->id] ?? null;
                                $isSelected = $pilihanSiswa === $opsi;
                                $isCorrect = $soal->jawaban_benar === $opsi;

                                $class = 'border-white/5 bg-slate-800/50 text-slate-400';

                                if ($isSelected && $isCorrect) {
                                    $class = 'border-emerald-500 bg-emerald-500/10 text-emerald-300';
                                } elseif ($isSelected && !$isCorrect) {
                                    $class = 'border-red-500 bg-red-500/10 text-red-300';
                                } elseif (!$isSelected && $isCorrect) {
                                    $class = 'border-cyan-500 bg-cyan-500/10 text-cyan-300';
                                }
                            @endphp

                            <div class="relative flex items-center p-4 rounded-2xl border-2 transition-all {{ $class }}">
                                <div class="flex items-center justify-between w-full gap-4">

                                    <p class="font-bold">
                                        <span class="uppercase mr-2">{{ $opsi }}.</span>
                                        {{ $soal->$labelOpsi }}
                                    </p>

                                    <div class="flex items-center gap-2 flex-wrap justify-end">

                                        @if($isSelected)
                                            <span class="text-[10px] font-black uppercase px-3 py-1 rounded-full
                                                {{ $isCorrect
                                                    ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30'
                                                    : 'bg-red-500/20 text-red-300 border border-red-500/30' }}">
                                                {{ $isCorrect ? 'Pilihan Kamu ✓' : 'Pilihan Kamu ✗' }}
                                            </span>
                                        @endif

                                        @if(!$isSelected && $isCorrect)
                                            <span class="text-[10px] font-black uppercase px-3 py-1 rounded-full bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">
                                                Jawaban Benar
                                            </span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if(($jawabanSiswa[$soal->id] ?? null) === '-')
                        <p class="mt-4 text-[10px] font-black uppercase tracking-widest text-orange-300">
                            Tidak dijawab saat waktu habis.
                        </p>
                    @endif

                </div>
            @endforeach
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-12 text-center">
            <a href="{{ route('siswa.dashboard') }}"
               class="inline-flex items-center gap-3 bg-gradient-to-r from-cyan-500 to-fuchsia-500 text-white px-10 py-4 rounded-2xl font-black shadow-[0_0_25px_rgba(6,182,212,0.35)] hover:scale-105 transition-all active:scale-95 uppercase tracking-wide">
                <span>Kembali ke Arena</span>

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="3"
                          d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </div>

    </div>
</div>
@endsection
