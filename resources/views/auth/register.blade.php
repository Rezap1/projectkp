@extends('layout.master')

@section('konten')
<div class="min-h-screen flex flex-col justify-center items-center pt-32 pb-12 px-6 bg-slate-50">
    <div class="w-full max-w-md bg-white/80 backdrop-blur-xl p-10 rounded-[2.5rem] shadow-2xl shadow-indigo-100 border border-white">

        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Daftar Akun</h2>
            <p class="text-slate-500 font-medium mt-2">Gabung di Quiz SDN 2 Cibinong</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full px-5 py-4 rounded-2xl border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all"
                    placeholder="Masukkan nama..." required autofocus>
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Email Sekolah</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-5 py-4 rounded-2xl border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all"
                    placeholder="nama@sekolah.id" required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Mendaftar Sebagai</label>
                <select name="role" class="w-full px-5 py-4 rounded-2xl border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all appearance-none bg-white">
                    <option value="siswa">Siswa (Ingin Belajar)</option>
                    <option value="guru">Guru (Ingin Mengajar)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                <input type="password" name="password"
                    class="w-full px-5 py-4 rounded-2xl border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all"
                    placeholder="••••••••" required>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full px-5 py-4 rounded-2xl border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all"
                    placeholder="••••••••" required>
            </div>

            <div class="mt-4">
                <label for="kelas" class="block font-medium text-sm text-gray-700">Pilih Kelas</label>
                    <select name="kelas" id="kelas" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500" required>
                        <option value="">-- Pilih Kelas --</option>
                        <option value="4">Kelas 4</option>
                        <option value="5">Kelas 5</option>
                        <option value="6">Kelas 6</option>
                    </select>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-indigo-200 transition-all hover:-translate-y-1 active:scale-95">
                Buat Akun Sekarang
            </button>
        </form>

        <p class="mt-8 text-center text-sm font-bold text-slate-400">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection
