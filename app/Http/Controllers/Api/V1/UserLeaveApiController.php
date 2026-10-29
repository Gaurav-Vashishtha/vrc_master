<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserLeaveApiController extends Controller
{
    public function leaveApplyApi(Request $request)
    {

        $request->validate([
            'leave_type' => 'required',
            'from_date'  => 'required|date',
            'to_date'    => 'required|date|after_or_equal:from_date',
            'total_days' => 'required|numeric',
        ]);

        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $leave = Leave::create([
            'user_id'    => $user->id,
            'leave_type' => $request->leave_type,
            'from_date'  => $request->from_date,
            'to_date'    => $request->to_date,
            'total_days' => $request->total_days,
            'status'     => 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Leave Applied Successfully',
            'data' => $leave
        ], 200);
    }


    public function leaveListApi(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $query = Leave::where('user_id', $user->id)
            ->latest();
        if ($request->filled('from_date')) {
            $query->whereDate('from_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('to_date', '<=', $request->to_date);
        }

        $leaves = $query->get();

        return response()->json([
            'status' => true,
            'message' => 'Leave list fetched successfully',
            'data' => $leaves
        ], 200);
    }

    public function leaveDetailApi($id)
    {

        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated.'
            ], 401);
        }

        $leave = Leave::where('id', $id)
            ->where('user_id', $user->id) 
            ->first();

        if (!$leave) {
            return response()->json([
                'status' => false,
                'message' => 'Leave not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Leave details fetched successfully.',
            'data' => $leave
        ], 200);
    }
}
