@extends('layout.master')

@section('konten')
<div class="max-w-4xl mx-auto p-6 text-center">
    <div class="bg-white rounded-[3rem] shadow-2xl p-10 mb-8 border-4 border-indigo-50">
        <h1 class="text-3xl font-black text-gray-900 mb-2">Hore! Kamu Selesai 🎉</h1>
        <p class="text-gray-500 mb-8">Ini adalah hasil kerja kerasmu di kuis {{ $category->nama_kategori }}</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="relative flex justify-center">
                <canvas id="resultChart" width="250" height="250"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-5xl font-black text-indigo-600">{{ round($score) }}</span>
                    <span class="text-xs font-bold text-gray-400 uppercase">Skor Akhir</span>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-green-50 p-4 rounded-2xl flex justify-between items-center border-2 border-green-100">
                    <span class="font-bold text-green-700">✅ Jawaban Benar</span>
                    <span class="text-2xl font-black text-green-600">{{ $correctAnswers }}</span>
                </div>
                <div class="bg-red-50 p-4 rounded-2xl flex justify-between items-center border-2 border-red-100">
                    <span class="font-bold text-red-700">❌ Jawaban Salah</span>
                    <span class="text-2xl font-black text-red-600">{{ $wrongAnswers }}</span>
                </div>
                <div class="bg-indigo-50 p-4 rounded-2xl flex justify-between items-center border-2 border-indigo-100">
                    <span class="font-bold text-indigo-700">📝 Total Soal</span>
                    <span class="text-2xl font-black text-indigo-600">{{ $totalQuestions }}</span>
                </div>
            </div>
        </div>

        <div class="mt-12 p-6 bg-yellow-50 rounded-3xl border-2 border-dashed border-yellow-200 text-yellow-800">
            <p class="text-lg font-bold">
                @if($score >= 80)
                    Luar biasa! Kamu pintar sekali! 🌟
                @elseif($score >= 60)
                    Bagus! Terus belajar ya agar makin hebat! 💪
                @else
                    Jangan menyerah! Coba lagi dan pasti bisa! 📚
                @endif
            </p>
        </div>

        <div class="mt-10 flex gap-4">
            <a href="{{ route('siswa.index') }}" class="flex-1 bg-gray-900 text-white font-bold py-4 rounded-2xl hover:bg-gray-800 transition shadow-lg">
                Kembali ke Beranda
            </a>
            <a href="{{ route('siswa.kuis.show', $category->slug) }}" class="flex-1 bg-indigo-600 text-white font-bold py-4 rounded-2xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                Ulangi Kuis
            </a>
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
                backgroundColor: ['#22c55e', '#ef4444'],
                hoverOffset: 4,
                borderWidth: 0,
                cutout: '80%' // Membuat lingkaran tengah lebih besar/bolong
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
