@extends('layout.master')

@section('konten')
<div class="min-h-screen flex flex-col justify-center items-center pt-32 pb-12 px-6 bg-slate-950 relative overflow-hidden">

    {{-- Ambient Background --}}
    <div class="absolute -top-24 -right-24 w-[500px] h-[500px] bg-cyan-600/10 rounded-full blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-10 -left-24 w-[500px] h-[500px] bg-fuchsia-600/10 rounded-full blur-[120px] animate-pulse"></div>

    {{-- Register Card --}}
    <div class="w-full max-w-md bg-slate-900/70 backdrop-blur-2xl p-10 rounded-[2.5rem] shadow-2xl border border-white/10 relative z-10">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-fuchsia-500/10 rounded-2xl mb-4 border border-fuchsia-500/20 shadow-inner shadow-fuchsia-500/20">
                <span class="text-4xl">🎓</span>
            </div>

            <div class="inline-block px-4 py-1 mb-4 bg-cyan-500/10 border border-cyan-500/20 rounded-full text-[10px] font-black text-cyan-400 uppercase tracking-widest">
                Registrasi Akun Baru
            </div>

            <h2 class="text-3xl font-black text-white tracking-tight uppercase italic">
                Daftar Akun
            </h2>

            <p class="text-slate-400 font-medium mt-2">
                Gabung di petualangan belajar Quiz SDN 2 Cibinong 🚀
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5" id="registerForm">
            @csrf

            {{-- Nama --}}
            <div>
                <label class="block text-xs font-black text-cyan-400 uppercase tracking-widest mb-2">
                    Nama Lengkap
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full px-5 py-4 rounded-2xl bg-slate-800/50 border border-white/10 text-white placeholder:text-slate-500 focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all outline-none"
                    placeholder="Masukkan nama..." required autofocus>
                @error('name')
                    <p class="text-fuchsia-400 text-[10px] mt-1 font-black uppercase">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-xs font-black text-cyan-400 uppercase tracking-widest mb-2">
                    Email Sekolah
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-5 py-4 rounded-2xl bg-slate-800/50 border border-white/10 text-white placeholder:text-slate-500 focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all outline-none"
                    placeholder="nama@sekolah.id" required>
                @error('email')
                    <p class="text-fuchsia-400 text-[10px] mt-1 font-black uppercase">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-xs font-black text-cyan-400 uppercase tracking-widest mb-2">
                    Mendaftar Sebagai
                </label>
                <select name="role"
                    class="w-full px-5 py-4 rounded-2xl bg-slate-800/50 border border-white/10 text-white focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all outline-none appearance-none">
                    <option value="siswa" class="text-black">Siswa (Ingin Belajar)</option>
                    <option value="guru" class="text-black">Guru (Ingin Mengajar)</option>
                </select>
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-xs font-black text-cyan-400 uppercase tracking-widest mb-2">
                    Password
                </label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="w-full px-5 py-4 pr-14 rounded-2xl bg-slate-800/50 border border-white/10 text-white placeholder:text-slate-500 focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all outline-none"
                        placeholder="••••••••" required>
                    <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-cyan-400">
                        👁️
                    </button>
                </div>
                @error('password')
                    <p class="text-fuchsia-400 text-[10px] mt-1 font-black uppercase">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label class="block text-xs font-black text-cyan-400 uppercase tracking-widest mb-2">
                    Konfirmasi Password
                </label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-5 py-4 pr-14 rounded-2xl bg-slate-800/50 border border-white/10 text-white placeholder:text-slate-500 focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all outline-none"
                        placeholder="••••••••" required>
                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-cyan-400">
                        👁️
                    </button>
                </div>
            </div>

            {{-- Kelas --}}
            <div>
                <label for="kelas" class="block text-xs font-black text-cyan-400 uppercase tracking-widest mb-2">
                    Pilih Kelas
                </label>
                <select name="kelas" id="kelas"
                    class="w-full px-5 py-4 rounded-2xl bg-slate-800/50 border border-white/10 text-white focus:ring-4 focus:ring-cyan-500/20 focus:border-cyan-500 transition-all outline-none appearance-none"
                    required>
                    <option value="" class="text-black">-- Pilih Kelas --</option>
                    <option value="4" class="text-black">Kelas 4</option>
                    <option value="5" class="text-black">Kelas 5</option>
                    <option value="6" class="text-black">Kelas 6</option>
                </select>
            </div>

            {{-- Submit --}}
            <button type="submit" id="registerBtn"
                class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-black py-4 rounded-2xl shadow-xl shadow-cyan-900/40 transition-all hover:-translate-y-1 active:scale-95">
                <span id="registerBtnText">Buat Akun Sekarang 🚀</span>
            </button>
        </form>

        {{-- Footer --}}
        <p class="mt-8 text-center text-sm font-bold text-slate-400">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-cyan-400 hover:underline">
                Masuk di sini
            </a>
        </p>

        <p class="mt-4 text-center text-[10px] text-slate-500 font-bold uppercase tracking-widest">
            Platform Pembelajaran Interaktif SDN Cibinong 2
        </p>
    </div>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    document.getElementById('registerForm').addEventListener('submit', function () {
        const btn = document.getElementById('registerBtn');
        const text = document.getElementById('registerBtnText');

        btn.disabled = true;
        text.innerHTML = 'Memproses... ⏳';
    });
</script>
@endsection
