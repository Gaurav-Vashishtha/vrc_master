<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::with('user')->latest();

        $fromDate = $request->input('from_date') ?? date('Y-m-01');
        $query->whereDate('created_at', '>=', $fromDate);

        $toDate = $request->input('to_date') ?? date('Y-m-d');
        $query->whereDate('created_at', '<=', $toDate);

        if ($request->filled('search_user')) {
            $query->where('user_id', $request->search_user);
        }

        $notifications = $query->paginate(10);
        return view('admin.pages.Notifications.index', compact('notifications'));
    }

    public function create()
    {
        $users = User::where('usertype', 3)
            ->where('status', 1)
            ->orderBy('first_name')
            ->get();

        return view('admin.pages.Notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['required', Rule::in(['Low', 'Medium', 'High'])],
            'audience' => ['required', Rule::in(['all', 'selected'])],
            'user_ids' => ['required_if:audience,selected', 'array', 'min:1'],
            'user_ids.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('users', 'id')->where('usertype', 3)->where('status', 1),
            ],
        ]);

        $recipientIds = $validated['audience'] === 'all'
            ? User::where('usertype', 3)->where('status', 1)->pluck('id')
            : collect($validated['user_ids']);

        if ($recipientIds->isEmpty()) {
            return back()->withInput()->with('flash_error', 'There are no active employees to receive this notification.');
        }

        $createdBy = $request->session()->get('users')->id;

        DB::transaction(function () use ($validated, $recipientIds, $createdBy) {
            foreach ($recipientIds as $userId) {
                Notification::create([
                    'title' => $validated['title'],
                    'description' => $validated['description'],
                    'user_type' => 3,
                    'user_id' => $userId,
                    'priority' => $validated['priority'],
                    'status' => 'Unseen',
                    'created_by' => $createdBy,
                ]);
            }
        });

        return redirect()->route('admin.notifications.index')->with('flash_success', 'Notification sent to ' . $recipientIds->count() . ' employee(s).');
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->delete();

        return redirect()->route('admin.notifications.index')->with('flash_success', 'Notification deleted successfully.');
    }
}
