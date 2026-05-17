<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\Result;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $today = now()->toDateString();
        $myCategoryIds = Category::where('user_id', $user->id)->pluck('id');

        $totalKategori = $myCategoryIds->count();
        $totalSoal = Question::whereIn('category_id', $myCategoryIds)->count();
        $totalHasil = Result::whereIn('category_id', $myCategoryIds)->count();

        $totalSiswaHariIni = Result::whereIn('category_id', $myCategoryIds)
            ->whereDate('created_at', $today)
            ->distinct('user_id')
            ->count('user_id');

        $rataRataNilai = Result::whereIn('category_id', $myCategoryIds)
            ->whereDate('created_at', $today)
            ->avg('skor') ?? 0;

        $aktivitasKelas4 = $this->activityByClass(4, $myCategoryIds, $today);
        $aktivitasKelas5 = $this->activityByClass(5, $myCategoryIds, $today);
        $aktivitasKelas6 = $this->activityByClass(6, $myCategoryIds, $today);

        $rankKelas4 = $this->rankByClass(4, $myCategoryIds);
        $rankKelas5 = $this->rankByClass(5, $myCategoryIds);
        $rankKelas6 = $this->rankByClass(6, $myCategoryIds);

        $categorySummary = Category::withCount(['questions', 'results'])
            ->where('user_id', $user->id)
            ->orderBy('kelas')
            ->orderBy('nama_kategori')
            ->take(6)
            ->get();

        $recentQuestions = Question::with('category')
            ->whereIn('category_id', $myCategoryIds)
            ->latest()
            ->take(5)
            ->get();

        $kelasStats = collect([4, 5, 6])->mapWithKeys(function ($kelas) use ($myCategoryIds) {
            return [$kelas => [
                'kategori' => Category::whereIn('id', $myCategoryIds)->where('kelas', $kelas)->count(),
                'soal' => Question::whereHas('category', fn ($query) => $query
                    ->whereIn('id', $myCategoryIds)
                    ->where('kelas', $kelas)
                )->count(),
                'rata' => Result::whereIn('category_id', $myCategoryIds)
                    ->whereHas('user', fn ($query) => $query->where('kelas', $kelas))
                    ->avg('skor') ?? 0,
            ]];
        });

        return view('admin.dashboard', compact(
            'totalKategori',
            'totalSoal',
            'totalHasil',
            'totalSiswaHariIni',
            'rataRataNilai',
            'aktivitasKelas4',
            'aktivitasKelas5',
            'aktivitasKelas6',
            'rankKelas4',
            'rankKelas5',
            'rankKelas6',
            'categorySummary',
            'recentQuestions',
            'kelasStats'
        ));
    }

    public function index(Request $request)
    {
        $categories = $this->ownedCategories()->orderBy('kelas')->orderBy('nama_kategori')->get();

        $questions = Question::with('category')
            ->whereHas('category', fn ($query) => $query->where('user_id', Auth::id()))
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('kelas'), fn ($query) => $query->whereHas('category', fn ($category) => $category->where('kelas', $request->kelas)))
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where(function ($search) use ($request) {
                    $term = '%' . $request->q . '%';
                    $search->where('pertanyaan', 'like', $term)
                        ->orWhere('opsi_a', 'like', $term)
                        ->orWhere('opsi_b', 'like', $term)
                        ->orWhere('opsi_c', 'like', $term)
                        ->orWhere('opsi_d', 'like', $term);
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.questions.index', compact('categories', 'questions'));
    }

    public function create()
    {
        $categories = $this->ownedCategories()->orderBy('kelas')->orderBy('nama_kategori')->get();

        return view('admin.questions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'integer'],
            'durasi' => ['required', 'integer', 'min:1', 'max:180'],
            'questions' => ['required', 'array'],
        ]);

        $category = $this->ownedCategories()->whereKey($request->category_id)->firstOrFail();
        $category->update(['durasi' => $request->durasi]);

        $count = 0;

        foreach ($request->input('questions', []) as $index => $data) {
            if (blank($data['pertanyaan'] ?? null)) {
                continue;
            }

            if (blank($data['jawaban_benar'] ?? null)) {
                return back()
                    ->withInput()
                    ->with('error', 'Kunci jawaban nomor ' . $index . ' belum dipilih.');
            }

            Question::create([
                'category_id' => $category->id,
                'pertanyaan' => $data['pertanyaan'],
                'opsi_a' => $data['opsi_a'] ?? '-',
                'opsi_b' => $data['opsi_b'] ?? '-',
                'opsi_c' => $data['opsi_c'] ?? '-',
                'opsi_d' => $data['opsi_d'] ?? '-',
                'jawaban_benar' => $data['jawaban_benar'],
            ]);

            $count++;
        }

        if ($count === 0) {
            return back()->with('success', 'Timer kuis ' . $category->nama_kategori . ' berhasil diperbarui menjadi ' . $request->durasi . ' menit.');
        }

        return redirect()
            ->route('questions.index')
            ->with('success', $count . ' soal berhasil ditambahkan ke ' . $category->nama_kategori . '.');
    }

    public function edit(Question $question)
    {
        $this->authorizeQuestion($question);

        $categories = $this->ownedCategories()->orderBy('kelas')->orderBy('nama_kategori')->get();

        return view('admin.questions.edit', compact('question', 'categories'));
    }

    public function update(Request $request, Question $question)
    {
        $this->authorizeQuestion($question);

        $validated = $request->validate([
            'category_id' => ['required', 'integer'],
            'pertanyaan' => ['required', 'string'],
            'opsi_a' => ['required', 'string', 'max:255'],
            'opsi_b' => ['required', 'string', 'max:255'],
            'opsi_c' => ['required', 'string', 'max:255'],
            'opsi_d' => ['required', 'string', 'max:255'],
            'jawaban_benar' => ['required', 'in:a,b,c,d'],
        ]);

        $this->ownedCategories()->whereKey($validated['category_id'])->firstOrFail();
        $question->update($validated);

        return redirect()->route('questions.index')->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Question $question)
    {
        $this->authorizeQuestion($question);
        $question->delete();

        return back()->with('success', 'Soal berhasil dihapus dari bank soal.');
    }

    public function categories()
    {
        $categories = Category::withCount(['questions', 'results'])
            ->where('user_id', Auth::id())
            ->orderBy('kelas')
            ->orderBy('nama_kategori')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'in:4,5,6'],
            'durasi' => ['nullable', 'integer', 'min:1', 'max:180'],
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'nama_kategori' => $validated['nama_kategori'],
            'slug' => $this->uniqueCategorySlug($validated['nama_kategori'], $validated['kelas']),
            'kelas' => $validated['kelas'],
            'durasi' => $validated['durasi'] ?? 60,
        ]);

        return back()->with('success', 'Kategori kelas ' . $validated['kelas'] . ' berhasil dibuat.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $this->authorizeCategory($category);

        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'in:4,5,6'],
        ]);

        $category->update([
            'nama_kategori' => $validated['nama_kategori'],
            'kelas' => $validated['kelas'],
            'slug' => $this->uniqueCategorySlug($validated['nama_kategori'], $validated['kelas'], $category->id),
        ]);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyCategory(Category $category)
    {
        $this->authorizeCategory($category);
        $category->delete();

        return back()->with('success', 'Kategori beserta soal dan hasil terkait berhasil dihapus.');
    }

    public function results(Request $request)
    {
        $data = $this->resultsReportData($request);
        $resultsQuery = $data['resultsQuery'];
        unset($data['resultsQuery']);

        $data['results'] = $resultsQuery->latest()->paginate(15)->withQueryString();

        return view('admin.results.index', $data);
    }

    public function resultsPdf(Request $request)
    {
        $data = $this->resultsReportData($request);
        unset($data['resultsQuery']);

        $studentName = $data['selectedStudent']
            ? Str::slug($data['selectedStudent']->name)
            : 'semua-siswa';
        $period = Str::slug($data['printPeriod']);

        $pdf = Pdf::loadView('admin.results.pdf', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download("rekap-{$studentName}-{$period}.pdf");
    }

    private function resultsReportData(Request $request): array
    {
        $categoryIds = $this->ownedCategories()->pluck('id');
        $categories = $this->ownedCategories()->orderBy('kelas')->orderBy('nama_kategori')->get();
        $students = User::where('role', 'siswa')
            ->whereIn('kelas', $categories->pluck('kelas')->filter()->unique())
            ->orderBy('kelas')
            ->orderBy('name')
            ->get();
        $selectedStudent = $request->filled('student_id')
            ? $students->firstWhere('id', (int) $request->student_id)
            : null;
        $monthStart = $this->reportMonthStart($request);
        $monthEnd = $monthStart->copy()->endOfMonth();
        $printPeriod = $monthStart->translatedFormat('F Y');

        $resultsQuery = Result::with(['user', 'category'])
            ->whereIn('category_id', $categoryIds)
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('kelas'), fn ($query) => $query->whereHas('user', fn ($user) => $user->where('kelas', $request->kelas)))
            ->when($request->filled('tanggal'), fn ($query) => $query->whereDate('created_at', $request->tanggal))
            ->when($selectedStudent, fn ($query) => $query->where('user_id', $selectedStudent->id))
            ->when(!$selectedStudent && $request->filled('q'), fn ($query) => $query->whereHas('user', fn ($user) => $user->where('name', 'like', '%' . $request->q . '%')));

        $monthlyQuery = Result::with(['user', 'category'])
            ->whereIn('category_id', $categoryIds)
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('kelas'), fn ($query) => $query->whereHas('user', fn ($user) => $user->where('kelas', $request->kelas)))
            ->when($selectedStudent, fn ($query) => $query->where('user_id', $selectedStudent->id))
            ->when(!$selectedStudent && $request->filled('q'), fn ($query) => $query->whereHas('user', fn ($user) => $user->where('name', 'like', '%' . $request->q . '%')));

        $summary = [
            'total' => (clone $resultsQuery)->count(),
            'avg' => (clone $resultsQuery)->avg('skor') ?? 0,
            'passed' => (clone $resultsQuery)->where('skor', '>=', 75)->count(),
            'remedial' => (clone $resultsQuery)->where('skor', '<', 75)->count(),
        ];

        $monthlySummary = [
            'total' => (clone $monthlyQuery)->count(),
            'avg' => round((clone $monthlyQuery)->avg('skor') ?? 0, 1),
            'passed' => (clone $monthlyQuery)->where('skor', '>=', 75)->count(),
            'remedial' => (clone $monthlyQuery)->where('skor', '<', 75)->count(),
            'students' => (clone $monthlyQuery)->distinct('user_id')->count('user_id'),
            'highest' => (clone $monthlyQuery)->max('skor') ?? 0,
        ];

        $monthlyRanking = Result::with('user')
            ->whereIn('category_id', $categoryIds)
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('kelas') || $selectedStudent, fn ($query) => $query->whereHas('user', fn ($user) => $user->where('kelas', $request->kelas ?: $selectedStudent->kelas)))
            ->when(!$selectedStudent && $request->filled('q'), fn ($query) => $query->whereHas('user', fn ($user) => $user->where('name', 'like', '%' . $request->q . '%')))
            ->selectRaw('user_id, SUM(skor) as total_skor, AVG(skor) as rata_skor, COUNT(*) as total_pengerjaan, MAX(skor) as skor_tertinggi')
            ->groupBy('user_id')
            ->orderByDesc('total_skor')
            ->orderByDesc('rata_skor')
            ->get()
            ->map(function ($rank, $index) {
                $rank->tier = $this->getTierData($rank->total_skor);
                $rank->position = $index + 1;

                return $rank;
            });

        $selectedStudentRank = $selectedStudent
            ? $monthlyRanking->firstWhere('user_id', $selectedStudent->id)
            : null;

        $categoryReport = Result::with('category')
            ->whereIn('category_id', $categoryIds)
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('kelas'), fn ($query) => $query->whereHas('user', fn ($user) => $user->where('kelas', $request->kelas)))
            ->when($selectedStudent, fn ($query) => $query->where('user_id', $selectedStudent->id))
            ->when(!$selectedStudent && $request->filled('q'), fn ($query) => $query->whereHas('user', fn ($user) => $user->where('name', 'like', '%' . $request->q . '%')))
            ->selectRaw('category_id, COUNT(*) as total_pengerjaan, AVG(skor) as rata_skor, MAX(skor) as skor_tertinggi')
            ->groupBy('category_id')
            ->orderByDesc('rata_skor')
            ->get();

        $monthlyResults = (clone $monthlyQuery)->latest()->get();

        $logoPath = public_path('img/logo.png');

        return [
            'categories' => $categories,
            'students' => $students,
            'selectedStudent' => $selectedStudent,
            'selectedStudentRank' => $selectedStudentRank,
            'resultsQuery' => $resultsQuery,
            'summary' => $summary,
            'printPeriod' => $printPeriod,
            'monthlySummary' => $monthlySummary,
            'monthlyRanking' => $monthlyRanking,
            'categoryReport' => $categoryReport,
            'monthlyResults' => $monthlyResults,
            'logoPath' => $logoPath,
            'logoSrc' => extension_loaded('gd') && file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null,
        ];
    }

    public function destroyResult(Result $result)
    {
        $this->authorizeCategory($result->category);
        $result->delete();

        return back()->with('success', 'Hasil siswa berhasil dihapus.');
    }

    private function activityByClass(int $kelas, $categoryIds, string $today)
    {
        return Result::with(['user', 'category'])
            ->whereIn('category_id', $categoryIds)
            ->whereDate('created_at', $today)
            ->whereHas('user', fn ($query) => $query->where('kelas', $kelas))
            ->latest()
            ->get();
    }

    private function rankByClass(int $kelas, $categoryIds)
    {
        return Result::with('user')
            ->whereIn('category_id', $categoryIds)
            ->whereHas('user', fn ($query) => $query->where('kelas', $kelas))
            ->selectRaw('user_id, MAX(skor) as high_score, MAX(created_at) as last_attempt')
            ->groupBy('user_id')
            ->orderByDesc('high_score')
            ->take(10)
            ->get();
    }

    private function ownedCategories()
    {
        return Category::where('user_id', Auth::id());
    }

    private function authorizeQuestion(Question $question): void
    {
        $question->loadMissing('category');
        $this->authorizeCategory($question->category);
    }

    private function authorizeCategory(?Category $category): void
    {
        abort_unless($category && (int) $category->user_id === (int) Auth::id(), 403);
    }

    private function uniqueCategorySlug(string $name, int $kelas, ?int $ignoreId = null): string
    {
        $base = Str::slug($name . '-kelas-' . $kelas . '-' . Auth::id());
        $slug = $base;
        $counter = 2;

        while (Category::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }

    private function reportMonthStart(Request $request): Carbon
    {
        if ($request->filled('bulan') && preg_match('/^\d{4}-\d{2}$/', $request->bulan)) {
            try {
                return Carbon::createFromFormat('Y-m', $request->bulan)->startOfMonth();
            } catch (\Throwable) {
                return now()->startOfMonth();
            }
        }

        return now()->startOfMonth();
    }

    private function getTierData($totalSkor): array
    {
        $score = (int) $totalSkor;

        if ($score >= 2500) {
            return $this->tierPayload('mythical_glory', 'Mythical Glory', 3, '#facc15', '#dc2626', '#6d28d9');
        }

        if ($score >= 1700) {
            return $this->tierPayload('mythic', 'Mythic', $score >= 2000 ? 2 : 1, '#c084fc', '#7c3aed', '#2563eb');
        }

        if ($score >= 800) {
            return $this->tierPayload('legend', 'Legend', $score >= 1400 ? 3 : ($score >= 1100 ? 2 : 1), '#fbbf24', '#f59e0b', '#b45309');
        }

        if ($score >= 50) {
            return $this->tierPayload('epic', 'Epic', $score >= 200 ? 3 : ($score >= 100 ? 2 : 1), '#22d3ee', '#14b8a6', '#059669');
        }

        return $this->tierPayload('warrior', 'Warrior', 1, '#94a3b8', '#64748b', '#44403c');
    }

    private function tierPayload(string $key, string $name, int $stars, string $primary, string $secondary, string $accent): array
    {
        return [
            'key' => $key,
            'name' => $name,
            'stars' => $stars,
            'label' => $name . ' ' . str_repeat('*', $stars),
            'primary' => $primary,
            'secondary' => $secondary,
            'accent' => $accent,
        ];
    }
}
