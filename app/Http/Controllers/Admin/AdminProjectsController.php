<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminProjectsController extends Controller
{

    public function index(Request $request)
    {
        $query = Project::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('start_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('start_date', '<=', $request->to_date);
        }

        $projects = $query->get();

        return view('admin.pages.Projects.index', compact('projects'));
    }


    /**
     * Store New Project
     */

    public function store(Request $request)
    {
        $user = Session::get('users');
        $user_id = $user['id'];

        $request->validate([
            'project_name' => 'required|string|max:50',
            'project_url'  => 'nullable|string|max:255',
            'start_date'   => 'required|date',
            'logo'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'       => 'required|in:active,inactive',
        ]);

        $logo = null;

        if ($request->hasFile('logo')) {

            $logo = time() . '.' . $request->file('logo')->getClientOriginalExtension();

            $request->file('logo')->move(
                public_path('uploads/projects'),
                $logo
            );
        }

        Project::create([
            'project_name' => $request->project_name,
            'project_url'  => $request->project_url,
            'start_date'   => $request->start_date,
            'logo'         => $logo,
            'status'       => $request->status,
            'created_by'   => $user_id,
        ]);

        return redirect()->route('admin.projects.list')->with('flash_success', 'Project Added Successfully');
    }


    //create page
    public function create()
    {
        return view('admin.pages.Projects.create');
    }
}
