<footer class="bg-slate-900 pt-20 pb-10 mt-20 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-indigo-500 to-transparent"></div>
    <div class="absolute -top-24 -left-24 w-64 h-64 bg-indigo-600/20 rounded-full blur-[100px]"></div>

    <div class="max-w-7xl mx-auto px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16 mb-16">

            {{-- Kolom 1: SDN Cibinong 2 --}}
            <div class="space-y-6">
                <h3 class="text-2xl font-black text-white tracking-tighter italic">QUIZ<span class="text-indigo-500">SDN 2 CIBINONG</span></h3>
                <div class="space-y-3">
                    <p class="text-slate-400 leading-relaxed font-medium text-sm">
                        Inovasi pembelajaran digital untuk masa depan siswa SDN Cibinong 2 yang lebih cerah.
                    </p>
                    <div class="flex gap-2 items-start">
                        <span class="text-indigo-500 text-sm">📍</span>
                        <p class="text-slate-500 text-xs font-bold leading-snug">
                            Jl. Raya Patrol-Agrabinta, Pananggapan, Kec. Cibinong, <br>Kabupaten Cianjur, Jawa Barat 43271
                        </p>
                    </div>
                </div>
            </div>

            {{-- Kolom 2: Universitas & Developer --}}
            <div class="grid grid-cols-2 gap-8">
                <div class="flex flex-col gap-4">
                    <h4 class="text-xs font-black text-indigo-400 uppercase tracking-[0.2em]">Navigasi</h4>
                    <a href="#" class="text-slate-300 hover:text-white transition font-bold text-sm">Dashboard</a>
                    <a href="#" class="text-slate-300 hover:text-white transition font-bold text-sm">Daftar Kuis</a>
                    <a href="#" class="text-slate-300 hover:text-white transition font-bold text-sm">Leaderboard</a>
                </div>
                <div class="flex flex-col gap-4">
                    <h4 class="text-xs font-black text-indigo-400 uppercase tracking-[0.2em]">Mitra Akademik & Developer</h4>
                    <div class="space-y-2">
                        <p class="text-white font-bold text-sm leading-tight italic">Universitas Suryakencana</p>
                        <div class="flex gap-2 items-start">
                            <span class="text-indigo-500 text-[10px]">📍</span>
                            <p class="text-slate-500 text-[10px] font-bold">Jl. Pasir Gede Raya, Bojongherang, Kec. Cianjur, Kabupaten Cianjur, Jawa Barat 43216</p>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-white font-bold text-sm">Reza Puda Julianda</p>
                        <p class="text-slate-500 text-[10px] font-bold uppercase tracking-tighter">Mahasiswa Teknik Informatika</p>
                        <p class="text-white font-bold text-sm">085861261805</p>
                    </div>
                </div>
            </div>

            {{-- Kolom 3: Status Projek --}}
            <div class="bg-slate-800/50 p-8 rounded-[2rem] border border-white/5">
                <h4 class="text-sm font-black text-white uppercase tracking-widest mb-4 italic">Status Projek</h4>
                <div class="flex flex-col gap-4">
                    <div class="flex-1">
                        <p class="text-[10px] text-indigo-400 font-black uppercase tracking-widest mb-1">🔄 Reset Bulanan Aktif</p>
                        <p class="text-white font-black italic text-lg">Kerja Praktek 2026</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="px-3 py-1 bg-indigo-500 text-white text-[10px] font-black rounded-lg">VER 2.0</div>
                        <span class="text-[9px] text-slate-500 font-black uppercase tracking-widest">Stable Release</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-sm text-slate-500 font-medium">
                &copy; 2026 SDN CIBINONG 2. Dikembangkan oleh Mahasiswa UNSUR.
            </p>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Sistem Online</span>
                </div>
                <div class="hidden md:block h-4 w-px bg-slate-800"></div>
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ now()->translatedFormat('F Y') }}</span>
            </div>
        </div>
    </div>
</footer>
