@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-[#0f172a] px-6 pt-36 pb-16 text-slate-100">
    <div class="mx-auto max-w-3xl space-y-8">
        
        <div>
            <a href="{{ route('superadmin.users') }}" class="inline-flex items-center gap-2 text-sm font-bold text-cyan-400 hover:text-cyan-300">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Pengguna
            </a>
            <h1 class="mt-4 text-3xl font-black tracking-tight text-white">Tambah Pengguna Baru</h1>
            <p class="mt-2 text-sm font-semibold text-slate-400">Daftarkan akun untuk Guru atau Siswa baru ke dalam sistem.</p>
        </div>

        <div class="rounded-[2rem] border border-white/10 bg-slate-900/80 p-8 shadow-2xl">
            <form action="{{ route('superadmin.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="name" class="block text-xs font-black uppercase tracking-widest text-slate-400">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-semibold text-white focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400"
                           placeholder="Misal: Budi Santoso">
                    @error('name') <p class="text-xs font-bold text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="email" class="block text-xs font-black uppercase tracking-widest text-slate-400">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-semibold text-white focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400"
                           placeholder="budi@sekolah.com">
                    @error('email') <p class="text-xs font-bold text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="password" class="block text-xs font-black uppercase tracking-widest text-slate-400">Password</label>
                    <input type="text" id="password" name="password" required
                           class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-semibold text-white focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400"
                           placeholder="Masukkan password awal (min. 8 karakter)">
                    @error('password') <p class="text-xs font-bold text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-2">
                        <label for="role" class="block text-xs font-black uppercase tracking-widest text-slate-400">Role Pengguna</label>
                        <select id="role" name="role" required onchange="toggleKelas(this.value)"
                                class="w-full rounded-xl border border-white/10 bg-slate-800 px-4 py-3 text-sm font-semibold text-white focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
                            <option value="">-- Pilih Role --</option>
                            <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role') <p class="text-xs font-bold text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2" id="kelasContainer" style="{{ old('role') == 'siswa' ? 'display:block;' : 'display:none;' }}">
                        <label for="kelas" class="block text-xs font-black uppercase tracking-widest text-slate-400">Kelas (Khusus Siswa)</label>
                        <select id="kelas" name="kelas"
                                class="w-full rounded-xl border border-white/10 bg-slate-800 px-4 py-3 text-sm font-semibold text-white focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
                            <option value="">-- Pilih Kelas --</option>
                            <option value="4" {{ old('kelas') == '4' ? 'selected' : '' }}>Kelas 4</option>
                            <option value="5" {{ old('kelas') == '5' ? 'selected' : '' }}>Kelas 5</option>
                            <option value="6" {{ old('kelas') == '6' ? 'selected' : '' }}>Kelas 6</option>
                        </select>
                        @error('kelas') <p class="text-xs font-bold text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-white/10">
                    <button type="submit" class="w-full rounded-xl bg-cyan-500 px-6 py-4 text-sm font-black uppercase tracking-widest text-slate-950 transition hover:bg-cyan-400">
                        Simpan Pengguna Baru
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    function toggleKelas(role) {
        const kelasContainer = document.getElementById('kelasContainer');
        const kelasSelect = document.getElementById('kelas');
        
        if (role === 'siswa') {
            kelasContainer.style.display = 'block';
            kelasSelect.required = true;
        } else {
            kelasContainer.style.display = 'none';
            kelasSelect.required = false;
            kelasSelect.value = '';
        }
    }
</script>
@endsection
