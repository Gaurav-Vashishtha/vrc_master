<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkReports;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

class AdminWorkReportsController extends Controller
{
    // Listing
    public function index(Request $request)
    {
        $query = WorkReports::with(['user', 'project'])->orderBy('report_date', 'desc');

        $fromDate = $request->input('from_date') ?? date('Y-m-01');
        $query->whereDate('report_date', '>=', $fromDate);

        $toDate = $request->input('to_date') ?? date('Y-m-d');
        $query->whereDate('report_date', '<=', $toDate);

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('id', $request->search);
            });
        }

        if ($request->filled('search_project')) {
            $query->whereHas('project', function ($q) use ($request) {
                $q->where('id', $request->search_project);
            });
        }

         $projects = Project::where('status', 1)->get(); 

        $workreports = $query->get();

        $users = User::where('usertype', 3)->get();

        return view('admin.pages.WorkReports.index', compact('workreports', 'users','projects'));
    }

    public function export(Request $request)
    {
        $query = WorkReports::with(['user', 'project'])->latest();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('search')) {
            $query->where('user_id', $request->search);
        }

          if ($request->filled('search_project')) {
            $query->whereHas('project', function ($q) use ($request) {
                $q->where('id', $request->search_project);
            });
        }

        $workreports = $query->get();

        $fileName = 'work_reports_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($workreports) {

            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'S.No',
                'Employee Name',
                'Report Date',
                'Working Hours',
                'Project Name',
                'Issue Status',
                'Project Issue',
                'Fixed Issue',
                'Pending Issue',
                'Pending Reason	',
                'Before Image',
                'After Image',
                'Created Date',
            ]);

            foreach ($workreports as $key => $report) {

                $userName = trim(
                    ($report->user?->first_name ?? '') . ' ' .
                    ($report->user?->last_name ?? '')
                );

                $projectName =  $report->project?->project_name ?? $report->project_name;
                fputcsv($file, [
                    $key + 1,
                    $userName,
                    \Carbon\Carbon::parse($report->report_date)->format('d-m-Y'),
                    $report->working_hours,
                    $projectName,
                    $report->issue_status,
                    $report->project_issue,
                    $report->fixed_issue,
                    $report->pending_issue,
                    $report->pending_reason,
                    $report->before_image ? asset('uploads/workreports/' . $report->before_image) : '',
                    $report->after_image ? asset('uploads/workreports/' . $report->after_image) : '',
                    optional($report->created_at)->format('d-m-Y'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Create Page
    public function create()
    {
        $users = User::where('status', 1)
            ->orderBy('first_name')
            ->get();

        $projects = Project::where('status', 1)->orderBy('project_name')->get();

        return view(
            'admin.pages.WorkReports.create',
            compact('users', 'projects')
        );
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required',
            'report_date'   => 'required',
            'working_hours' => 'required',
            'project_id'    => 'required',
            'issue_status'  => 'required',
        ]);

        // if validation fails 
        $beforeImage = null;
        $afterImage  = null;

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

        WorkReports::create([
            'user_id'        => $request->user_id,
            'report_date'    => $request->report_date,
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
        return redirect()
            ->route('admin.work.reports.list')
            ->with('flash_success', 'Work Report Added Successfully');
    }

    // View
    public function view($id)
    {
        $workreport = WorkReports::findOrFail($id);

        return view('admin.pages.WorkReports.view', compact('workreport'));
    }

    // // Edit
    // public function edit($id)
    // {
    //     $workreport = WorkReports::findOrFail($id);

    //     return view('admin.pages.WorkReports.edit', compact('workreport'));
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

    //     return redirect()->route('admin.work.reports.list')->with('flash_success', 'Work Report Updated Successfully');
    // }

    // Delete
    public function delete($id)
    {
        $workreport = WorkReports::find($id);

        if ($workreport) {

            $workreport->delete();

            return redirect()->back()->with('flash_success', 'Work Report Deleted Successfully');
        }

        return redirect()->back()->with('flash_error', 'Record Not Found');
    }
}
