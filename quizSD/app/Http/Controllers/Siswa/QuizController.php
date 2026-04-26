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
        $badge = $this->getTierName($totalSkorSiswa);
        $badgeColor = $this->getBadgeColor($totalSkorSiswa);
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
            'badge', 'badgeColor', 'totalSkorSiswa', 'targetSkor', 'leaderboard'
        ));
    }

    public function show($id)
    {
        $user = auth()->user();

        // Proteksi: Cek apakah sudah pernah mengerjakan hari ini
        $alreadyDone = Result::where('user_id', $user->id)
                            ->where('category_id', $id)
                            ->whereDate('created_at', now()->toDateString())
                            ->exists();

        if ($alreadyDone) {
            return redirect()->route('siswa.dashboard')->with('error', 'Kamu sudah mengerjakan kuis ini hari ini.');
        }

        $category = Category::findOrFail($id);

        // Hanya ambil 1 soal TERBARU hari ini
        $questions = Question::where('category_id', $id)
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

        // Proteksi ganda agar tidak bisa submit berkali-kali
        $alreadyDone = Result::where('user_id', $user->id)
                            ->where('category_id', $category_id)
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
        $tierLama = $this->getTierName($skorSebelum);

        $jawabanUser = $request->input('jawaban');

        // Ambil 1 soal terbaru hari ini
        $questions = Question::where('category_id', $category_id)
                             ->whereDate('created_at', now()->toDateString())
                             ->latest()
                             ->take(1)
                             ->get();

        $totalSoal = $questions->count();
        $jawabanBenarCounter = 0;

        if ($jawabanUser && $totalSoal > 0) {
            foreach ($questions as $soal) {
                $pilihanSiswa = $jawabanUser[$soal->id] ?? null;

                \App\Models\UserAnswer::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'question_id' => $soal->id,
                        'category_id' => $category_id,
                    ],
                    [
                        'jawaban_siswa' => $pilihanSiswa,
                        'created_at' => now(),
                    ]
                );

                if ($pilihanSiswa == $soal->jawaban_benar) {
                    $jawabanBenarCounter++;
                }
            }
        }

        $skor = ($totalSoal > 0) ? ($jawabanBenarCounter / $totalSoal) * 100 : 0;

        // Simpan Hasil (Hanya satu hasil per kategori per hari)
        Result::updateOrCreate(
            [
                'user_id'     => $user->id,
                'category_id' => $category_id,
                'created_at'  => now()->toDateString(), // Filter tanggal
            ],
            [
                'skor'        => $skor,
                'benar'       => $jawabanBenarCounter,
                'salah'       => $totalSoal - $jawabanBenarCounter,
                'created_at'  => now(), // Timestamps lengkap
            ]
        );

        $skorSesudah = Result::where('user_id', $user->id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('skor');
        $tierBaru = $this->getTierName($skorSesudah);

        if ($tierLama !== $tierBaru && $skorSesudah > $skorSebelum) {
            session()->flash('rankUp', [
                'tier' => $tierBaru,
                'pesan' => 'Luar biasa! Peringkatmu sekarang: ' . $tierBaru
            ]);
        }

        return redirect()->route('siswa.dashboard')->with('success', 'Kuis berhasil dikerjakan!');
    }

    public function review($category_id)
    {
        $user = auth()->user();
        $result = Result::where('user_id', $user->id)
                        ->where('category_id', $category_id)
                        ->whereDate('created_at', now()->toDateString())
                        ->latest()
                        ->firstOrFail();

        $category = Category::with(['questions' => function($query) {
            $query->whereDate('created_at', now()->toDateString())->latest()->take(1);
        }])->findOrFail($category_id);

        $jawabanSiswa = \App\Models\UserAnswer::where('user_id', $user->id)
                        ->where('category_id', $category_id)
                        ->whereDate('created_at', now()->toDateString())
                        ->latest()
                        ->take($category->questions->count())
                        ->pluck('jawaban_siswa', 'question_id');

        return view('siswa.review', compact('category', 'result', 'jawabanSiswa'));
    }

    private function getTierName($totalSkor)
    {
        if ($totalSkor >= 2500) return 'Mythical Glory ⭐⭐⭐';
        if ($totalSkor >= 2000) return 'Mythic ⭐⭐';
        if ($totalSkor >= 1700) return 'Mythic ⭐';
        if ($totalSkor >= 1400) return 'Legend ⭐⭐⭐';
        if ($totalSkor >= 1100) return 'Legend ⭐⭐';
        if ($totalSkor >= 800)  return 'Legend ⭐';
        if ($totalSkor >= 600)  return 'Epic ⭐⭐⭐';
        if ($totalSkor >= 400)  return 'Epic ⭐⭐';
        if ($totalSkor >= 200)  return 'Epic ⭐';
        return 'Warrior ⭐';
    }

    private function getBadgeColor($totalSkor)
    {
        if ($totalSkor >= 2500) return 'from-purple-700 via-red-600 to-yellow-500';
        if ($totalSkor >= 1700) return 'from-purple-600 to-blue-600';
        if ($totalSkor >= 800)  return 'from-orange-500 to-yellow-500';
        if ($totalSkor >= 200)  return 'from-teal-500 to-green-500';
        return 'from-slate-500 to-slate-600';
    }
}
