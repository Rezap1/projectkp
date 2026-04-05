<nav class="fixed w-full z-50 top-0 px-4 py-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-slate-900/90 backdrop-blur-xl border border-white/10 shadow-2xl shadow-indigo-900/20 rounded-[2rem] px-8 py-4 flex justify-between items-center transition-all duration-300">

            <a href="/" class="flex items-center gap-2 group">
                <div class="bg-indigo-500 p-2 rounded-xl group-hover:rotate-12 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="text-xl font-black bg-gradient-to-r from-indigo-400 to-blue-400 bg-clip-text text-transparent tracking-tighter">
                    QUIZ<span class="text-white">SDN CIBINONG 2</span>
                </span>
            </a>

            <div class="flex items-center gap-6">
                @auth
                    <div class="hidden md:flex flex-col items-end mr-2 text-right">
                        <span class="text-[10px] font-black uppercase tracking-widest text-indigo-400">User</span>
                        <span class="text-sm font-bold text-white">{{ Auth::user()->name }}</span>
                    </div>

                    <div class="h-8 w-[1px] bg-white/10 mx-2 hidden md:block"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="group flex items-center gap-2 bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white px-5 py-2.5 rounded-2xl font-bold transition-all duration-300 border border-red-500/20">
                            <span class="text-sm">Keluar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>
