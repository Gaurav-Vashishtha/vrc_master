<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\LeaveApprovedMail;
use App\Mail\LeaveRejectedMail;
use Illuminate\Support\Facades\Mail;

class AdminLeaveController extends Controller
{

    //User Logs Listing

    public function index(Request $request)
    {
        $query = Leave::with(['user'])->latest();

        if ($request->filled('from_date')) {
            $query->whereDate('from_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('to_date', '<=', $request->to_date);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('id', $request->search);
            });
        }

        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->leave_type);
        }

        $leaves = $query->get();
        $users = User::where('usertype', 3)->get();

        return view('admin.pages.Leave.index', compact('leaves', 'users',));
    }

    //create Leave

    public function create()
    {
        $users = User::where('status', 1)
            ->orderBy('first_name')
            ->get();

        return view('admin.pages.Leave.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required',
            'leave_type' => 'required',
            'from_date'  => 'required',
            'to_date'    => 'required',
            'total_days' => 'required',
            'leave_reason' => 'required|string',
        ]);

        Leave::create([
            'user_id'    => $request->user_id,
            'leave_type' => $request->leave_type,
            'from_date'  => $request->from_date,
            'to_date'    => $request->to_date,
            'total_days' => $request->total_days,
            'leave_reason' => $request->leave_reason,
        ]);

        return redirect()->route('admin.leave.list')->with('flash_success', 'Leave Added Successfully');
    }

    public function approve($id)
    {
        $leave = Leave::with('user')->findOrFail($id);
        $leave->status = 1;
        $leave->save();

        // Send approval email to User
        if ($leave->user && $leave->user->email) {
            Mail::to($leave->user->email)->send(new LeaveApprovedMail($leave));
        }

        return redirect() ->route('admin.leave.list') ->with('flash_success', 'Leave Approved Successfully');
    }

    public function reject($id)
    {
        $leave = Leave::with('user')->findOrFail($id);
        $leave->status = 2;
        $leave->save();

        // Send rejection email to User
        if ($leave->user && $leave->user->email) {

            Mail::to($leave->user->email) ->send(new LeaveRejectedMail($leave));
        }


        return redirect()  ->route('admin.leave.list') ->with('flash_success', 'Leave Rejected Successfully');
    }


    public function export(Request $request)
    {
        $query = Leave::with(['user'])->latest();

        if ($request->filled('from_date')) {
            $query->whereDate('from_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('to_date', '<=', $request->to_date);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('id', $request->search);
            });
        }

        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->leave_type);
        }

        $leavereports = $query->get();

        $fileName = 'leave_reports_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($leavereports) {

            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'S.No',
                'Employee Name',
                'Leave Type',
                'From Date',
                'To Date',
                'Total Days',
                'Reason',
                'Status',
                'Created Date',
            ]);

            foreach ($leavereports as $key => $leave) {

                $userName = trim(
                    ($leave->user?->first_name ?? '') . ' ' .
                    ($leave->user?->last_name ?? '')
                );

                $leave_status = 'Unknown';
                if($leave->status == 0){
                    $leave_status = 'Pending';
                }elseif($leave->status == 1){
                    $leave_status = 'Approved';
                }elseif($leave->status == 2){
                    $leave_status = 'Rejected';
                }

                fputcsv($file, [
                    $key + 1,
                    $userName,
                    $leave->leave_type,
                    \Carbon\Carbon::parse($leave->from_date)->format('d-m-Y'),
                    \Carbon\Carbon::parse($leave->to_date)->format('d-m-Y'),
                    $leave->total_days,
                    $leave->leave_reason,
                    $leave_status,
                    optional($leave->created_at)->format('d-m-Y'),
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function details($id)
    {
        $leave = Leave::with('user')->where('id', $id)->firstOrFail();
        return view('admin.pages.Leave.details', compact('leave'));
    }


    public function approveWithdrawal($id)
    {
        $leave = Leave::findOrFail($id);
        if ($leave->withdrawal_status != 1) {
            return back()->with('flash_error', 'Invalid withdrawal request.');
        }

        $leave->update([
            'withdrawal_status' => 2,
            'withdrawal_action_at' => now(),
        ]);
        return back()->with('flash_success', 'Withdrawal approved successfully.');
    }


    public function rejectWithdrawal(Request $request, $id)
    {
        $request->validate([
            'withdrawal_admin_reason' => 'required|string|max:1000',
        ]);

        $leave = Leave::findOrFail($id);

        if ($leave->withdrawal_status != 1) {
            return back()->with('flash_error', 'Invalid withdrawal request.');
        }

        $leave->update([
            'withdrawal_status' => 3,
            'withdrawal_admin_reason' => $request->withdrawal_admin_reason,
            'withdrawal_action_at' => now(),
        ]);
        return back()->with('flash_success', 'Withdrawal request rejected.');
    }
}
