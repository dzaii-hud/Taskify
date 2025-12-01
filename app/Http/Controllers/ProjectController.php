<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Tampilkan daftar proyek milik user yang login.
     *
     * Sekarang menampilkan:
     * - proyek yang user buat (owner_id)
     * - proyek yang diassign ke user (legacy assigned_to OR pivot assignedUsers)
     *
     * Menggabungkan keduanya dan menghapus duplikat.
     */
    public function index()
    {
        $user = Auth::user();

        // Proyek yang dia buat (owner)
        $owned = Project::where('owner_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Proyek yang diassign ke dia:
        // 1) legacy assigned_to column
        $legacyAssigned = Project::where('assigned_to', $user->id)->get();

        // 2) pivot assignedUsers
        $pivotAssigned = $user->assignedProjects()->get();

        // Merge semua koleksi dan unique by id
        $projects = $owned->merge($legacyAssigned)->merge($pivotAssigned)->unique('id')->values();

        return view('projects.index', [
            'projects' => $projects,
            'editing' => null,   // default: tidak sedang edit
        ]);
    }

    /**
     * Simpan proyek baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'deadline'    => ['nullable', 'date'],
        ]);

        Project::create([
           'owner_id'    => Auth::id(),
           'name'        => $validated['name'],
           'description' => $validated['description'] ?? null,
           'deadline'    => $validated['deadline'] ?? null,
           //'status'      => 'ongoing',

            // ketika user membuat proyek sendiri,
            // tugas/proyek dianggap "ditugaskan untuk dirinya sendiri"
            'assigned_to' => Auth::id(),
            'assigned_by' => Auth::id(),
        ]);


        return redirect()
            ->route('projects.index')
            ->with('success', 'Proyek berhasil ditambahkan.');
    }

    /**
     * Form Edit Proyek
     */
    public function edit(Project $project)
    {
        // pastikan user hanya bisa edit proyek miliknya
        abort_if($project->owner_id !== Auth::id(), 403);

        $projects = Project::where('owner_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('projects.index', [
            'projects' => $projects,
            'editing' => $project,   // proyek yang sedang di-edit
        ]);
    }

    /**
     * Update Proyek
     */
    public function update(Request $request, Project $project)
    {
        abort_if($project->owner_id !== Auth::id(), 403);

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'deadline'    => ['nullable', 'date'],
        ]);

        $project->update($validated);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Proyek berhasil diperbarui.');
    }

    /**
     * Hapus proyek
     */
    public function destroy(Project $project)
    {
        abort_if($project->owner_id !== Auth::id(), 403);

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Proyek berhasil dihapus.');
    }
}
