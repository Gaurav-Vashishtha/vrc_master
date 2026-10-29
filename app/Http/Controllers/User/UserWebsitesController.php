<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Websites;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\WebsiteHistory;
use Illuminate\Support\Facades\Session;

class UserWebsitesController extends Controller
{
    public function index(Request $request)
    {
        $query = Websites::where('user_id', Session::get('users')->id)->latest();

        if ($request->filled('from_date')) {
            $query->whereDate('start_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('start_date', '<=', $request->to_date);
        }

        $websites = $query->get();

        return view('user.pages.Websites.index', compact('websites'));
    }


    
    public function history($id)
    {
        $website = Websites::with('user')->findOrFail($id);

        $histories = WebsiteHistory::with('user')
            ->where('website_id', $id)
            ->latest()
            ->get()->take(10);
            // ->paginate(10);

        return view('user.pages.Websites.history', compact('website', 'histories'));
    }

    public function storeCheck(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:working,problem',
            'message' => 'required|string|max:1000',
        ]);

        $website = Websites::where('id', $id)
            ->where('user_id', Session::get('users.id'))
            ->firstOrFail();

        WebsiteHistory::create([
            'website_id' => $website->id,
            'user_id' => Session::get('users.id'),
            'status' => $request->status,
            'message' => $request->message,
        ]);

        return redirect()
            ->back()
            ->with('flash_success', 'Website status submitted successfully.');
    }
}
