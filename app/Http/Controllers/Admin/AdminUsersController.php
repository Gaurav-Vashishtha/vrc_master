<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{

    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->filled('from_date')) {
            $query->where('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('created_at', '<=', $request->to_date);
        }

        $users = $query->where('is_deleted', 0)->get();

        return view('admin.pages.users.index', compact('users'));
    }


    /**
     * Store New User
     */

    public function store(Request $request)
    {
        $user = Session::get('users');
        $user_id = $user['id'];

        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'nullable|string|max:50',
            'phone'      => 'required|string|max:15|unique:users,phone',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'usertype'   => 'required|in:1,3',
            'status'     => 'required|boolean',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'usertype'   => $request->usertype,
            'status'     => $request->status,
            'created_by' => $user_id,
        ]);

       return redirect()->route('admin.users.index')->with('flash_success', 'User Added Successfully');
    }





    //Delete User

    public function delete($id)
    {
        $data = User::find($id);
        if ($data) {
            $data->update(['is_deleted'=> 1]);

            return redirect()->back()->with('flash_success', "User - $data->first_name $data->last_name User Deleted Successfully!");
        } else {

            return redirect()->back()->with('flash_error', "Error while deleting ID - $id");
        }
    }


    //view page

    public function view($id)
    {
        $user = User::findOrFail($id);
        return view('admin.pages.users.view', compact('user'));
    }

    //create page
    public function create()
    {
        return view('admin.pages.users.create');
    }

    //edit page
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.pages.users.edit', compact('user'));
    }

    //update page
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'nullable|string|max:50',
            'phone'      => 'required|string|max:15|unique:users,phone,'.$id,
            'email'      => 'required|email|unique:users,email,'.$id,
            'usertype'   => 'required|in:1,3',
            'status'     => 'required|boolean',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'usertype'   => $request->usertype,
            'status'     => $request->status,
        ]);

        return redirect()->route('admin.users.index')
            ->with('flash_success', 'User Updated Successfully');
    }

    public function export(Request $request)
    {
        $query = User::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $users = $query->get();

        $fileName = "users.csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($users) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'First Name',
                'Last Name',
                'Phone',
                'Email',
                'Role',
                'Status',
                'Deleted Status',
                'Created Date'
            ]);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->first_name,
                    $user->last_name,
                    $user->phone,
                    $user->email,
                    @getUserRoleByID($user->id),
                    $user->status == 1 ? 'Active' : 'Inactive',
                    $user->is_deleted,
                    $user->created_at->format('d-m-Y h:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
