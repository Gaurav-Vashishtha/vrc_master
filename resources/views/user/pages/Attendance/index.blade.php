@extends('user.template.base')

@section('title', 'My Attendance')

@section('styles')

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

    /* Pagination Fix */
    .custom-pagination {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .custom-pagination .pagination {
        display: flex;
        list-style: none;
        padding-left: 0;
        margin: 0;
        gap: 4px;
    }

    .custom-pagination .page-item {
        display: inline-block;
    }

    .custom-pagination .page-link {
        position: relative;
        display: block;
        padding: 8px 12px;
        margin-left: 0;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6;
        text-decoration: none;
        border-radius: 4px;
    }

    .custom-pagination .page-item.active .page-link {
        z-index: 1;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .custom-pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }
    table.table tr.table-info,
        table.table tr.table-info > td,
        table.table tr.table-info > th {
        background-color: rgba(139, 92, 246, 0.22) !important; /* Deep AI purple overlay */
        color: #f3e8ff !important; /* Crisp white-purple for high readability */
        font-weight: 500;
    }
</style>

@endsection
@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title"> My Attendance </h3>
        </div>

        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        
                        <form method="GET"
                            action="{{ route('user.attendance') }}">

                            <div class="d-flex align-items-end gap-3 flex-wrap"
                                style="gap:5px">

                                <div class="mb-2">
                                    <label>From Date</label>
                                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') ?? date('Y-m-01') }}">
                                </div>

                                <div class="mb-2">
                                    <label>To Date</label>
                                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') ?? date('Y-m-d') }}">
                                </div>

                                <div class="d-flex gap-2 mb-2" style="gap:3px">

                                    <button type="submit" class="btn btn-primary btn-fixed">
                                        Filter
                                    </button>

                                    <a href="{{ route('user.attendance') }}" class="btn btn-secondary btn-fixed">
                                        Reset
                                    </a>

                                    <a href="{{ route('user.attendance.reports.export', request()->all()) }}" class="btn btn-success btn-fixed">
                                        Export CSV
                                    </a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-hover"
                                id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Employee Name</th>
                                        <th>Attendance Date</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Total Work</th>
                                        <th>Attendance Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($calendarRows as $key => $row)
                                        <tr @if(in_array($row['status'], ['Holiday', 'Sunday', 'Saturday Off']))
                                                class="table-info"
                                            @endif
                                        >
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ $row['user']?->first_name }}
                                                {{ $row['user']?->last_name }}
                                            </td>
                                            <td>{{ date('D d-m-Y', strtotime($row['date'])) }}</td>
                                            <td>{{ $row['check_in'] }}</td>
                                            <td>{{ $row['check_out'] }}</td>
                                            <td>{{ $row['total_work'] }}</td>
                                            <td>
                                                @if($row['status'] == 'Present')
                                                    <span class="badge bg-success">Present</span>
                                                @elseif($row['status'] == 'Absent')
                                                    <span class="badge bg-danger">Absent</span>
                                                @elseif($row['status'] == 'Holiday')
                                                    <span class="badge bg-warning text-dark">
                                                        Holiday: {{ $row['type'] }}
                                                    </span>
                                                @elseif($row['status'] == 'Sunday')
                                                    <span class="badge bg-primary">Sunday</span>
                                                @elseif($row['status'] == 'Saturday Off')
                                                    <span class="badge bg-primary">
                                                        Saturday Off
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning text-dark">
                                                        {{ $row['status'] }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                No Attendance Found
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