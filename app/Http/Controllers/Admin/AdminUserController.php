<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Halaman daftar semua user
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Halaman detail user
     */
    public function show(User $user)
    {
        // Load relasi minimal
        $user->load(['projects', 'tasks']);

        // ================================
        //        PROYEK USER
        // ================================
        // 1. Proyek yang dibuat user
        $ownedProjects = Project::where('owner_id', $user->id)
            ->withCount([
                'tasks',
                'tasks as done_tasks' => function ($q) {
                    $q->where('status', 'done');
                }
            ])
            ->get();

        // 2. proyek yang ditugaskan via pivot (BETUL)
        $assignedProjects = $user->assignedProjects()
            ->withCount([
                'tasks',
                'tasks as done_tasks' => function ($q) {
                    $q->where('status', 'done');
                }
            ])
            ->get();

        $projects = $ownedProjects->merge($assignedProjects);


        // Hitung progress
        $projects = $projects->map(function ($p) {
            $p->progress = $p->tasks_count == 0
                ? 0
                : (int) round(($p->done_tasks / $p->tasks_count) * 100);
            return $p;
        });


        // ================================
        //        TUGAS USER
        // ================================
        // Task yang ditugaskan ke user
        $tasks = Task::where('assigned_to', $user->id)
            ->with('project')
            ->orderBy('deadline')
            ->get();

        return view('admin.users.show', compact('user', 'projects', 'tasks'));
    }

    /**
     * Menghapus user & semua proyek/tugas terkait
     */
    public function destroy(User $user)
    {
        // Tidak boleh hapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Tidak boleh hapus admin lain
        if ($user->role === 'admin') {
            return back()->with('error', 'Anda tidak dapat menghapus admin lain.');
        }

        // Hapus seluruh proyek yang dimiliki user
        foreach ($user->projects as $project) {
            $project->tasks()->delete();
            $project->delete();
        }

        // Hapus tugas yang ditugaskan admin kepada user
        Task::where('assigned_to', $user->id)->delete();

        // Hapus user
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus beserta seluruh proyek & tugas terkait.');
    }

    /**
     * Form global assign project to a user (admin)
     */
    public function assignProjectForm()
    {
        $users = User::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        return view('admin.users.assign-project', compact('users', 'projects'));
    }

    /**
     * Process global assign project to a user (SINGLE USER)
     * — KODE LAMA — TIDAK DIHAPUS
     */
    public function assignProject(Request $request)
    {
     $data = $request->validate([
        'project_id' => ['required', 'exists:projects,id'],
        'user_id' => ['required', 'exists:users,id'],
     ]);

     $project = Project::findOrFail($data['project_id']);

     // Legacy column (untuk kompatibilitas)
     $project->update([
        'assigned_to' => $data['user_id'],
        'assigned_by' => Auth::id(),
     ]);

     // Pivot many-to-many (penting!)
     $project->assignedUsers()->syncWithoutDetaching([$data['user_id']]);

     return redirect()
        ->route('admin.users.index')
        ->with('success', 'Project berhasil diassign ke user.');
    }


    /**
     * ===============================================
     *  TAMBAHAN BARU — ASSIGN PROJECT TO MULTIPLE USERS
     * ===============================================
     */
    public function assignProjectMultiple(Request $request)
    {
     $data = $request->validate([
        'project_id' => ['required', 'exists:projects,id'],
        'users' => ['required', 'array'],
        'users.*' => ['exists:users,id'],
     ]);

     $project = Project::findOrFail($data['project_id']);

     // Update pivot
     $project->assignedUsers()->sync($data['users']);

     // Update legacy "assigned_to" ikut user pertama
     $first = $data['users'][0] ?? null;

     if ($first) {
        $project->update([
            'assigned_to' => $first,
            'assigned_by' => Auth::id(),
        ]);
     }

     return redirect()
        ->route('admin.users.index')
        ->with('success', 'Project berhasil diassign ke banyak user.');
    }


    /**
     * Form global assign task to a user (admin)
     */
    public function assignTaskForm()
    {
        $users = User::orderBy('name')->get();
        $projects = Project::with('tasks')->orderBy('name')->get();
        return view('admin.users.assign-task', compact('users', 'projects'));
    }

    /**
     * Process create and assign task to a user (admin)
     */
    public function assignTask(Request $request)
    {
        $data = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'deadline' => ['nullable', 'date'],
            'priority' => ['required', 'integer', 'min:1', 'max:3'],
        ]);

        $task = Task::create([
            'project_id' => $data['project_id'],
            'assigned_to' => $data['user_id'],
            'assigned_by' => Auth::id(),
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'deadline' => $data['deadline'] ?? null,
            'priority' => $data['priority'],
            'status' => 'on_going',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Tugas berhasil dibuat dan diassign ke user.');
    }
}
