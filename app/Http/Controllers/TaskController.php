<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected function ensureProjectOwner(Project $project): void
    {
        abort_if($project->owner_id !== Auth::id(), 403);
    }

    protected function ensureTaskBelongsToProject(Project $project, Task $task): void
    {
        abort_if($task->project_id !== $project->id, 404);
    }

    /**
     * Check whether current user can modify (edit/delete) the task.
     * Business rule: only the user who assigned/created the task (assigned_by) can modify it.
     */
    protected function ensureUserCanModifyTask(Task $task): void
    {
        abort_if((int)$task->assigned_by !== (int)Auth::id(), 403);
    }

    /**
     * SEMUA TUGAS USER (tugas yang ditugaskan ke user)
     */
    public function allTasks(Request $request)
    {
        $user = Auth::user();
        $highlight = $request->query('highlight');

        // ❗ Card 1 — Tugas yang user buat sendiri
        $myCreatedTasks = Task::where('assigned_by', $user->id)
            ->orderBy('status')
            ->orderBy('priority', 'desc')
            ->orderBy('deadline')
            ->with('project')
            ->get();

        // ❗ Card 2 — Tugas yang ditugaskan ke user (oleh orang lain)
        $assignedToMe = Task::where('assigned_to', $user->id)
            ->where('assigned_by', '!=', $user->id)
            ->orderBy('status')
            ->orderBy('priority', 'desc')
            ->orderBy('deadline')
            ->with('project')
            ->get();

        // Proyek user
        $ownedProjects = Project::where('owner_id', $user->id)->with('tasks')->get();
        $legacyAssignedProjects = Project::where('assigned_to', $user->id)->with('tasks')->get();
        $pivotAssignedProjects = $user->assignedProjects()->with('tasks')->get();

        // Gabungkan semua proyek tanpa duplikat
        $projects = $ownedProjects
            ->merge($legacyAssignedProjects)
            ->merge($pivotAssignedProjects)
            ->unique('id')
            ->values();

        // Alias untuk blade lama
        $tasksAssigned = $assignedToMe;

        return view('tasks.all', [
            'myCreatedTasks' => $myCreatedTasks,
            'assignedToMe'   => $assignedToMe,
            'projects'       => $projects,
            'tasksAssigned'  => $tasksAssigned,
            'highlight'      => $highlight,
        ]);
    }

    /**
     * TASK PER PROJECT
     */
    public function index(Project $project)
    {
        $userId = Auth::id();
        $isOwner = $project->owner_id == $userId;
        $inPivot = $project->assignedUsers()->where('users.id', $userId)->exists();

        if (!$isOwner && !$inPivot) {
            abort(403);
        }

        $tasks = Task::where('project_id', $project->id)
            ->where('assigned_to', $userId)
            ->orderBy('status')
            ->orderBy('priority', 'desc')
            ->orderBy('deadline')
            ->get();

        return view('tasks.index', [
            'project' => $project,
            'tasks'   => $tasks,
            'editing' => null,
        ]);
    }

    /**
     * SIMPAN TUGAS
     *
     * NOTE: Di aplikasi kamu user biasa hanya membuat tugas untuk dirinya sendiri.
     * Jika ada tempat admin membuat/assign tugas (AdminTaskController), tambahkan logic notif di sana juga.
     */
    public function store(Request $request, Project $project)
    {
        $this->ensureProjectOwner($project);

        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['nullable'],
            'deadline' => ['nullable', 'date'],
            'priority' => ['required', 'integer', 'min:1', 'max:3'],
        ]);

        $validated['status'] = 'on_going';
        $validated['project_id'] = $project->id;

        // This controller is used when a user creates a task for themself (project owner).
        $validated['assigned_to'] = Auth::id();
        $validated['assigned_by'] = Auth::id();

        $task = Task::create($validated);

        // -------------------------------
        // NOTIF: user membuat tugas untuk diri sendiri
        // Rule from you: when user creates a task for themself -> notify that user
        // -------------------------------
        Notification::create([
            'user_id'   => Auth::id(),
            'type'      => 'new_task',
            'title'     => 'Tugas Baru Dibuat',
            'message'   => "Kamu membuat tugas baru: {$task->title}",
            'task_id'   => $task->id,
            'is_read'   => false,
        ]);

        return redirect()
            ->route('projects.tasks.index', $project)
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    // EDIT
    public function edit(Project $project, Task $task)
    {
        $this->ensureProjectOwner($project);
        $this->ensureTaskBelongsToProject($project, $task);

        $this->ensureUserCanModifyTask($task);

        $tasks = $project->tasks()
            ->orderBy('status')
            ->orderBy('priority', 'desc')
            ->orderBy('deadline')
            ->get();

        return view('tasks.index', [
            'project' => $project,
            'tasks'   => $tasks,
            'editing' => $task,
        ]);
    }

    // UPDATE
    public function update(Request $request, Project $project, Task $task)
    {
        $this->ensureProjectOwner($project);
        $this->ensureTaskBelongsToProject($project, $task);

        // Only the creator (assigned_by) can modify — enforced by ensureUserCanModifyTask
        $this->ensureUserCanModifyTask($task);

        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['nullable'],
            'deadline' => ['nullable', 'date'],
            'priority' => ['required', 'integer', 'min:1', 'max:3'],
        ]);

        $task->update($validated);

        // -------------------------------
        // NOTIF: admin updated a task assigned to a user
        // Rule: only notify assigned user when admin (assigned_by) updates a task that belongs to them
        // (user cannot edit admin tasks in your system, so this is safe)
        // -------------------------------
        // If the updater is the assigned_by (owner/admin) and the assigned_to is someone else -> notify assigned_to
        $updaterId = Auth::id();
        if ((int)$task->assigned_by === (int)$updaterId && (int)$task->assigned_to !== (int)$updaterId) {
            // Notify the assignee that admin updated the task
            Notification::create([
                'user_id' => $task->assigned_to,
                'type'    => 'update_task',
                'title'   => 'Tugas Diperbarui',
                'message' => "Tugas \"{$task->title}\" telah diperbarui.",
                'task_id' => $task->id,
                'is_read' => false,
            ]);
        }

        return redirect()
            ->route('projects.tasks.index', $project)
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    // HAPUS
    public function destroy(Project $project, Task $task)
    {
        $this->ensureProjectOwner($project);
        $this->ensureTaskBelongsToProject($project, $task);
        $this->ensureUserCanModifyTask($task);

        $task->delete();

        return redirect()
            ->route('projects.tasks.index', $project)
            ->with('success', 'Tugas berhasil dihapus.');
    }

    // TANDAI SELESAI — FINAL BERSIH (versi tunggal)
    public function complete(Request $request, Task $task)
    {
        // allow marking done only if this task is assigned to the current user
        abort_if((int)$task->assigned_to !== (int)Auth::id(), 403);

        $task->update([
            'status'          => 'done',
            'completion_note' => $request->completion_note
        ]);

        // -------------------------------
        // NOTIF: user completes task
        // Rule: if user completes a task that was assigned by someone else (admin),
        // notify the assigned_by (admin). If user completes their own created task => NO notif.
        // -------------------------------
        if ($task->assigned_by && (int)$task->assigned_by !== (int)Auth::id()) {
            Notification::create([
                'user_id' => $task->assigned_by,
                'type'    => 'finish_task',
                'title'   => 'Tugas Telah Diselesaikan',
                'message' => Auth::user()->name . " telah menyelesaikan tugas: \"{$task->title}\"",
                'task_id' => $task->id,
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'Tugas berhasil ditandai selesai.');
    }
}
