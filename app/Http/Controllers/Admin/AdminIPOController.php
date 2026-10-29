<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IPOContactUs;
use App\Models\IPOContactLanding;

class AdminIPOController extends Controller
{
    //
    public function ipoContactUs(Request $request)
    {
        $query = IPOContactUs::orderBy('created_at', 'desc');
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        $contactUs = $query->paginate(10);
        return view('admin.pages.ipo.contactusIndex', compact('contactUs'));
    }

    public function ipoContactUsView($id)
    {
        $contact = IPOContactUs::findOrFail($id);
        return view('admin.pages.ipo.contactusView', compact('contact'));
    }

    public function ipocontactsExport(Request $request)
    {
        $query = IPOContactUs::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $contacts = $query->get();

        $fileName = "IPOcontacts.csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($contacts) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Name',
                'Company Name',
                'Email',
                'Phone',
                'IPO Stage',
                'Validation Points',
                'Message',
                'Date',
            ]);

            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->name,
                    $contact->company,
                    $contact->email,
                    $contact->phone,
                    $contact->ipo_stage,
                    $contact->validation_points,
                    $contact->message,
                    $contact->created_at->format('d-m-Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    
    public function ipoContactLanding(Request $request)
    {
        $query = IPOContactLanding::orderBy('created_at', 'desc');
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }
        $contactUs = $query->paginate(10);
        return view('admin.pages.ipo.contactusLanding', compact('contactUs'));
    }

    public function ipoContactLandingView($id)
    {
        $contact = IPOContactLanding::findOrFail($id);
        return view('admin.pages.ipo.contactusLandingView', compact('contact'));
    }

    public function ipocontactsLandingExport(Request $request)
    {
        $query = IPOContactLanding::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $contacts = $query->get();

        $fileName = "IpoLandingContacts.csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($contacts) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Name',
                'Company Name',
                'Email',
                'Phone',
                'interest',
                'Requirement',
                'Date',
            ]);

            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->name,
                    $contact->company,
                    $contact->email,
                    $contact->phone,
                    $contact->interest,
                    $contact->requirement,
                    $contact->created_at->format('d-m-Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
