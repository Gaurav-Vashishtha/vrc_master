<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Reminder;
use App\Models\Notification;

class UserLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
            ->where('usertype', '3')
            ->first();

        if (!$user) {
            return back()->withInput()->with('Failed', 'Invalid email address.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withInput()->with('Failed', 'Invalid email or password.');
        }

        if ($user->status === '0') {
            return back()->withInput()->with('Failed', 'Your account is pending admin verification.');
        }

        if ($user->status === '2') {
            return back()->withInput()->with('Failed', 'Your account is inactive.');
        }

        Session::put('users', $user);

        return redirect()->route('user.dashboard')->with(['status' => '1', 'msg' => 'Login Successfully']);
    }


    public function dashboard()
    {
        if (!Session::has('users')) {
            return redirect()->route('user.login');
        }

        $user = Session::get('users');
        $activeReminders = Reminder::activeReminders()->where('created_by', $user->id)
                ->orderBy('reminder_date', 'asc')->get();
        $notification = Notification::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return response()->view('user.Dashboard', [
            'todayCheckedIn'  => false,
            'lastChecked'     => null,
            'todayCheckedOut' => false,
            'notification'    => $notification,
            'activeReminders' => $activeReminders,
        ])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }

    public function logout(Request $request)
    {
        Session::forget('users');
        Session::flush();

        return redirect()->route('user.login')
            ->with('success', 'Logout Successfully');
    }

    public function changePassword()
    {
        if (!Session::has('users')) {
            return redirect()->route('user.login');
        }

        return view('user.pages.ChangePassword');
    }

    public function updatePassword(Request $request)
    {
        if (!Session::has('users')) {
            return redirect()->route('user.login');
        }

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = User::find(Session::get('users')->id);

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('flash_error', 'Current password is incorrect');
        }

        // Check new password should not be same
        if (Hash::check($request->new_password, $user->password)) {
            return back()->with('flash_error', 'New password cannot be the same as the current password');
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Update session
        Session::put('users', $user);
        return redirect()->route('user.change.password')->with('flash_success', 'Password changed successfully');
    }
}
