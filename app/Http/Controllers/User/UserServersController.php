<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Servers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ServerHistory;
use Illuminate\Support\Facades\Session;

class UserServersController extends Controller
{
    public function index(Request $request)
    {
        $query = Servers::with(['histories'])->where('user_id', Session::get('users')->id)->latest();

        if ($request->filled('from_date')) {
            $query->whereDate('start_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('start_date', '<=', $request->to_date);
        }

        $servers = $query->get();
        return view('user.pages.Servers.index', compact('servers'));
    }


    
    public function history($id)
    {
        $server = Servers::with('user')->where('id', $id)->where('user_id', Session::get('users')->id)->first();
        if (!$server) {
            return redirect()->route('user.servers.index')->with('flash_error', 'Server not found.');
        }

        $histories = ServerHistory::with('user')
            ->where('server_id', $id)
            ->latest()
            ->get()->take(10);
            // ->paginate(10);

        return view('user.pages.Servers.history', compact('server', 'histories'));
    }

    public function storeCheck(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:working,problem',
            'message' => 'required|string|max:1000',
        ]);

        $server = Servers::where('id', $id)
            ->where('user_id', Session::get('users.id'))
            ->firstOrFail();

        ServerHistory::create([
            'server_id' => $server->id,
            'user_id' => Session::get('users.id'),
            'status' => $request->status,
            'message' => $request->message,
        ]);

        return redirect()
            ->back()
            ->with('flash_success', 'Server status submitted successfully.');
    }
}
