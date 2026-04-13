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

        // 1. ambil kategori (Mata Pelajaran) milik guru yang login
        $myCategoryIds = Category::where('user_id', $user->id)->pluck('id');

        // 2. Hitung total soal hanya dari kategori milik guru tersebut
        $totalSoal = Question::whereIn('category_id', $myCategoryIds)->count();

        // 3. Ambil hasil kuis siswa khusus untuk mata pelajaran guru ini
        $recentResults = Result::with(['user', 'category'])
            ->whereIn('category_id', $myCategoryIds)
            ->latest()
            ->take(5)
            ->get();

        // 4. Hitung rata-rata nilai khusus mata pelajaran guru ini
        $rataRataNilai = Result::whereIn('category_id', $myCategoryIds)->avg('skor') ?? 0;

        // 5. Total siswa yang sudah mengerjakan kuis guru ini
        $totalSiswa = Result::whereIn('category_id', $myCategoryIds)->distinct('user_id')->count();

        return view('admin.dashboard', compact('totalSiswa', 'totalSoal', 'rataRataNilai', 'recentResults'));
    }

    // Halaman Form Tambah Soal
    public function create()
    {

        $categories = Category::where('user_id', Auth::id())->get();

        return view('admin.questions.create', compact('categories'));
    }

    // Proses Simpan ke Database (Support 30 Soal sekaligus)
    public function store(Request $request)
    {
        // 1. Validasi kategori
        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);

        $categoryId = $request->category_id;
        $questionsData = $request->input('questions');

        // 2. Loop data soal dari form
        $count = 0;


        if ($questionsData) {
            foreach ($questionsData as $data) {
                // Cek: Hanya simpan jika 'pertanyaan' tidak kosong
                if (!empty($data['pertanyaan'])) {
                    Question::create([
                        'category_id'   => $categoryId,
                        'pertanyaan'    => $data['pertanyaan'],
                        'opsi_a'        => $data['opsi_a'],
                        'opsi_b'        => $data['opsi_b'],
                        'opsi_c'        => $data['opsi_c'],
                        'opsi_d'        => $data['opsi_d'],
                        'jawaban_benar' => $data['jawaban_benar'],
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
}
