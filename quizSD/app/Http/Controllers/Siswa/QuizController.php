<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Question;
use App\Models\Result;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $now = now();
    $currentMonth = now()->month;
    $currentYear = now()->year;

    // 1. Ambil Kuis sesuai KELAS siswa
    $listKuis = Category::whereHas('questions')
        ->where('kelas', $user->kelas)
        ->latest()
        ->get()
        ->map(function ($kuis) use ($user, $now) {
            $lastResult = Result::where('user_id', $user->id)
                                ->where('category_id', $kuis->id)
                                ->latest()
                                ->first();

            $kuis->is_done = $lastResult ? true : false;
            $kuis->should_hide = false;

            // LOGIKA SEMBUNYI 5 MENIT:
            if ($lastResult) {
                $menitLalu = \Carbon\Carbon::parse($lastResult->created_at)->diffInMinutes($now);
                if ($menitLalu >= 5) {
                    $kuis->should_hide = true;
                }
                $kuis->last_result_time = $lastResult->created_at;
            }

            return $kuis;
        })
        ->filter(function ($kuis) {
            return $kuis->should_hide === false;
        });

    // 2. Statistik & Badge (DIBUAT RESET BULANAN)
    $userResults = Result::where('user_id', $user->id)
        ->whereMonth('created_at', $currentMonth) // Hanya hitung skor bulan ini
        ->whereYear('created_at', $currentYear)
        ->get();

    $rataRata = $userResults->avg('skor') ?? 0;
    $skorTertinggi = $userResults->max('skor') ?? 0;
    $totalSkorSiswa = $userResults->sum('skor');

    // Penentuan Tier berdasarkan skor BULAN INI
    if ($totalSkorSiswa >= 1700) {
        $badge = 'Mythical Glory 🎖️';
        $badgeColor = 'bg-gradient-to-r from-purple-600 to-red-600';
    } elseif ($totalSkorSiswa >= 1200) {
        $badge = 'Mythic 🌟';
        $badgeColor = 'bg-gradient-to-r from-blue-500 to-purple-500';
    } elseif ($totalSkorSiswa >= 700) {
        $badge = 'Legend 🛡️';
        $badgeColor = 'bg-gradient-to-r from-yellow-500 to-orange-500';
    } elseif ($totalSkorSiswa >= 300) {
        $badge = 'Epic ⚔️';
        $badgeColor = 'bg-gradient-to-r from-green-500 to-teal-500';
    } else {
        $badge = 'Warrior 🍃';
        $badgeColor = 'bg-slate-400';
    }

    $targetSkor = 5000;

    // 3. Menghitung Peringkat (DIBUAT RESET BULANAN)
    $peringkatRaw = Result::select('user_id', \DB::raw('SUM(skor) as total_skor'))
        ->whereMonth('created_at', $currentMonth) // Peringkat hanya berdasarkan skor bulan ini
        ->whereYear('created_at', $currentYear)
        ->groupBy('user_id')
        ->orderByDesc('total_skor')
        ->get()
        ->pluck('user_id')
        ->search($user->id);

    $peringkat = ($peringkatRaw !== false) ? $peringkatRaw + 1 : '-';

    return view('siswa.dashboard', compact(
        'listKuis', 'rataRata', 'skorTertinggi', 'peringkat',
        'badge', 'badgeColor', 'totalSkorSiswa', 'targetSkor'
    ));
}

    public function show($id)
    {
        $user = auth()->user();
        $category = Category::findOrFail($id);

        $lastResult = Result::where('user_id', $user->id)
                            ->where('category_id', $id)
                            ->latest()
                            ->first();

        if ($lastResult) {
            $menitLalu = Carbon::parse($lastResult->created_at)->diffInMinutes(now());
            if ($menitLalu >= 5) {
                return redirect()->route('siswa.dashboard')->with('error', 'Waktu akses kuis ini sudah habis.');
            }
        }

        $questions = Question::where('category_id', $id)->get();
        return view('siswa.show', compact('category', 'questions'));
    }

    public function submit(Request $request, $category_id)
    {
        $jawabanUser = $request->input('jawaban');
        $questions = Question::where('category_id', $category_id)->get();
        $totalSoal = $questions->count();
        $jawabanBenarCounter = 0;

        if ($jawabanUser) {
            foreach ($questions as $soal) {
                $pilihanSiswa = $jawabanUser[$soal->id] ?? null;

                \App\Models\UserAnswer::create([
                    'user_id'       => auth()->id(),
                    'category_id'   => $category_id,
                    'question_id'   => $soal->id,
                    'jawaban_siswa' => $pilihanSiswa,
                ]);

                if ($pilihanSiswa == $soal->jawaban_benar) {
                    $jawabanBenarCounter++;
                }
            }
        }

        $jawabanSalahCounter = $totalSoal - $jawabanBenarCounter;
        $skor = ($totalSoal > 0) ? ($jawabanBenarCounter / $totalSoal) * 100 : 0;

        Result::create([
            'user_id'     => auth()->id(),
            'category_id' => $category_id,
            'skor'        => $skor,
            'benar'       => $jawabanBenarCounter,
            'salah'       => $jawabanSalahCounter,
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Kuis berhasil dikerjakan! Kamu punya 5 menit untuk melihat hasilnya.');
    }

    public function review($category_id)
    {
        $user = auth()->user();
        $result = Result::where('user_id', $user->id)->where('category_id', $category_id)->firstOrFail();

        $category = Category::with(['questions' => function($query) {
            $query->orderBy('id', 'asc');
        }])->findOrFail($category_id);

        $jawabanSiswa = \App\Models\UserAnswer::where('user_id', $user->id)
                        ->where('category_id', $category_id)
                        ->pluck('jawaban_siswa', 'question_id');

        return view('siswa.review', compact('category', 'result', 'jawabanSiswa'));
    }
}
