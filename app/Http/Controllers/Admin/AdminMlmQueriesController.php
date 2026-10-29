<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MlmQueries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminMlmQueriesController extends Controller
{

    public function index(Request $request)
    {
        $query = MlmQueries::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $users = $query->get();

        return view('admin.pages.MlmQueries.index', compact('users'));
    }


    public function export(Request $request)
    {
        $query = MlmQueries::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $mlm_queries = $query->get();

        $fileName = "mlm_queries.csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($mlm_queries) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Name',
                'Address',
                'Email',
                'Contact',
                'Contact Time',
                'Date'
            ]);

            foreach ($mlm_queries as $mlm_query) {
                fputcsv($file, [
                    $mlm_query->fullname,
                    $mlm_query->address,
                    $mlm_query->email,
                    $mlm_query->contact,
                    $mlm_query->contact_time,
                   
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
