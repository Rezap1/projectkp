@extends('layout.master')

@section('konten')
<div class="min-h-screen pt-32 pb-12 px-6 bg-slate-50">
    <div class="max-w-3xl mx-auto">

        {{-- Floating Timer Section --}}
        <div class="fixed top-28 right-6 z-50 hidden md:block" id="timerContainer">
            <div class="bg-white px-8 py-6 rounded-[2.5rem] shadow-2xl border-2 border-indigo-600 flex flex-col items-center group transition-all hover:scale-105">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Sisa Waktu</p>
                <div id="timer" class="text-4xl font-black text-indigo-600 tabular-nums">
                    00:00
                </div>
            </div>
        </div>

        {{-- Mobile Timer (Sticky) --}}
        <div class="md:hidden sticky top-24 z-40 mb-6">
            <div class="bg-indigo-600 text-white p-4 rounded-2xl shadow-lg flex justify-between items-center">
                <span class="font-black text-xs uppercase tracking-widest">Waktu Pengerjaan</span>
                <span id="timerMobile" class="font-black text-xl tabular-nums">00:00</span>
            </div>
        </div>

        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-1">
                <h1 class="text-4xl font-black text-slate-900 leading-tight">{{ $category->nama_kategori }} ✍️</h1>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-[10px] font-black uppercase">Kelas {{ $category->kelas }}</span>
                    <p class="text-slate-500 font-medium italic text-sm">Jawablah pertanyaan dengan teliti!</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="bg-white px-6 py-4 rounded-3xl shadow-sm border border-slate-100">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Soal</p>
                    <p class="text-xl font-bold text-indigo-600 text-center">{{ $questions->count() }}</p>
                </div>
                <div class="bg-white px-6 py-4 rounded-3xl shadow-sm border border-slate-100">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Durasi</p>
                    <p class="text-xl font-bold text-amber-500 text-center">{{ $category->durasi }}<span class="text-xs ml-1">Min</span></p>
                </div>
            </div>
        </div>

        <form action="{{ route('kuis.submit', $category->id) }}" method="POST" id="quizForm">
            @csrf
            <div class="space-y-8">
                @foreach($questions as $index => $soal)
                    <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm transition-all hover:shadow-md relative overflow-hidden group">
                        {{-- Aksen Background Nomor --}}
                        <div class="absolute -top-4 -left-4 w-24 h-24 bg-slate-50 rounded-full -z-0 opacity-50 group-hover:bg-indigo-50 transition-colors"></div>

                        <div class="flex gap-6 relative z-10">
                            {{-- Nomor Soal --}}
                            <span class="flex-none w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center font-black text-white shadow-xl shadow-indigo-100 transform -rotate-3 group-hover:rotate-0 transition-transform">
                                {{ $index + 1 }}
                            </span>

                            <div class="flex-1">
                                <p class="text-xl font-bold text-slate-800 mb-8 leading-relaxed">
                                    {{ $soal->pertanyaan }}
                                </p>

                                {{-- Pilihan Jawaban --}}
                                <div class="grid grid-cols-1 gap-4">
                                    @foreach(['a', 'b', 'c', 'd'] as $opsi)
                                        @php $labelOpsi = "opsi_" . $opsi; @endphp
                                        <label class="relative flex items-center p-5 rounded-[1.5rem] border-2 border-slate-50 cursor-pointer transition-all hover:bg-slate-50 group/item has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50">
                                            <input type="radio"
                                                   name="jawaban[{{ $soal->id }}]"
                                                   value="{{ $opsi }}"
                                                   class="hidden peer"
                                                   required>

                                            <div class="flex items-center gap-4 w-full">
                                                {{-- Kotak Huruf --}}
                                                <div class="w-10 h-10 rounded-xl border-2 border-slate-100 flex items-center justify-center font-black text-slate-400 group-hover/item:border-indigo-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-600 peer-checked:text-white transition-all">
                                                    {{ strtoupper($opsi) }}
                                                </div>

                                                <p class="font-bold text-slate-600 group-hover/item:text-slate-900 peer-checked:text-indigo-900 transition-all">
                                                    {{ $soal->$labelOpsi }}
                                                </p>
                                            </div>

                                            {{-- Icon Ceklis saat dipilih --}}
                                            <div class="absolute right-6 scale-0 peer-checked:scale-100 transition-transform">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-16 mb-32 text-center">
                <button type="button" onclick="confirmSubmit()" class="group inline-flex items-center gap-4 bg-slate-900 text-white px-16 py-6 rounded-[2.5rem] font-black text-xl hover:bg-indigo-600 shadow-2xl transition-all active:scale-95">
                    <span>Kirim Jawaban</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // 1. LOGIKA TIMER
    // Ambil durasi dari Laravel (dalam menit) lalu kali 60 untuk jadi detik
    let timeLeft = {{ $category->durasi * 60 }};
    const timerDisplay = document.getElementById('timer');
    const timerMobile = document.getElementById('timerMobile');
    const quizForm = document.getElementById('quizForm');

    const countdown = setInterval(() => {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;


        const displayString = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        timerDisplay.innerText = displayString;
        timerMobile.innerText = displayString;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            alert('Waktu pengerjaan telah habis! Jawaban kamu akan otomatis dikirim.');
            quizForm.submit();
        }

        if (timeLeft <= 60) {
            timerDisplay.classList.replace('text-indigo-600', 'text-red-500');
            timerDisplay.classList.add('animate-pulse');
            document.getElementById('timerContainer').querySelector('div').classList.replace('border-indigo-600', 'border-red-500');
        }

        timeLeft--;
    }, 1000);


    function confirmSubmit() {
        const totalSoal = {{ $questions->count() }};
        const jawabanTerisi = document.querySelectorAll('input[type="radio"]:checked').length;

        if (jawabanTerisi < totalSoal) {
            if (!confirm(`Kamu baru menjawab ${jawabanTerisi} dari ${totalSoal} soal. Yakin ingin mengirim sekarang?`)) {
                return;
            }
        } else {
            if (!confirm('Apakah kamu yakin ingin mengirim semua jawaban?')) {
                return;
            }
        }

        quizForm.submit();
    }
</script>
@endsection
