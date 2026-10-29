<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\WorkReports;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\attendance;
use Illuminate\Support\Facades\DB;

class UserWorkReportsController extends Controller
{
    // Listing
    public function index(Request $request)
    {
        $query = WorkReports::with(['user', 'project'])
        ->where('user_id', Session::get('users')->id)->latest();

        $fromDate = $request->input('from_date') ?? date('Y-m-01');
        $query->whereDate('report_date', '>=', $fromDate);

        $toDate = $request->input('to_date') ?? date('Y-m-d');
        $query->whereDate('report_date', '<=', $toDate);

        $workreports = $query->latest()->get();

        return view(
            'user.pages.WorkReports.index', compact('workreports')
        );
    }

    // Create Page
    public function create()
    {
        $users = User::where('status', 1)
            ->orderBy('first_name')
            ->get();

        $projects = Project::where('status', 1)->orderBy('project_name')->get();

        return view(
            'user.pages.WorkReports.create',
            compact('users', 'projects')
        );
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
           // 'user_id'       => 'required',
            'report_date'   => 'required',
            'working_hours' => 'required|regex:/^\d{1,2}(\.\d{1,2})?$/',
            'project_id'    => 'required',
            'issue_status'  => 'required',
        ]);

        DB::beginTransaction();
        // if validation fails 
        $beforeImage = null;
        $afterImage  = null;
        $user = Session::get('users');
        $work_report_date = $request->report_date;

        // Before Image Upload
        if ($request->hasFile('before_image')) {

            $beforeImage = time() . '_before.' . $request->before_image->extension();

            $request->before_image->move(
                public_path('uploads/workreports'),
                $beforeImage
            );
        }

        // After Image Upload
        if ($request->hasFile('after_image')) {

            $afterImage = time() . '_after.' . $request->after_image->extension();

            $request->after_image->move(
                public_path('uploads/workreports'),
                $afterImage
            );
        }

        $WorkReports = WorkReports::create([
            'user_id'        => $user->id,
            'report_date'    => $work_report_date,
            'working_hours'  => $request->working_hours,
            'project_id'     => $request->project_id,
            'project_name'   => $request->other_project_name,
            'issue_status'   => $request->issue_status,
            'project_issue'  => $request->project_issue,
            'pending_issue'  => $request->pending_issue,
            'pending_reason' => $request->pending_reason,
            'fixed_issue'    => $request->fixed_issue,
            'before_image'   => $beforeImage,
            'after_image'    => $afterImage,
           
        ]);

        $report_working_hours = $WorkReports->working_hours;

        // Find attendance for this employee and work report date
        $attendance = attendance::where('emp_code', $user->id)->whereDate('att_date', $work_report_date)->first();

        // Existing attendance working hours
        $existingSeconds = 0;
        if ($attendance && $attendance->total_work) {
            [$hours, $minutes, $seconds] = array_pad(explode(':', $attendance->total_work), 3, 0);
            $existingSeconds = ((int) $hours * 3600) + ((int) $minutes * 60) + (int) $seconds;
        }

        // Convert work report hours
        // Example: 2.5 = 2 hours 30 minutes
        $reportHours = floor((float) $report_working_hours);
        $reportMinutes = round(
            ((float) $report_working_hours - $reportHours) * 60
        );

        $reportSeconds = ($reportHours * 3600) + ($reportMinutes * 60);
        // Total attendance working hours
        $totalSeconds = $existingSeconds + $reportSeconds;
        $totalHours = floor($totalSeconds / 3600);
        $totalMinutes = floor(($totalSeconds % 3600) / 60);
        $totalSecondsRemaining = $totalSeconds % 60;

        $cal_working_hour = sprintf(
            '%02d:%02d:%02d',
            $totalHours,
            $totalMinutes,
            $totalSecondsRemaining
        );

        // Create or update attendance
        if ($attendance) {
            $attendance->update([
                'total_work' => $cal_working_hour,
                'updated_by' => $user->id,
            ]);
        } else {
            attendance::create([
                'emp_code'   => $user->id,
                'check_in'   => null,
                'check_out'  => null,
                'total_work' => $cal_working_hour,
                'updated_by' => $user->id,
                'att_date'   => $work_report_date,
                'att_type'   => 'Present',
            ]);
        }

        DB::commit();
        return redirect()->route('user.work.reports.list')->with('flash_success', 'Work Report Added Successfully');
    }

    // View
    public function view($id)
    {
        $workreport = WorkReports::findOrFail($id);

        return view('user.pages.WorkReports.view', compact('workreport'));
    }

    // // Edit
    // public function edit($id)
    // {
    //     $workreport = WorkReports::findOrFail($id);

    //     return view('user.pages.WorkReports.edit', compact('workreport'));
    // }

    // // Update
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'user_id'        => 'required',
    //         'report_date'    => 'required',
    //         'working_hours'  => 'required',
    //         'project_id'     => 'required',
    //         'issue_status'   => 'required',
    //     ]);

    //     $workreport = WorkReports::findOrFail($id);

    //     $data = [
    //         'user_id'       => $request->user_id,
    //         'report_date'   => $request->report_date,
    //         'working_hours' => $request->working_hours,
    //         'project_id'    => $request->project_id,
    //         'issue_status'  => $request->issue_status,
    //         'project_issue' => $request->project_issue,
    //     ];

    //     if ($request->hasFile('before_image')) {

    //         $beforeImage =
    //             time() . '_before.' .
    //             $request->before_image->extension();

    //         $request->before_image->move(public_path('uploads/workreports'), $beforeImage);

    //         $data['before_image'] = $beforeImage;
    //     }

    //     if ($request->hasFile('after_image')) {

    //         $afterImage =
    //             time() . '_after.' .
    //             $request->after_image->extension();

    //         $request->after_image->move(public_path('uploads/workreports'), $afterImage);

    //         $data['after_image'] = $afterImage;
    //     }

    //     $workreport->update($data);

    //     return redirect()->route('user.work.reports.list')->with('flash_success', 'Work Report Updated Successfully');
    // }

    // Delete
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $workreport = WorkReports::find($id);
            if (!$workreport) {
                DB::rollBack();
                return redirect()->back()->with('flash_error', 'Record Not Found');
            }

            $user = Session::get('users');
            $work_report_date = $workreport->report_date;
            $report_working_hours = (float) $workreport->working_hours;

            $attendance = attendance::where('emp_code', $user->id)->whereDate('att_date', $work_report_date)->first();

            if ($attendance) {
                $existingSeconds = 0;
                if ($attendance->total_work) {
                    [$hours, $minutes, $seconds] =
                        array_pad( explode(':', $attendance->total_work), 3, 0);
                    $existingSeconds =
                        ((int) $hours * 3600) +
                        ((int) $minutes * 60) +
                        (int) $seconds;
                }

                // Convert Work Report hours to seconds
                $reportHours = floor($report_working_hours);
                $reportMinutes = round(
                    ($report_working_hours - $reportHours) * 60
                );

                $reportSeconds = ($reportHours * 3600) + ($reportMinutes * 60);
                $remainingSeconds = $existingSeconds - $reportSeconds;

                /*
                * If remaining attendance time is
                * 00:00:00 or less, delete attendance.
                */
                if ($remainingSeconds <= 0) {
                    $attendance->delete();
                } else {
                    $totalHours = floor($remainingSeconds / 3600);
                    $totalMinutes = floor(
                        ($remainingSeconds % 3600) / 60
                    );

                    $totalSecondsRemaining = $remainingSeconds % 60;

                    $cal_working_hour = sprintf(
                        '%02d:%02d:%02d',
                        $totalHours,
                        $totalMinutes,
                        $totalSecondsRemaining
                    );

                    $attendance->update([
                        'total_work' => $cal_working_hour,
                        'updated_by' => $user->id,
                    ]);
                }
            }

            $workreport->delete();
            DB::commit();
            return redirect()->back()->with('flash_success', 'Work Report Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('flash_error', $e->getMessage());
        }
    }
}
