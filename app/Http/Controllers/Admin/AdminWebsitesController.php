<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Websites;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\WebsiteHistory;
use Illuminate\Support\Facades\Session;

class AdminWebsitesController extends Controller
{

    public function index(Request $request)
    {
        $query = Websites::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('start_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('start_date', '<=', $request->to_date);
        }

        $websites = $query->get();

        return view('admin.pages.Websites.index', compact('websites'));
    }


    /**
     * Store New Website
     */

    public function store(Request $request)
    {
        $user = Session::get('users');
        $user_id = $user['id'];

        $request->validate([
            'website_name' => 'required|string|max:50',
            'website_url'  => 'nullable|string|max:255',
            'user_id'     => 'required|exists:users,id',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'status'       => 'required|in:active,inactive',
        ]);

        $logo = null;

        if ($request->hasFile('logo')) {

            $logo = time() . '.' . $request->file('logo')->getClientOriginalExtension();

            $request->file('logo')->move(
                public_path('uploads/websites'),
                $logo
            );
        }

        Websites::create([
            'website_name' => $request->website_name,
            'website_url'  => $request->website_url,
            'user_id'     => $request->user_id,
            'logo'         => $logo,
            'description' => $request->description,
            'status'       => $request->status,
            'created_by'   => $user_id,
        ]);

        return redirect()->route('admin.websites.index')->with('flash_success', 'Website Added Successfully');
    }


    //create page
    public function create()
    {
        $users = User::where('usertype', 3)->where('status', 1)->get();

        return view('admin.pages.Websites.create', compact('users'));
    }

    public function edit($id)
    {
        $website = Websites::findOrFail($id);

        $users = User::where('usertype', 3)->where('status', 1)->get();

        return view('admin.pages.Websites.edit', compact('website', 'users'));
    }


    public function history($id)
    {
        $website = Websites::with('user')->findOrFail($id);

        $histories = WebsiteHistory::with('user')
            ->where('website_id', $id)
            ->latest()
            ->paginate(10);

        return view('admin.pages.Websites.history', compact('website', 'histories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'website_name' => 'required|string|max:255',
            'website_url' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $website = Websites::findOrFail($id);

        $website->website_name = $request->website_name;
        $website->website_url = $request->website_url;
        $website->user_id = $request->user_id;
        $website->status = $request->status;
        $website->description = $request->description;

        if ($request->hasFile('logo')) {
            $destination = public_path('uploads/websites');

            if ($website->logo && file_exists($destination . '/' . $website->logo)) {
                unlink($destination . '/' . $website->logo);
            }

            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move($destination, $logoName);

            $website->logo = $logoName;
        }

        $website->save();

        return redirect()
            ->route('admin.websites.index')
            ->with('success', 'Website updated successfully.');
    }
}
