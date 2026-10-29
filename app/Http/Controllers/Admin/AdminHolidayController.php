<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Illuminate\Http\Request;

class AdminHolidayController extends Controller
{

    //User Logs Listing

    public function index(Request $request)
    {
        $query = Holiday::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('from_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('to_date', '<=', $request->to_date);
        }

        $holidays = $query->get();

        return view('admin.pages.Holiday.index', compact('holidays'));
    }

    //create Holiday Leave

    public function create()
    {
        return view('admin.pages.Holiday.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'holiday_name' => 'required',
            'from_date'    => 'required',
            'to_date'      => 'required',
            'total_days'   => 'required',
        ]);

        Holiday::create([
            'holiday_name' => $request->holiday_name,
            'from_date'    => $request->from_date,
            'to_date'      => $request->to_date,
            'total_days'   => $request->total_days,
        ]);

        return redirect()->route('admin.holiday.list')->with('flash_success', 'Holiday Added Successfully');
    }


    //Delete User Log

    public function delete($id)
    {
        $data = Holiday::find($id);

        if ($data) {
            $data->delete();

            return redirect()->back()->with(
                'flash_success',
                'Holiday Deleted Successfully!'
            );
        }

        return redirect()->back()->with(
            'flash_error',
            "Error while deleting ID - $id"
        );
    }
}
