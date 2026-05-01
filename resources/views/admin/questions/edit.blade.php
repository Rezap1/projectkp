@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-[#0f172a] px-6 pt-36 pb-16 text-slate-100">
    <div class="mx-auto max-w-5xl space-y-6">
        <div>
            <a href="{{ route('questions.index') }}" class="inline-flex items-center gap-2 text-sm font-black text-cyan-300 hover:text-cyan-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M15 19 8 12l7-7"/></svg>
                Bank Soal
            </a>
            <p class="mt-6 text-xs font-black uppercase tracking-[0.24em] text-cyan-300">Editor Soal</p>
            <h1 class="mt-2 text-4xl font-black tracking-tight text-white">Perbarui Pertanyaan</h1>
            <p class="mt-3 max-w-2xl text-sm font-semibold leading-6 text-slate-400">Ubah kategori, isi pertanyaan, pilihan jawaban, dan kunci yang benar.</p>
        </div>

        @if($errors->any())
            <div class="rounded-lg border border-red-400/30 bg-red-500/10 px-5 py-4 text-sm font-bold text-red-200">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('questions.update', $question) }}" class="rounded-lg border border-white/10 bg-slate-900/80 p-6">
            @csrf
            @method('PATCH')

            <div class="grid gap-5 md:grid-cols-[1fr_180px]">
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Kategori</label>
                    <select name="category_id" required class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $question->category_id) == $category->id)>Kelas {{ $category->kelas }} - {{ $category->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Kunci</label>
                    <select name="jawaban_benar" required class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-black uppercase text-white outline-none transition focus:border-cyan-400">
                        @foreach(['a', 'b', 'c', 'd'] as $answer)
                            <option value="{{ $answer }}" @selected(old('jawaban_benar', $question->jawaban_benar) === $answer)>{{ strtoupper($answer) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Pertanyaan</label>
                <textarea name="pertanyaan" rows="5" required class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold leading-6 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400">{{ old('pertanyaan', $question->pertanyaan) }}</textarea>
            </div>

            <div class="mt-6 grid gap-4 md:grid-cols-2">
                @foreach(['a', 'b', 'c', 'd'] as $option)
                    <div>
                        <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Opsi {{ strtoupper($option) }}</label>
                        <input name="opsi_{{ $option }}" value="{{ old('opsi_' . $option, $question->{'opsi_' . $option}) }}" required class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400">
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('questions.index') }}" class="inline-flex items-center justify-center rounded-lg border border-white/10 bg-white/5 px-5 py-3 text-sm font-black text-slate-300 transition hover:text-white">Batal</a>
                <button class="inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-400 px-5 py-3 text-sm font-black text-slate-950 transition hover:bg-cyan-300">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="m4.5 12.75 6 6 9-13.5"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
