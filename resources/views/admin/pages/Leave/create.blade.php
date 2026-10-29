@extends('admin.template.base')

@section('title','Apply Leave')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4>Apply Leave</h4>

                <form action="{{ route('admin.leave.store') }}" method="POST">
                    @csrf

                    <!-- User -->
                    <div class="form-group">
                        <label>User <span class="text-danger">*</span></label>

                        <select name="user_id" class="form-control" required>
                            <option value="">Select User</option>

                            @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Leave Type -->
                    <div class="form-group mt-3">
                        <label>Leave Type <span class="text-danger">*</span></label>

                        <select name="leave_type" class="form-control" required>
                            <option value="">Select Leave Type</option>
                            <option value="Casual Leave">Casual Leave</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Emergency Leave">Emergency Leave</option>
                            <option value="Paid Leave">Paid Leave</option>
                            <option value="Half Day">Half Day</option>
                        </select>
                    </div>

                    <!-- From Date -->
                    <div class="form-group mt-3">
                        <label>From Date</label>

                        <input type="date"
                            name="from_date"
                            class="form-control"
                            id="from_date"
                            required>
                    </div>

                    <!-- To Date -->
                    <div class="form-group mt-3">
                        <label>To Date</label>

                        <input type="date"
                            name="to_date"
                            class="form-control"
                            id="to_date"
                            required>
                    </div>

                    <!-- Total Days -->
                    <div class="form-group mt-3">
                        <label>Total Days</label>

                        <input type="number"
                            name="total_days"
                            class="form-control"
                            id="total_days"
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
                        Save
                    </button>

                    <a href="{{ route('admin.leave.list') }}"
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
    document.getElementById('from_date').addEventListener('change', calculateDays);
    document.getElementById('to_date').addEventListener('change', calculateDays);

    function calculateDays() {
        let fromDate = document.getElementById('from_date').value;
        let toDate = document.getElementById('to_date').value;

        if (fromDate) {
            document.getElementById('to_date').min = fromDate;
        }

        if (fromDate && toDate) {

            let start = new Date(fromDate);
            let end = new Date(toDate);

            if (end < start) {

                alert('To Date must be greater than or equal to From Date');

                document.getElementById('to_date').value = '';
                document.getElementById('total_days').value = '';

                return;
            }

            let diff = end - start;

            let days = Math.floor(diff / (1000 * 60 * 60 * 24)) + 1;

            document.getElementById('total_days').value = days;
        }
    }
</script>

@endsection