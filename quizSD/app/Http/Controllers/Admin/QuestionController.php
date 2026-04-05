<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Category;
use App\Models\Result;


class QuestionController extends Controller
{

    public function dashboard()
    {
        $totalSiswa = Result::distinct('user_id')->count();
        $totalSoal = Question::count();
        $rataRataNilai = Result::avg('skor');
        $recentResults = Result::with(['user', 'category'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalSiswa', 'totalSoal', 'rataRataNilai', 'recentResults'));
    }


    // Halaman Form Tambah Soal
    public function create()
    {
        $categories = \App\Models\Category::all(); // Ambil kategori untuk dropdown
        return view('admin.questions.create', compact('categories'));
    }

    // Proses Simpan ke Database
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'pertanyaan' => 'required',
            'opsi_a' => 'required',
            'opsi_b' => 'required',
            'opsi_c' => 'required',
            'opsi_d' => 'required',
            'jawaban_benar' => 'required|in:a,b,c,d',
        ]);

        Question::create([
            'category_id' => $request->category_id,
            'pertanyaan' => $request->pertanyaan,
            'opsi_a' => $request->opsi_a,
            'opsi_b' => $request->opsi_b,
            'opsi_c' => $request->opsi_c,
            'opsi_d' => $request->opsi_d,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Soal berhasil ditambahkan ke bank kuis!');
    }
}

