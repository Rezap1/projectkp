<nav class="fixed w-full z-50 top-0 px-3 py-4 sm:px-4 sm:py-6" x-data="{ mobileMenuOpen: false }" @keydown.escape.window="mobileMenuOpen = false">
    <div class="max-w-7xl mx-auto">

        {{-- Container Navbar dengan Glass + Glow --}}
        <div class="relative overflow-visible bg-[#223f35]/95 backdrop-blur-2xl border border-[#2f574a] shadow-xl shadow-slate-500/20 rounded-3xl sm:rounded-[2rem] px-4 py-3 sm:px-8 sm:py-4 flex justify-between items-center gap-4 transition-all duration-300">

            {{-- Friendly Accent Decoration --}}
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute inset-x-8 bottom-0 h-1 rounded-full bg-[#cfe66a]"></div>
            </div>

            {{-- Logo Section --}}
            <a href="/" class="relative z-10 flex min-w-0 items-center gap-3 group">

                {{-- Logo Icon --}}
                <div class="shrink-0 bg-[#cfe66a] p-2.5 sm:p-3 rounded-2xl group-hover:rotate-6 group-hover:scale-105 transition-all duration-300 shadow-lg shadow-black/10">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-[#223f35] sm:h-6 sm:w-6"
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
                <div class="flex min-w-0 flex-col leading-tight">
                    <span class="truncate text-base font-black text-[#f6f1e7] tracking-tight italic uppercase sm:text-xl">
                        Quiz Arena
                    </span>
                    <span class="truncate text-[9px] font-bold uppercase tracking-[0.18em] text-[#b9c8c1] sm:text-[10px] sm:tracking-[0.25em]">
                        SDN Cibinong 2
                    </span>
                </div>
            </a>

            @auth
                @if(Auth::user()->role === 'guru')
                    <div class="relative z-10 hidden items-center gap-2 lg:flex">
                        <a href="{{ route('admin.dashboard') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Dashboard</a>
                        <a href="{{ route('questions.index') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('questions.*') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Kelola Soal</a>
                        <a href="{{ route('categories.index') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('categories.*') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Kelola Mapel</a>
                        <a href="{{ route('results.index') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('results.*') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Lihat Hasil</a>
                    </div>
                @elseif(Auth::user()->role === 'admin')
                    <div class="relative z-10 hidden items-center gap-2 lg:flex">
                        <a href="{{ route('superadmin.dashboard') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Dashboard</a>
                        <a href="{{ route('superadmin.users') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('superadmin.users') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Pengguna</a>
                        <a href="{{ route('superadmin.classes') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('superadmin.classes') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Kelas</a>
                        <a href="{{ route('superadmin.results') }}" class="rounded-xl px-4 py-2 text-xs font-black uppercase tracking-widest transition {{ request()->routeIs('superadmin.results') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Semua Hasil</a>
                    </div>
                @endif
            @endauth

            {{-- User & Action Section --}}
            <div class="relative z-10 flex items-center gap-3 lg:gap-6">
                @auth

                    {{-- Player Status --}}
                    <div class="hidden md:flex items-center gap-4 bg-[#2b4d42] border border-[#3b6759] rounded-2xl px-5 py-3">

                        {{-- Avatar --}}
                        <div class="w-10 h-10 rounded-xl bg-[#cfe66a] flex items-center justify-center font-black text-[#223f35] shadow-lg shadow-black/10">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        {{-- Info --}}
                        <div class="flex flex-col items-start leading-tight">
                            <span class="text-[10px] font-black uppercase tracking-widest text-[#cfe66a]">
                                {{ Auth::user()->role === 'admin' ? 'SuperAdmin' : (Auth::user()->role === 'guru' ? 'Guru Online' : 'Player Online') }}
                            </span>
                            <span class="text-sm font-bold text-[#f6f1e7] uppercase tracking-tight">
                                {{ Auth::user()->name }}
                            </span>
                        </div>
                    </div>

                    {{-- Tombol Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="hidden lg:block">
                        @csrf
                        <button type="submit"
                                class="group flex items-center gap-3 bg-rose-50 hover:bg-rose-500 text-rose-500 hover:text-white px-6 py-3 rounded-2xl font-black transition-all duration-300 border border-rose-100 uppercase text-xs tracking-widest shadow-lg shadow-rose-100/70 active:scale-95">

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

                    {{-- Tombol Menu Mobile --}}
                    <button type="button"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-[#3b6759] bg-[#2b4d42] text-[#cfe66a] transition hover:bg-[#355f52] active:scale-95 lg:hidden"
                            aria-label="Buka menu navigasi"
                            :aria-expanded="mobileMenuOpen.toString()"
                            @click.stop="mobileMenuOpen = !mobileMenuOpen">
                        <svg x-show="!mobileMenuOpen"
                             x-cloak
                             xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen"
                             x-cloak
                             xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endauth
            </div>

            @auth
                {{-- Dropdown Mobile --}}
                <div x-show="mobileMenuOpen"
                     x-cloak
                     x-transition.origin.top.right
                     @click.outside="mobileMenuOpen = false"
                     class="absolute left-3 right-3 top-[calc(100%+0.75rem)] z-50 rounded-3xl border border-[#2f574a] bg-[#223f35]/98 p-4 shadow-2xl shadow-slate-500/40 backdrop-blur-2xl lg:hidden">
                    <div class="mb-4 flex items-center gap-3 rounded-2xl border border-[#3b6759] bg-[#2b4d42] px-4 py-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#cfe66a] font-black text-[#223f35] shadow-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 leading-tight">
                            <p class="text-[10px] font-black uppercase tracking-widest text-[#cfe66a]">
                                {{ Auth::user()->role === 'admin' ? 'SuperAdmin' : (Auth::user()->role === 'guru' ? 'Guru Online' : 'Player Online') }}
                            </p>
                            <p class="truncate text-sm font-bold uppercase tracking-tight text-[#f6f1e7]">
                                {{ Auth::user()->name }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        @if(Auth::user()->role === 'guru')
                            <a href="{{ route('admin.dashboard') }}" class="rounded-2xl px-4 py-3 text-sm font-black uppercase tracking-widest transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Dashboard</a>
                            <a href="{{ route('questions.index') }}" class="rounded-2xl px-4 py-3 text-sm font-black uppercase tracking-widest transition {{ request()->routeIs('questions.*') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Kelola Soal</a>
                            <a href="{{ route('categories.index') }}" class="rounded-2xl px-4 py-3 text-sm font-black uppercase tracking-widest transition {{ request()->routeIs('categories.*') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Kelola Mapel</a>
                            <a href="{{ route('results.index') }}" class="rounded-2xl px-4 py-3 text-sm font-black uppercase tracking-widest transition {{ request()->routeIs('results.*') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Lihat Hasil</a>
                        @elseif(Auth::user()->role === 'admin')
                            <a href="{{ route('superadmin.dashboard') }}" class="rounded-2xl px-4 py-3 text-sm font-black uppercase tracking-widest transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Dashboard</a>
                            <a href="{{ route('superadmin.users') }}" class="rounded-2xl px-4 py-3 text-sm font-black uppercase tracking-widest transition {{ request()->routeIs('superadmin.users') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Pengguna</a>
                            <a href="{{ route('superadmin.classes') }}" class="rounded-2xl px-4 py-3 text-sm font-black uppercase tracking-widest transition {{ request()->routeIs('superadmin.classes') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Kelas</a>
                            <a href="{{ route('superadmin.results') }}" class="rounded-2xl px-4 py-3 text-sm font-black uppercase tracking-widest transition {{ request()->routeIs('superadmin.results') ? 'bg-[#cfe66a] text-[#223f35] shadow-md shadow-black/10' : 'text-[#d8e1dc] hover:bg-white/10 hover:text-white' }}">Semua Hasil</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="pt-2">
                            @csrf
                            <button type="submit"
                                    class="flex w-full items-center justify-between rounded-2xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm font-black uppercase tracking-widest text-rose-500 transition hover:bg-rose-500 hover:text-white active:scale-[0.99]">
                                <span>Keluar</span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-4 w-4"
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
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
