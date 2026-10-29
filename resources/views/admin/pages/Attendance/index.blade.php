@extends('admin.template.base')

@section('title', 'Attendance List')

@section('styles')

<link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('admin/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">

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

    .select2-container {
        width: 180px !important;
    }

    .select2-container .select2-selection--single {
        height: 42px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        text-align: center;
        padding-left: 0 !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        text-align: center;
        width: 100%;
    }

    .select2-container--default .select2-selection--single {
        background-color: #2A3038;
        border: none;
        border-radius: 4px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #fff;
        line-height: 20px;
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
        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title">
                Attendance List
            </h3>
        </div>

        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('admin.attendance') }}">
                            <div class="d-flex align-items-end gap-3 flex-wrap" style="gap:5px">

                                <div class="mb-2">
                                    <label>From Date</label>
                                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') ?? date('Y-m-01') }}">
                                </div>

                                <div class="mb-2">
                                    <label>To Date</label>
                                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') ?? date('Y-m-d') }}">
                                </div>

                                <div class="mb-2">
                                    <select name="user_id"  class="form-control search select2">
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <select name="leave_type[]" class="form-control select2" multiple data-placeholder="Select Leave Types" aria-label="Select Leave Types">
                                        <option value="Casual Leave" {{ in_array('Casual Leave', (array) request('leave_type', []), true) ? 'selected' : '' }}>Casual Leave</option>
                                        <option value="Sick Leave" {{ in_array('Sick Leave', (array) request('leave_type', []), true) ? 'selected' : '' }}>Sick Leave</option>
                                        <option value="Emergency Leave" {{ in_array('Emergency Leave', (array) request('leave_type', []), true) ? 'selected' : '' }}>Emergency Leave</option>
                                        <option value="Paid Leave" {{ in_array('Paid Leave', (array) request('leave_type', []), true) ? 'selected' : '' }}>Paid Leave</option>
                                        <option value="Half Day" {{ in_array('Half Day', (array) request('leave_type', []), true) ? 'selected' : '' }}>Half Day</option>
                                        <option value="Short Leave" {{ in_array('Short Leave', (array) request('leave_type', []), true) ? 'selected' : '' }}>Short Leave</option>
                                    </select>
                                </div>

                                <div class="d-flex gap-2 mb-2" style="gap:3px">
                                    <button type="submit" class="btn btn-primary btn-fixed">Filter</button>

                                    <a href="{{ route('admin.attendance') }}" class="btn btn-secondary btn-fixed">Reset</a>
                                    
                                    <a href="{{ route('admin.attendance.reports.export', request()->all()) }}" class="btn btn-success btn-fixed">Export CSV</a>
                                </div>

                            </div>
                        </form>


                        <div class="table-responsive">
                            <table class="table table-hover" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Employee Name</th>
                                        <th>Attendance Date</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                        <th>Total Work</th>
                                        <th>Status</th>
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

@section('scripts')
<script src="{{ URL::asset('admin/assets/vendors/select2/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection