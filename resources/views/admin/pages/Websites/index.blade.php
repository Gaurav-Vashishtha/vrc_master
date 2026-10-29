@extends('admin.template.base')

@section('title', 'Websites List')

@section('content')
<style>
    /* .d-flex.mainbtn {
    justify-content: space-around;
    padding-top: 31px;
    width: 154px;
} */

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
</style>
<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title">All Websites</h3>

            <a href="{{ route('admin.websites.create') }}"
                class="btn btn-success">
                Add Website
            </a>
        </div>


        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">

                    <div class="card-body">
                        {{--<form method="GET" action="{{ route('admin.websites.index') }}">
                            <div class="d-flex align-items-end gap-3 flex-wrap" style="gap:5px">

                                <div class="mb-2">
                                    <label><strong>From Date</strong></label>
                                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                </div>

                                <div class="mb-2">
                                    <label><strong>To Date</strong></label>
                                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                </div>

                                <div class="d-flex gap-2  mb-2" style="gap:3px">
                                    <button type="submit" class="btn btn-primary me-2 btn-fixed">Filter</button>
                                    <a href="{{ route('admin.websites.index') }}" class="btn btn-secondary me-2 btn-fixed">Reset</a>
                                </div>

                            </div>
                        </form>--}}

                        <div class="table-responsive">

                            <table class="table table-hover" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Website Name</th>
                                        <th>Website URL</th>
                                        <th>User</th>
                                        <th>Logo</th>
                                        <!-- <th>Description</th> -->
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($websites as $key => $website)
                                    @php $index = 1; @endphp
                                    <tr>
                                        <td>
                                            {{ $key + 1  }}
                                        </td>

                                        <td>{{ $website->website_name }}</td>
                                        <td> <a href="{{ $website->website_url }}" target="_blank">{{$website->website_url}}</a>
                                        </td>
                                        <td>
                                            {{ $website->user->first_name ?? '' }}
                                            {{ $website->user->last_name ?? '' }}
                                        </td>

                                        <td>
                                            @if($website->logo)
                                            <a href="{{ asset('uploads/websites/'.$website->logo) }}" target="_blank">
                                                <img src="{{ asset('uploads/websites/'.$website->logo) }}" alt="Logo" style="width:40px;height:40px;">
                                            </a>
                                            @else
                                            No Logo
                                            @endif
                                        </td>
                                        <!-- <td>
                                            {{ $website->description ?? 'No Description' }}
                                        </td> -->

                                        <td>
                                            @if($website->status == 'active')
                                            <span class="badge bg-success">
                                                Active
                                            </span>
                                            @else
                                            <span class="badge bg-danger">
                                                Inactive
                                            </span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.websites.edit', $website->id) }}"
                                                class="btn btn-sm btn-primary"><i class="mdi mdi-pencil"></i>
                                                Edit
                                            </a>

                                            <a href="{{ route('admin.websites.history', $website->id) }}"
                                                class="btn btn-sm btn-info"><i class="mdi mdi-history"></i>History
                                            </a>
                                        </td>

                                    </tr>

                                    @empty

                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No Websites Found
                                        </td>
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