@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-[#0f172a] px-6 pt-36 pb-16 text-slate-100">
    <div class="mx-auto max-w-7xl space-y-8">
        
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.24em] text-cyan-300">SuperAdmin</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-white md:text-4xl">Daftar Pengguna</h1>
            </div>
            <a href="{{ route('superadmin.users.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-cyan-400 px-4 py-3 text-sm font-black text-slate-950 shadow-lg shadow-cyan-500/20 transition hover:bg-cyan-300">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M12 4v16m8-8H4"/></svg>
                Tambah Pengguna Baru
            </a>
        </div>

        @if(session('success'))
            <div class="rounded-lg border border-emerald-400/30 bg-emerald-500/10 px-5 py-4 text-sm font-bold text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-lg border border-red-400/30 bg-red-500/10 px-5 py-4 text-sm font-bold text-red-200">
                {{ session('error') }}
            </div>
        @endif

        <div class="rounded-lg border border-white/10 bg-slate-900/80 p-6">
            <form method="GET" action="{{ route('superadmin.users') }}" class="flex flex-col gap-4 md:flex-row md:items-end">
                <div class="flex-1">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-widest text-slate-400">Pencarian</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..." class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-3 text-sm font-semibold text-white placeholder-slate-500 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
                </div>
                <div class="w-full md:w-48">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-widest text-slate-400">Filter Role</label>
                    <select name="role" class="w-full rounded-lg border border-white/10 bg-slate-800 px-4 py-3 text-sm font-semibold text-white focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    </select>
                </div>
                <div class="w-full md:w-40">
                    <label class="mb-2 block text-xs font-bold uppercase tracking-widest text-slate-400">Kelas</label>
                    <select name="kelas" class="w-full rounded-lg border border-white/10 bg-slate-800 px-4 py-3 text-sm font-semibold text-white focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
                        <option value="">Semua</option>
                        @foreach([4, 5, 6] as $kelas)
                            <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>Kelas {{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="rounded-lg bg-cyan-500 px-6 py-3 text-sm font-black text-slate-950 transition hover:bg-cyan-400">
                    Filter
                </button>
            </form>
        </div>

        <div class="rounded-lg border border-white/10 bg-slate-900/80">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-950/60 text-xs uppercase tracking-widest text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Kelas</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($users as $user)
                            <tr class="hover:bg-white/[0.03]">
                                <td class="px-6 py-4 font-bold text-white">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-slate-400">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-md px-2 py-1 text-xs font-black {{ $user->role === 'admin' ? 'bg-fuchsia-500/10 text-fuchsia-300' : ($user->role === 'guru' ? 'bg-emerald-500/10 text-emerald-300' : 'bg-cyan-500/10 text-cyan-300') }}">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-400">{{ $user->kelas ?? '-' }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('superadmin.users.edit', $user) }}" class="rounded-md bg-white/5 px-3 py-1.5 text-xs font-bold text-cyan-300 transition hover:bg-cyan-500/10">Edit</a>
                                        <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini? Semua data terkait mungkin akan ikut terhapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md bg-white/5 px-3 py-1.5 text-xs font-bold text-red-400 transition hover:bg-red-500/10" {{ $user->id === auth()->id() ? 'disabled' : '' }}>Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-14 text-center font-bold text-slate-500">Tidak ada pengguna ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
                <div class="border-t border-white/10 p-6">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
