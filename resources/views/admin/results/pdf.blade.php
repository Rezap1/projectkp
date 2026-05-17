<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $selectedStudent ? 'Kartu Prestasi ' . $selectedStudent->name : 'Rekap Prestasi Bulanan' }}</title>
    <style>
        @page { margin: 24px; }
        * { box-sizing: border-box; }
        body {
            color: #111827;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 0;
        }
        .cover {
            background: #0f172a;
            border-radius: 18px;
            color: #fff;
            padding: 22px;
            width: 100%;
        }
        .brand-table, .stats-table, .hero-table { width: 100%; border-collapse: collapse; }
        .brand-logo { width: 82px; vertical-align: middle; }
        .brand-logo img {
            background: #fff;
            border-radius: 14px;
            height: 72px;
            object-fit: contain;
            padding: 6px;
            width: 72px;
        }
        .logo-fallback {
            background: #38bdf8;
            border: 4px solid #111827;
            border-radius: 18px;
            color: #111827;
            font-size: 9px;
            font-weight: bold;
            height: 72px;
            line-height: 1.15;
            padding-top: 10px;
            text-align: center;
            width: 72px;
        }
        .logo-fallback strong {
            display: block;
            font-size: 17px;
            margin-bottom: 4px;
        }
        .eyebrow {
            color: #a5f3fc;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1.4px;
            margin: 0 0 5px;
            text-transform: uppercase;
        }
        h1 { font-size: 25px; line-height: 1.15; margin: 0; }
        .subtitle { color: #dbeafe; font-size: 11px; font-weight: bold; margin: 8px 0 0; }
        .score-box {
            background: #164e63;
            border-radius: 14px;
            padding: 12px;
            text-align: center;
            width: 110px;
        }
        .score-box span, .stat span, .section-kicker, .student-card span {
            display: block;
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .score-box strong { color: #fff; display: block; font-size: 30px; margin-top: 4px; }
        .student-card {
            background: #ecfeff;
            border: 1px solid #67e8f9;
            border-radius: 16px;
            margin-top: 14px;
            padding: 14px;
        }
        .avatar {
            background: #06b6d4;
            border-radius: 14px;
            color: #0f172a;
            font-size: 30px;
            font-weight: bold;
            height: 64px;
            line-height: 64px;
            text-align: center;
            width: 64px;
        }
        .student-name { display: block; font-size: 22px; font-weight: bold; margin-top: 3px; }
        .student-meta { color: #475569; font-size: 10px; font-weight: bold; margin: 4px 0 0; }
        .badge {
            background: #fff;
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 8px;
            text-align: center;
        }
        .badge strong { display: block; font-size: 13px; margin-top: 3px; }
        .stats-table { margin-top: 14px; }
        .stat {
            background: #f8fafc;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            padding: 10px;
            width: 20%;
        }
        .stat strong { display: block; font-size: 21px; margin-top: 4px; }
        .section { margin-top: 18px; page-break-inside: avoid; }
        .section-title {
            border-bottom: 2px solid #0f172a;
            margin-bottom: 8px;
            padding-bottom: 6px;
        }
        .section-kicker { color: #0891b2; }
        .section-title h2 { display: inline-block; float: right; font-size: 15px; margin: -2px 0 0; }
        table.data { border-collapse: collapse; width: 100%; }
        .data th {
            background: #0f172a;
            color: #fff;
            font-size: 8px;
            padding: 7px;
            text-align: left;
            text-transform: uppercase;
        }
        .data td {
            border-bottom: 1px solid #e2e8f0;
            font-size: 9px;
            padding: 7px;
            vertical-align: middle;
        }
        .data tr:nth-child(even) td { background: #f8fafc; }
        .top td { background: #ecfeff !important; font-weight: bold; }
        .selected td { background: #fef9c3 !important; font-weight: bold; }
        .tier {
            border: 1px solid #0891b2;
            border-radius: 999px;
            color: #155e75;
            display: inline-block;
            font-size: 8px;
            font-weight: bold;
            padding: 3px 6px;
            text-transform: uppercase;
        }
        .note {
            background: #ecfeff;
            border: 1px solid #67e8f9;
            border-radius: 12px;
            color: #155e75;
            font-size: 11px;
            font-weight: bold;
            margin-top: 16px;
            padding: 11px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="cover">
        <table class="brand-table">
            <tr>
                <td class="brand-logo">
                    @if($logoSrc)
                        <img src="{{ $logoSrc }}" alt="Logo SD Negeri Cibinong 2">
                    @else
                        <div class="logo-fallback">
                            <strong>1954</strong>
                            SD NEGERI<br>CIBINONG 2
                        </div>
                    @endif
                </td>
                <td>
                    <p class="eyebrow">SDN Cibinong 2 | Quiz Arena</p>
                    <h1>{{ $selectedStudent ? 'Kartu Prestasi Siswa' : 'Rekap Prestasi Bulanan' }}</h1>
                    <p class="subtitle">
                        {{ $printPeriod }} | Guru: {{ auth()->user()->name }}
                        @if($selectedStudent)
                            | {{ $selectedStudent->name }} - Kelas {{ $selectedStudent->kelas }}
                        @endif
                    </p>
                </td>
                <td align="right" style="width: 120px;">
                    <div class="score-box">
                        <span>Rata-rata</span>
                        <strong>{{ $monthlySummary['avg'] }}</strong>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    @if($selectedStudent)
        <div class="student-card">
            <table class="hero-table">
                <tr>
                    <td style="width: 76px;"><div class="avatar">{{ strtoupper(substr($selectedStudent->name, 0, 1)) }}</div></td>
                    <td>
                        <span>Siswa Pilihan</span>
                        <strong class="student-name">{{ $selectedStudent->name }}</strong>
                        <p class="student-meta">{{ $selectedStudent->email }} | Kelas {{ $selectedStudent->kelas }}</p>
                    </td>
                    <td style="width: 260px;">
                        <table style="width: 100%; border-collapse: separate; border-spacing: 6px 0;">
                            <tr>
                                <td class="badge"><span>Rank</span><strong>#{{ $selectedStudentRank->position ?? '-' }}</strong></td>
                                <td class="badge"><span>Tier</span><strong>{{ $selectedStudentRank->tier['label'] ?? 'Belum Ada' }}</strong></td>
                                <td class="badge"><span>Total</span><strong>{{ $selectedStudentRank ? round($selectedStudentRank->total_skor) : 0 }}</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    @endif

    <table class="stats-table" style="border-collapse: separate; border-spacing: 7px 0;">
        <tr>
            <td class="stat"><span>Peserta</span><strong>{{ $monthlySummary['students'] }}</strong></td>
            <td class="stat"><span>Pengerjaan</span><strong>{{ $monthlySummary['total'] }}</strong></td>
            <td class="stat"><span>Lulus</span><strong>{{ $monthlySummary['passed'] }}</strong></td>
            <td class="stat"><span>Remedial</span><strong>{{ $monthlySummary['remedial'] }}</strong></td>
            <td class="stat"><span>Tertinggi</span><strong>{{ $monthlySummary['highest'] }}</strong></td>
        </tr>
    </table>

    <div class="section">
        <div class="section-title">
            <span class="section-kicker">Hall of Fame</span>
            <h2>{{ $selectedStudent ? 'Posisi Ranking Kelas' : 'Ranking dan Tier Siswa' }}</h2>
        </div>
        <table class="data">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Siswa</th>
                    <th>Kelas</th>
                    <th>Tier</th>
                    <th>Total</th>
                    <th>Rata</th>
                    <th>Kerja</th>
                    <th>Tertinggi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($monthlyRanking as $index => $rank)
                    <tr class="{{ $selectedStudent && $rank->user_id === $selectedStudent->id ? 'selected' : ($index < 3 ? 'top' : '') }}">
                        <td>#{{ $rank->position }}</td>
                        <td>{{ $rank->user->name ?? '-' }}</td>
                        <td>{{ $rank->user->kelas ?? '-' }}</td>
                        <td><span class="tier">{{ $rank->tier['label'] }}</span></td>
                        <td>{{ round($rank->total_skor) }}</td>
                        <td>{{ round($rank->rata_skor, 1) }}</td>
                        <td>{{ $rank->total_pengerjaan }}</td>
                        <td>{{ $rank->skor_tertinggi }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8">Belum ada data ranking bulan ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">
            <span class="section-kicker">Mapel</span>
            <h2>Performa Kategori Kuis</h2>
        </div>
        <table class="data">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Kelas</th>
                    <th>Pengerjaan</th>
                    <th>Rata-rata</th>
                    <th>Tertinggi</th>
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
                    <tr><td colspan="5">Belum ada data mapel bulan ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">
            <span class="section-kicker">Detail Nilai</span>
            <h2>Nilai Siswa Selama 1 Bulan</h2>
        </div>
        <table class="data">
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
                    <tr><td colspan="8">Belum ada nilai pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="note">
        Tetap semangat naik tier. Setiap kuis adalah langkah baru menuju rank berikutnya.
    </div>
</body>
</html>
