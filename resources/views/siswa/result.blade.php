@extends('layout.master')

@section('konten')
<div class="min-h-screen px-6 py-20 bg-[#0f172a] text-slate-200 relative overflow-hidden">

    {{-- Background Glow --}}
    <div class="absolute top-0 left-0 w-96 h-96 bg-cyan-500/10 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-fuchsia-500/10 blur-[120px] rounded-full"></div>

    <div class="max-w-4xl mx-auto text-center relative z-10">

        <div class="bg-slate-900/80 backdrop-blur-xl rounded-[3rem] shadow-2xl p-10 mb-8 border border-cyan-500/20">

            {{-- Header --}}
            <div class="mb-8">
                <div class="inline-flex items-center gap-2 bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest mb-5">
                    Mission Complete
                </div>

                <h1 class="text-4xl font-black text-white mb-3 uppercase italic">
                    Victory! 🎉
                </h1>

                <p class="text-slate-400">
                    Berikut hasil pertarunganmu pada arena
                    <span class="text-cyan-400 font-bold">{{ $category->nama_kategori }}</span>
                </p>
            </div>

            {{-- Main Result --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

                {{-- Chart --}}
                <div class="relative flex justify-center">
                    <canvas id="resultChart" width="250" height="250"></canvas>

                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-5xl font-black text-cyan-400">
                            {{ round($score) }}
                        </span>
                        <span class="text-xs font-bold text-slate-500 uppercase">
                            Final Score
                        </span>
                    </div>
                </div>

                {{-- Statistik --}}
                <div class="space-y-4">

                    <div class="bg-emerald-500/10 p-4 rounded-2xl flex justify-between items-center border border-emerald-500/20">
                        <span class="font-bold text-emerald-300">✅ Jawaban Benar</span>
                        <span class="text-2xl font-black text-white">{{ $correctAnswers }}</span>
                    </div>

                    <div class="bg-red-500/10 p-4 rounded-2xl flex justify-between items-center border border-red-500/20">
                        <span class="font-bold text-red-300">❌ Jawaban Salah</span>
                        <span class="text-2xl font-black text-white">{{ $wrongAnswers }}</span>
                    </div>

                    <div class="bg-cyan-500/10 p-4 rounded-2xl flex justify-between items-center border border-cyan-500/20">
                        <span class="font-bold text-cyan-300">📝 Total Soal</span>
                        <span class="text-2xl font-black text-white">{{ $totalQuestions }}</span>
                    </div>

                    {{-- Rank Badge --}}
                    <div class="bg-gradient-to-r from-fuchsia-500/10 to-cyan-500/10 p-5 rounded-2xl border border-fuchsia-500/20">
                        <p class="text-xs font-black text-fuchsia-400 uppercase tracking-widest mb-2">
                            Performance Rank
                        </p>

                        <p class="text-2xl font-black text-white uppercase italic">
                            @if($score >= 90)
                                S-Tier Champion 🏆
                            @elseif($score >= 80)
                                Elite Warrior ⚔️
                            @elseif($score >= 70)
                                Rising Fighter 🔥
                            @elseif($score >= 60)
                                Brave Learner 📚
                            @else
                                Rookie Explorer 🌱
                            @endif
                        </p>
                    </div>

                </div>
            </div>

            {{-- Motivasi --}}
            <div class="mt-12 p-6 bg-slate-800/80 rounded-3xl border border-white/10">
                <p class="text-lg font-bold text-white">
                    @if($score >= 80)
                        Luar biasa! Kamu menaklukkan arena dengan sangat hebat! 🌟
                    @elseif($score >= 60)
                        Kerja bagus! Sedikit lagi menuju rank tertinggi! 💪
                    @else
                        Jangan menyerah! Semua champion pernah belajar dari kegagalan 📚
                    @endif
                </p>
            </div>

            {{-- Button --}}
            <div class="mt-10 flex flex-col md:flex-row gap-4">
                <a href="{{ route('siswa.dashboard') }}"
                   class="flex-1 bg-slate-800 text-white font-black py-4 rounded-2xl hover:bg-slate-700 transition shadow-lg uppercase tracking-wide">
                    Kembali ke Arena
                </a>

                <a href="{{ route('kuis.show', $category->id) }}"
                   class="flex-1 bg-gradient-to-r from-cyan-500 to-fuchsia-500 text-white font-black py-4 rounded-2xl hover:scale-105 transition shadow-lg shadow-cyan-500/20 uppercase tracking-wide">
                    Tantang Lagi
                </a>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('resultChart').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Benar', 'Salah'],
            datasets: [{
                data: [{{ $correctAnswers }}, {{ $wrongAnswers }}],
                backgroundColor: ['#06b6d4', '#ef4444'],
                hoverOffset: 6,
                borderWidth: 0,
                cutout: '80%'
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection
