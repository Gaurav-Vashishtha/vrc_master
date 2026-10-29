<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\chatbot_sessions;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminChatBoxController extends Controller
{
    // ChatBox Listing
    public function index(Request $request)
    {
        $query = chatbot_sessions::query();

        $query->whereDate('created_at', '>=', Carbon::now()->subDays(7));

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        $query->orwhere('is_pinned', '=', 1);

        $chatSessions = $query->orderByDesc('created_at')->get();

        return view('admin.pages.ChatBox.index', compact('chatSessions'));
    }

    public function show($thread_id)
    {
        $chatSession = chatbot_sessions::with('messages')->where('thread_id', $thread_id)->first();
        if (!$chatSession) {
          return back()->with('flash_error', 'Chat not found.');  
        }
        return view('admin.pages.ChatBox.show', compact('chatSession'));
    }

    public function togglePin($id)
    {
        $session = chatbot_sessions::findOrFail($id);

        $session->is_pinned = $session->is_pinned ? 0 : 1;

        $session->save();

        return back()->with(
            'flash_success',
            $session->is_pinned
                ? 'Session pinned successfully.'
                : 'Session unpinned successfully.'
        );
    }
}
