@extends('layout.master')

@section('konten')
    <div class="min-h-screen pt-32 pb-12 bg-slate-100 text-slate-900">
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>
@endsection
