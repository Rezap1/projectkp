@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-[#0f172a] px-6 pt-36 pb-16 text-slate-100">
    <div class="mx-auto max-w-6xl space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <a href="{{ route('questions.index') }}" class="inline-flex items-center gap-2 text-sm font-black text-cyan-300 hover:text-cyan-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M15 19 8 12l7-7"/></svg>
                    Bank Soal
                </a>
                <p class="mt-6 text-xs font-black uppercase tracking-[0.24em] text-cyan-300">Input Database</p>
                <h1 class="mt-2 text-4xl font-black tracking-tight text-white">Tambah Soal Kuis</h1>
                <p class="mt-3 max-w-2xl text-sm font-semibold leading-6 text-slate-400">Pilih kategori, atur durasi, lalu isi beberapa soal sekaligus. Baris pertanyaan kosong akan dilewati.</p>
            </div>

            <a href="{{ route('categories.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-sm font-black text-slate-200 transition hover:bg-white/10">
                Kelola Kategori
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-lg border border-emerald-400/30 bg-emerald-500/10 px-5 py-4 text-sm font-bold text-emerald-200">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="rounded-lg border border-red-400/30 bg-red-500/10 px-5 py-4 text-sm font-bold text-red-200">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="rounded-lg border border-red-400/30 bg-red-500/10 px-5 py-4 text-sm font-bold text-red-200">{{ $errors->first() }}</div>
        @endif

        @if($categories->isEmpty())
            <div class="rounded-lg border border-yellow-400/30 bg-yellow-500/10 p-6">
                <h2 class="text-xl font-black text-yellow-200">Kategori belum tersedia</h2>
                <p class="mt-2 text-sm font-semibold text-yellow-100/80">Buat mata pelajaran terlebih dahulu sebelum menambahkan soal.</p>
                <a href="{{ route('categories.index') }}" class="mt-5 inline-flex rounded-lg bg-yellow-300 px-4 py-3 text-sm font-black text-slate-950 transition hover:bg-yellow-200">Buat Kategori</a>
            </div>
        @else
            <form action="{{ route('questions.store') }}" method="POST" class="space-y-6">
                @csrf

                <section class="grid gap-5 rounded-lg border border-white/10 bg-slate-900/80 p-6 md:grid-cols-[1fr_220px]">
                    <div>
                        <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Mata Pelajaran</label>
                        <select name="category_id" required class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>Kelas {{ $cat->kelas }} - {{ $cat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Durasi Menit</label>
                        <input type="number" name="durasi" value="{{ old('durasi', 60) }}" min="1" max="180" required class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                    </div>
                </section>

                <section class="space-y-5">
                    @for ($i = 1; $i <= 30; $i++)
                        <div class="rounded-lg border border-white/10 bg-slate-900/80 p-6">
                            <div class="mb-5 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-cyan-400/10 text-sm font-black text-cyan-300">{{ $i }}</span>
                                    <h2 class="text-lg font-black text-white">Soal {{ $i }}</h2>
                                </div>
                                <span class="text-xs font-black uppercase tracking-widest text-slate-600">Opsional</span>
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Pertanyaan</label>
                                <textarea name="questions[{{ $i }}][pertanyaan]" rows="3" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold leading-6 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400" placeholder="Ketik pertanyaan...">{{ old("questions.$i.pertanyaan") }}</textarea>
                            </div>

                            <div class="mt-5 grid gap-4 md:grid-cols-2">
                                @foreach(['a', 'b', 'c', 'd'] as $o)
                                    <div>
                                        <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Opsi {{ strtoupper($o) }}</label>
                                        <input type="text" name="questions[{{ $i }}][opsi_{{ $o }}]" value="{{ old("questions.$i.opsi_$o") }}" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400" placeholder="Isi jawaban...">
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-5">
                                <label class="mb-3 block text-xs font-black uppercase tracking-widest text-slate-500">Kunci Jawaban</label>
                                <div class="grid grid-cols-4 gap-3">
                                    @foreach(['a', 'b', 'c', 'd'] as $ans)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="questions[{{ $i }}][jawaban_benar]" value="{{ $ans }}" class="peer sr-only" @checked(old("questions.$i.jawaban_benar") === $ans)>
                                            <span class="block rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-center text-sm font-black uppercase text-slate-400 transition peer-checked:border-emerald-400 peer-checked:bg-emerald-500 peer-checked:text-white">{{ $ans }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endfor
                </section>

                <div class="sticky bottom-5 z-20 rounded-lg border border-cyan-400/20 bg-slate-950/90 p-4 shadow-2xl shadow-cyan-950/40 backdrop-blur">
                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-cyan-400 px-5 py-4 text-sm font-black text-slate-950 transition hover:bg-cyan-300">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        Simpan Soal ke Database
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
