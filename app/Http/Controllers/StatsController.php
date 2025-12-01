<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Project;

class StatsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // ✓ Ambil semua project yang dibuat user
        $userProjects = Project::where('owner_id', $userId)->pluck('id');

        // ✓ Ambil semua tugas yang dibuat user lewat project
        $tasksFromUserProjects = Task::whereIn('project_id', $userProjects);

        // ✓ Ambil semua tugas yang diberikan admin ke user
        $tasksAssignedByAdmin = Task::where('assigned_to', $userId);

        // Gabung dua sumber tugas
        $combinedTasks = Task::where(function ($q) use ($userProjects, $userId) {
            $q->whereIn('project_id', $userProjects)
              ->orWhere('assigned_to', $userId);
        });

        // Hitung statistik
        $total      = $combinedTasks->count();
        $completed  = (clone $combinedTasks)->where('status', 'done')->count();
        $ongoing    = (clone $combinedTasks)->where('status', 'on_going')->count();
        $pending    = (clone $combinedTasks)->where('status', 'pending')->count();

        $chartData = [
            'completed' => $completed,
            'ongoing'   => $ongoing,
        ];

        return view('stats.index', compact(
            'total',
            'completed',
            'ongoing',
            'pending',
            'chartData'
        ));
    }
}
