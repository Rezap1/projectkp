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
                // Ambil hasil pengerjaan terakhir HARI INI
                $lastResultToday = Result::where('user_id', $user->id)
                                    ->where('category_id', $kuis->id)
                                    ->whereDate('created_at', now()->toDateString())
                                    ->latest()
                                    ->first();

                $kuis->is_done = $lastResultToday ? true : false;
                $kuis->should_hide = false;

                if ($lastResultToday) {
                    $menitLalu = \Carbon\Carbon::parse($lastResultToday->created_at)->diffInMinutes($now);

                    // Hilangkan kuis jika sudah lewat 5 menit setelah dikerjakan
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

        // Mengambil Rank dan Warna berdasarkan TOTAL SKOR
        $badge = $this->getTierName($totalSkorSiswa);
        $badgeColor = $this->getBadgeColor($totalSkorSiswa);

        $targetSkor = 5000;

        // 3. Menghitung Peringkat
        $peringkatRaw = Result::select('user_id', DB::raw('SUM(skor) as total_skor'))
            ->whereMonth('created_at', $currentMonth)
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

        $lastResultToday = Result::where('user_id', $user->id)
                            ->where('category_id', $id)
                            ->whereDate('created_at', now()->toDateString())
                            ->latest()
                            ->first();

        if ($lastResultToday) {
            $menitLalu = Carbon::parse($lastResultToday->created_at)->diffInMinutes(now());
            if ($menitLalu >= 5) {
                return redirect()->route('siswa.dashboard')->with('error', 'Waktu akses kuis hari ini sudah habis.');
            }
        }

        $questions = Question::where('category_id', $id)->get();
        return view('siswa.show', compact('category', 'questions'));
    }

    public function submit(Request $request, $category_id)
    {
        $user = auth()->user();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // --- CEK TIER SEBELUM SUBMIT ---
        $skorSebelum = Result::where('user_id', $user->id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('skor');
        $tierLama = $this->getTierName($skorSebelum);

        $jawabanUser = $request->input('jawaban');
        $questions = Question::where('category_id', $category_id)->get();
        $totalSoal = $questions->count();
        $jawabanBenarCounter = 0;

        if ($jawabanUser) {
            foreach ($questions as $soal) {
                $pilihanSiswa = $jawabanUser[$soal->id] ?? null;

                \App\Models\UserAnswer::create([
                    'user_id'       => $user->id,
                    'category_id'   => $category_id,
                    'question_id'   => $soal->id,
                    'jawaban_siswa' => $pilihanSiswa,
                ]);

                if ($pilihanSiswa == $soal->jawaban_benar) {
                    $jawabanBenarCounter++;
                }
            }
        }

        $skor = ($totalSoal > 0) ? ($jawabanBenarCounter / $totalSoal) * 100 : 0;

        Result::create([
            'user_id'     => $user->id,
            'category_id' => $category_id,
            'skor'        => $skor,
            'benar'       => $jawabanBenarCounter,
            'salah'       => $totalSoal - $jawabanBenarCounter,
        ]);

        // --- CEK TIER SESUDAH SUBMIT ---
        $skorSesudah = Result::where('user_id', $user->id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('skor');
        $tierBaru = $this->getTierName($skorSesudah);

        // Jika naik tier/bintang, kirim sinyal pop-up
        if ($tierLama !== $tierBaru && $skorSesudah > $skorSebelum) {
            session()->flash('rankUp', [
                'tier' => $tierBaru,
                'pesan' => 'Luar biasa! Peringkatmu sekarang: ' . $tierBaru
            ]);
        }

        return redirect()->route('siswa.dashboard')->with('success', 'Kuis berhasil dikerjakan! Tombol review aktif 5 menit.');
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
            $query->orderBy('id', 'asc');
        }])->findOrFail($category_id);

        $jawabanSiswa = \App\Models\UserAnswer::where('user_id', $user->id)
                        ->where('category_id', $category_id)
                        ->latest()
                        ->take($category->questions->count())
                        ->pluck('jawaban_siswa', 'question_id');

        return view('siswa.review', compact('category', 'result', 'jawabanSiswa'));
    }

    // --- FUNGSI HELPER AGAR KODE RAPI ---

    private function getTierName($totalSkor)
    {
        // Debugging: Jika ingin Epic muncul lebih cepat untuk tes, ubah angka 200 jadi 50
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
        if ($totalSkor >= 200)  return 'from-teal-500 to-green-500'; // Epic Color
        return 'from-slate-500 to-slate-600'; // Warrior Color
    }
}
