<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class loginController extends Controller
{

    // User Login (for usertype 2)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
            ->where('usertype', '2')
            ->first();

        if (!$user) {
            return back()->with('Failed', 'Invalid Email!');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('Failed', 'Invalid Email or Password');
        }

        if ($user->status === '0') {
            return back()->with('Failed', 'Your ID is pending for admin verification');
        } elseif ($user->status === '1') {
            Session::put('users', $user);
            return redirect('/seller/dashboard')->with(['status' => '1', 'msg' => 'Login Successfully']);
        } else {
            return back()->with('Failed', 'Your ID is inactivated by admin');
        }
    }

    
    // Admin Login (for usertype 1)
    public function loginAdmin(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $admin = User::where('email', $request->email)
                ->where('usertype', '1')
                ->first();

            if (!$admin) {
                return back()->with('Failed', 'Invalid Email!');
            }

            if (!Hash::check($request->password, $admin->password)) {
                return back()->with('Failed', 'Invalid Email or Password');
            }

            if ($admin->status === '0') {
                return back()->with('Failed', 'Your ID is pending for admin verification');
            } elseif ($admin->status === '1') {
                Session::put('users', $admin);
                return redirect('/admin/dashboard')->with(['status' => '1', 'msg' => 'Login Successfully']);
            } else {
                return back()->with('Failed', 'Your ID is inactivated by admin');
            }
        }

        return view('admin.pages.auth.login');
    }
}
