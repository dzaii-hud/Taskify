<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminTeamController extends Controller
{
    /**
     * Show create team form
     */
    public function create()
    {
        return view('admin.teams.create');
    }

    /**
     * Handle create team request
     *
     * NOTE: Currently this is a lightweight flow — it validates input and returns success.
     * If you want persistent teams, we can add a Team model & migration next.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'team_name' => ['required', 'string', 'max:255'],
            'members' => ['nullable', 'array'],
            'members.*' => ['integer', 'exists:users,id'],
            'leader_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        // For now we do not persist to DB (no Team model). We return success message.
        // If you want persistence, I can create Team model + migration and attach members.
        return redirect()->route('admin.users.index')
            ->with('success', 'Tim "' . $data['team_name'] . '" berhasil dibuat (sampel). Implementasi persisten bisa ditambahkan).');
    }
}
