@extends('admin.template.base')

@section('title','Add Holiday')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4>Add Holiday</h4>

                <form action="{{ route('admin.holiday.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Holiday Name</label>
                        <input type="text"
                               name="holiday_name"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-group mt-3">
                        <label>From Date</label>
                        <input type="date" name="from_date" class="form-control" id="from_date" required>
                    </div>

                    <div class="form-group mt-3">
                        <label>To Date</label>
                        <input type="date" name="to_date" class="form-control" id="to_date" required>
                    </div>

                    <div class="form-group mt-3">
                        <label>Total Days</label>
                        <input type="number" name="total_days" class="form-control" id="total_days" required required readonly>
                    </div>


                    <button type="submit" class="btn btn-success mt-3">Save</button>                  
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

                let diffTime = end - start;
                let diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

                document.getElementById('total_days').value = diffDays;
            }
        }
    </script>
@endsection