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

        // Menyiapkan list kuis dengan fitur Timer & Satu Kali Kerjakan
        $listKuis = Category::all()->map(function ($kuis) use ($user) {
            // Cek apakah sudah pernah dikerjakan
            $kuis->is_done = Result::where('user_id', $user->id)
                                ->where('category_id', $kuis->id)
                                ->exists();

            // Cek apakah sudah lewat 3 hari (Timer)
            $tanggalTerbit = Carbon::parse($kuis->created_at);
            $kuis->is_expired = Carbon::now()->diffInDays($tanggalTerbit) >= 3;

            return $kuis;
        });

        // Menghitung Statistik
        $userResults = Result::where('user_id', $user->id)->get();
        $rataRata = $userResults->avg('skor') ?? 0;
        $skorTertinggi = $userResults->max('skor') ?? 0;

        // --- SOLUSI ERROR image_45d0e6.jpg (Menghitung Peringkat) ---
        $peringkatRaw = Result::select('user_id', DB::raw('SUM(skor) as total_skor'))
            ->groupBy('user_id')
            ->orderByDesc('total_skor')
            ->get()
            ->pluck('user_id')
            ->search($user->id);

        $peringkat = ($peringkatRaw !== false) ? $peringkatRaw + 1 : '-';

        // Kirim semua variabel yang diminta oleh dashboard.blade.php
        return view('siswa.dashboard', compact('listKuis', 'rataRata', 'skorTertinggi', 'peringkat'));
    }




    public function show($id)
{
    $user = auth()->user();
    $category = \App\Models\Category::findOrFail($id);

    // LOGIKA KEAMANAN BARU
    $sudahDikerjakan = \App\Models\Result::where('user_id', $user->id)
                        ->where('category_id', $id)
                        ->exists();

    $isExpired = \Carbon\Carbon::now()->diffInDays($category->created_at) >= 3;

    if ($sudahDikerjakan || $isExpired) {
        return redirect()->route('siswa.dashboard')->with('error', 'Kuis tidak tersedia.');
    }
    // AKHIR LOGIKA KEAMANAN

    $questions = \App\Models\Question::where('category_id', $id)->get();
    return view('siswa.show', compact('category', 'questions'));
}

    public function submit(Request $request)
    {
        $category_id = $request->input('category_id');
        $jawabanUser = $request->input('jawaban');

        $questions = Question::where('category_id', $category_id)->get();
        $totalSoal = $questions->count();
        $jawabanBenarCounter = 0;

        if ($jawabanUser) {
            foreach ($questions as $soal) {
                if (isset($jawabanUser[$soal->id]) && $jawabanUser[$soal->id] == $soal->jawaban_benar) {
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

        return redirect()->route('dashboard')->with('success', 'Kuis Selesai! Skor Anda: ' . number_format($skor, 0));
    }
}
