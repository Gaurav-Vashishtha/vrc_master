<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\attendance;
use Illuminate\Http\Request;
use App\Models\Holiday;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class UserAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->input('from_date') ?: date('Y-m-01');
        $toDate   = $request->input('to_date') ?: date('Y-m-d');

        $userID = Session::get('users.id');
        $usersQuery = User::where('usertype', 3)->where('id', $userID)->get();

        $attendances = attendance::with('user')
            ->whereDate('att_date', '>=', $fromDate)
            ->whereDate('att_date', '<=', $toDate)
            ->where('emp_code', $userID)
            ->get();

        $attendanceMap = [];
        foreach ($attendances as $record) {
            if ($record->user && $record->att_date) {
                $dateKey = Carbon::parse($record->att_date)->format('Y-m-d');

                $attendanceMap[$record->user->id . '_' . $dateKey] = $record;
            }
        }

        $holidays = Holiday::whereDate('from_date', '<=', $toDate)
            ->whereDate('to_date', '>=', $fromDate)
            ->get();

        $period = array_reverse(
            iterator_to_array(CarbonPeriod::create($fromDate, $toDate))
        );

        $calendarRows = [];
        foreach ($period as $periodDate) {
            $date = $periodDate->copy();
            $dateString = $date->format('Y-m-d');

            $holiday = $holidays->first(function ($item) use ($dateString) {
                return $dateString >= Carbon::parse($item->from_date)->format('Y-m-d')
                    && $dateString <= Carbon::parse($item->to_date)->format('Y-m-d');
            });

            $status = null;
            $type = null;

            if ($holiday) {
                $status = 'Holiday';
                $type = $holiday->holiday_name;
            } elseif ($date->isSunday()) {
                $status = 'Sunday';
                $type = 'Weekly Off';
            } elseif (isSaturdayOff($date)) {
                $status = 'Saturday Off';
                $type = 'Weekly Off';
            }

            if ($status !== null) {
                $calendarRows[] = [
                    'user'       => null,
                    'date'       => $date->format('d-m-Y'),
                    'day'        => $date->format('l'),
                    'check_in'   => '',
                    'check_out'  => '',
                    'total_work' => '',
                    'status'     => $status,
                    'type'       => $type,
                ];
                continue;
            }

            foreach ($usersQuery as $user) {
                $key = $user->id . '_' . $dateString;
                $record = $attendanceMap[$key] ?? null;

                if ($record) {
                    $employeeStatus = $record->att_type ?: 'Present';
                } else {
                    $employeeStatus = 'Absent';
                }

                $calendarRows[] = [
                    'user'       => $user,
                    'date'       => $date->format('d-m-Y'),
                    'day'        => $date->format('l'),
                    'check_in'   => $record?->check_in ?? '-',
                    'check_out'  => $record?->check_out ?? '-',
                    'total_work' => $record?->total_work ?? '-',
                    'status'     => $employeeStatus,
                    'type'       => $employeeStatus,
                ];
            }
        }

        return view('user.pages.Attendance.index', compact('calendarRows', 'fromDate', 'toDate'));
    }

    public function export(Request $request)
    {
        $userID = Session::get('users.id');
        $fromDate = $request->input('from_date') ?: date('Y-m-01');
        $toDate = $request->input('to_date') ?: date('Y-m-d');

        $attendances = attendance::with('user')
            ->where('emp_code', $userID)
            ->whereDate('att_date', '>=', $fromDate)
            ->whereDate('att_date', '<=', $toDate)
            ->get();

        $attendanceMap = [];
        foreach ($attendances as $record) {
            if ($record->user && $record->att_date) {
                $dateKey = Carbon::parse($record->att_date)->format('Y-m-d');
                $attendanceMap[$record->user->id . '_' . $dateKey] = $record;
            }
        }

        $user = User::where('usertype', 3)->where('id', $userID)->first();
        $holidays = Holiday::whereDate('from_date', '<=', $toDate)
            ->whereDate('to_date', '>=', $fromDate)
            ->get();
        $period = CarbonPeriod::create($fromDate, $toDate);

        $exportRows = [];
        foreach ($period as $periodDate) {
            $date = $periodDate->copy();
            $dateString = $date->format('Y-m-d');
            $holiday = $holidays->first(function ($item) use ($dateString) {
                return $dateString >= Carbon::parse($item->from_date)->format('Y-m-d')
                    && $dateString <= Carbon::parse($item->to_date)->format('Y-m-d');
            });

            if ($holiday) {
                $exportRows[] = [
                    '',
                    $date->format('D'),
                    $date->format('d-m-Y'),
                    '',
                    '',
                    '',
                    'Holiday: ' . $holiday->holiday_name,
                ];
                continue;
            }

            if ($date->isSunday()) {
                $status = 'Sunday';
            } elseif (isSaturdayOff($date)) {
                $status = 'Saturday Off';
            } else {
                $record = $attendanceMap[($user?->id ?? '') . '_' . $dateString] ?? null;
                $userName = trim(
                    ($user?->first_name ?? '') . ' ' .
                    ($user?->last_name ?? '')
                );

                $exportRows[] = [
                    $userName ?: '-',
                    $date->format('D'),
                    $date->format('d-m-Y'),
                    $record?->check_in ?? '-',
                    $record?->check_out ?? '-',
                    $record?->total_work ?? '-',
                    $record ? ($record->att_type ?: 'Present') : 'Absent',
                ];
                continue;
            }

            $exportRows[] = [
                '',
                $date->format('D'),
                $date->format('d-m-Y'),
                '',
                '',
                '',
                $status,
            ];
        }

        $fileName = 'my_attendances_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];

        $callback = function () use ($exportRows) {
            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'Sr.No',
                'Employee Name',
                'Attendance Day',
                'Attendance Date',
                'Check In',
                'Check Out',
                'Total Work',
                'Attendance Type',
            ]);

            foreach ($exportRows as $key => $row) {
                fputcsv($file, array_merge([$key + 1], $row));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}