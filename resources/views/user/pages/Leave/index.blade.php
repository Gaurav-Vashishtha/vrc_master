@extends('user.template.base')

@section('title', 'Leave List')

@section('styles')
<style>
    pre {
        background: #191c24;
        padding: 15px;
        font-size: 14px;
        color: white;
        white-space: break-spaces;
    }
</style>
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
    .badge, .badge:hover{
        color: white;
    }
</style>
@endsection

@section('content')
<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title">Leave List</h3>

            <a href="{{ route('user.leave.create') }}" class="btn btn-success">
                Apply Leave
            </a>
        </div>

        <div class="row">
            <div class="col-12 grid-margin">

                <div class="card">
                    <div class="card-body">

                        <form method="GET" action="{{ route('user.leave.list') }}">
                            <div class="d-flex align-items-end flex-wrap" style="gap:5px;">

                                <div>
                                    <label>From Date</label>
                                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                </div>

                                <div>
                                    <label>To Date</label>
                                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                </div>

                                <div>
                                    <label>Leave Type</label>
                                    <select name="leave_type" class="form-control search select2">
                                        <option value="">Select Leave Type</option>
                                        <option value="Casual Leave" {{ request('leave_type') == 'Casual Leave' ? 'selected' : '' }}>Casual Leave</option>
                                        <option value="Sick Leave" {{ request('leave_type') == 'Sick Leave' ? 'selected' : '' }}>Sick Leave</option>
                                        <option value="Emergency Leave" {{ request('leave_type') == 'Emergency Leave' ? 'selected' : '' }}>Emergency Leave</option>
                                        <option value="Paid Leave" {{ request('leave_type') == 'Paid Leave' ? 'selected' : '' }}>Paid Leave</option>
                                        <option value="Half Day" {{ request('leave_type') == 'Half Day' ? 'selected' : '' }}>Half Day</option>
                                        <option value="Short Leave" {{ request('leave_type') == 'Short Leave' ? 'selected' : '' }}>Short Leave</option>
                                    </select>
                                </div>

                                <div class="d-flex" style="gap:5px;">
                                    <button class="btn btn-primary btn-fixed">
                                        Search
                                    </button>

                                    <a href="{{ route('user.leave.list') }}"
                                       class="btn btn-warning btn-fixed">
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
                                        <th>Leave Type</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Total Days</th>
                                        <th>Leave Reason</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>

                                @forelse($leaves as $key => $leave)

                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $leave->leave_type }}</td>
                                        <td>{{ date('D, d-m-Y', strtotime($leave->from_date)) }}</td>
                                        <td>{{ date('D, d-m-Y', strtotime($leave->to_date)) }}</td>
                                        <td>{{ $leave->total_days }}</td>
                                        <td>
                                            <i class="mdi mdi-eye text-primary view-leave-reason"
                                            style="cursor: pointer;"
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="View Leave Reason"
                                            data-leave-reason="{{ $leave->leave_reason ?? 'No Leave Reason Available' }}">
                                            </i>
                                        </td>
                                        <td>
                                            @if($leave->status == 0)
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($leave->status == 1)
                                                <span class="badge badge-success">Approved</span>
                                            @elseif($leave->status == 2)
                                                <span class="badge badge-danger">Rejected</span>
                                            @else
                                                <span class="badge badge-secondary">Unknown</span>
                                            @endif


                                            @if($leave->status == 1)
                                                @if($leave->withdrawal_status == 0)
                                                    <a class="badge bg-warning" href="{{ route('user.leave.details', $leave->id) }}">Request Withdrawal</a>
                                                @elseif($leave->withdrawal_status == 1)
                                                    <a class="badge bg-warning" href="{{ route('user.leave.details', $leave->id) }}">Withdrawal Pending</a>
                                                @elseif($leave->withdrawal_status == 2)
                                                    <a class="badge bg-success" href="{{ route('user.leave.details', $leave->id) }}">Withdrawn</a>
                                                @elseif($leave->withdrawal_status == 3)
                                                    <a class="badge bg-danger" href="{{ route('user.leave.details', $leave->id) }}">Withdrawal Rejected</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            No Leave Found
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

<!-- Leave Reason Modal -->
<div class="modal fade" id="leaveReasonModal" tabindex="-1" role="dialog" aria-labelledby="leaveReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="leaveReasonModalLabel">
                    Leave Reason
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p>
                    <pre id="leaveReasonText"></pre>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('.view-leave-reason').on('click', function () {
        let leaveReason = $(this).data('leave-reason');
        $('#leaveReasonText').text(leaveReason);
        $('#leaveReasonModal').modal('show');
    });
});
</script>
@endsection