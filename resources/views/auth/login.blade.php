@extends('layout.master')

@section('konten')
<div class="min-h-screen flex flex-col justify-center items-center pt-32 pb-12 px-6 relative overflow-hidden bg-slate-950">

    {{-- Ambient Background --}}
    <div class="absolute -top-24 -right-24 w-[500px] h-[500px] bg-cyan-600/10 rounded-full blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-10 -left-24 w-[500px] h-[500px] bg-fuchsia-600/10 rounded-full blur-[120px] animate-pulse"></div>
    <div class="absolute top-1/2 left-1/2 w-[300px] h-[300px] bg-indigo-500/5 rounded-full blur-[100px] -translate-x-1/2 -translate-y-1/2"></div>

    {{-- Floating Particles --}}
    <div class="absolute top-24 left-10 text-3xl opacity-20 animate-bounce">✨</div>
    <div class="absolute bottom-20 right-16 text-4xl opacity-20 animate-pulse">📚</div>
    <div class="absolute top-1/3 right-20 text-2xl opacity-20 animate-bounce delay-200">🚀</div>

    {{-- Login Card --}}
    <div class="w-full max-w-md bg-slate-900/70 backdrop-blur-2xl p-10 rounded-[2.5rem] shadow-2xl border border-white/10 relative z-10">

        {{-- Header --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-cyan-500/10 rounded-2xl mb-4 border border-cyan-500/20 shadow-inner shadow-cyan-500/20">
                <span class="text-4xl">🔐</span>
            </div>

            <div class="inline-block px-4 py-1 mb-4 bg-cyan-500/10 border border-cyan-500/20 rounded-full text-[10px] font-black text-cyan-400 uppercase tracking-widest">
                Portal Belajar Aktif
            </div>

            <h2 class="text-3xl font-black text-white tracking-tighter uppercase italic">
                Selamat Datang!
            </h2>

            <p class="text-slate-400 font-medium mt-2">
                Masuk dan lanjutkan petualangan belajarmu 🚀
            </p>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 font-bold text-sm text-emerald-400 text-center animate-pulse">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
            @csrf

            {{-- Email --}}
            <div class="space-y-2">
                <label for="email" class="block text-xs font-black text-cyan-400 uppercase tracking-widest ml-1">
                    Email
                </label>

                <div class="relative group">
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="w-full bg-slate-800/50 px-5 py-4 rounded-2xl border border-white/5 text-white focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 focus:bg-slate-800 transition-all placeholder:text-slate-500 outline-none group-hover:border-cyan-400/30"
                           placeholder="nama@email.com"
                           required
                           autofocus
                           autocomplete="username">
                </div>

                @error('email')
                    <p class="text-fuchsia-400 text-[10px] mt-1 font-black uppercase tracking-tighter ml-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="space-y-2">
                <label for="password" class="block text-xs font-black text-cyan-400 uppercase tracking-widest ml-1">
                    Password
                </label>

                <div class="relative group">
                    <input id="password"
                           type="password"
                           name="password"
                           class="w-full bg-slate-800/50 px-5 py-4 pr-14 rounded-2xl border border-white/5 text-white focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 focus:bg-slate-800 transition-all placeholder:text-slate-500 outline-none group-hover:border-cyan-400/30"
                           placeholder="••••••••"
                           required
                           autocomplete="current-password">

                    {{-- Toggle Password --}}
                    <button type="button"
                            onclick="togglePassword()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-cyan-400 transition">
                        👁️
                    </button>
                </div>

                @error('password')
                    <p class="text-fuchsia-400 text-[10px] mt-1 font-black uppercase tracking-tighter ml-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit"
                    id="loginBtn"
                    class="group w-full bg-cyan-600 hover:bg-cyan-500 text-white font-black py-4 rounded-2xl shadow-xl shadow-cyan-900/40 transition-all hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2 overflow-hidden relative">
                <span id="btnText" class="relative z-10 uppercase tracking-tighter">
                    Masuk Sekarang →
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </button>

            {{-- Extra Features --}}
            <div class="flex items-center justify-between pt-2">
                <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                    <div class="relative flex items-center">
                        <input id="remember_me"
                               type="checkbox"
                               class="peer appearance-none w-5 h-5 border-2 border-white/10 rounded bg-slate-800 checked:bg-cyan-500 checked:border-cyan-500 transition-all"
                               name="remember">

                        <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity left-[3px]"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="4">
                            <path d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>

                    <span class="ms-2 text-[11px] font-black text-slate-500 uppercase tracking-widest group-hover:text-slate-300 transition-colors">
                        Ingatkan Saya
                    </span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-[11px] font-black text-fuchsia-500 hover:text-fuchsia-400 uppercase tracking-widest transition-colors"
                       href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
        </form>

        {{-- Footer Note --}}
        <div class="mt-8 text-center">
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">
                Sistem Pembelajaran Interaktif • SDN Cibinong 2
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        password.type = password.type === 'password' ? 'text' : 'password';
    }

    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn = document.getElementById('loginBtn');
        const text = document.getElementById('btnText');

        btn.disabled = true;
        text.innerHTML = 'Memproses... ⏳';
    });
</script>
@endsection
