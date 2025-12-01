<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// USER CONTROLLERS
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\NotificationController;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminTaskController;
use App\Http\Controllers\Admin\AdminTeamController;
use App\Http\Controllers\Admin\AdminStatistikController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// 👤 Profile
Route::view('/profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


// =============================================================
// 📌 FIX: Explicit route-model-binding untuk Task
// agar tidak terpengaruh nested routes {project}/{task}
// =============================================================
Route::bind('task', function ($id) {
    return \App\Models\Task::findOrFail($id);
});


// ==========================================================================
// 🟦 USER ROUTES (ROLE: user)
// ==========================================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // 📊 Dashboard User
    Route::get('/dashboard', function () {

        $userId = Auth::id();

        $projects = \App\Models\Project::where(function ($q) use ($userId) {
                $q->where('owner_id', $userId)
                  ->orWhere('assigned_to', $userId)
                  ->orWhereHas('assignedUsers', function ($q2) use ($userId) {
                      $q2->where('users.id', $userId);
                  });
            })
            ->withCount([
                'tasks as total_tasks',
                'tasks as done_tasks' => function ($q) {
                    $q->where('status', 'done');
                },
            ])
            ->get()
            ->map(function ($project) {
                $project->progress = $project->total_tasks == 0
                    ? 0
                    : (int) round(($project->done_tasks / $project->total_tasks) * 100);
                return $project;
            });

        return view('user.dashboarduser', compact('projects'));
    })->name('dashboard');



    // ➤ Semua Tugas User
    Route::get('/tasks', [TaskController::class, 'allTasks'])
        ->name('tasks.all');

    // ➤ Tandai Selesai
    Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])
        ->name('tasks.complete');


    // 📦 CRUD PROJECT (USER)
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // 🧩 TASK CRUD PER PROYEK
    Route::prefix('projects/{project}')->group(function () {

        Route::get('/tasks', [TaskController::class, 'index'])->name('projects.tasks.index');
        Route::post('/tasks', [TaskController::class, 'store'])->name('projects.tasks.store');

        Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('projects.tasks.edit');
        Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('projects.tasks.update');

        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('projects.tasks.destroy');
    });


    // 📈 Statistik User (HALAMAN)
    Route::get('/statistik', [StatsController::class, 'index'])
    ->name('statistik.index');

    // 📡 REAL-TIME STATISTIK DATA (AJAX FETCH)
    Route::get('/statistik/data', function () {

    $userId = Auth::id();

    // ✓ Ambil semua project milik user (tugas pribadi)
    $userProjects = \App\Models\Project::where('owner_id', $userId)->pluck('id');

    // ✓ Statistik = tugas dari project user + tugas assigned admin
    $combinedTasks = \App\Models\Task::where(function ($q) use ($userProjects, $userId) {
        $q->whereIn('project_id', $userProjects)
          ->orWhere('assigned_to', $userId);
    });

    return response()->json([
        'total'     => $combinedTasks->count(),
        'completed' => (clone $combinedTasks)->where('status', 'done')->count(),
        'ongoing'   => (clone $combinedTasks)->where('status', 'on_going')->count(),
        'pending'   => (clone $combinedTasks)->where('status', 'pending')->count(),
    ]);

    })->name('statistik.data');

    // 🔔 NOTIFICATION ROUTES

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])
        ->name('notifications.read');

    Route::post('/notifications/read/all', [NotificationController::class, 'markAllRead'])
        ->name('notifications.readAll');

    // DETAIL NOTIFICATION

    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])
        ->name('notifications.show');


});




// ==========================================================================
// 🟥 ADMIN ROUTES (ROLE: admin)
// ==========================================================================
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // ======================
        // USER MANAGEMENT
        // ======================
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // ======================
        // PROJECT MANAGEMENT
        // ======================
        Route::get('/projects', [AdminProjectController::class, 'index'])
            ->name('projects.index');

        Route::get('/projects/create', [AdminProjectController::class, 'create'])
            ->name('projects.create');
        Route::post('/projects', [AdminProjectController::class, 'store'])
            ->name('projects.store');

        Route::get('/projects/{project}/assign', [AdminProjectController::class, 'assignForm'])
            ->name('projects.assignForm');
        Route::post('/projects/{project}/assign', [AdminProjectController::class, 'assign'])
            ->name('projects.assign');

        Route::get('/projects/{project}', [AdminProjectController::class, 'show'])
            ->name('projects.show');

        // ======================
        // TASK MANAGEMENT
        // ======================
        Route::get('/tasks', [AdminTaskController::class, 'index'])->name('tasks.index');

        Route::get('/tasks/create', [AdminTaskController::class, 'create'])->name('tasks.create');
        Route::post('/tasks', [AdminTaskController::class, 'store'])->name('tasks.store');

        Route::get('/tasks/{task}/edit', [AdminTaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/tasks/{task}', [AdminTaskController::class, 'update'])->name('tasks.update');

        Route::delete('/tasks/{task}', [AdminTaskController::class, 'destroy'])->name('tasks.destroy');

        // ======================
        // REPORTS + SETTINGS
        // ======================
        Route::view('/reports', 'admin.placeholder', ['title' => 'Laporan Sistem'])->name('reports');
        Route::view('/settings', 'admin.placeholder', ['title' => 'Pengaturan Sistem'])->name('settings');

        // ======================
        // TEAM MANAGEMENT (BARU)
        // ======================
        Route::get('/teams/create', [AdminTeamController::class, 'create'])
            ->name('teams.create');
        Route::post('/teams', [AdminTeamController::class, 'store'])
            ->name('teams.store');

        // ======================
        // GLOBAL ASSIGN (BARU)
        // ======================
        Route::get('/assign/project', [AdminUserController::class, 'assignProjectForm'])
            ->name('assign.project.form');
        Route::post('/assign/project', [AdminUserController::class, 'assignProject'])
            ->name('assign.project');

        Route::get('/assign/task', [AdminUserController::class, 'assignTaskForm'])
            ->name('assign.task.form');
        Route::post('/assign/task', [AdminUserController::class, 'assignTask'])
            ->name('assign.task');

        Route::post('/projects/{project}/assign/multi', [AdminProjectController::class, 'assignMultiple'])
            ->name('projects.assignMultiple');

        // ====================================================
        // MULTIPLE ASSIGN PROJECT (FIXED)
        // ====================================================
        Route::post('/assign/project/multiple', [AdminUserController::class, 'assignProjectMultiple'])
            ->name('assign.project.multiple'); // FIXED — remove double admin!

        Route::resource('projects', AdminProjectController::class);


        Route::get('/tasks/{task}', [AdminTaskController::class, 'show'])
            ->name('tasks.show');


        // =======================================
        // ADMIN NOTIFICATIONS (FINAL FIX)
        // =======================================
        Route::get('/notifications', [\App\Http\Controllers\Admin\AdminNotificationController::class, 'index'])
            ->name('notifications.index');

        // Detail notifikasi
        Route::get('/notifications/{id}', [\App\Http\Controllers\Admin\AdminNotificationController::class, 'show'])
            ->name('notifications.show');

        // Tandai satu notif sebagai dibaca
        Route::post('/notifications/mark-read/{id}', [\App\Http\Controllers\Admin\AdminNotificationController::class, 'markRead'])
            ->name('notifications.read');

        // Tandai semua notif sebagai dibaca
        Route::post('/notifications/mark-all-read', [\App\Http\Controllers\Admin\AdminNotificationController::class, 'markAllRead'])
            ->name('notifications.markAllRead');


        // =======================================
        // ADMIN STATISTIK
        // =======================================
        Route::get('/statistik', [AdminStatistikController::class, 'index'])
            ->name('statistik.index');

    });


// 🔑 Auth Routes
require __DIR__ . '/auth.php';
