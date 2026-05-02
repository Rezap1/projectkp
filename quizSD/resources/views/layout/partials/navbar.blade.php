<nav class="fixed w-full z-50 top-0 px-4 py-6">
    <div class="max-w-7xl mx-auto">

        {{-- Container Navbar dengan Glass + Glow --}}
        <div class="relative overflow-hidden bg-slate-900/85 backdrop-blur-2xl border border-cyan-500/10 shadow-2xl shadow-cyan-900/20 rounded-[2rem] px-8 py-4 flex justify-between items-center transition-all duration-300">

            {{-- Glow Decoration --}}
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute -top-10 -left-10 w-32 h-32 bg-cyan-500/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-10 right-10 w-32 h-32 bg-fuchsia-500/10 rounded-full blur-3xl"></div>
            </div>

            {{-- Logo Section --}}
            <a href="/" class="relative z-10 flex items-center gap-3 group">

                {{-- Logo Icon --}}
                <div class="bg-cyan-500 p-3 rounded-2xl group-hover:rotate-12 group-hover:scale-110 transition-all duration-300 shadow-[0_0_20px_rgba(6,182,212,0.5)]">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6 text-slate-900"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2.5"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>

                {{-- Branding --}}
                <div class="flex flex-col leading-tight">
                    <span class="text-xl font-black bg-gradient-to-r from-cyan-400 to-fuchsia-400 bg-clip-text text-transparent tracking-tight italic uppercase">
                        Quiz Arena
                    </span>
                    <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-slate-400">
                        SDN Cibinong 2
                    </span>
                </div>
            </a>

            @auth
                @if(Auth::user()->role === 'guru')
                    <div class="relative z-10 hidden items-center gap-2 lg:flex">
                        <a href="{{ route('admin.dashboard') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('admin.dashboard') ? 'bg-cyan-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Dashboard</a>
                        <a href="{{ route('questions.index') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('questions.*') ? 'bg-cyan-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Soal</a>
                        <a href="{{ route('categories.index') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('categories.*') ? 'bg-cyan-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Kategori</a>
                        <a href="{{ route('results.index') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('results.*') ? 'bg-cyan-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Hasil</a>
                    </div>
                @elseif(Auth::user()->role === 'admin')
                    <div class="relative z-10 hidden items-center gap-2 lg:flex">
                        <a href="{{ route('superadmin.dashboard') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-cyan-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Dashboard</a>
                        <a href="{{ route('superadmin.users') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('superadmin.users') ? 'bg-cyan-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Pengguna</a>
                        <a href="{{ route('superadmin.classes') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('superadmin.classes') ? 'bg-cyan-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Kelas</a>
                        <a href="{{ route('superadmin.results') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('superadmin.results') ? 'bg-cyan-400 text-slate-950' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">Semua Hasil</a>
                    </div>
                @endif
            @endauth

            {{-- User & Action Section --}}
            <div class="relative z-10 flex items-center gap-6">
                @auth

                    {{-- Player Status --}}
                    <div class="hidden md:flex items-center gap-4 bg-slate-800/70 border border-white/5 rounded-2xl px-5 py-3">

                        {{-- Avatar --}}
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-fuchsia-500 flex items-center justify-center font-black text-white shadow-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        {{-- Info --}}
                        <div class="flex flex-col items-start leading-tight">
                            <span class="text-[10px] font-black uppercase tracking-widest text-cyan-400 animate-pulse">
                                {{ Auth::user()->role === 'admin' ? 'SuperAdmin' : (Auth::user()->role === 'guru' ? 'Guru Online' : 'Player Online') }}
                            </span>
                            <span class="text-sm font-bold text-white uppercase tracking-tight">
                                {{ Auth::user()->name }}
                            </span>
                        </div>
                    </div>

                    {{-- Tombol Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="group flex items-center gap-3 bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white px-6 py-3 rounded-2xl font-black transition-all duration-300 border border-red-500/20 uppercase text-xs tracking-widest shadow-lg hover:shadow-red-500/20 active:scale-95">

                            <span>Keluar</span>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-4 w-4 group-hover:translate-x-1 transition-transform"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2.5"
                                      d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>
