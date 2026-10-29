<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\employee;
use App\Models\attendance;
use App\Models\Reminder;

class AdminController extends Controller
{
    // This function show the Admin Dashboard
    public function dashboard()
    {
        $employees = [];

        $NoOfEmployees = count($employees);

        $workingEmp = [];

        $NoOfWorkingEmp = count($workingEmp);

        $CurrentWorkingEmp = [];

        $activeReminders = Reminder::activeReminders()->orderBy('reminder_date', 'asc')->get();
         return view('admin.Dashboard', compact('NoOfEmployees','NoOfWorkingEmp','CurrentWorkingEmp','activeReminders')
        );
    }


    public function underDevelopment()
    {
        return view('admin.under-development');
    }


    public function underDevelopmentSeller()
    {
        return view('seller.under-development');
    }
}
