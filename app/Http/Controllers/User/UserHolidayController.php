<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Illuminate\Http\Request;

class UserHolidayController extends Controller
{
    public function index(Request $request)
    {
        $query = Holiday::query();

        if ($request->filled('from_date')) {
            $query->whereDate('from_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('to_date', '<=', $request->to_date);
        }

        $holidays = $query->latest()->get();

        return view('user.pages.Holiday.index', compact('holidays'));
    }
}