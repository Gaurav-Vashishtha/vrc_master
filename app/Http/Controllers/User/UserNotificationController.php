<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserNotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::with('user')->where('user_id', session('users.id'))->latest();

        $fromDate = $request->input('from_date') ?? date('Y-m-01');
        $query->whereDate('created_at', '>=', $fromDate);

        $toDate = $request->input('to_date') ?? date('Y-m-d');
        $query->whereDate('created_at', '<=', $toDate);

        if ($request->filled('search_user')) {
            $query->where('user_id', $request->search_user);
        }

        Notification::with('user')->where('user_id', session('users.id'))
        ->where('status', 'Unseen')
        ->update(['status' => 'Seen']);        

        $notifications = $query->paginate(10);
        return view('user.pages.Notification.index', compact('notifications'));
    }

    public function show($id)
    {
        $userId = \Illuminate\Support\Facades\Session::get('users.id');
        abort_unless($userId, 403);

        $notification = \App\Models\Notification::where('user_id', $userId)
            ->findOrFail($id);

        return view('user.pages.Notification.show', compact('notification'));
    }

    public function notificationCount()
    {
        $count = @getUserNotificationByID(session('users.id'));
        return response()->json([
            'status' => true,
            'message' => 'Notification count',
            'count' => count($count),
            'status_code' => 200
        ], 200);
    }
}
