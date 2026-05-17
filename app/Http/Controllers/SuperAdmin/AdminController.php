<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Result;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalGuru = User::where('role', 'guru')->count();
        $totalSiswa = User::where('role', 'siswa')->count();
        // Assume classes are defined by distinct classes in categories or users
        $totalKelas = Category::distinct('kelas')->count('kelas');
        if($totalKelas == 0) {
            $totalKelas = 3; // 4, 5, 6
        }
        $totalHasil = Result::count();
        
        $recentUsers = User::latest()->take(5)->get();
        $recentResults = Result::with(['user', 'category'])->latest()->take(5)->get();
        $kelasDashboard = $this->classDashboardSummary();
        [$progressLabels, $classProgress] = $this->classProgressData();

        return view('superadmin.dashboard', compact(
            'totalGuru',
            'totalSiswa',
            'totalKelas',
            'totalHasil',
            'recentUsers',
            'recentResults',
            'kelasDashboard',
            'progressLabels',
            'classProgress'
        ));
    }

    public function users(Request $request)
    {
        $query = User::query();
        
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }
        
        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('email', 'like', '%' . $request->q . '%');
            });
        }
        
        $users = $query->latest()->paginate(15)->withQueryString();
        
        return view('superadmin.users.index', compact('users'));
    }

    public function classes()
    {
        $kelasCards = collect([4, 5, 6])->mapWithKeys(function ($kelas) {
            $resultQuery = Result::whereHas('user', fn ($query) => $query
                ->where('role', 'siswa')
                ->where('kelas', $kelas)
            );

            return [$kelas => [
                'total_siswa' => User::where('role', 'siswa')->where('kelas', $kelas)->count(),
                'total_guru' => Category::where('kelas', $kelas)->distinct('user_id')->count('user_id'),
                'total_kategori' => Category::where('kelas', $kelas)->count(),
                'total_hasil' => (clone $resultQuery)->count(),
                'rata_rata' => round((clone $resultQuery)->avg('skor') ?? 0, 1),
                'nilai_tertinggi' => (clone $resultQuery)->max('skor') ?? 0,
            ]];
        });

        return view('superadmin.classes.index', compact('kelasCards'));
    }

    public function classDetail(int $kelas)
    {
        abort_unless(in_array($kelas, [4, 5, 6], true), 404);

        $resultQuery = Result::whereHas('user', fn ($query) => $query
            ->where('role', 'siswa')
            ->where('kelas', $kelas)
        );

        $summary = [
            'total_siswa' => User::where('role', 'siswa')->where('kelas', $kelas)->count(),
            'total_kategori' => Category::where('kelas', $kelas)->count(),
            'total_hasil' => (clone $resultQuery)->count(),
            'rata_rata' => round((clone $resultQuery)->avg('skor') ?? 0, 1),
            'lulus' => (clone $resultQuery)->where('skor', '>=', 75)->count(),
            'remedial' => (clone $resultQuery)->where('skor', '<', 75)->count(),
        ];

        $students = User::where('role', 'siswa')
            ->where('kelas', $kelas)
            ->withCount('results')
            ->withAvg('results', 'skor')
            ->withMax('results', 'skor')
            ->orderBy('name')
            ->paginate(12);

        $categories = Category::with('user')
            ->withCount(['questions', 'results'])
            ->where('kelas', $kelas)
            ->orderBy('nama_kategori')
            ->get();

        $recentResults = Result::with(['user', 'category'])
            ->whereHas('user', fn ($query) => $query->where('kelas', $kelas))
            ->latest()
            ->take(10)
            ->get();

        $topStudents = User::where('role', 'siswa')
            ->where('kelas', $kelas)
            ->whereHas('results')
            ->withAvg('results', 'skor')
            ->withMax('results', 'skor')
            ->orderByDesc('results_avg_skor')
            ->take(5)
            ->get();

        return view('superadmin.classes.show', compact(
            'kelas',
            'summary',
            'students',
            'categories',
            'recentResults',
            'topStudents'
        ));
    }

    public function results(Request $request)
    {
        $query = Result::with(['user', 'category']);
        
        if ($request->filled('kelas')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }
        
        if ($request->filled('q')) {
            $query->where(function($subQuery) use ($request) {
                $subQuery->whereHas('user', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->q . '%')
                      ->orWhere('kelas', 'like', '%' . $request->q . '%');
                })->orWhereHas('category', function($q) use ($request) {
                    $q->where('nama_kategori', 'like', '%' . $request->q . '%');
                });
            });
        }
        
        $results = $query->latest()->paginate(15)->withQueryString();
        $categories = collect([4, 5, 6]);
        
        return view('superadmin.results.index', compact('results', 'categories'));
    }
    public function create()
    {
        return view('superadmin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,guru,siswa'],
            'kelas' => ['nullable', 'required_if:role,siswa', 'in:4,5,6'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => $validated['role'],
            'kelas' => $validated['role'] === 'siswa' ? $validated['kelas'] : null,
        ]);

        return redirect()->route('superadmin.users')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('superadmin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', \Illuminate\Validation\Rule::unique(User::class)->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'in:admin,guru,siswa'],
            'kelas' => ['nullable', 'required_if:role,siswa', 'in:4,5,6'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'kelas' => $validated['role'] === 'siswa' ? $validated['kelas'] : null,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('superadmin.users')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    private function classDashboardSummary()
    {
        return collect([4, 5, 6])->mapWithKeys(function ($kelas) {
            $resultQuery = Result::whereHas('user', fn ($query) => $query
                ->where('role', 'siswa')
                ->where('kelas', $kelas)
            );

            return [$kelas => [
                'siswa' => User::where('role', 'siswa')->where('kelas', $kelas)->count(),
                'mapel' => Category::where('kelas', $kelas)->count(),
                'hasil' => (clone $resultQuery)->count(),
                'rata' => round((clone $resultQuery)->avg('skor') ?? 0, 1),
            ]];
        });
    }

    private function classProgressData(): array
    {
        $dates = collect(range(6, 0))->map(fn ($daysAgo) => now()->subDays($daysAgo));
        $labels = $dates->map(fn ($date) => $date->translatedFormat('d M'))->values();

        $progress = collect([4, 5, 6])->mapWithKeys(function ($kelas) use ($dates) {
            return [$kelas => $dates->map(function ($date) use ($kelas) {
                return round(Result::whereHas('user', fn ($query) => $query->where('kelas', $kelas))
                    ->whereDate('created_at', $date->toDateString())
                    ->avg('skor') ?? 0, 1);
            })->values()];
        });

        return [$labels, $progress];
    }
}
