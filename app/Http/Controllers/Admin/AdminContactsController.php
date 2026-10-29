<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminContactsController extends Controller
{

    public function index(Request $request)
    {
        $query = Contact::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $users = $query->get();

        return view('admin.pages.contacts.index', compact('users'));
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
            'usertype'   => 'required|string',
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

        return response()->json(['message' => 'User added successfully']);
    }




    /**
     * Delete User
     */
    public function delete($id)
    {
        $data = Contact::find($id);
        if ($data) {
            $data->delete();

            return redirect()->back()->with('flash_success', "Category - $data->name Category Deleted Successfully!");
        } else {

            return redirect()->back()->with('flash_error', "Error while deleting ID - $id");
        }
    }

    /**
     * view page
     */
    public function view($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.pages.contacts.view', compact('contact'));
    }

    public function export(Request $request)
    {
        $query = Contact::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $contacts = $query->get();

        $fileName = "contacts.csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($contacts) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Name',
                'Email',
                'Phone',
                'Address',
                'Budget',
                'Requirement',
                'Date'
            ]);

            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->fullname,
                    $contact->email,
                    $contact->contact,
                    $contact->address,
                    $contact->budget,
                    $contact->requirement,
                    $contact->created_at->format('d-m-Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
