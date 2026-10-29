@extends('user.template.base')

@section('title', 'Work Reports List')

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
        min-width: 180px;
        height: 42px;
    }

    .card-body {
        padding: 25px !important;
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
            <h3 class="page-title">Work Reports List</h3>

            <a href="{{ route('user.work.reports.create') }}"
                class="btn btn-success">
                Add Work Report
            </a>
        </div> 

        <div class="row">
            <div class="col-12 grid-margin">

                <div class="card">
                    <div class="card-body">

                        <!-- Filter Form -->
                        <form method="GET"
                            action="{{ route('user.work.reports.list') }}">

                            <div class="d-flex align-items-end gap-3 flex-wrap" style="gap:5px">

                                <div class="mb-2">
                                    <label>From Date</label> <input type="date" name="from_date" class="form-control" value="{{ request('from_date') ?? date('Y-m-01') }}">
                                </div>

                                <div class="mb-2">
                                    <label>To Date</label> <input type="date" name="to_date" class="form-control" value="{{ request('to_date') ?? date('Y-m-d') }}">
                                </div>

                                <div class="d-flex gap-2 mb-2" style="gap:3px">

                                    <button type="submit" class="btn btn-primary btn-fixed">
                                        Filter
                                    </button>

                                    <a href="{{ route('user.work.reports.list') }}" class="btn btn-secondary btn-fixed">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Table -->
                            <div class="table-responsive" >
                                <table class="table table-hover" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>User Name</th>
                                        <th>Report Date</th>
                                        <th>Working Hours</th>
                                        <th>Project Name</th>
                                        <th>Issue Status</th>
                                        <th>Project Issue</th>
                                        <th>Before Image</th>
                                        <th>After Image</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($workreports as $key => $report)

                                    <tr>

                                        <td>
                                            {{  $key + 1 }}
                                        </td>

                                        <td>{{ $report?->user?->first_name }} {{ $report?->user?->last_name }}</td>

                                        <td>
                                            {{ date('d-m-Y', strtotime($report->report_date)) }}
                                        </td>

                                        <td>{{ $report->working_hours }}</td>

                                        <td>
                                            @if($report->project_id == -1)
                                                {{ $report->project_name }}
                                            @else
                                                {{ $report?->project?->project_name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($report->issue_status == 'Completed')
                                            <span class="badge bg-success">
                                                Completed
                                            </span>
                                            @else
                                            <span class="badge bg-warning">
                                                {{ $report->issue_status }}
                                            </span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ Str::limit($report->project_issue, 40) }}
                                        </td>

                                        <td>
                                            @if($report->before_image)
                                            <img src="{{ asset('uploads/workreports/'.$report->before_image) }}"
                                                width="60">
                                            @else
                                            N/A
                                            @endif
                                        </td>

                                        <td>
                                            @if($report->after_image)
                                            <img src="{{ asset('uploads/workreports/'.$report->after_image) }}"
                                                width="60">
                                            @else
                                            N/A
                                            @endif
                                        </td>

                                        <td>
                                            {{ $report->created_at ? $report->created_at->format('d M Y') : '-' }}
                                        </td>

                                        <td>
                                           
                                            <a href="{{ route('user.work.reports.view',$report->id) }}"
                                            title="View">
                                            <i class="mdi mdi-eye text-primary"></i>
                                            </a>

                                            <!-- Delete -->
                                            @if($report->created_at->format('d M Y') == now()->format('d M Y'))
                                            <a href="{{ route('user.work.reports.delete',$report->id) }}"
                                                onclick="return confirm('Are you sure you want to delete this report?')"
                                                title="Delete">
                                                <i class="mdi mdi-delete text-danger"></i>
                                            </a>
                                            @endif
                                        </td>

                                    </tr>

                                    @empty

                                    <tr>
                                        <td colspan="11" class="text-center">
                                            No Work Reports Found
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