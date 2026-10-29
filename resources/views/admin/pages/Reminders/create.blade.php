@extends('admin.template.base')

@section('title', 'Add Reminder')

@section('content')

<style>
    .btn-fixed {
        height: 42px;
        min-width: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-control {
        height: 42px;
    }

    .card-body {
        padding: 25px !important;
    }

    label {
        margin-bottom: 8px;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Add Reminder</h3>

            <a href="{{ route('admin.reminders') }}" class="btn btn-warning">
                Back
            </a>
        </div>

        <div class="row">
            <div class="col-12 grid-margin">

                <div class="card">
                    <div class="card-body">

                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('admin.reminders.store') }}" method="POST">

                            @csrf

                            <div class="row">

                                {{-- Reminder Type --}}
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label>
                                            <strong>Reminder Type <span class="text-danger">*</span></label></strong>
                                        </label>

                                        <select
                                            name="reminder_type"
                                            id="reminder_type"
                                            class="form-control"
                                            required>

                                            <option value="">Select Type</option>

                                            <option value="general"
                                                {{ old('reminder_type') == 'general' ? 'selected' : '' }}>
                                                General
                                            </option>

                                            <option value="bill_payment"
                                                {{ old('reminder_type') == 'bill_payment' ? 'selected' : '' }}>
                                                Bill Payment
                                            </option>

                                            <option value="meeting"
                                                {{ old('reminder_type') == 'meeting' ? 'selected' : '' }}>
                                                Meeting
                                            </option>

                                            <option value="follow_up"
                                                {{ old('reminder_type') == 'follow_up' ? 'selected' : '' }}>
                                                Follow Up
                                            </option>

                                            <option value="other"
                                                {{ old('reminder_type') == 'other' ? 'selected' : '' }}>
                                                Other
                                            </option>

                                        </select>

                                    </div>
                                </div>


                                {{-- Title --}}
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label>
                                            <strong>Title <span class="text-danger">*</span></label></strong>
                                        </label>

                                        <input
                                            type="text"
                                            name="title"
                                            class="form-control"
                                            placeholder="Enter reminder title"
                                            value="{{ old('title') }}"
                                            required>

                                    </div>
                                </div>


                                {{-- Amount --}}
                                <div
                                    class="col-md-6"
                                    id="amountField"
                                    style="display: none;">

                                    <div class="form-group">

                                        <label>
                                            <strong>Amount</strong>
                                        </label>

                                        <input
                                            type="number"
                                            name="amount"
                                            id="amount"
                                            class="form-control"
                                            placeholder="Enter amount"
                                            step="0.01"
                                            min="0"
                                            value="{{ old('amount') }}">

                                    </div>

                                </div>


                                {{-- Reminder Date --}}
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label>
                                            <strong>Reminder Date <span class="text-danger">*</span></label></strong>
                                        </label>

                                        <input
                                            type="date"
                                            name="reminder_date"
                                            class="form-control"
                                            value="{{ old('reminder_date') }}"
                                            required>

                                    </div>
                                </div>


                                {{-- Remind Before --}}
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label>
                                            <strong>Remind Before (Days)</strong>
                                        </label>

                                        <input
                                            type="number"
                                            name="remind_before_days"
                                            class="form-control"
                                            placeholder="Example: 2"
                                            min="0"
                                            value="{{ old('remind_before_days', 0) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Repeat</strong></label>
                                        <select name="repeat_type" class="form-control" required>
                                            <option value="none" {{ old('repeat_type', 'none') == 'none' ? 'selected' : '' }}>
                                                Does Not Repeat
                                            </option>

                                            <option value="daily" {{ old('repeat_type') == 'daily' ? 'selected' : '' }}>
                                                Every Day
                                            </option>

                                            <option value="weekly" {{ old('repeat_type') == 'weekly' ? 'selected' : '' }}>
                                                Every Week
                                            </option>

                                            <option value="monthly" {{ old('repeat_type') == 'monthly' ? 'selected' : '' }}>
                                                Every Month
                                            </option>

                                            <option value="3_months" {{ old('repeat_type') == '3_months' ? 'selected' : '' }}>
                                                Every 3 Months
                                            </option>

                                            <option value="6_months" {{ old('repeat_type') == '6_months' ? 'selected' : '' }}>
                                                Every 6 Months
                                            </option>

                                            <option value="yearly" {{ old('repeat_type') == 'yearly' ? 'selected' : '' }}>
                                                Every Year
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><strong>Description</strong></label>
                                        <textarea name="description" class="form-control" rows="5" placeholder="Enter description">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="d-flex gap-2" style="gap:5px;">
                                        <button type="submit" class="btn btn-primary btn-fixed">
                                            Save Reminder
                                        </button>

                                        <a href="{{ route('admin.reminders') }}" class="btn btn-warning btn-fixed">
                                            Cancel
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')

<script>
    $(document).ready(function() {

        function toggleAmountField() {

            let reminderType = $('#reminder_type').val();

            if (reminderType === 'bill_payment') {

                $('#amountField').show();
                $('#amount').prop('required', true);

            } else {
                $('#amountField').hide();
                $('#amount').prop('required', false);
                $('#amount').val('');
            }
        }
        toggleAmountField();
        $('#reminder_type').on('change', function() {
            toggleAmountField();
        });
    });
</script>

@endsection