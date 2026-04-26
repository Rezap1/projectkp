<footer class="bg-slate-950 pt-20 pb-10 mt-20 relative overflow-hidden">

    {{-- Neon Top Border --}}
    <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-cyan-500 to-transparent"></div>

    {{-- Decorative Glow --}}
    <div class="absolute -top-24 -left-24 w-72 h-72 bg-fuchsia-600/15 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-500/10 rounded-full blur-[120px]"></div>

    <div class="max-w-7xl mx-auto px-8 relative z-10">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-16 mb-16">

            {{-- Kolom 1: Branding --}}
            <div class="space-y-6">
                <div>
                    <h3 class="text-3xl font-black tracking-tight uppercase italic">
                        <span class="bg-gradient-to-r from-cyan-400 to-fuchsia-400 bg-clip-text text-transparent">
                            Quiz Arena
                        </span>
                    </h3>
                    <p class="text-[10px] text-slate-500 font-black uppercase tracking-[0.35em] mt-1">
                        SDN CIBINONG 2
                    </p>
                </div>

                <div class="space-y-4">
                    <p class="text-slate-400 leading-relaxed font-medium text-sm">
                        Platform pembelajaran digital interaktif untuk membantu siswa belajar lebih seru,
                        kompetitif, dan menyenangkan melalui sistem kuis berbasis gamifikasi.
                    </p>

                    <div class="flex gap-3 items-start">
                        <span class="text-cyan-400 mt-0.5">📍</span>
                        <p class="text-slate-500 text-xs font-bold leading-snug uppercase tracking-tight">
                            Jl. Raya Patrol-Agrabinta, Pananggapan,<br>
                            Kec. Cibinong, Kabupaten Cianjur, Jawa Barat 43271
                        </p>
                    </div>
                </div>
            </div>

            {{-- Kolom 2 --}}
            <div class="grid grid-cols-2 gap-8">

                {{-- Navigasi --}}
                <div class="flex flex-col gap-4">
                    <h4 class="text-xs font-black text-cyan-400 uppercase tracking-[0.25em]">
                        Navigasi
                    </h4>

                    <a href="#" class="text-slate-300 hover:text-cyan-400 transition-all font-bold text-sm uppercase italic tracking-tight">
                        Dashboard
                    </a>

                    <a href="#" class="text-slate-300 hover:text-cyan-400 transition-all font-bold text-sm uppercase italic tracking-tight">
                        Daftar Kuis
                    </a>

                    <a href="#" class="text-slate-300 hover:text-cyan-400 transition-all font-bold text-sm uppercase italic tracking-tight">
                        Leaderboard
                    </a>
                </div>

                {{-- Developer --}}
                <div class="flex flex-col gap-4">
                    <h4 class="text-xs font-black text-fuchsia-400 uppercase tracking-[0.25em]">
                        Mitra & Dev
                    </h4>

                    <div class="space-y-2">
                        <p class="text-white font-black text-sm italic uppercase">
                            Universitas Suryakancana
                        </p>

                        <div class="flex gap-2 items-start">
                            <span class="text-fuchsia-500 text-[10px]">📍</span>
                            <p class="text-slate-500 text-[10px] font-bold uppercase leading-tight">
                                Jl. Pasir Gede Raya, Cianjur, Jawa Barat
                            </p>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <p class="text-white font-black text-sm italic">
                            Reza Puda Julianda
                        </p>
                        <p class="text-slate-500 text-[10px] font-black uppercase tracking-tight">
                            Informatika Developer
                        </p>
                        <p class="text-cyan-400 font-black text-xs">
                            085861261805
                        </p>
                    </div>
                </div>
            </div>

            {{-- Kolom 3 --}}
            <div class="bg-slate-900/70 backdrop-blur-xl p-8 rounded-[2rem] border border-cyan-500/10 relative overflow-hidden group shadow-xl">

                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/5 via-transparent to-fuchsia-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                <h4 class="text-sm font-black text-white uppercase tracking-widest mb-5 italic relative z-10">
                    Status Sistem
                </h4>

                <div class="flex flex-col gap-5 relative z-10">

                    <div>
                        <p class="text-[10px] text-fuchsia-400 font-black uppercase tracking-widest mb-1">
                            🔄 Sinkronisasi Aktif
                        </p>
                        <p class="text-white font-black italic text-lg uppercase tracking-tight">
                            Kerja Praktek 2026
                        </p>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="px-4 py-2 bg-cyan-600 text-white text-[10px] font-black rounded-xl shadow-[0_0_12px_rgba(8,145,178,0.4)] uppercase">
                            Version 2.0
                        </div>

                        <span class="text-[9px] text-slate-500 font-black uppercase tracking-widest">
                            Stable Core
                        </span>
                    </div>

                </div>
            </div>
        </div>

        {{-- Bottom Footer --}}
        <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">

            <p class="text-sm text-slate-500 font-bold uppercase tracking-tight text-center md:text-left">
                &copy; 2026
                <span class="text-slate-300">SDN CIBINONG 2</span>.
                Dikembangkan oleh Mahasiswa
                <span class="text-cyan-400">UNSUR</span>.
            </p>

            <div class="flex items-center gap-4">

                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.6)]"></div>
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest italic">
                        Server Online
                    </span>
                </div>

                <div class="hidden md:block h-4 w-[1px] bg-white/10"></div>

                <span class="text-[10px] font-black text-cyan-400 uppercase tracking-widest italic">
                    {{ now()->translatedFormat('F Y') }}
                </span>

            </div>
        </div>
    </div>
</footer>
