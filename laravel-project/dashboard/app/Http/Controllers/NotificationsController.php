<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityNotification;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $items = ActivityNotification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
        if ($request->wantsJson()) {
            return response()->json([
                'items' => $items,
                'unread' => $items->whereNull('read_at')->count(),
            ]);
        }
        return view('partials.notifications_list', compact('items'));
    }

    public function unreadCount()
    {
        $count = ActivityNotification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();
        return response()->json(['count' => $count]);
    }

    public function markAllRead()
    {
        ActivityNotification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function markRead(ActivityNotification $notification)
    {
        abort_if($notification->user_id !== Auth::id(), 403);
        if (!$notification->read_at) {
            $notification->update(['read_at' => now()]);
        }
        return response()->json(['success' => true]);
    }
}
