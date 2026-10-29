<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminCareerController extends Controller
{

    public function index(Request $request)
    {
        $query = Career::orderBy('doe', 'desc');

        if ($request->filled('from_date')) {
            $query->where('doe', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('doe', '<=', $request->to_date);
        }

        $users = $query->get();

        return view('admin.pages.career.index', compact('users'));
    }


    public function export(Request $request)
    {
        $query = Career::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $careers = $query->get();

        $fileName = "careers.csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($careers) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Name',
                'Experience',
                'Position',
                'email',
                'Contact No',
                'CV File',
                'Date'
            ]);

            foreach ($careers as $career) {
                fputcsv($file, [
                    $career->name,
                    $career->experience,
                    $career->position,
                    $career->email,
                    $career->contact_no,
                    $career->cvfile,
                    $career->doe
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
