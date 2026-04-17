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

    // Opsional: Hapus hasil yang sudah lebih dari 7 hari (sesuai kode lama Anda)
    \App\Models\Result::where('created_at', '<', now()->subDays(7))->delete();

    // 1. Ambil Kategori yang HANYA memiliki soal DAN sesuai KELAS siswa
    $listKuis = Category::whereHas('questions')
        ->where('kelas', $user->kelas) // <--- FILTER KELAS DISINI
        ->where(function($query) {
            // Tampilkan jika: Dibuat dalam 1 hari terakhir ATAU tanggalnya kosong (NULL)
            $query->where('created_at', '>=', now()->subDays(1))
                  ->orWhereNull('created_at');
        })
        ->get()
        ->map(function ($kuis) use ($user) {
            // Cek apakah sudah pernah dikerjakan
            $kuis->is_done = Result::where('user_id', $user->id)
                                ->where('category_id', $kuis->id)
                                ->exists();

            // Logika expired untuk tampilan di Blade
            if (is_null($kuis->created_at)) {
                $kuis->is_expired = false;
            } else {
                // Sesuai filter query di atas, kuis dianggap expired jika lewat 1 hari
                $kuis->is_expired = \Carbon\Carbon::parse($kuis->created_at)->diffInDays(\Carbon\Carbon::now()) >= 1;
            }

            return $kuis;
        });

    // --- Statistik ---
    $userResults = Result::where('user_id', $user->id)->get();
    $rataRata = $userResults->avg('skor') ?? 0;
    $skorTertinggi = $userResults->max('skor') ?? 0;

    // --- Menghitung Peringkat ---
    $peringkatRaw = Result::select('user_id', \Illuminate\Support\Facades\DB::raw('SUM(skor) as total_skor'))
        ->groupBy('user_id')
        ->orderByDesc('total_skor')
        ->get()
        ->pluck('user_id')
        ->search($user->id);

    $peringkat = ($peringkatRaw !== false) ? $peringkatRaw + 1 : '-';

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

    public function submit(Request $request, $category_id) // Tambahkan $category_id di sini agar sinkron dengan Route
{
    $jawabanUser = $request->input('jawaban');

    $questions = Question::where('category_id', $category_id)->get();
    $totalSoal = $questions->count();
    $jawabanBenarCounter = 0;

    if ($jawabanUser) {
        foreach ($questions as $soal) {
            $pilihanSiswa = $jawabanUser[$soal->id] ?? null;

            // 1. SIMPAN DETAIL JAWABAN KE TABEL user_answers (PENTING UNTUK REVIEW)
            \App\Models\UserAnswer::create([
                'user_id'       => auth()->id(),
                'category_id'   => $category_id,
                'question_id'   => $soal->id,
                'jawaban_siswa' => $pilihanSiswa,
            ]);

            // 2. CEK JAWABAN BENAR
            if ($pilihanSiswa == $soal->jawaban_benar) {
                $jawabanBenarCounter++;
            }
        }
    }

    $jawabanSalahCounter = $totalSoal - $jawabanBenarCounter;
    $skor = ($totalSoal > 0) ? ($jawabanBenarCounter / $totalSoal) * 100 : 0;

    // 3. SIMPAN HASIL AKHIR
    Result::create([
        'user_id'     => auth()->id(),
        'category_id' => $category_id,
        'skor'        => $skor,
        'benar'       => $jawabanBenarCounter,
        'salah'       => $jawabanSalahCounter,
        'created_at'  => now(),
        'updated_at'  => now(), // Pastikan nama kolomnya benar 'updated_at'
    ]);

    return redirect()->route('siswa.dashboard')->with('success', 'Kuis berhasil dikerjakan!');
}

    public function dashboard()
{
    $user = auth()->user();
    // ... (logika listKuis dan rataRata)

    // Logika hitung peringkat sederhana
    $peringkat = Result::orderBy('skor', 'desc')
        ->pluck('user_id')
        ->unique()
        ->values()
        ->search($user->id) + 1;

    return view('siswa.dashboard', compact('listKuis', 'rataRata', 'skorTertinggi', 'peringkat'));
}

public function review($category_id)
{
    $user = auth()->user();

    // Ambil hasil skor
    $result = \App\Models\Result::where('user_id', $user->id)
                    ->where('category_id', $category_id)
                    ->firstOrFail();

    // Ambil semua soal (urutkan agar konsisten)
    $category = \App\Models\Category::with(['questions' => function($query) {
        $query->orderBy('id', 'asc');
    }])->findOrFail($category_id);

    // Ambil jawaban yang pernah diinput siswa [id_soal => jawaban_siswa]
    $jawabanSiswa = \App\Models\UserAnswer::where('user_id', $user->id)
                    ->where('category_id', $category_id)
                    ->pluck('jawaban_siswa', 'question_id');

    return view('siswa.review', compact('category', 'result', 'jawabanSiswa'));
}

public function startQuiz($id) {
    $category = Category::findOrFail($id);
    $questions = Question::where('category_id', $id)->get();

    return view('siswa.show', compact('category', 'questions'));
}

}
