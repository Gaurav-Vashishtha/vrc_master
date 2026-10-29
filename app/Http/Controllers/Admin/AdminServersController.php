<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ServerHistory;
use Illuminate\Support\Facades\Session;

class AdminServersController extends Controller
{

    public function index(Request $request)
    {
        $query = Servers::with(['histories'])->latest();

        if ($request->filled('from_date')) {
            $query->whereDate('start_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('start_date', '<=', $request->to_date);
        }

        if ($request->filled('search_user')) {
            $query->where('user_id', $request->search_user);
        }

        $servers = $query->get();

        return view('admin.pages.Servers.index', compact('servers'));
    }


    /**
     * Store New Server
     */

    public function store(Request $request)
    {
        $user = Session::get('users');
        $user_id = $user['id'];

        $request->validate([
            'server_name' => 'required|string|max:50',
            'server_url'  => 'nullable|string|max:255',
            'user_id'     => 'required|exists:users,id',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'status'       => 'required|in:active,inactive',
        ]);

        $logo = null;

        if ($request->hasFile('logo')) {

            $logo = time() . '.' . $request->file('logo')->getClientOriginalExtension();

            $request->file('logo')->move(
                public_path('uploads/servers'),
                $logo
            );
        }

        Servers::create([
            'server_name' => $request->server_name,
            'server_url'  => $request->server_url,
            'user_id'     => $request->user_id,
            'username'     => $request->username,
            'password'     => $request->password,
            'logo'         => $logo,
            'description' => $request->description,
            'status'       => $request->status,
            'created_by'   => $user_id,
        ]);

        return redirect()->route('admin.servers.index')->with('flash_success', 'Server Added Successfully');
    }


    //create page
    public function create()
    {
        $users = User::where('usertype', 3)->where('status', 1)->get();

        return view('admin.pages.Servers.create', compact('users'));
    }

    public function edit($id)
    {
        $server = Servers::findOrFail($id);

        $users = User::where('usertype', 3)->where('status', 1)->get();

        return view('admin.pages.Servers.edit', compact('server', 'users'));
    }


    public function history($id)
    {
        $server = Servers::with('user')->findOrFail($id);

        $histories = ServerHistory::with('user')
            ->where('server_id', $id)
            ->latest()
            ->paginate(10);

        return view('admin.pages.Servers.history', compact('server', 'histories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'server_name' => 'required|string|max:255',
            'server_url' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $server = Servers::findOrFail($id);

        $server->server_name = $request->server_name;
        $server->server_url = $request->server_url;
        $server->user_id = $request->user_id;
        $server->username = $request->username;
        $server->password = $request->password;
        $server->status = $request->status;
        $server->description = $request->description;

        if ($request->hasFile('logo')) {
            $destination = public_path('uploads/servers');

            if ($server->logo && file_exists($destination . '/' . $server->logo)) {
                unlink($destination . '/' . $server->logo);
            }

            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move($destination, $logoName);

            $server->logo = $logoName;
        }

        $server->save();

        return redirect()
            ->route('admin.servers.index')
            ->with('flash_success', 'Server updated successfully.');
    }
}
