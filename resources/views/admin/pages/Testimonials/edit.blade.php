@extends('admin.template.base')

@section('title', 'Edit Testimonial')

@section('content')

<style>
    .card-body {
        padding: 25px !important;
    }

    .form-control {
        height: 42px;
    }

    textarea.form-control {
        height: 120px;
    }

    .current-photo {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 10px;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title"> Edit Testimonial </h3>
            <a href="{{ route('admin.testimonials') }}" class="btn btn-secondary">
                Back
            </a>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label><strong>Name</strong></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $testimonial->name) }}" placeholder="Enter name" required>
                                    @error('name')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label><strong>Email</strong></label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $testimonial->email) }}" placeholder="Enter email">
                                    @error('email')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label><strong>Designation</strong></label>
                                    <input type="text" name="designation" class="form-control" value="{{ old('designation', $testimonial->designation) }}" placeholder="Enter designation">
                                    @error('designation')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label><strong>Rating</strong></label>
                                    <select name="rating" class="form-control" required>
                                        <option value="">Select Rating</option>
                                        <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}> 1 </option>
                                        <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}> 2 </option>
                                        <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}> 3 </option>
                                        <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}> 4 </option>
                                        <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}> 5 </option>
                                    </select>

                                    @error('rating')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label><strong>Description</strong></label>
                                    <textarea name="description" class="form-control" placeholder="Enter description" required>{{ old('description', $testimonial->description) }}</textarea>
                                    @error('description')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label><strong>Current Photo</strong></label>
                                    <div>
                                        @if($testimonial->photo)
                                        <img src="{{ asset('uploads/testimonials/' . $testimonial->photo) }}" class="current-photo" alt="testimonial">
                                        @else
                                        <p>-</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">

                                    <label> <strong>Change Photo</strong> </label>
                                    <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                                    @error('photo')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label><strong>Status</strong></label>
                                    <select name="status" class="form-control" required>
                                        <option value="1" {{ old('status', $testimonial->status) == 1 ? 'selected' : '' }}> Active </option>
                                        <option value="0" {{ old('status', $testimonial->status) == 0 ? 'selected' : '' }}> Inactive </option>
                                    </select>

                                    @error('status')
                                    <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary"> Update Testimonial </button>
                                <a href="{{ route('admin.testimonials') }}" class="btn btn-secondary"> Cancel </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection