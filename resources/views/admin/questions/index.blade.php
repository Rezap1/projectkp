@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-[#0f172a] px-6 pt-36 pb-16 text-slate-100">
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-black text-cyan-300 hover:text-cyan-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M15 19 8 12l7-7"/></svg>
                    Dashboard
                </a>
                <p class="mt-6 text-xs font-black uppercase tracking-[0.24em] text-cyan-300">Bank Soal</p>
                <h1 class="mt-2 text-4xl font-black tracking-tight text-white">Kelola Soal</h1>
                <p class="mt-3 max-w-2xl text-sm font-semibold leading-6 text-slate-400">Cari, filter, edit, dan hapus soal yang sudah tersimpan di database guru.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('categories.index') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-sm font-black text-slate-200 transition hover:bg-white/10">Kategori</a>
                <a href="{{ route('questions.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-400 px-4 py-3 text-sm font-black text-slate-950 shadow-lg shadow-cyan-500/20 transition hover:bg-cyan-300">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M12 4v16m8-8H4"/></svg>
                    Tambah Soal
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-lg border border-emerald-400/30 bg-emerald-500/10 px-5 py-4 text-sm font-bold text-emerald-200">{{ session('success') }}</div>
        @endif

        <form method="GET" class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
            <div class="grid gap-4 lg:grid-cols-[1fr_180px_220px_auto] lg:items-end">
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Pencarian</label>
                    <input name="q" value="{{ request('q') }}" placeholder="Cari pertanyaan atau opsi jawaban..." class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400">
                </div>
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Kelas</label>
                    <select name="kelas" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                        <option value="">Semua</option>
                        @foreach([4, 5, 6] as $kelas)
                            <option value="{{ $kelas }}" @selected(request('kelas') == $kelas)>Kelas {{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Kategori</label>
                    <select name="category_id" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                        <option value="">Semua kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>K{{ $category->kelas }} - {{ $category->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button class="rounded-lg bg-cyan-400 px-5 py-3 text-sm font-black text-slate-950 transition hover:bg-cyan-300">Filter</button>
                    <a href="{{ route('questions.index') }}" class="rounded-lg border border-white/10 bg-white/5 px-5 py-3 text-sm font-black text-slate-300 transition hover:text-white">Reset</a>
                </div>
            </div>
        </form>

        <section class="rounded-lg border border-white/10 bg-slate-900/80">
            <div class="flex flex-col gap-3 border-b border-white/10 p-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-fuchsia-300">Database</p>
                    <h2 class="mt-2 text-2xl font-black text-white">{{ $questions->total() }} Soal Tersimpan</h2>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[940px] text-left text-sm">
                    <thead class="bg-slate-950/60 text-xs uppercase tracking-widest text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Pertanyaan</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4 text-center">Kunci</th>
                            <th class="px-6 py-4">Dibuat</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($questions as $question)
                            <tr class="align-top hover:bg-white/[0.03]">
                                <td class="px-6 py-5">
                                    <p class="max-w-xl font-bold leading-6 text-white">{{ $question->pertanyaan }}</p>
                                    <div class="mt-3 grid gap-2 text-xs font-bold text-slate-400 sm:grid-cols-2">
                                        <span>A. {{ $question->opsi_a }}</span>
                                        <span>B. {{ $question->opsi_b }}</span>
                                        <span>C. {{ $question->opsi_c }}</span>
                                        <span>D. {{ $question->opsi_d }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="rounded-md bg-cyan-400/10 px-3 py-1 text-xs font-black text-cyan-300">Kelas {{ $question->category->kelas ?? '-' }}</span>
                                    <p class="mt-2 font-bold text-slate-300">{{ $question->category->nama_kategori ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="rounded-md bg-emerald-500/10 px-3 py-1 text-xs font-black uppercase text-emerald-300">{{ $question->jawaban_benar }}</span>
                                </td>
                                <td class="px-6 py-5 text-sm font-bold text-slate-500">{{ $question->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('questions.edit', $question) }}" class="rounded-lg border border-white/10 bg-white/5 p-3 text-slate-300 transition hover:border-cyan-400/40 hover:text-cyan-200" title="Edit soal">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('questions.destroy', $question) }}" onsubmit="return confirm('Hapus soal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded-lg border border-red-400/20 bg-red-500/10 p-3 text-red-300 transition hover:bg-red-500 hover:text-white" title="Hapus soal">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0A48.108 48.108 0 0 0 16.5 5.5m-9 0a48.11 48.11 0 0 0-2.728.29m0 0A48.667 48.667 0 0 1 12 5.25c2.466 0 4.862.185 7.228.54"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center font-bold text-slate-500">Belum ada soal sesuai filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-white/10 p-6">
                {{ $questions->links() }}
            </div>
        </section>
    </div>
</div>
@endsection
