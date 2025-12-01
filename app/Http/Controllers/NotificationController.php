<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Task;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $unreadCount = Notification::where('user_id', $userId)->where('is_read', false)->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markRead(Notification $notification)
    {
        $this->authorizeAccess($notification);

        $notification->update(['is_read' => true]);

        /**
         * 🟢 OPSIONAL: Jika notif punya task_id
         * kamu bisa redirect ke halaman task-nya.
         *
         * SEMENTARA AKU TETAPKAN return back()
         * karena kamu tidak minta auto redirect.
         */
        return back();
    }

    public function markAllRead()
    {
        $userId = Auth::id();
        Notification::where('user_id', $userId)->where('is_read', false)->update(['is_read' => true]);

        return back();
    }

    protected function authorizeAccess(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }
    }

    // SHOW NOTIFICATION ( DETAIL )

    public function show(Notification $notification)
{
    $this->authorizeAccess($notification);

    // tandai dibaca ketika dibuka
    if (! $notification->is_read) {
        $notification->update(['is_read' => true]);
    }

    return view('notifications.show', compact('notification'));
    }

}
