<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class AdminTaskController extends Controller
{
    // List semua tugas (sudah ada)
    public function index()
    {
        $tasks = Task::with(['project', 'assignedUser', 'assignedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.tasks.index', compact('tasks'));
    }

    // Show create form (opsional)
    public function create()
    {
        $projects = Project::orderBy('name')->get();
        $users = \App\Models\User::orderBy('name')->get();

        return view('admin.tasks.create', compact('projects', 'users'));
    }

    // Store task as admin (can assign to any user)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'project_id' => ['required', 'exists:projects,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'description' => ['nullable'],
            'deadline' => ['nullable', 'date'],
            'priority' => ['nullable', 'integer', 'min:1', 'max:3'],
        ]);

        $validated['status'] = 'on_going';
        $validated['assigned_by'] = Auth::id();

        // Create the task
        $task = Task::create($validated);

        /**
         * 🟦 NOTIFIKASI: ADMIN ASSIGN TUGAS KE USER
         */
        if (!empty($validated['assigned_to'])) {
            Notification::create([
                'user_id' => $validated['assigned_to'],
                'type'    => 'assigned_task',
                'title'   => "Tugas Baru Dari Admin",
                'message' => "Admin menugaskan kamu tugas baru: {$task->title}",
                'task_id' => $task->id,
            ]);
        }

        return redirect()->route('admin.tasks.index')->with('success', 'Task dibuat & diassign (jika dipilih).');
    }

    public function edit(Task $task)
    {
        $users = \App\Models\User::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();

        return view('admin.tasks.edit', compact('task', 'users', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'project_id' => ['required', 'exists:projects,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'description' => ['nullable'],
            'deadline' => ['nullable', 'date'],
            'priority' => ['nullable', 'integer', 'min:1', 'max:3'],
            'status' => ['nullable'],
        ]);

        // Simpan assigned_to lama untuk cek apakah ganti user
        $oldAssignedUser = $task->assigned_to;

        // Update task
        $task->update($validated);

        /**
         * 🟦 NOTIFIKASI: ADMIN UPDATE TUGAS YANG SUDAH DIASSIGN
         * Kondisi:
         * - Jika tugas punya assigned_to (baik user lama atau user baru)
         * - Maka user tersebut diberi notifikasi
         */
        if (!empty($task->assigned_to)) {
            Notification::create([
                'user_id' => $task->assigned_to,
                'type'    => 'updated_task',
                'title'   => "Tugas Anda Telah Diperbarui",
                'message' => "Admin memperbarui tugas: {$task->title}",
                'task_id' => $task->id,
            ]);
        }

        return redirect()->route('admin.tasks.index')->with('success', 'Task diperbarui oleh admin.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Task dihapus.');
    }

    public function show(Task $task)
    {
        return view('admin.tasks.show', compact('task'));
    }
}
