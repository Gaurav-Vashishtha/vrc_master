<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\attendance;
use Illuminate\Support\Facades\DB;
use App\Mail\NewLeaveAppliedMail;
use Illuminate\Support\Facades\Mail;

class UserLeaveController extends Controller
{
    // Leave List
    public function index(Request $request)
    {
        $userID = Session::get('users.id');
        $query = Leave::where('user_id', $userID)->latest();

        if ($request->filled('from_date')) {
            $query->whereDate('from_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('to_date', '<=', $request->to_date);
        }

        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->leave_type);
        }

        $leaves = $query->get();

        return view('user.pages.Leave.index', compact('leaves'));
    }

    // Create Leave Page
    public function create()
    {
        return view('user.pages.Leave.create');
    }

    // Store Leave
    public function store(Request $request)
    {
        $request->validate([
            'leave_type'   => 'required',
            'from_date'    => 'required|date',
            'to_date'      => 'required|date|after_or_equal:from_date',
            'total_days'   => 'required|numeric',
            'leave_reason' => 'required|string',
        ]);

        $user = Session::get('users');
        DB::beginTransaction();
        try {
            $leave = Leave::create([
                'user_id'      => $user->id,
                'leave_type'   => $request->leave_type,
                'from_date'    => $request->from_date,
                'to_date'      => $request->to_date,
                'total_days'   => $request->total_days,
                'leave_reason' => $request->leave_reason,
                'status'       => 0,
            ]);

            // Create Attendance for each leave date
            $fromDate = \Carbon\Carbon::parse($request->from_date);
            $toDate   = \Carbon\Carbon::parse($request->to_date);
            while ($fromDate->lte($toDate)) {
                attendance::updateOrCreate(
                    [
                        'emp_code' => $user->id,
                        'att_date' => $fromDate->format('Y-m-d'),
                    ],
                    [
                        'updated_by' => $user->id,
                        'att_type'   => $request->leave_type,
                    ]
                );

                $fromDate->addDay();
            }

            // Send email to Admin
            Mail::to(env('ADMIN_EMAIL'))->send(new NewLeaveAppliedMail($leave));

            DB::commit();
            return redirect()->route('user.leave.list')->with('flash_success', 'Leave Applied Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('flash_error', $e->getMessage());
        }
    }


    public function details($id)
    {
        $user = Session::get('users');
        $leave = Leave::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        // // Only approved leave can request withdrawal 
        // if ($leave->status != 1) { 
        //     return redirect()->route('user.leave.list')->with( 'flash_error', 'Only approved leave can request withdrawal.' ); 
        // }
        
        // // Already withdrawn 
        // if ($leave->withdrawal_status == 2) {
        //     return redirect()->route('user.leave.list')->with( 'flash_error', 'This leave has already been withdrawn.' ); 
        // }
        
        // // Withdrawal request already pending 
        // if ($leave->withdrawal_status == 1) {
        //     return redirect()->route('user.leave.list')->with( 'flash_error', 'Withdrawal request is already pending.' ); 
        // }
        return view('user.pages.Leave.details', compact('leave'));
    }


    public function requestWithdrawal(Request $request, $id)
    {
        $request->validate([
            'withdrawal_reason' => 'required|string|max:1000',
        ]);

        $user = Session::get('users');
        $leave = Leave::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        // Only approved leave can be withdrawn
        if ($leave->status != 1) {
            return back()->with('flash_error', 'Only approved leave can be withdrawn.');
        }

        // Already a withdrawal request
        if ($leave->withdrawal_status == 1) {
            return back()->with('flash_error', 'Withdrawal request is already pending.');
        }

        // Withdrawal was already approved 
        if ($leave->withdrawal_status == 2) {
            return back()->with( 'flash_error', 'This leave has already been withdrawn.' ); 
        }

        $leave->update([
            'withdrawal_status' => 1,
            'withdrawal_reason' => $request->withdrawal_reason,
            'withdrawal_admin_reason' => null,
            'withdrawal_requested_at' => now(),
            'withdrawal_action_at' => null,
        ]);

        return redirect()->route('user.leave.list')->with('flash_success', 'Withdrawal request submitted successfully.');
    }
}