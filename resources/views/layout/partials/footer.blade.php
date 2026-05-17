<footer class="relative mt-20 overflow-hidden border-t border-[#d8d0c2] bg-[#ddd6c8]">
    <div class="absolute left-0 top-0 h-1 w-full bg-[#cfe66a]"></div>

    <div class="mx-auto max-w-7xl px-6 py-14 sm:px-8">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-3">
            <div class="space-y-5">
                <div>
                    <h3 class="text-2xl font-black uppercase italic tracking-tight">
                        <span class="text-[#223f35]">
                            Quiz Arena
                        </span>
                    </h3>
                    <p class="mt-1 text-[10px] font-black uppercase tracking-[0.32em] text-slate-500">
                        SDN CIBINONG 2
                    </p>
                </div>

                <p class="max-w-sm text-sm font-medium leading-6 text-slate-600">
                    Platform kuis interaktif yang dibuat lebih ceria, mudah dipakai, dan mendukung
                    proses belajar siswa SD dengan suasana yang menyenangkan.
                </p>

                <p class="text-xs font-bold uppercase leading-5 tracking-tight text-slate-500">
                    Jl. Raya Patrol-Agrabinta, Pananggapan,<br>
                    Kec. Cibinong, Kabupaten Cianjur, Jawa Barat 43271
                </p>
            </div>

            <div class="grid grid-cols-2 gap-8">
                <div class="flex flex-col gap-4">
                    <h4 class="text-xs font-black uppercase tracking-[0.25em] text-[#223f35]">
                        Navigasi
                    </h4>

                    <a href="#" class="text-sm font-bold text-slate-600 transition hover:text-[#223f35]">
                        Dashboard
                    </a>

                    <a href="#" class="text-sm font-bold text-slate-600 transition hover:text-[#223f35]">
                        Daftar Kuis
                    </a>

                    <a href="#" class="text-sm font-bold text-slate-600 transition hover:text-[#223f35]">
                        Hasil Belajar
                    </a>
                </div>

                <div class="flex flex-col gap-4">
                    <h4 class="text-xs font-black uppercase tracking-[0.25em] text-[#223f35]">
                        Mitra & Dev
                    </h4>

                    <div class="space-y-2">
                        <p class="text-sm font-black uppercase text-slate-800">
                            Universitas Suryakancana
                        </p>
                        <p class="text-[10px] font-bold uppercase leading-4 text-slate-500">
                            Jl. Pasir Gede Raya, Cianjur, Jawa Barat
                        </p>
                    </div>

                    <div class="space-y-1">
                        <p class="text-sm font-black text-slate-800">
                            Reza Puda Julianda
                        </p>
                        <p class="text-[10px] font-black uppercase tracking-tight text-slate-500">
                            Informatika Developer
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-[#d8d0c2] bg-[#eee7da] p-7 shadow-lg shadow-slate-400/20">
                <h4 class="mb-5 text-sm font-black uppercase tracking-widest text-slate-800">
                    Status Sistem
                </h4>

                <div class="space-y-5">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-[#223f35]">
                            Sinkronisasi Aktif
                        </p>
                        <p class="mt-1 text-lg font-black uppercase tracking-tight text-slate-800">
                            Kerja Praktek 2026
                        </p>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <div class="rounded-xl bg-[#cfe66a] px-4 py-2 text-[10px] font-black uppercase text-[#223f35] shadow-md shadow-slate-400/20">
                            Version 2.0
                        </div>

                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-500">
                            Stable Core
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-5 border-t border-[#d8d0c2] pt-7 md:flex-row">
            <p class="text-center text-sm font-bold text-slate-500 md:text-left">
                &copy; 2026 <span class="text-slate-800">SDN CIBINONG 2</span>.
                Dikembangkan oleh Mahasiswa <span class="text-[#223f35]">UNSUR</span>.
            </p>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                    <span class="text-xs font-black uppercase tracking-widest text-slate-500">
                        Server Online
                    </span>
                </div>

                <div class="hidden h-4 w-px bg-[#d8d0c2] md:block"></div>

                <span class="text-[10px] font-black uppercase tracking-widest text-[#223f35]">
                    {{ now()->translatedFormat('F Y') }}
                </span>
            </div>
        </div>
    </div>
</footer>
