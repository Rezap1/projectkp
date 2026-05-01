@extends('layout.master')

@section('konten')
    <div class="min-h-screen flex items-center justify-center px-6 pt-32 pb-12 bg-[#0f172a]">
        <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl">
            {{ $slot }}
        </div>
    </div>
@endsection
