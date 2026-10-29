<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\IPOContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IPOContactUsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'nullable|string|max:255',
            'company'           => 'nullable|string|max:255',
            'email'             => 'nullable|email|max:255',
            'phone'             => 'nullable|string|max:20',
            'ipo_stage'         => 'nullable|string|max:255',
            'validation_points' => 'nullable|string',
            'message'           => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $contact = IPOContactUs::create([
            'name'              => $request->name,
            'company'           => $request->company,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'ipo_stage'         => $request->ipo_stage,
            'validation_points' => $request->validation_points,
            'message'           => $request->message,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Enquiry submitted successfully!',
            // 'data'    => $contact,
        ], 201);
    }
}
