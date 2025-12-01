<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminStatistikController extends Controller
{
    public function index()
    {
        // ⚠ HANYA AMBIL USER BIASA (SUPER ADMIN / ADMIN TIDAK DIAKUMULASIKAN)
        // Sesuaikan dengan nilai role yg kamu pakai.
        // Misal: 'admin', 'super_admin', 'user'
        $users = User::whereNotIn('role', ['admin', 'super_admin'])->with('tasks')->get();

        // AMBIL SEMUA USER BESERTA STATISTIK
        $stats = $users->map(function ($user) {

            $total = $user->tasks->count();

            // STATUS DIGANTI SESUAI YANG KAMU PAKAI DI DATABASE
            $completed = $user->tasks->where('status', 'done')->count();
            $ongoing   = $user->tasks->where('status', 'on_going')->count();
            $pending   = $user->tasks->where('status', 'pending')->count();

            return [
                'id'        => $user->id,
                'name'      => $user->name,
                'total'     => $total,
                'completed' => $completed,
                'ongoing'   => $ongoing,
                'pending'   => $pending,
            ];
        });

        return view('admin.statistik.index', compact('stats'));
    }
}
