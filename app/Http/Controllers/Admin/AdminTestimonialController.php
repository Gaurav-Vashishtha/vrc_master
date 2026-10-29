<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    // Testimonials List
    public function index(Request $request)
    {
        $query = Testimonial::latest();

        // From Date Filter
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        // To Date Filter
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Pagination
        $testimonials = $query->get();

        return view(
            'admin.pages.Testimonials.index',
            compact('testimonials')
        );
    }


    // Edit Page
    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        return view(
            'admin.pages.Testimonials.edit',
            compact('testimonial')
        );
    }


    // Update Testimonial
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'nullable|email|max:255',

            'designation' => 'nullable|string|max:255',

            'description' => 'required|string',

            'rating' => 'required|integer|min:1|max:5',

            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'status' => 'required|in:0,1',
        ]);


        $testimonial = Testimonial::findOrFail($id);


        // Basic Details
        $testimonial->name = $request->name;

        $testimonial->email = $request->email;

        $testimonial->designation = $request->designation;

        $testimonial->description = $request->description;

        $testimonial->rating = $request->rating;

        $testimonial->status = $request->status;


        // Update Photo
        if ($request->hasFile('photo')) {

            $photo = $request->file('photo');

            $photoName = time() . '.' .
                $photo->getClientOriginalExtension();

            $photo->move(
                public_path('uploads/testimonials'),
                $photoName
            );

            $testimonial->photo = $photoName;
        }


        $testimonial->save();


        return redirect()
            ->route('admin.testimonials')
            ->with(
                'flash_success',
                'Testimonial Updated Successfully'
            );
    }


    // Change Status
    public function status($id)
    {
        $testimonial = Testimonial::findOrFail($id);


        if ($testimonial->status == 1) {

            $testimonial->status = 0;

        } else {

            $testimonial->status = 1;
        }


        $testimonial->save();


        return redirect()
            ->route('admin.testimonials')
            ->with(
                'flash_success',
                'Testimonial Status Updated Successfully'
            );
    }
}