@extends('user.template.base')

@section('title','Apply Leave')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">
                <h4>Apply Leave</h4>
                <form action="{{ route('user.leave.store') }}" method="POST">
                    @csrf

                    <!-- Leave Type -->
                    <div class="form-group">
                        <label>Leave Type <span class="text-danger">*</span></label>
                        <select name="leave_type" class="form-control" required>
                            <option value="">Select Leave Type</option>
                            <option value="Casual Leave" {{ old('leave_type') == 'Casual Leave' ? 'selected' : '' }}>Casual Leave</option>
                            <option value="Sick Leave" {{ old('leave_type') == 'Sick Leave' ? 'selected' : '' }}>Sick Leave</option>
                            <option value="Emergency Leave" {{ old('leave_type') == 'Emergency Leave' ? 'selected' : '' }}>Emergency Leave</option>
                            <option value="Paid Leave" {{ old('leave_type') == 'Paid Leave' ? 'selected' : '' }}>Paid Leave</option>
                            <option value="Half Day" {{ old('leave_type') == 'Half Day' ? 'selected' : '' }}>Half Day</option>
                            <option value="Short Leave" {{ old('leave_type') == 'Short Leave' ? 'selected' : '' }}>Short Leave</option>
                        </select>
                    </div>

                    <!-- From Date -->
                    <div class="form-group mt-3">
                        <label>From Date <span class="text-danger">*</span></label>

                        <input type="date"
                            name="from_date"
                            id="from_date"
                            class="form-control"
                            min="{{ date('Y-m-d', strtotime('-40 days')) }}"
                            max="{{ date('Y-m-d', strtotime('+60 days')) }}"
                            value="{{ old('from_date') }}"
                            required>
                    </div>

                    <!-- To Date -->
                    <div class="form-group mt-3">
                        <label>To Date <span class="text-danger">*</span></label>

                        <input type="date"
                            name="to_date"
                            id="to_date"
                            class="form-control"
                            max="{{ date('Y-m-d', strtotime('+60 days')) }}"
                            value="{{ old('to_date') }}"
                            required>
                    </div>

                    <!-- Total Days -->
                    <div class="form-group mt-3">
                        <label>Total Days</label>

                        <input type="number"
                            name="total_days"
                            id="total_days"
                            class="form-control"
                            value="{{ old('total_days') }}"
                            readonly
                            required>
                    </div>

                    <!-- Leave Reason -->
                    <div class="form-group mt-3">
                        <label>Leave Reason <span class="text-danger">*</span></label>

                        <textarea
                            name="leave_reason"
                            id="leave_reason"
                            class="form-control"
                            rows="4"
                            placeholder="Enter leave reason..."
                            required>{{ old('leave_reason') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">
                        Apply Leave
                    </button>

                    <a href="{{ route('user.leave.list') }}"
                        class="btn btn-secondary mt-3">
                        Back
                    </a>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')

<script>
    const fromDate = document.getElementById('from_date');
    const toDate = document.getElementById('to_date');
    const totalDays = document.getElementById('total_days');

    fromDate.addEventListener('change', calculateDays);
    toDate.addEventListener('change', calculateDays);

    function calculateDays() {
        if (fromDate.value) {
            toDate.min = fromDate.value;
        }

        if (fromDate.value && toDate.value) {

            let start = new Date(fromDate.value);
            let end = new Date(toDate.value);

            if (end < start) {

                alert('To Date must be greater than or equal to From Date');

                toDate.value = '';
                totalDays.value = '';

                return;
            }

            let diff = end.getTime() - start.getTime();

            let days = Math.floor(diff / (1000 * 60 * 60 * 24)) + 1;

            totalDays.value = days;
        }
    }

    window.onload = function() {
        calculateDays();
    };
</script>

@endsection