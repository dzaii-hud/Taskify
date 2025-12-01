<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // STATISTIK
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $tasksDone = Task::where('status', 'done')->count();
        $tasksOngoing = $totalTasks - $tasksDone;

        // 5 USER TERBARU
        $latestUsers = User::latest()->limit(5)->get();

        // 5 PROYEK TERBARU (WITH PROGRESS)
        $latestProjects = Project::withCount([
            'tasks',
            'tasks as done_tasks' => function ($q) {
                $q->where('status', 'done');
            }
        ])
        ->latest()
        ->limit(5)
        ->get()
        ->map(function ($p) {
            $p->progress = $p->tasks_count == 0
                ? 0
                : (int) round(($p->done_tasks / $p->tasks_count) * 100);
            return $p;
        });

        return view('admin.dashboardadmin', compact(
            'totalUsers',
            'totalAdmins',
            'totalProjects',
            'totalTasks',
            'tasksDone',
            'tasksOngoing',
            'latestUsers',        // <- nama variabel sudah benar
            'latestProjects'      // <- nama variabel sudah benar
        ));
    }
}
