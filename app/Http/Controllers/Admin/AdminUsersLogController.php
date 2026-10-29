<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserLog;
use Illuminate\Http\Request;

class AdminUsersLogController extends Controller
{
    /**
     * User Logs Listing
     */
    public function userLogs(Request $request)
    {
        $query = UserLog::with(['user'])->latest();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $users = $query->get();

        return view('admin.pages.UserLog.index', compact('users'));
    }

    /**
     * Delete User Log
     */
    public function delete($id)
    {
        $data = UserLog::find($id);

        if ($data) {
            $data->delete();

            return redirect()->back()->with(
                'flash_success',
                'User Log Deleted Successfully!'
            );
        }

        return redirect()->back()->with(
            'flash_error',
            "Error while deleting ID - $id"
        );
    }

    /**
     * Export User Logs CSV
     */
    public function export(Request $request)
    {
        $query = UserLog::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $users = $query->get();

        $fileName = 'user_logs.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () use ($users) {

            $file = fopen('php://output', 'w');

            // CSV Header
            fputcsv($file, [
                'User ID',
                'Action',
                'IP Address',
                'User Agent',
                'Created At'
            ]);

            // CSV Data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->user_id,
                    $user->action,
                    $user->ip_address,
                    $user->user_agent,
                    $user->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}