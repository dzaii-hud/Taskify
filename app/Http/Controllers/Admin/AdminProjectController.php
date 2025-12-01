<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProjectController extends Controller
{
    /**
     * Halaman daftar semua proyek
     */
    public function index()
    {
        $projects = Project::withCount([
            'tasks',
            'tasks as done_tasks' => function ($q) {
                $q->where('status', 'done');
            }
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        // Hitung progress untuk tiap proyek
        $projects->getCollection()->transform(function ($p) {
            $p->progress = $p->tasks_count == 0
                ? 0
                : (int) round(($p->done_tasks / $p->tasks_count) * 100);
            return $p;
        });

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Halaman detail proyek (admin melihat detail)
     */
    public function show(Project $project)
    {
        $project->load([
            'tasks',
            'tasks.assignedUser',
            'owner',
            'assignedUser',
            'assignedUsers', // <--- TAMBAHAN BARU, TIDAK MENGGANGGU YANG LAMA
        ]);

        // hitung progress
        $total = $project->tasks->count();
        $done  = $project->tasks->where('status', 'done')->count();
        $project->progress = $total == 0 ? 0 : (int) round(($done / $total) * 100);

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Halaman form assign proyek ke user (single atau multiple)
     */
    public function assignForm(Project $project)
    {
        $users = User::orderBy('name')->get();
        return view('admin.projects.assign', compact('project', 'users'));
    }

    /**
     * Proses assign proyek (single) — keep backward compatibility
     */
    public function assign(Request $request, Project $project)
    {
        $data = $request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
        ]);

        $project->update([
            'assigned_to' => $data['assigned_to'],
            'assigned_by' => Auth::id(),
        ]);

        // sync pivot as well (avoid removing others if you want to keep them use syncWithoutDetaching)
        $project->assignedUsers()->syncWithoutDetaching([$data['assigned_to']]);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project berhasil diassign.');
    }

    /**
     * Halaman form create project (Admin)
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.projects.create', compact('users'));
    }

    /**
     * Simpan proyek baru yang dibuat admin
     *
     * IMPORTANT:
     * - Jika admin memilih user(s) untuk assign, owner_id akan di-set ke user pertama yang dipilih.
     * - Jika tidak memilih user, owner_id akan diset ke admin (agar tidak melanggar NOT NULL pada migration).
     * - Jika memilih multiple (array), kita sync pivot table project_user.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'deadline' => ['nullable', 'date'],
            // allow single id or array (for future multiple assign support)
            'assigned_to' => ['nullable'],
        ]);

        // Normalize assigned_to: can be comma-separated string, array, or single id.
        $assigned = $data['assigned_to'] ?? null;

        // if it's a JSON/array from form (multiple), keep it
        if (is_string($assigned) && str_contains($assigned, ',')) {
            $assignedArr = array_filter(array_map('trim', explode(',', $assigned)));
        } elseif (is_array($assigned)) {
            $assignedArr = $assigned;
        } elseif ($assigned) {
            $assignedArr = [$assigned];
        } else {
            $assignedArr = [];
        }

        // owner_id: if admin assigned at least one user, set owner to first assigned user
        $ownerId = count($assignedArr) ? (int) $assignedArr[0] : Auth::id();

        // Create project — assigned_to (legacy single column) set to first user if exists
        $project = Project::create([
            'owner_id'    => $ownerId,
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'deadline'    => $data['deadline'] ?? null,
            'status'      => 'ongoing',
            'assigned_to' => count($assignedArr) ? (int) $assignedArr[0] : null,
            'assigned_by' => Auth::id(),
        ]);

        // If multiple assigned users provided, sync pivot
        if (!empty($assignedArr)) {
            // ensure ints
            $ids = array_map('intval', $assignedArr);
            // syncWithoutDetaching to keep existing assignments if needed; you can change to sync() if you want replace
            $project->assignedUsers()->sync($ids);
        }

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Proyek berhasil dibuat.');
    }

    /**
     * Assign MULTIPLE users ke project (Pivot Many-to-Many)
     */
    public function assignMultiple(Request $request, Project $project)
    {
        $data = $request->validate([
            'assigned_to' => ['required', 'array'],
            'assigned_to.*' => ['exists:users,id'],
        ]);

        $project->assignedUsers()->sync($data['assigned_to']);

        // update assigned_to legacy column with first id (optional)
        $first = $data['assigned_to'][0] ?? null;
        if ($first) {
            $project->update([
                'assigned_to' => $first,
                'assigned_by' => Auth::id(),
            ]);
        }

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project berhasil diassign ke banyak user.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'description' => ['nullable'],
        ]);

        $project->update($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }
}
