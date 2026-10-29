<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckIpMaster;
use Illuminate\Http\Request;

class AdminCheckIpAddressController extends Controller
{
    public function index()
    {
        $secondMaster = CheckIpMaster::first();

        return view('admin.pages.check-ip.index', compact('secondMaster'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|ip',
        ]);

        $allDays = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];

        $days = [];

        foreach ($allDays as $day) {
            $days[$day] = isset($request->days[$day]) ? 1 : 0;
        }

        $data = CheckIpMaster::first();

        if (!$data) {
            $data = new CheckIpMaster();
        }
        if (empty($data->ip_address) && empty($data->days)) {
            $data->ip_address = $request->ip_address;
        }
        elseif ($request->boolean('force_update_ip')) {
            $data->ip_address = $request->ip_address;
        }

        $data->days = $days;
        $data->save();

        return back()->with('flash_success', 'IP Day Settings Updated Successfully');
    }
}
