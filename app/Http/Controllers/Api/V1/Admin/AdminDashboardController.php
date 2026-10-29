<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\WorkReports;
use App\Models\Holiday;
use App\Models\News;
use App\Models\Notification;
use WpOrg\Requests\Response;
use Illuminate\Support\Facades\Validator;

class AdminDashboardController extends Controller
{

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    // public function adminLogin(Request $request)
    // {

    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $admin = User::where('email', $request->email)
    //         ->where('usertype', '1')
    //         ->first();

    //     if (!$admin) {
    //         return $this->sendError('Invalid Email!', [], 401);
    //     }

    //     if (!Hash::check($request->password, $admin->password)) {
    //         return $this->sendError('Invalid Email or Password', [], 401);
    //     }

    //     if ($admin->status == '0') {
    //         return $this->sendError('Your ID is pending for admin verification', [], 403);
    //     }

    //     if ($admin->status != '1') {
    //         return $this->sendError('Your ID is inactivated by admin', [], 403);
    //     }

    //     $token = Auth::guard('admin-api')->login($admin);

    //     $data = [
    //         'token' => $token,
    //         'token_type' => 'bearer',
    //         'admin' => [$admin],
    //     ];

    //     return $this->sendResponse($data, 'Login Successfully');
    // }

    // public function logout(Request $request)
    // {
    //     try {
    //         Auth::guard('admin-api')->logout();

    //         return $this->sendResponse([], 'Successfully admin logged out');
    //     } catch (\Exception $e) {
    //         return $this->sendError('Logout failed', [], 500);
    //     }
    // }

    // public function changePassword(Request $request)
    // {
    //     $request->validate([
    //         'current_password' => 'required',
    //         'new_password' => 'required|max:10|confirmed',
    //     ]);

    //     $admin = Auth::guard('admin-api')->user();

    //     if (!Hash::check($request->current_password, $admin->password)) {
    //         return $this->sendError('Current password is incorrect', [], 400);
    //     }

    //     $admin->password = Hash::make($request->new_password);
    //     $admin->save();

    //     return $this->sendResponse([], 'Password changed successfully');
    // }

    // public function dashboard()
    // {
    //     $employees = [];
    //     $NoOfEmployees = count($employees);

    //     $workingEmp = [];
    //     $NoOfWorkingEmp = count($workingEmp);

    //     $CurrentWorkingEmp = [];

    //     return $this->sendResponse([
    //         'NoOfEmployees' => $NoOfEmployees,
    //         'NoOfWorkingEmp' => $NoOfWorkingEmp,
    //         'CurrentWorkingEmp' => $CurrentWorkingEmp,
    //     ], 'Dashboard data fetched successfully');
    // }

    public function index(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }


        $query = Project::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('start_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('start_date', '<=', $request->to_date);
        }

        $projects = $query->get();


        $baseLogoUrl = asset('uploads/projects/logos') . '/';

        $projectsTransformed = $projects->map(function ($project) use ($baseLogoUrl) {
            $projectArray = $project->toArray();

            if (!empty($projectArray['logo'])) {
                $projectArray['logo'] = $baseLogoUrl . $projectArray['logo'];
            }

            return $projectArray;
        });

        return response()->json([
            'status' => true,
            'message' => 'Projects fetched successfully',
            'data' => $projectsTransformed
        ], 200);
    }

    public function workReportApiList(Request $request)
    {

        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }


        $query = WorkReports::with(['user', 'project'])
            ->where('user_id', $user->id)
            ->latest();

        if ($request->filled('from_date')) {
            $query->whereDate('report_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('report_date', '<=', $request->to_date);
        }

        $workreports = $query->get();

        $baseImageUrl = asset('uploads/workreports') . '/';

        $workreports = $workreports->map(function ($report) use ($baseImageUrl) {

            $reportArray = $report->toArray();

            if (!empty($reportArray['before_image'])) {
                $reportArray['before_image'] = $baseImageUrl . $reportArray['before_image'];
            }

            if (!empty($reportArray['after_image'])) {
                $reportArray['after_image'] = $baseImageUrl . $reportArray['after_image'];
            }

            return $reportArray;
        });

        return response()->json([
            'status' => true,
            'message' => 'Work reports fetched successfully',
            'data' => $workreports
        ], 200);
    }

    public function addWorkReportApi(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }
        $validator = Validator::make($request->all(), [
            'report_date'    => 'required|date',
            'working_hours'  => 'required|numeric',
            'project_id'     => 'required|exists:projects,id',
            'project_name'   => 'nullable|string',
            'issue_status'   => 'required|string',
            'project_issue'  => 'nullable|string',
            'pending_issue'  => 'nullable|string',
            'pending_reason' => 'nullable|string',
            'fixed_issue'    => 'nullable|string',
            'before_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'after_image'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $beforeImage = null;
        $afterImage  = null;

        if ($request->hasFile('before_image')) {
            $beforeImage = time() . '_before.' . $request->before_image->extension();
            $request->before_image->move(
                public_path('uploads/workreports'),
                $beforeImage
            );
        }

        if ($request->hasFile('after_image')) {
            $afterImage = time() . '_after.' . $request->after_image->extension();
            $request->after_image->move(
                public_path('uploads/workreports'),
                $afterImage
            );
        }

        $workReport = WorkReports::create([

            'user_id'       => $user->id,
            'report_date'   => $request->report_date,
            'working_hours' => $request->working_hours,
            'project_id'    => $request->project_id,
            'project_name'  => $request->project_name,
            'issue_status'  => $request->issue_status,
            'project_issue' => $request->project_issue,
            'before_image'  => $beforeImage,
            'after_image'   => $afterImage,
            'pending_issue' => $request->pending_issue,
            'pending_reason' => $request->pending_reason,
            'fixed_issue'   => $request->fixed_issue,
            'status'        => 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Work report added successfully',
            'data' => $workReport
        ], 201);
    }

    public function workReportDetailApi($id)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $workReport = WorkReports::with(['user', 'project'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$workReport) {
            return response()->json([
                'status' => false,
                'message' => 'Work report not found.'
            ], 404);
        }

        $baseImageUrl = asset('uploads/workreports') . '/';

        $data = $workReport->toArray();

        if (!empty($data['before_image'])) {
            $data['before_image'] = $baseImageUrl . $data['before_image'];
        }

        if (!empty($data['after_image'])) {
            $data['after_image'] = $baseImageUrl . $data['after_image'];
        }

        return response()->json([
            'status' => true,
            'message' => 'Work detail fetched successfully',
            'data' => $data
        ], 200);
    }


    public function holidayListApi(Request $request)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $query = Holiday::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('from_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('to_date', '<=', $request->to_date);
        }

        $holidays = $query->get();

        return response()->json([
            'status' => true,
            'message' => 'Holidays fetched successfully',
            'data' => $holidays
        ], 200);
    }

    public function notificationListApi()
    {

        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $notification = Notification::where('user_id', $user->id)->latest()->get();

        return response()->json([

            'status' => true,
            'message' => 'Notification fetched successfully.',
            'data'   => $notification
        ], 200);
    }

    public function newsListApi()
    {

        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $news = News::all();

        return Response()->json([
            'status'  => true,
            'message' => 'News List Fetched successfully.',
            'data'  => $news
        ], 200);
    }

    public function newsDetailsApi($id)
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $news = News::find($id);

        if (!$news) {
            return response()->json([
                'status' => false,
                'message' => 'News not found.'
            ], 404);
        }

        $baseImageUrl = asset('uploads/news') . '/';

        $newsArray = $news->toArray();

        if (!empty($newsArray['image'])) {
            $newsArray['image'] = $baseImageUrl . $newsArray['image'];
        }

        return response()->json([
            'status'  => true,
            'message' => 'News details fetched successfully.',
            'data'    => $newsArray
        ], 200);
    }
}
