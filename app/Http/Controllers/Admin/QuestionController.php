<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Category;
use App\Models\Result;
use Illuminate\Support\Facades\Auth; // Tambahkan ini agar Auth terbaca aman

class QuestionController extends Controller
{
   public function dashboard()
{
    $user = Auth::user();
    $today = now()->toDateString();

    // 1. Ambil kategori (Mata Pelajaran) milik guru yang login
    $myCategoryIds = Category::where('user_id', $user->id)->pluck('id');

    // 2. Hitung total soal dari kategori milik guru tersebut
    $totalSoal = Question::whereIn('category_id', $myCategoryIds)->count();

    // 3. Statistik Harian (Hanya data hari ini)
    $totalSiswaHariIni = Result::whereIn('category_id', $myCategoryIds)
        ->whereDate('created_at', $today)
        ->distinct('user_id')
        ->count();

    $rataRataNilai = Result::whereIn('category_id', $myCategoryIds)
        ->whereDate('created_at', $today)
        ->avg('skor') ?? 0;

    // 4. Ambil Aktivitas Terbaru (Reset Harian)
    $aktivitasKelas4 = Result::with(['user', 'category'])
        ->whereIn('category_id', $myCategoryIds)
        ->whereDate('created_at', $today)
        ->whereHas('user', fn($q) => $q->where('kelas', 4))
        ->latest()->get();

    $aktivitasKelas5 = Result::with(['user', 'category'])
        ->whereIn('category_id', $myCategoryIds)
        ->whereDate('created_at', $today)
        ->whereHas('user', fn($q) => $q->where('kelas', 5))
        ->latest()->get();

    $aktivitasKelas6 = Result::with(['user', 'category'])
        ->whereIn('category_id', $myCategoryIds)
        ->whereDate('created_at', $today)
        ->whereHas('user', fn($q) => $q->where('kelas', 6))
        ->latest()->get();

    // 5. Ambil Data Leaderboard (Peringkat - Tidak Reset Harian)
    // Mengambil skor tertinggi per siswa di mata pelajaran Anda
    $rankKelas4 = Result::with('user')
        ->whereIn('category_id', $myCategoryIds)
        ->whereHas('user', fn($q) => $q->where('kelas', 4))
        ->selectRaw('user_id, MAX(skor) as high_score, MAX(created_at) as last_attempt')
        ->groupBy('user_id')
        ->orderBy('high_score', 'desc')
        ->take(10)->get();

    $rankKelas5 = Result::with('user')
        ->whereIn('category_id', $myCategoryIds)
        ->whereHas('user', fn($q) => $q->where('kelas', 5))
        ->selectRaw('user_id, MAX(skor) as high_score, MAX(created_at) as last_attempt')
        ->groupBy('user_id')
        ->orderBy('high_score', 'desc')
        ->take(10)->get();

    $rankKelas6 = Result::with('user')
        ->whereIn('category_id', $myCategoryIds)
        ->whereHas('user', fn($q) => $q->where('kelas', 6))
        ->selectRaw('user_id, MAX(skor) as high_score, MAX(created_at) as last_attempt')
        ->groupBy('user_id')
        ->orderBy('high_score', 'desc')
        ->take(10)->get();

    return view('admin.dashboard', compact(
        'totalSiswaHariIni',
        'totalSoal',
        'rataRataNilai',
        'aktivitasKelas4',
        'aktivitasKelas5',
        'aktivitasKelas6',
        'rankKelas4',
        'rankKelas5',
        'rankKelas6'
    ));
}

    // Halaman Form Tambah Soal
    public function create()
    {

        $categories = Category::where('user_id', Auth::id())->get();

        return view('admin.questions.create', compact('categories'));
    }

    // Proses Simpan ke Database (Support 30 Soal sekaligus)
    // app/Http/Controllers/Admin/QuestionController.php

public function store(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'kelas'
        ]);
    $questionsData = $request->input('questions');
    $count = 0;

    if ($questionsData) {
        foreach ($questionsData as $data) {
            if (!empty($data['pertanyaan'])) {
                Question::create([
                    'category_id'   => $request->category_id,
                    'pertanyaan'    => $data['pertanyaan'],
                    'opsi_a'        => $data['opsi_a'],
                    'opsi_b'        => $data['opsi_b'],
                    'opsi_c'        => $data['opsi_c'],
                    'opsi_d'        => $data['opsi_d'],
                    'jawaban_benar' => $data['jawaban_benar'],
                    // PAKSA ISI TANGGAL DISINI
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
                $count++;
            }
        }
    }

        // 3. Jika tidak ada soal yang diisi sama sekali
        if ($count == 0) {
            return redirect()->back()->with('error', 'Mohon isi minimal satu pertanyaan.');
        }

        return redirect()->route('admin.dashboard')->with('success', $count . ' Soal berhasil ditambahkan ke bank kuis!');
    }

    public function storeCategory(Request $request)
{
    $request->validate([
        'nama_kategori' => 'required|string|max:255',
        'kelas'         => 'required|in:4,5,6', // Pastikan input kelas ada
    ]);

    \App\Models\Category::create([
        'nama_kategori' => $request->nama_kategori,
        'kelas'         => $request->kelas,
        'created_at'    => now(),
        'updated_at'    => now(),
    ]);

    return redirect()->back()->with('success', 'Kategori kelas ' . $request->kelas . ' berhasil dibuat!');
}
}
