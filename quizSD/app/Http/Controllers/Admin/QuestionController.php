<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\Result;
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
            'durasi' => ['required', 'integer', 'min:1', 'max:180'],
        ]);

        $category->update([
            'nama_kategori' => $validated['nama_kategori'],
            'kelas' => $validated['kelas'],
            'durasi' => $validated['durasi'],
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
        $categoryIds = $this->ownedCategories()->pluck('id');
        $categories = $this->ownedCategories()->orderBy('kelas')->orderBy('nama_kategori')->get();

        $resultsQuery = Result::with(['user', 'category'])
            ->whereIn('category_id', $categoryIds)
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('kelas'), fn ($query) => $query->whereHas('user', fn ($user) => $user->where('kelas', $request->kelas)))
            ->when($request->filled('tanggal'), fn ($query) => $query->whereDate('created_at', $request->tanggal))
            ->when($request->filled('q'), fn ($query) => $query->whereHas('user', fn ($user) => $user->where('name', 'like', '%' . $request->q . '%')));

        $summary = [
            'total' => (clone $resultsQuery)->count(),
            'avg' => (clone $resultsQuery)->avg('skor') ?? 0,
            'passed' => (clone $resultsQuery)->where('skor', '>=', 75)->count(),
            'remedial' => (clone $resultsQuery)->where('skor', '<', 75)->count(),
        ];

        $results = $resultsQuery->latest()->paginate(15)->withQueryString();

        return view('admin.results.index', compact('categories', 'results', 'summary'));
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
}
