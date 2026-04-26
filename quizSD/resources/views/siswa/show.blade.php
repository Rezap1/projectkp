@extends('layout.master')

@section('konten')
<div class="min-h-screen pt-32 pb-12 px-6 bg-[#0f172a] text-slate-200 relative overflow-hidden">

    {{-- Background Arena Effect --}}
    <div class="absolute top-0 left-0 w-96 h-96 bg-cyan-500/10 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-fuchsia-500/10 blur-[120px] rounded-full"></div>

    <div class="max-w-3xl mx-auto relative z-10">

        {{-- Floating Timer Section --}}
        <div class="fixed top-28 right-6 z-50 hidden md:block" id="timerContainer">
            <div class="bg-slate-900/90 backdrop-blur-xl px-8 py-6 rounded-[2.5rem] shadow-[0_0_35px_rgba(6,182,212,0.35)] border-2 border-cyan-500 flex flex-col items-center group transition-all hover:scale-105">
                <p class="text-[10px] font-black text-cyan-400 uppercase tracking-[0.2em] mb-1">Sisa Waktu</p>
                <div id="timer" class="text-4xl font-black text-cyan-400 tabular-nums">
                    00:00
                </div>
            </div>
        </div>

        {{-- Mobile Timer --}}
        <div class="md:hidden sticky top-24 z-40 mb-6">
            <div class="bg-cyan-600 text-white p-4 rounded-2xl shadow-lg flex justify-between items-center">
                <span class="font-black text-xs uppercase tracking-widest">Sisa Waktu</span>
                <span id="timerMobile" class="font-black text-xl tabular-nums">00:00</span>
            </div>
        </div>

        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <h1 class="text-4xl font-black text-white leading-tight uppercase italic">
                    {{ $category->nama_kategori }} ⚔️
                </h1>

                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-3 py-1 bg-cyan-500/10 text-cyan-400 border border-cyan-500/30 rounded-full text-[10px] font-black uppercase">
                        Arena Kelas {{ $category->kelas }}
                    </span>

                    <p class="text-slate-400 font-medium italic text-sm">
                        Taklukkan seluruh soal dengan teliti!
                    </p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="bg-slate-900/80 px-6 py-4 rounded-3xl shadow border border-white/10">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest text-center">Total Soal</p>
                    <p class="text-xl font-bold text-cyan-400 text-center">{{ $questions->count() }}</p>
                </div>

                <div class="bg-slate-900/80 px-6 py-4 rounded-3xl shadow border border-white/10">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest text-center">Durasi</p>
                    <p class="text-xl font-bold text-fuchsia-400 text-center">
                        {{ $category->durasi }}<span class="text-xs ml-1">Min</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Progress Bar --}}
        <div class="mb-8 bg-slate-900/80 p-5 rounded-3xl border border-white/10">
            <div class="flex justify-between text-xs font-black uppercase tracking-widest mb-3">
                <span class="text-cyan-400">Progress Jawaban</span>
                <span id="progressText" class="text-slate-400">0 / {{ $questions->count() }}</span>
            </div>

            <div class="w-full bg-slate-800 h-4 rounded-full overflow-hidden">
                <div id="progressBar"
                     class="h-full bg-gradient-to-r from-cyan-500 to-fuchsia-500 rounded-full transition-all duration-500"
                     style="width: 0%">
                </div>
            </div>
        </div>

        <form action="{{ route('kuis.submit', $category->id) }}" method="POST" id="quizForm">
            @csrf

            <div class="space-y-8">
                @foreach($questions as $index => $soal)
                    <div class="bg-slate-900/80 backdrop-blur-xl p-8 rounded-[3rem] border border-white/10 shadow-xl transition-all hover:shadow-cyan-500/10 hover:border-cyan-500/30 relative overflow-hidden group">

                        <div class="absolute -top-4 -left-4 w-24 h-24 bg-cyan-500/5 rounded-full opacity-50"></div>

                        <div class="flex gap-6 relative z-10">

                            {{-- Nomor --}}
                            <span class="flex-none w-12 h-12 bg-gradient-to-br from-cyan-500 to-fuchsia-500 rounded-2xl flex items-center justify-center font-black text-white shadow-lg transform -rotate-3 group-hover:rotate-0 transition-transform">
                                {{ $index + 1 }}
                            </span>

                            <div class="flex-1">
                                <p class="text-xl font-bold text-white mb-8 leading-relaxed">
                                    {{ $soal->pertanyaan }}
                                </p>

                                {{-- Opsi --}}
                                <div class="grid grid-cols-1 gap-4">
                                    @foreach(['a', 'b', 'c', 'd'] as $opsi)
                                        @php $labelOpsi = "opsi_" . $opsi; @endphp

                                        <label class="relative flex items-center p-5 rounded-[1.5rem] border-2 border-white/5 cursor-pointer transition-all hover:bg-slate-800 group/item has-[:checked]:border-cyan-500 has-[:checked]:bg-cyan-500/10">
                                            <input type="radio"
                                                   name="jawaban[{{ $soal->id }}]"
                                                   value="{{ $opsi }}"
                                                   class="hidden peer"
                                                   required>

                                            <div class="flex items-center gap-4 w-full">

                                                <div class="w-10 h-10 rounded-xl border-2 border-white/10 flex items-center justify-center font-black text-slate-400 peer-checked:border-cyan-500 peer-checked:bg-cyan-500 peer-checked:text-white transition-all">
                                                    {{ strtoupper($opsi) }}
                                                </div>

                                                <p class="font-bold text-slate-300 peer-checked:text-cyan-300 transition-all">
                                                    {{ $soal->$labelOpsi }}
                                                </p>
                                            </div>

                                            <div class="absolute right-6 scale-0 peer-checked:scale-100 transition-transform">
                                                ✔
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Submit --}}
            <div class="mt-16 mb-32 text-center">
                <button type="button"
                        onclick="confirmSubmit()"
                        class="group inline-flex items-center gap-4 bg-gradient-to-r from-cyan-500 to-fuchsia-500 text-white px-16 py-6 rounded-[2.5rem] font-black text-xl shadow-[0_0_30px_rgba(6,182,212,0.35)] hover:scale-105 transition-all active:scale-95 uppercase tracking-wide">
                    <span>Selesaikan Misi</span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6 group-hover:translate-x-2 transition-transform"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="3"
                              d="M13 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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
            alert('⏰ Waktu habis! Jawaban otomatis dikirim.');
            quizForm.submit();
        }

        if (timeLeft <= 60) {
            timerDisplay.classList.replace('text-cyan-400', 'text-red-400');
            timerDisplay.classList.add('animate-pulse');

            document.getElementById('timerContainer')
                .querySelector('div')
                .classList.replace('border-cyan-500', 'border-red-500');
        }

        timeLeft--;
    }, 1000);

    function confirmSubmit() {
        const totalSoal = {{ $questions->count() }};
        const jawabanTerisi = document.querySelectorAll('input[type="radio"]:checked').length;

        if (jawabanTerisi < totalSoal) {
            if (!confirm(`Kamu baru menjawab ${jawabanTerisi} dari ${totalSoal} soal. Tetap kirim?`)) {
                return;
            }
        } else {
            if (!confirm('Yakin ingin menyelesaikan arena ini?')) {
                return;
            }
        }

        quizForm.submit();
    }

    // Progress realtime
    const radios = document.querySelectorAll('input[type="radio"]');

    radios.forEach(radio => {
        radio.addEventListener('change', updateProgress);
    });

    function updateProgress() {
        const total = {{ $questions->count() }};
        const answered = document.querySelectorAll('input[type="radio"]:checked').length;
        const percent = (answered / total) * 100;

        document.getElementById('progressBar').style.width = percent + '%';
        document.getElementById('progressText').innerText = `${answered} / ${total}`;
    }
</script>
@endsection
