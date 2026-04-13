<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Siswa\QuizController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () { return view('welcome'); });

// PENGALIHAN SETELAH LOGIN
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'guru') {
        return redirect()->route('admin.dashboard');
    }
    // Arah rute siswa
    return redirect()->route('siswa.dashboard');
})->middleware(['auth'])->name('dashboard');

// AREA SISWA
Route::middleware(['auth', 'checkRole:siswa'])->group(function () {

    Route::get('/siswa/dashboard', [QuizController::class, 'index'])->name('siswa.dashboard');

    Route::get('/kuis/mulai/{id}', [QuizController::class, 'show'])->name('kuis.show');
    Route::post('/kuis/submit', [QuizController::class, 'submit'])->name('kuis.submit');
});

// AREA GURU
Route::middleware(['auth', 'checkRole:guru'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [QuestionController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('questions', QuestionController::class);
});

require __DIR__.'/auth.php';
