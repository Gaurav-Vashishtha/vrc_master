<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\IPOContactLanding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IPOContactLandingController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'required|string|max:20',
            'company'     => 'required|string|max:255',
            'interest'    => 'required|string|max:255',
            'requirement' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $contact = IPOContactLanding::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'company'     => $request->company,
            'interest'    => $request->interest,
            'requirement' => $request->requirement,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Enquiry submitted successfully!',
            // 'data'    => $contact,
        ], 201);
    }
}
