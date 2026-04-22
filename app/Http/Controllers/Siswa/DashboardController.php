<?php

namespace App\Http\Controllers\Siswa;

// Memanggil file Controller yang baru kita buat tadi
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $listKuis = Category::all();
        $skorTertinggi = 0;

        return view('siswa.dashboard', compact('listKuis', 'skorTertinggi'));
    }
}
