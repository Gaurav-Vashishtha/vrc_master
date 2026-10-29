<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminTestimonialApiController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Testimonials fetched successfully.',
            'data' => $testimonials
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'designation' => 'nullable|string|max:255',
            'description' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }


        $testimonial = new Testimonial();

        $testimonial->name = $request->name;
        $testimonial->email = $request->email;
        $testimonial->designation = $request->designation;
        $testimonial->description = $request->description;
        $testimonial->rating = $request->rating;
        $testimonial->ip = $request->ip();
        $testimonial->status = 0;

        if ($request->hasFile('photo')) {

            $photo = $request->file('photo');

            $photoName = time() . '_' . $photo->getClientOriginalName();

            $photo->move(
                public_path('uploads/testimonials'),
                $photoName
            );

            $testimonial->photo = $photoName;
        }

        $testimonial->save();

        return response()->json([
            'status' => true,
            'message' => 'Testimonial added successfully',
            'data' => $testimonial
        ], 201);
    }
}
