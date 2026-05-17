@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-[#0f172a] px-6 pt-36 pb-16 text-slate-100" x-data="{ editing: null }">
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-black text-cyan-300 hover:text-cyan-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M15 19 8 12l7-7"/></svg>
                    Dashboard
                </a>
                <p class="mt-6 text-xs font-black uppercase tracking-[0.24em] text-cyan-300">Database Kuis</p>
                <h1 class="mt-2 text-4xl font-black tracking-tight text-white">Mata Pelajaran</h1>
                <p class="mt-3 max-w-2xl text-sm font-semibold leading-6 text-slate-400">Buat kategori kuis per kelas, lalu pantau jumlah soal serta hasil yang tersimpan.</p>
            </div>

            <a href="{{ route('questions.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-400 px-4 py-3 text-sm font-black text-slate-950 shadow-lg shadow-cyan-500/20 transition hover:bg-cyan-300">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M12 4v16m8-8H4"/></svg>
                Tambah Soal
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-lg border border-emerald-400/30 bg-emerald-500/10 px-5 py-4 text-sm font-bold text-emerald-200">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="rounded-lg border border-red-400/30 bg-red-500/10 px-5 py-4 text-sm font-bold text-red-200">{{ $errors->first() }}</div>
        @endif

        <section class="grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
            <form method="POST" action="{{ route('categories.store') }}" class="rounded-lg border border-cyan-400/15 bg-slate-900/80 p-6">
                @csrf
                <p class="text-xs font-black uppercase tracking-[0.22em] text-cyan-300">Tambah Kategori</p>
                <h2 class="mt-2 text-2xl font-black text-white">Kuis Baru</h2>

                <div class="mt-6 space-y-5">
                    <div>
                        <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Nama Mata Pelajaran</label>
                        <input name="nama_kategori" value="{{ old('nama_kategori') }}" required placeholder="Contoh: Matematika Pecahan" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400">
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Kelas</label>
                        <select name="kelas" required class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                            <option value="4">Kelas 4</option>
                            <option value="5">Kelas 5</option>
                            <option value="6">Kelas 6</option>
                        </select>
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-cyan-400 px-4 py-3 text-sm font-black text-slate-950 transition hover:bg-cyan-300">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M12 4v16m8-8H4"/></svg>
                        Simpan Kategori
                    </button>
                </div>
            </form>

            <div class="rounded-lg border border-white/10 bg-slate-900/80">
                <div class="border-b border-white/10 p-6">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-fuchsia-300">Daftar Database</p>
                    <h2 class="mt-2 text-2xl font-black text-white">Kategori Aktif</h2>
                </div>

                <div class="divide-y divide-white/5">
                    @forelse($categories as $category)
                        <div class="p-6">
                            <div x-show="editing !== {{ $category->id }}" class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                <div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <h3 class="text-xl font-black text-white">{{ $category->nama_kategori }}</h3>
                                        <span class="rounded-md bg-cyan-400/10 px-3 py-1 text-xs font-black text-cyan-300">Kelas {{ $category->kelas }}</span>
                                    </div>
                                    <p class="mt-2 text-sm font-bold text-slate-500">{{ $category->questions_count }} soal | {{ $category->results_count }} hasil</p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button type="button" @click="editing = {{ $category->id }}" class="rounded-lg border border-white/10 bg-white/5 p-3 text-slate-300 transition hover:border-cyan-400/40 hover:text-cyan-200" title="Edit kategori">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/></svg>
                                    </button>
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini beserta soal dan hasil terkait?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-red-400/20 bg-red-500/10 p-3 text-red-300 transition hover:bg-red-500 hover:text-white" title="Hapus kategori">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0A48.108 48.108 0 0 0 16.5 5.5m-9 0a48.11 48.11 0 0 0-2.728.29m0 0A48.667 48.667 0 0 1 12 5.25c2.466 0 4.862.185 7.228.54"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <form x-show="editing === {{ $category->id }}" x-cloak method="POST" action="{{ route('categories.update', $category) }}" class="grid gap-4 md:grid-cols-[1fr_140px_auto] md:items-end">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Nama</label>
                                    <input name="nama_kategori" value="{{ $category->nama_kategori }}" required class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none focus:border-cyan-400">
                                </div>
                                <div>
                                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Kelas</label>
                                    <select name="kelas" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none focus:border-cyan-400">
                                        @foreach([4, 5, 6] as $kelas)
                                            <option value="{{ $kelas }}" @selected($category->kelas == $kelas)>Kelas {{ $kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex gap-2">
                                    <button class="rounded-lg bg-cyan-400 px-4 py-3 text-sm font-black text-slate-950 hover:bg-cyan-300">Simpan</button>
                                    <button type="button" @click="editing = null" class="rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-sm font-black text-slate-300 hover:text-white">Batal</button>
                                </div>
                            </form>
                        </div>
                    @empty
                        <div class="p-12 text-center font-bold text-slate-500">Belum ada kategori. Buat kategori pertama dari form di samping.</div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
