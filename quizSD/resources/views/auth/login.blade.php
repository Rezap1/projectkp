@extends('layout.master')

@section('konten')
<div class="min-h-screen flex flex-col justify-center items-center pt-32 pb-12 px-6 bg-slate-50">
    <div class="w-full max-w-md bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-2xl shadow-indigo-100 border border-white">

        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Selamat Datang!</h2>
            <p class="text-slate-500 font-medium mt-2">Silakan masuk ke akun Anda</p>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                <input id="email" type="email" name="email" :value="old('email')"
                    class="w-full px-5 py-4 rounded-2xl border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all placeholder:text-slate-400"
                    placeholder="nama@email.com" required autofocus autocomplete="username">
                @error('email')
                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                <input id="password" type="password" name="password"
                    class="w-full px-5 py-4 rounded-2xl border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all placeholder:text-slate-400"
                    placeholder="••••••••" required autocomplete="current-password">
                @error('password')
                    <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm font-bold text-slate-600">Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm font-bold text-indigo-600 hover:text-indigo-500 underline" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-indigo-200 transition-all hover:-translate-y-1 active:scale-95">
                Masuk Sekarang →
            </button>
        </form>

        <p class="mt-8 text-center text-sm font-bold text-slate-400">
            Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Daftar di sini</a>
        </p>
    </div>
</div>
@endsection
