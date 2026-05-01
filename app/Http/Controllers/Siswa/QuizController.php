<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Question;
use App\Models\Result;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $now = now();
        $currentMonth = $now->month;
        $currentYear = $now->year;

        // 1. Ambil Kuis yang memiliki soal hari ini
        $listKuis = Category::whereHas('questions', function($query) {
                $query->whereDate('created_at', now()->toDateString());
            })
            ->where('kelas', $user->kelas)
            ->latest()
            ->get()
            ->map(function ($kuis) use ($user, $now) {

                // Ambil soal terbaru hari ini untuk kategori ini
                $latestQuestion = Question::where('category_id', $kuis->id)
                                 ->whereDate('created_at', now()->toDateString())
                                 ->latest()
                                 ->first();

                // Cek apakah siswa sudah punya hasil (Result) untuk kategori ini HARI INI
                $lastResultToday = Result::where('user_id', $user->id)
                                    ->where('category_id', $kuis->id)
                                    ->whereDate('created_at', now()->toDateString())
                                    ->latest()
                                    ->first();

                // STATUS: Sudah selesai jika sudah ada data di tabel Result hari ini
                $kuis->is_done = $lastResultToday ? true : false;
                $kuis->should_hide = false;

                // Logika menyembunyikan kuis setelah 5 menit pengerjaan
                if ($lastResultToday) {
                    $menitLalu = Carbon::parse($lastResultToday->created_at)->diffInMinutes($now);
                    if ($menitLalu >= 5) {
                        $kuis->should_hide = true;
                    }
                    $kuis->last_result_time = $lastResultToday->created_at;
                }

                return $kuis;
            })
            ->filter(function ($kuis) {
                return $kuis->should_hide === false;
            });

        // 2. Statistik & Badge
        $userResults = Result::where('user_id', $user->id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->get();

        $rataRata = $userResults->avg('skor') ?? 0;
        $skorTertinggi = $userResults->max('skor') ?? 0;
        $totalSkorSiswa = $userResults->sum('skor');
        $tier = $this->getTierData($totalSkorSiswa);
        $badge = $tier['label'];
        $badgeColor = $tier['gradient'];
        $targetSkor = 5000;

        // 3. Peringkat Pribadi
        $peringkatRaw = Result::select('user_id', DB::raw('SUM(skor) as total_skor'))
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('user_id')
            ->orderByDesc('total_skor')
            ->get()
            ->pluck('user_id')
            ->search($user->id);

        $peringkat = ($peringkatRaw !== false) ? $peringkatRaw + 1 : '-';

        // 4. LEADERBOARD (1-10)
        $leaderboard = Result::select('user_id', DB::raw('SUM(skor) as total_skor'))
            ->with('user')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('user_id')
            ->orderByDesc('total_skor')
            ->take(10)
            ->get();

        return view('siswa.dashboard', compact(
            'listKuis', 'rataRata', 'skorTertinggi', 'peringkat',
            'badge', 'badgeColor', 'tier', 'totalSkorSiswa', 'targetSkor', 'leaderboard'
        ));
    }

    public function show($id)
    {
        $user = auth()->user();
        $category = Category::where('kelas', $user->kelas)->findOrFail($id);

        // Proteksi: Cek apakah sudah pernah mengerjakan hari ini
        $alreadyDone = Result::where('user_id', $user->id)
                            ->where('category_id', $category->id)
                            ->whereDate('created_at', now()->toDateString())
                            ->exists();

        if ($alreadyDone) {
            return redirect()->route('siswa.dashboard')->with('error', 'Kamu sudah mengerjakan kuis ini hari ini.');
        }

        // Hanya ambil 1 soal TERBARU hari ini
        $questions = Question::where('category_id', $category->id)
                             ->whereDate('created_at', now()->toDateString())
                             ->latest()
                             ->take(1)
                             ->get();

        if ($questions->isEmpty()) {
            return redirect()->route('siswa.dashboard')->with('error', 'Belum ada soal untuk kuis ini.');
        }

        return view('siswa.show', compact('category', 'questions'));
    }

    public function submit(Request $request, $category_id)
    {
        $user = auth()->user();
        $category = Category::where('kelas', $user->kelas)->findOrFail($category_id);

        // Proteksi ganda agar tidak bisa submit berkali-kali
        $alreadyDone = Result::where('user_id', $user->id)
                            ->where('category_id', $category->id)
                            ->whereDate('created_at', now()->toDateString())
                            ->exists();

        if ($alreadyDone) {
            return redirect()->route('siswa.dashboard')->with('error', 'Jawaban sudah terkirim sebelumnya.');
        }

        $currentMonth = now()->month;
        $currentYear = now()->year;

        $skorSebelum = Result::where('user_id', $user->id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('skor');
        $tierLama = $this->getTierData($skorSebelum);

        $jawabanUser = $request->input('jawaban', []);

        // Ambil 1 soal terbaru hari ini
        $questions = Question::where('category_id', $category->id)
                             ->whereDate('created_at', now()->toDateString())
                             ->latest()
                             ->take(1)
                             ->get();

        $totalSoal = $questions->count();
        $jawabanBenarCounter = 0;

        if ($totalSoal > 0) {
            foreach ($questions as $soal) {
                $pilihanSiswa = $jawabanUser[$soal->id] ?? null;

                \App\Models\UserAnswer::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'question_id' => $soal->id,
                        'category_id' => $category->id,
                    ],
                    [
                        'jawaban_siswa' => $pilihanSiswa ?: '-',
                    ]
                );

                if ($pilihanSiswa == $soal->jawaban_benar) {
                    $jawabanBenarCounter++;
                }
            }
        }

        $skor = ($totalSoal > 0) ? ($jawabanBenarCounter / $totalSoal) * 100 : 0;

        // Simpan Hasil (Hanya satu hasil per kategori per hari)
        Result::create([
            'user_id'     => $user->id,
            'category_id' => $category->id,
            'skor'        => $skor,
            'benar'       => $jawabanBenarCounter,
            'salah'       => $totalSoal - $jawabanBenarCounter,
        ]);

        $skorSesudah = Result::where('user_id', $user->id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('skor');
        $tierBaru = $this->getTierData($skorSesudah);

        if ($tierLama['label'] !== $tierBaru['label'] && $skorSesudah > $skorSebelum) {
            session()->flash('rankUp', [
                'tier' => $tierBaru,
                'previous' => $tierLama,
                'score' => $skorSesudah,
                'pesan' => 'Peringkatmu sekarang: ' . $tierBaru['label'],
            ]);
        }

        return redirect()->route('siswa.dashboard')->with('success', 'Kuis berhasil dikerjakan!');
    }

    public function review($category_id)
    {
        $user = auth()->user();
        $category = Category::where('kelas', $user->kelas)->findOrFail($category_id);

        $result = Result::where('user_id', $user->id)
                        ->where('category_id', $category->id)
                        ->whereDate('created_at', now()->toDateString())
                        ->latest()
                        ->firstOrFail();

        $category->load(['questions' => function($query) {
            $query->whereDate('created_at', now()->toDateString())->latest()->take(1);
        }]);

        $jawabanSiswa = \App\Models\UserAnswer::where('user_id', $user->id)
                        ->where('category_id', $category->id)
                        ->whereDate('created_at', now()->toDateString())
                        ->latest()
                        ->take($category->questions->count())
                        ->pluck('jawaban_siswa', 'question_id');

        return view('siswa.review', compact('category', 'result', 'jawabanSiswa'));
    }

    private function getTierName($totalSkor)
    {
        return $this->getTierData($totalSkor)['label'];
    }

    private function getBadgeColor($totalSkor)
    {
        return $this->getTierData($totalSkor)['gradient'];
    }

    private function getTierData($totalSkor): array
    {
        $score = (int) $totalSkor;

        if ($score >= 2500) {
            return $this->tierPayload('mythical_glory', 'Mythical Glory', 3, 2500, null, 'from-purple-700 via-red-600 to-yellow-400', '#facc15', '#dc2626', '#6d28d9');
        }

        if ($score >= 2000) {
            return $this->tierPayload('mythic', 'Mythic', 2, 2000, 2500, 'from-violet-600 via-fuchsia-500 to-blue-500', '#c084fc', '#7c3aed', '#2563eb');
        }

        if ($score >= 1700) {
            return $this->tierPayload('mythic', 'Mythic', 1, 1700, 2000, 'from-violet-600 via-fuchsia-500 to-blue-500', '#c084fc', '#7c3aed', '#2563eb');
        }

        if ($score >= 1400) {
            return $this->tierPayload('legend', 'Legend', 3, 1400, 1700, 'from-amber-500 via-yellow-300 to-orange-500', '#fbbf24', '#f59e0b', '#b45309');
        }

        if ($score >= 1100) {
            return $this->tierPayload('legend', 'Legend', 2, 1100, 1400, 'from-amber-500 via-yellow-300 to-orange-500', '#fbbf24', '#f59e0b', '#b45309');
        }

        if ($score >= 800) {
            return $this->tierPayload('legend', 'Legend', 1, 800, 1100, 'from-amber-500 via-yellow-300 to-orange-500', '#fbbf24', '#f59e0b', '#b45309');
        }

        if ($score >= 600) {
            return $this->tierPayload('epic', 'Epic', 3, 600, 800, 'from-teal-400 via-cyan-400 to-emerald-500', '#22d3ee', '#14b8a6', '#059669');
        }

        if ($score >= 400) {
            return $this->tierPayload('epic', 'Epic', 2, 400, 600, 'from-teal-400 via-cyan-400 to-emerald-500', '#22d3ee', '#14b8a6', '#059669');
        }

        if ($score >= 200) {
            return $this->tierPayload('epic', 'Epic', 1, 200, 400, 'from-teal-400 via-cyan-400 to-emerald-500', '#22d3ee', '#14b8a6', '#059669');
        }

        return $this->tierPayload('warrior', 'Warrior', 1, 0, 200, 'from-slate-500 via-zinc-400 to-stone-500', '#94a3b8', '#64748b', '#44403c');
    }

    private function tierPayload(string $key, string $name, int $stars, int $minScore, ?int $nextScore, string $gradient, string $primary, string $secondary, string $accent): array
    {
        return [
            'key' => $key,
            'name' => $name,
            'stars' => $stars,
            'label' => $name . ' ' . str_repeat('*', $stars),
            'min_score' => $minScore,
            'next_score' => $nextScore,
            'gradient' => $gradient,
            'primary' => $primary,
            'secondary' => $secondary,
            'accent' => $accent,
        ];
    }
}
