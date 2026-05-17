@extends('layout.master')

@section('konten')
<div class="min-h-screen bg-[#0f172a] px-6 pt-36 pb-16 text-slate-100">
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-black text-cyan-300 hover:text-cyan-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M15 19 8 12l7-7"/></svg>
                    Dashboard
                </a>
                <p class="mt-6 text-xs font-black uppercase tracking-[0.24em] text-cyan-300">Rekap Nilai</p>
                <h1 class="mt-2 text-4xl font-black tracking-tight text-white">Hasil Siswa</h1>
                <p class="mt-3 max-w-2xl text-sm font-semibold leading-6 text-slate-400">Pantau skor, status kelulusan, waktu pengerjaan, dan bersihkan data hasil bila diperlukan.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('results.pdf', request()->query()) }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-400 px-4 py-3 text-sm font-black text-slate-950 shadow-lg shadow-emerald-500/20 transition hover:bg-emerald-300">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14"/></svg>
                    Unduh PDF
                </a>
                <button onclick="window.print()" class="inline-flex items-center justify-center gap-2 rounded-lg border border-cyan-400/30 bg-cyan-400 px-4 py-3 text-sm font-black text-slate-950 shadow-lg shadow-cyan-500/20 transition hover:bg-cyan-300">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17h10v4H7v-4Zm0-8V3h10v6M5 17H4a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1"/></svg>
                    Cetak
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-lg border border-emerald-400/30 bg-emerald-500/10 px-5 py-4 text-sm font-bold text-emerald-200">{{ session('success') }}</div>
        @endif

        <section class="grid gap-4 md:grid-cols-4">
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Total Hasil</p>
                <p class="mt-3 text-4xl font-black text-white">{{ $summary['total'] }}</p>
            </div>
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Rata-rata</p>
                <p class="mt-3 text-4xl font-black text-cyan-300">{{ round($summary['avg']) }}</p>
            </div>
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Lulus</p>
                <p class="mt-3 text-4xl font-black text-emerald-300">{{ $summary['passed'] }}</p>
            </div>
            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-5">
                <p class="text-xs font-black uppercase tracking-widest text-slate-500">Remedial</p>
                <p class="mt-3 text-4xl font-black text-orange-300">{{ $summary['remedial'] }}</p>
            </div>
        </section>

        <form method="GET" class="rounded-lg border border-white/10 bg-slate-900/80 p-5 no-print">
            <div class="grid gap-4 xl:grid-cols-[1fr_210px_120px_180px_150px_150px_auto] xl:items-end">
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Cari Nama</label>
                    <input name="q" value="{{ request('q') }}" placeholder="Cari nama siswa..." class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400">
                </div>
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Siswa Cetak</label>
                    <select name="student_id" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                        <option value="">Semua siswa</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" @selected(request('student_id') == $student->id)>K{{ $student->kelas }} - {{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Kelas</label>
                    <select name="kelas" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                        <option value="">Semua</option>
                        @foreach([4, 5, 6] as $kelas)
                            <option value="{{ $kelas }}" @selected(request('kelas') == $kelas)>Kelas {{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Kategori</label>
                    <select name="category_id" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                        <option value="">Semua kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>K{{ $category->kelas }} - {{ $category->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                </div>
                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-slate-500">Bulan Cetak</label>
                    <input type="month" name="bulan" value="{{ request('bulan', now()->format('Y-m')) }}" class="w-full rounded-lg border border-white/10 bg-slate-950/60 px-4 py-3 text-sm font-bold text-white outline-none transition focus:border-cyan-400">
                </div>
                <div class="flex gap-2">
                    <button class="rounded-lg bg-cyan-400 px-5 py-3 text-sm font-black text-slate-950 transition hover:bg-cyan-300">Filter</button>
                    <a href="{{ route('results.index') }}" class="rounded-lg border border-white/10 bg-white/5 px-5 py-3 text-sm font-black text-slate-300 transition hover:text-white">Reset</a>
                </div>
            </div>
        </form>

        <section class="grid gap-6 lg:grid-cols-[0.85fr_1.15fr] no-print">
            <div class="rounded-lg border border-cyan-400/15 bg-slate-900/80 p-6 shadow-xl shadow-cyan-950/20">
                <p class="text-xs font-black uppercase tracking-[0.24em] text-cyan-300">Preview Cetak</p>
                <h2 class="mt-2 text-2xl font-black text-white">{{ $selectedStudent ? 'Kartu Prestasi ' . $selectedStudent->name : 'Rekap ' . $printPeriod }}</h2>
                <p class="mt-3 text-sm font-semibold leading-6 text-slate-400">
                    {{ $selectedStudent ? 'Laporan cetak akan fokus ke satu siswa: tier, ranking, ringkasan mapel, dan riwayat nilai 1 bulan.' : 'Pilih Siswa Cetak kalau ingin membuat rekap personal untuk satu siswa.' }}
                </p>
                @if($selectedStudent)
                    <div class="mt-5 rounded-lg border border-cyan-400/20 bg-cyan-400/10 p-4">
                        <div class="flex items-center gap-4">
                            <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-cyan-400 text-xl font-black text-slate-950">
                                {{ strtoupper(substr($selectedStudent->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-black text-white">{{ $selectedStudent->name }}</p>
                                <p class="mt-1 text-xs font-bold text-cyan-200">Kelas {{ $selectedStudent->kelas }} | Rank #{{ $selectedStudentRank->position ?? '-' }} | {{ $selectedStudentRank->tier['label'] ?? 'Belum ada tier' }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <div class="rounded-lg bg-white/[0.04] p-4">
                        <p class="text-xs font-bold uppercase text-slate-500">Peserta</p>
                        <p class="mt-2 text-3xl font-black text-white">{{ $monthlySummary['students'] }}</p>
                    </div>
                    <div class="rounded-lg bg-white/[0.04] p-4">
                        <p class="text-xs font-bold uppercase text-slate-500">Rata-rata</p>
                        <p class="mt-2 text-3xl font-black text-cyan-300">{{ $monthlySummary['avg'] }}</p>
                    </div>
                    <div class="rounded-lg bg-white/[0.04] p-4">
                        <p class="text-xs font-bold uppercase text-slate-500">Lulus</p>
                        <p class="mt-2 text-3xl font-black text-emerald-300">{{ $monthlySummary['passed'] }}</p>
                    </div>
                    <div class="rounded-lg bg-white/[0.04] p-4">
                        <p class="text-xs font-bold uppercase text-slate-500">Nilai Tertinggi</p>
                        <p class="mt-2 text-3xl font-black text-fuchsia-300">{{ $monthlySummary['highest'] }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-white/10 bg-slate-900/80 p-6">
                <div class="flex items-center justify-between border-b border-white/10 pb-4">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-fuchsia-300">Ranking Bulanan</p>
                        <h2 class="mt-2 text-xl font-black text-white">Top Siswa {{ $printPeriod }}</h2>
                    </div>
                </div>
                <div class="mt-5 grid gap-3 md:grid-cols-3">
                    @forelse($monthlyRanking->take(3) as $index => $rank)
                        <div class="rounded-lg border border-white/10 bg-white/[0.04] p-4">
                            <div class="flex items-center justify-between">
                                <span class="flex h-9 w-9 items-center justify-center rounded-md {{ $index === 0 ? 'bg-yellow-400 text-slate-950' : 'bg-cyan-400/10 text-cyan-300' }} text-sm font-black">#{{ $index + 1 }}</span>
                                <span class="text-xs font-black uppercase tracking-widest text-slate-500">{{ $rank->tier['label'] }}</span>
                            </div>
                            <p class="mt-4 font-black text-white">{{ $rank->user->name ?? '-' }}</p>
                            <p class="mt-1 text-xs font-bold text-slate-500">Kelas {{ $rank->user->kelas ?? '-' }}</p>
                            <p class="mt-4 text-3xl font-black text-cyan-300">{{ round($rank->total_skor) }}</p>
                        </div>
                    @empty
                        <p class="rounded-lg border border-dashed border-white/10 p-6 text-center font-bold text-slate-500 md:col-span-3">Belum ada ranking untuk bulan ini.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="print-report">
            <div class="print-cover">
                <div class="print-brand">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo SD Negeri Cibinong 2" class="print-logo">
                    <div>
                        <p class="print-eyebrow">SDN Cibinong 2 | Quiz Arena</p>
                        <h1>{{ $selectedStudent ? 'Kartu Prestasi Siswa' : 'Rekap Prestasi Bulanan' }}</h1>
                        <p class="print-subtitle">
                            {{ $printPeriod }} | Guru: {{ auth()->user()->name }}
                            @if($selectedStudent)
                                | {{ $selectedStudent->name }} - Kelas {{ $selectedStudent->kelas }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="print-score-card">
                    <span>Rata-rata</span>
                    <strong>{{ $monthlySummary['avg'] }}</strong>
                </div>
            </div>

            @if($selectedStudent)
                <div class="print-student-hero">
                    <div class="print-student-avatar">{{ strtoupper(substr($selectedStudent->name, 0, 1)) }}</div>
                    <div class="print-student-main">
                        <span>Siswa Pilihan</span>
                        <strong>{{ $selectedStudent->name }}</strong>
                        <p>{{ $selectedStudent->email }} | Kelas {{ $selectedStudent->kelas }}</p>
                    </div>
                    <div class="print-student-badges">
                        <div>
                            <span>Rank</span>
                            <strong>#{{ $selectedStudentRank->position ?? '-' }}</strong>
                        </div>
                        <div>
                            <span>Tier</span>
                            <strong>{{ $selectedStudentRank->tier['label'] ?? 'Belum Ada' }}</strong>
                        </div>
                        <div>
                            <span>Total Skor</span>
                            <strong>{{ $selectedStudentRank ? round($selectedStudentRank->total_skor) : 0 }}</strong>
                        </div>
                    </div>
                </div>
            @endif

            <div class="print-stats">
                <div><span>Peserta</span><strong>{{ $monthlySummary['students'] }}</strong></div>
                <div><span>Total Pengerjaan</span><strong>{{ $monthlySummary['total'] }}</strong></div>
                <div><span>Lulus</span><strong>{{ $monthlySummary['passed'] }}</strong></div>
                <div><span>Remedial</span><strong>{{ $monthlySummary['remedial'] }}</strong></div>
                <div><span>Nilai Tertinggi</span><strong>{{ $monthlySummary['highest'] }}</strong></div>
            </div>

            <div class="print-section print-avoid-break">
                <div class="print-section-title">
                    <span>Hall of Fame</span>
                    <h2>{{ $selectedStudent ? 'Posisi Ranking Kelas' : 'Ranking dan Tier Siswa' }}</h2>
                </div>
                <table class="print-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Tier</th>
                            <th>Total Skor</th>
                            <th>Rata-rata</th>
                            <th>Pengerjaan</th>
                            <th>Tertinggi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monthlyRanking as $index => $rank)
                            <tr class="{{ $selectedStudent && $rank->user_id === $selectedStudent->id ? 'print-selected-rank' : ($index < 3 ? 'print-top-rank' : '') }}">
                                <td><strong>#{{ $index + 1 }}</strong></td>
                                <td>{{ $rank->user->name ?? '-' }}</td>
                                <td>{{ $rank->user->kelas ?? '-' }}</td>
                                <td>
                                    <span class="print-tier" style="border-color: {{ $rank->tier['primary'] }}; color: {{ $rank->tier['secondary'] }}">
                                        {{ $rank->tier['label'] }}
                                    </span>
                                </td>
                                <td><strong>{{ round($rank->total_skor) }}</strong></td>
                                <td>{{ round($rank->rata_skor, 1) }}</td>
                                <td>{{ $rank->total_pengerjaan }}</td>
                                <td>{{ $rank->skor_tertinggi }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Belum ada data ranking bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="print-section print-avoid-break">
                <div class="print-section-title">
                    <span>Mapel</span>
                    <h2>Performa Kategori Kuis</h2>
                </div>
                <table class="print-table">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Kelas</th>
                            <th>Total Pengerjaan</th>
                            <th>Rata-rata</th>
                            <th>Nilai Tertinggi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categoryReport as $categoryStat)
                            <tr>
                                <td>{{ $categoryStat->category->nama_kategori ?? '-' }}</td>
                                <td>{{ $categoryStat->category->kelas ?? '-' }}</td>
                                <td>{{ $categoryStat->total_pengerjaan }}</td>
                                <td>{{ round($categoryStat->rata_skor, 1) }}</td>
                                <td>{{ $categoryStat->skor_tertinggi }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Belum ada data mapel bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="print-section">
                <div class="print-section-title">
                    <span>Detail Nilai</span>
                    <h2>Nilai Siswa Selama 1 Bulan</h2>
                </div>
                <table class="print-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Kategori</th>
                            <th>Benar</th>
                            <th>Salah</th>
                            <th>Skor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($monthlyResults as $result)
                            <tr>
                                <td>{{ $result->created_at->format('d M Y') }}</td>
                                <td>{{ $result->user->name ?? '-' }}</td>
                                <td>{{ $result->user->kelas ?? '-' }}</td>
                                <td>{{ $result->category->nama_kategori ?? '-' }}</td>
                                <td>{{ $result->benar }}</td>
                                <td>{{ $result->salah }}</td>
                                <td><strong>{{ $result->skor }}</strong></td>
                                <td>{{ $result->skor >= 75 ? 'Lulus' : 'Remedial' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Belum ada nilai pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="print-footer-note">
                Tetap semangat naik tier. Setiap kuis adalah langkah baru menuju rank berikutnya.
            </div>
        </section>

        <section class="rounded-lg border border-white/10 bg-slate-900/80">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left text-sm">
                    <thead class="bg-slate-950/60 text-xs uppercase tracking-widest text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Siswa</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4 text-center">Benar</th>
                            <th class="px-6 py-4 text-center">Salah</th>
                            <th class="px-6 py-4 text-center">Skor</th>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4 text-right no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($results as $result)
                            <tr class="hover:bg-white/[0.03]">
                                <td class="px-6 py-5">
                                    <p class="font-black text-white">{{ $result->user->name ?? '-' }}</p>
                                    <p class="mt-1 text-xs font-bold text-slate-500">{{ $result->user->email ?? '-' }} | Kelas {{ $result->user->kelas ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="font-bold text-slate-200">{{ $result->category->nama_kategori ?? '-' }}</p>
                                    <p class="mt-1 text-xs font-bold text-slate-500">Kelas {{ $result->category->kelas ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-5 text-center font-black text-emerald-300">{{ $result->benar }}</td>
                                <td class="px-6 py-5 text-center font-black text-orange-300">{{ $result->salah }}</td>
                                <td class="px-6 py-5 text-center">
                                    <span class="rounded-md px-3 py-1 text-xs font-black {{ $result->skor >= 75 ? 'bg-emerald-500/10 text-emerald-300' : 'bg-orange-500/10 text-orange-300' }}">{{ $result->skor }}</span>
                                </td>
                                <td class="px-6 py-5 text-sm font-bold text-slate-500">{{ $result->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-5 text-right no-print">
                                    <form method="POST" action="{{ route('results.destroy', $result) }}" onsubmit="return confirm('Hapus hasil siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-red-400/20 bg-red-500/10 p-3 text-red-300 transition hover:bg-red-500 hover:text-white" title="Hapus hasil">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0A48.108 48.108 0 0 0 16.5 5.5m-9 0a48.11 48.11 0 0 0-2.728.29m0 0A48.667 48.667 0 0 1 12 5.25c2.466 0 4.862.185 7.228.54"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center font-bold text-slate-500">Belum ada hasil sesuai filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-white/10 p-6 no-print">
                {{ $results->links() }}
            </div>
        </section>
    </div>
</div>

<style>
    .print-report {
        display: none;
    }

    @media print {
        @page {
            margin: 12mm;
            size: A4 portrait;
        }

        body * {
            visibility: hidden;
        }

        .print-report,
        .print-report * {
            visibility: visible;
        }

        .print-report {
            background: #ffffff !important;
            color: #111827 !important;
            display: block !important;
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }

        .print-cover {
            align-items: center;
            background: linear-gradient(135deg, #0f172a 0%, #155e75 54%, #86198f 100%) !important;
            border-radius: 18px;
            color: #ffffff !important;
            display: flex;
            justify-content: space-between;
            margin-bottom: 18px;
            padding: 24px;
        }

        .print-brand {
            align-items: center;
            display: flex;
            gap: 18px;
        }

        .print-logo {
            background: rgba(255,255,255,0.92) !important;
            border: 2px solid rgba(255,255,255,0.75);
            border-radius: 16px;
            height: 84px;
            object-fit: contain;
            padding: 7px;
            width: 84px;
        }

        .print-student-hero {
            align-items: center;
            background: linear-gradient(135deg, #ecfeff 0%, #f5f3ff 100%) !important;
            border: 1.5px solid #67e8f9;
            border-radius: 16px;
            display: grid;
            gap: 16px;
            grid-template-columns: 72px 1fr 1.25fr;
            margin-bottom: 16px;
            padding: 16px;
        }

        .print-student-avatar {
            align-items: center;
            background: #06b6d4 !important;
            border-radius: 16px;
            color: #0f172a !important;
            display: flex;
            font-size: 34px;
            font-weight: 900;
            height: 72px;
            justify-content: center;
            width: 72px;
        }

        .print-student-main span,
        .print-student-badges span {
            color: #64748b !important;
            display: block;
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .print-student-main strong {
            color: #0f172a !important;
            display: block;
            font-size: 22px;
            font-weight: 900;
            margin-top: 4px;
        }

        .print-student-main p {
            color: #475569 !important;
            font-size: 11px;
            font-weight: 800;
            margin: 4px 0 0;
        }

        .print-student-badges {
            display: grid;
            gap: 8px;
            grid-template-columns: 0.65fr 1.2fr 0.8fr;
        }

        .print-student-badges div {
            background: rgba(255,255,255,0.78) !important;
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 10px;
        }

        .print-student-badges strong {
            color: #0f172a !important;
            display: block;
            font-size: 15px;
            font-weight: 900;
            margin-top: 4px;
        }

        .print-eyebrow {
            color: #a5f3fc !important;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 0.18em;
            margin: 0 0 8px;
            text-transform: uppercase;
        }

        .print-cover h1 {
            color: #ffffff !important;
            font-size: 28px;
            font-weight: 900;
            letter-spacing: 0;
            margin: 0;
        }

        .print-subtitle {
            color: #dbeafe !important;
            font-size: 12px;
            font-weight: 800;
            margin: 8px 0 0;
        }

        .print-score-card {
            background: rgba(255,255,255,0.14) !important;
            border: 1px solid rgba(255,255,255,0.24);
            border-radius: 14px;
            min-width: 120px;
            padding: 14px 18px;
            text-align: center;
        }

        .print-score-card span,
        .print-stats span,
        .print-section-title span {
            display: block;
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .print-score-card strong {
            color: #ffffff !important;
            display: block;
            font-size: 34px;
            font-weight: 900;
            line-height: 1;
            margin-top: 5px;
        }

        .print-stats {
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(5, 1fr);
            margin-bottom: 18px;
        }

        .print-stats div {
            background: #f8fafc !important;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            padding: 12px;
        }

        .print-stats span {
            color: #64748b !important;
        }

        .print-stats strong {
            color: #0f172a !important;
            display: block;
            font-size: 23px;
            font-weight: 900;
            margin-top: 5px;
        }

        .print-section {
            margin-top: 18px;
        }

        .print-avoid-break {
            break-inside: avoid;
            page-break-inside: avoid;
        }

        .print-section-title {
            align-items: end;
            border-bottom: 2px solid #0f172a;
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding-bottom: 7px;
        }

        .print-section-title span {
            color: #0891b2 !important;
        }

        .print-section-title h2 {
            color: #0f172a !important;
            font-size: 16px;
            font-weight: 900;
            margin: 0;
        }

        .print-table {
            border-collapse: separate;
            border-spacing: 0;
            font-size: 10px;
            overflow: hidden;
            width: 100%;
        }

        .print-table th {
            background: #0f172a !important;
            color: #ffffff !important;
            font-size: 9px;
            font-weight: 900;
            padding: 8px;
            text-align: left;
            text-transform: uppercase;
        }

        .print-table td {
            border-bottom: 1px solid #e2e8f0;
            color: #111827 !important;
            padding: 8px;
            vertical-align: middle;
        }

        .print-table tr:nth-child(even) td {
            background: #f8fafc !important;
        }

        .print-top-rank td {
            background: #ecfeff !important;
            border-bottom-color: #67e8f9;
            font-weight: 800;
        }

        .print-selected-rank td {
            background: #fef9c3 !important;
            border-bottom: 1.5px solid #facc15;
            font-weight: 900;
        }

        .print-tier {
            border: 1.5px solid;
            border-radius: 999px;
            display: inline-block;
            font-size: 9px;
            font-weight: 900;
            padding: 3px 7px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .print-footer-note {
            background: #ecfeff !important;
            border: 1px solid #67e8f9;
            border-radius: 12px;
            color: #155e75 !important;
            font-size: 12px;
            font-weight: 900;
            margin-top: 18px;
            padding: 12px;
            text-align: center;
        }
    }
</style>
@endsection
