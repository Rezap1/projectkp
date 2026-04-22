@extends('layout.master')

@section('konten')
<div class="max-w-7xl mx-auto p-8">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black text-gray-900 mb-2">Pilih Mata Pelajaran ✏️</h1>
        <p class="text-gray-500">Ayo uji kemampuanmu dan dapatkan nilai terbaik!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($categories as $cat)
        <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-100 p-8 border-b-8 border-indigo-600 hover:-translate-y-2 transition-transform duration-300">
            <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6 text-3xl">
                📚
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $cat->nama_kategori }}</h2>
            <a href="{{ route('siswa.kuis.show', $cat->slug) }}"
               class="inline-block w-full text-center bg-indigo-600 text-white font-bold py-4 rounded-2xl hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">
                Mulai Kuis
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
