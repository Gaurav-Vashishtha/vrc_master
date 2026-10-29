@extends('user.template.base')

@section('title', 'Leave Details')

@section('styles')

<style>
    .status-box {
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .detail-label {
        font-weight: 600;
        color: #0090e7;
    }

    .detail-value {
        margin-bottom: 15px;
    }
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
        <h3 class="page-title">Leave Details</h3>
        <a href="{{ route('user.leave.list') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Leave Information</h4>

                    {{-- Leave Details --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-value">
                                <div class="detail-label">
                                    Leave Type
                                </div>

                                {{ $leave->leave_type }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-value">
                                <div class="detail-label">
                                    Total Days
                                </div>

                                {{ $leave->total_days }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-value">
                                <div class="detail-label">
                                    From Date
                                </div>

                                {{ date('D, d-m-Y', strtotime($leave->from_date)) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-value">
                                <div class="detail-label">
                                    To Date
                                </div>

                                {{ date('D, d-m-Y', strtotime($leave->to_date)) }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="detail-value">
                                <div class="detail-label">
                                    Leave Reason
                                </div>

                                {{ $leave->leave_reason ?? 'No Leave Reason Available' }}
                            </div>
                        </div>

                    </div>

                    <hr>

                    {{-- Original Leave Status --}}
                    <div class="status-box">

                        <h5>Leave Status</h5>
                        @if($leave->status == 0)
                            <span class="badge badge-warning">Pending</span>
                        @elseif($leave->status == 1)
                            <span class="badge badge-success">Approved</span>
                        @elseif($leave->status == 2)
                            <span class="badge badge-danger">Rejected</span>
                        @else
                            <span class="badge badge-secondary">
                                Unknown
                            </span>
                        @endif
                    </div>


                    {{-- Withdrawal Status --}}
                    <div class="status-box">
                        <h5>Withdrawal Status</h5>

                        @if($leave->withdrawal_status == 0)
                            <span class="badge badge-primary">
                                No Withdrawal Request
                            </span>
                        @elseif($leave->withdrawal_status == 1)
                            <span class="badge badge-warning">
                                Withdrawal Pending
                            </span>
                        @elseif($leave->withdrawal_status == 2)
                            <span class="badge badge-danger">
                                Withdrawn
                            </span>
                        @elseif($leave->withdrawal_status == 3)
                            <span class="badge badge-danger">
                                Withdrawal Rejected
                            </span>
                        @endif
                    </div>


                    {{-- User Withdrawal Reason --}}
                    @if($leave->withdrawal_reason)

                        <div class="form-group">
                            <label>Your Withdrawal Reason</label>
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


                    {{-- Withdrawal Request Form --}}
                    @if($leave->status == 1 && $leave->withdrawal_status == 0)
                        <hr>
                        <h5 class="mb-3">Request Withdrawal</h5>
                        <form method="POST" action="{{ route('user.leave.withdrawal.request', $leave->id) }}">
                            @csrf
                            <div class="form-group">
                                <label>Reason for Withdrawal <span class="text-danger">*</span></label>
                                <textarea name="withdrawal_reason" class="form-control" rows="5" required placeholder="Enter reason for withdrawing this leave..."></textarea>
                                @error('withdrawal_reason')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-warning">
                                Submit Withdrawal Request
                            </button>
                        </form>
                    @elseif($leave->status == 1 && $leave->withdrawal_status == 1)
                        <div class="alert alert-info mt-3">
                            Your withdrawal request is currently
                            <strong>waiting for admin approval.</strong>
                        </div>
                    @elseif($leave->status == 1 && $leave->withdrawal_status == 2)
                        <div class="alert alert-success mt-3">
                            This leave has been
                            <strong>withdrawn.</strong>
                        </div>
                    @elseif($leave->status == 1 && $leave->withdrawal_status == 3)
                        <div class="alert alert-danger mt-3">
                            Your withdrawal request was
                            <strong>rejected by admin.</strong>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
