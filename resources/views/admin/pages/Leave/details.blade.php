@extends('admin.template.base')

@section('title', 'Leave Details')

@section('styles')

<style>
    .status-box { padding: 15px; border-radius: 6px; margin-bottom: 20px; }
    .detail-label { font-weight: 600; color: #0090e7; }
    .detail-value { margin-bottom: 15px; }
        pre {
        padding: 15px;
        font-size: 14px;
        white-space: break-spaces;
    }
</style>

@endsection

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title">Leave Withdrawal Details</h3>
            <a href="{{route('admin.leave.list')}}" class="btn btn-secondary">Back</a>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-4">Leave Information</h4>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="detail-value">
                                    <div class="detail-label">Employee</div>
                                    {{ $leave?->user?->first_name }} {{ $leave?->user?->last_name }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-value">
                                    <div class="detail-label">Leave Type</div>
                                    {{ $leave->leave_type }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-value">
                                    <div class="detail-label">From Date</div>
                                    {{ date('D, d-m-Y', strtotime($leave->from_date)) }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-value">
                                    <div class="detail-label">To Date</div>
                                    {{ date('D, d-m-Y', strtotime($leave->to_date)) }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-value">
                                    <div class="detail-label">Total Days</div>
                                    {{ $leave->total_days }}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="detail-value">
                                    <div class="detail-label">Leave Reason</div>
                                    {{ $leave->leave_reason ?? 'No Leave Reason Available' }}
                                </div>
                            </div>

                        </div>

                        <hr>

                        {{-- Leave Status --}}
                        <div class="status-box">
                            <h5>Leave Status</h5>

                            @if($leave->status == 0)
                                <span class="badge badge-warning">Pending</span>
                            @elseif($leave->status == 1)
                                <span class="badge badge-success">Approved</span>
                            @elseif($leave->status == 2)
                                <span class="badge badge-danger">Rejected</span>
                            @else
                                <span class="badge badge-secondary">Unknown</span>
                            @endif
                        </div>

                        {{-- Withdrawal Status --}}
                        <div class="status-box">
                            <h5>Withdrawal Status</h5>

                            @if($leave->withdrawal_status == 0)
                                <span class="badge badge-info">No Withdrawal Request</span>
                            @elseif($leave->withdrawal_status == 1)
                                <span class="badge badge-warning">Withdrawal Pending</span>
                            @elseif($leave->withdrawal_status == 2)
                                <span class="badge badge-sucess">Withdrawn</span>
                            @elseif($leave->withdrawal_status == 3)
                                <span class="badge badge-danger">Withdrawal Rejected</span>
                            @else
                                <span class="badge badge-danger">Unknown</span>
                            @endif
                        </div>

                        {{-- Employee Withdrawal Reason --}}
                        @if($leave->withdrawal_reason)
                            <div class="form-group">
                                <label>Employee Withdrawal Reason</label>
                                <pre>{{ $leave->withdrawal_reason }}</pre>
                            </div>
                        @endif

                        {{-- Admin Rejection Reason --}}
                        @if($leave->withdrawal_status == 3 && $leave->withdrawal_admin_reason)
                            <div class="form-group">
                                <label class="text-danger">Admin Withdrawal Rejection Reason</label>
                                <pre>{{ $leave->withdrawal_admin_reason }}</pre>
                            </div>
                        @endif

                        {{-- Admin Actions --}}
                        @if($leave->status == 1 && $leave->withdrawal_status == 1)
                            <hr>
                            <h5 class="mb-3">Withdrawal Action</h5>
                            <div class="d-flex" style="gap:10px;">

                                <form method="POST" action="{{ route('admin.leave.approveWithdrawal', $leave->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Approve Withdrawal</button>
                                </form>

                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectWithdrawalModal">
                                    Reject Withdrawal
                                </button>
                            </div>
                        @elseif($leave->withdrawal_status == 2)
                            <div class="alert alert-success mt-3">
                                This withdrawal request has been <strong>approved</strong>.
                            </div>
                        @elseif($leave->withdrawal_status == 3)
                            <div class="alert alert-danger mt-3">
                                This withdrawal request has been <strong>rejected</strong>.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Reject Withdrawal Modal --}}
@if($leave->status == 1 && $leave->withdrawal_status == 1)
<div class="modal fade" id="rejectWithdrawalModal" tabindex="-1" role="dialog" aria-labelledby="rejectWithdrawalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.leave.rejectWithdrawal', $leave->id) }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="rejectWithdrawalModalLabel">Reject Withdrawal Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Employee Withdrawal Reason</label>
                        <textarea class="form-control" rows="4" readonly>{{ $leave->withdrawal_reason }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Admin Rejection Reason <span class="text-danger">*</span></label>
                        <textarea name="withdrawal_admin_reason" class="form-control" rows="5" required placeholder="Enter reason for rejecting this withdrawal request..."></textarea>

                        @error('withdrawal_admin_reason')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Withdrawal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection