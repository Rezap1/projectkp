<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Siswa\QuizController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\SuperAdmin\AdminController as SuperAdminController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () { return view('welcome'); });

// PENGALIHAN SETELAH LOGIN
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('superadmin.dashboard');
    }
    if (Auth::user()->role === 'guru') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('siswa.dashboard');
})->middleware(['auth'])->name('dashboard');

// Profil Dinonaktifkan untuk user biasa demi keamanan
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// AREA SISWA
Route::middleware(['auth', 'checkRole:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [QuizController::class, 'index'])->name('siswa.dashboard');

    // Route Mulai Kuis
    Route::get('/kuis/mulai/{id}', [QuizController::class, 'show'])->name('kuis.show');

    // PERBAIKAN: Tambahkan parameter {category_id} agar sinkron dengan Controller submit
    Route::post('/kuis/submit/{category_id}', [QuizController::class, 'submit'])->name('kuis.submit');

    // PERBAIKAN: Pindahkan Review ke dalam Middleware Siswa agar aman
    Route::get('/kuis/review/siswa/{category_id}', [QuizController::class, 'review'])->name('kuis.review');
});

// AREA GURU
Route::middleware(['auth', 'checkRole:guru'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [QuestionController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/categories', [QuestionController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [QuestionController::class, 'storeCategory'])->name('categories.store');
    Route::patch('/categories/{category}', [QuestionController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [QuestionController::class, 'destroyCategory'])->name('categories.destroy');
    Route::get('/results', [QuestionController::class, 'results'])->name('results.index');
    Route::get('/results/pdf', [QuestionController::class, 'resultsPdf'])->name('results.pdf');
    Route::delete('/results/{result}', [QuestionController::class, 'destroyResult'])->name('results.destroy');
    Route::resource('questions', QuestionController::class)->except(['show']);
});

// AREA ADMIN (SUPERADMIN)
Route::middleware(['auth', 'checkRole:admin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/users', [SuperAdminController::class, 'users'])->name('superadmin.users');
    Route::get('/users/create', [SuperAdminController::class, 'create'])->name('superadmin.users.create');
    Route::post('/users', [SuperAdminController::class, 'store'])->name('superadmin.users.store');
    Route::get('/users/{user}/edit', [SuperAdminController::class, 'edit'])->name('superadmin.users.edit');
    Route::patch('/users/{user}', [SuperAdminController::class, 'update'])->name('superadmin.users.update');
    Route::delete('/users/{user}', [SuperAdminController::class, 'destroy'])->name('superadmin.users.destroy');
    Route::get('/classes', [SuperAdminController::class, 'classes'])->name('superadmin.classes');
    Route::get('/classes/{kelas}', [SuperAdminController::class, 'classDetail'])->name('superadmin.classes.show');
    Route::get('/results', [SuperAdminController::class, 'results'])->name('superadmin.results');
});

require __DIR__.'/auth.php';
