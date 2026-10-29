@extends('admin.template.base')

@section('title', 'Testimonials List')

@section('content')

<style>
    .btn-fixed {
        height: 38px;
        min-width: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-control {
        height: 38px;
    }

    .card-body {
        padding: 25px !important;
    }

    .form-control {
        min-width: 180px;
        height: 42px;
    }

    .btn-fixed {
        min-width: 120px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table-responsive {
        margin-top: 15px;
    }

    .table th,
    .table td {
        padding: 14px 12px;
        vertical-align: middle;
    }

    .testimonial-photo {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title"> All Testimonials </h3>
        </div>

        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.testimonials') }}">

                            <div class="d-flex align-items-end gap-3 flex-wrap" style="gap:5px">

                                <div class="mb-2">
                                    <label> <strong>From Date</strong> </label>
                                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                </div>

                                <div class="mb-2">
                                    <label> <strong>To Date</strong> </label>
                                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                </div>

                                <div class="d-flex gap-2 mb-2" style="gap:3px">

                                    <button type="submit" class="btn btn-primary me-2 btn-fixed">
                                        Filter
                                    </button>

                                    <a href="{{ route('admin.testimonials') }}" class="btn btn-secondary me-2 btn-fixed">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-hover" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Designation</th>
                                        <th>Description</th>
                                        <th>Rating</th>
                                        <th>IP & Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @forelse($testimonials as $key => $testimonial)
                                    <tr>
                                        <td>{{ ++ $key }}</td>
                                        <td>
                                            @if($testimonial->photo)
                                            <img src="{{ asset('uploads/testimonials/' . $testimonial->photo) }}" class="testimonial-photo" alt="testimonial">
                                            @else
                                            <span>-</span>
                                            @endif
                                        </td>
                                        <td>{{ $testimonial->name }} </td>
                                        <td>{{ $testimonial->email ?? '-' }}</td>
                                        <td>{{ $testimonial->designation ?? '-' }}</td>
                                        <td>{{ Str::limit($testimonial->description, 60) }}</td>
                                        <td>{{ $testimonial->rating }}/5 </td>
                                        <td>{{ $testimonial->ip ?? '-' }}
                                            <br>
                                            {{ $testimonial->created_at->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            @if($testimonial->status == 1)
                                            <a href="{{ route('admin.testimonials.status', $testimonial->id) }}" class="btn btn-sm btn-success">
                                                Active
                                            </a>
                                            @else
                                            <a href="{{ route('admin.testimonials.status', $testimonial->id) }}" class="btn btn-sm btn-danger">
                                                Inactive
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" title="Edit">
                                                <i class="mdi mdi-pencil" style="color:blue;font-size:18px;"> </i>
                                            </a>
                                        </td>
                                    </tr>

                                    @empty

                                    <tr>
                                        <td colspan="11" class="text-center">No Testimonials Found </td>
                                    </tr>

                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection