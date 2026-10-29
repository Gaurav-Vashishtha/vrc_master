@extends('user.template.base')
@section('title', 'Reminders List')
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
        <div class="page-header">
            <h3 class="page-title">All Reminders List</h3>
            <a href="{{ route('user.reminders.create') }}" class="btn btn-success">Add Reminder</a>
        </div>

        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <form action="{{ route('user.reminders') }}" method="get">
                                    <div class="d-flex align-items-end gap-3 flex-wrap" style="gap:5px">

                                        <div><label class="form-label mb-2"><strong>Search</strong></label>
                                            <input type="text" name="search" class="form-control" placeholder="Search Reminder" value="{{ request('search') }}">
                                        </div>

                                        <div><label class="form-label mb-2"><strong>Reminder Type</strong></label>
                                            <select name="reminder_type" class="form-control">
                                                <option value="">All Types</option>
                                                <option value="general" {{ request('reminder_type') == 'general' ? 'selected' : '' }}> General </option>
                                                <option value="bill_payment" {{ request('reminder_type') == 'bill_payment' ? 'selected' : '' }}> Bill Payment </option>
                                                <option value="meeting" {{ request('reminder_type') == 'meeting' ? 'selected' : '' }}> Meeting </option>
                                                <option value="follow_up" {{ request('reminder_type') == 'follow_up' ? 'selected' : '' }}> Follow Up </option>
                                                <option value="other" {{ request('reminder_type') == 'other' ? 'selected' : '' }}> Other </option>
                                            </select>
                                        </div>

                                        <!-- <div>
                                            <label class="form-label mb-2"><strong>Status</strong></label>
                                            <select name="status" class="form-control">
                                                <option value="">All Status</option>
                                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}> Pending </option>
                                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}> Completed </option>
                                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}> Cancelled </option>
                                                 <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}> Overdue </option>
                                                  <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}> Upcoming </option>
                                            </select>
                                        </div> -->

                                        <div><label class="form-label mb-2"><strong>From Date</strong></label>
                                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                        </div>

                                        <div>
                                            <label class="form-label mb-2"><strong>To Date</strong></label>
                                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                        </div>

                                        <div class="d-flex gap-2" style="gap:3px;">
                                            <button type="submit" class="btn btn-primary btn-fixed"> Search </button>
                                            <a href="{{ route('user.reminders') }}" class="btn btn-warning btn-fixed"> Reset </a>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div id="alertBox" class="mb-3"></div>
                        </div>
                        <div id="alertBox" class="mt-2"></div>
                        {{-- Reminders Table --}}
                        <div class="table-responsive">
                            <table class="table table-hover" id="datatablesSimple">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Type</th>
                                        <th>Title</th>
                                        <th>Amount</th>
                                        <th>Reminder Date</th>
                                        <th>Remind Before</th>
                                        <th>Repeat</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($reminders as $index => $reminder)
                                    <tr>
                                        <td>{{ $reminders->firstItem() + $index }}</td>
                                        <td>
                                            @if($reminder->reminder_type == 'bill_payment')
                                            Bill Payment
                                            @elseif($reminder->reminder_type == 'follow_up')
                                            Follow Up
                                            @else
                                            {{ ucfirst(str_replace('_', ' ', $reminder->reminder_type)) }}
                                            @endif
                                        </td>
                                        <td>{{ $reminder->title }}</td>
                                        <td>
                                            @if($reminder->amount)
                                            ₹{{ number_format($reminder->amount, 2) }}
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td>{{ date('D, d-M-Y', strtotime($reminder->reminder_date)) }}</td>
                                        <td>{{ $reminder->remind_before_days ?? 0 }} Days</td>
                                        <td>
                                            @if($reminder->repeat_type == 'none')
                                            Does Not Repeat 
                                            @else
                                           {{ ucwords(str_replace('_', ' ', $reminder->repeat_type)) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($reminder->status == 'completed')
                                                <span class="badge badge-success">Completed</span>

                                            @elseif($reminder->status == 'cancelled')
                                                <span class="badge badge-danger">Cancelled</span>

                                            @elseif(
                                                $reminder->status == 'pending' &&
                                                $reminder->reminder_date->copy()
                                                    ->subDays($reminder->remind_before_days)
                                                    ->toDateString() <= now()->toDateString()
                                            )

                                                @if($reminder->reminder_date->toDateString() === now()->toDateString())
                                                    <span class="badge badge-warning">Due Today</span>

                                                @elseif($reminder->reminder_date->toDateString() < now()->toDateString())
                                                    <span class="badge badge-danger">Overdue</span>

                                                @else
                                                    <span class="badge badge-info">Upcoming</span>
                                                    <!-- <span class="badge badge-success">Completed</span> -->
                                                @endif

                                            @else
                                                <!-- <span class="badge badge-info">Upcoming</span> -->
                                                <span class="badge badge-success">Completed</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($reminder->status == 'pending')
                                            <a href="{{ route('user.reminders.complete', $reminder->id) }}" onclick="return confirm('Are you sure you want to complete this reminder?')">
                                                <i class="mdi mdi-check-circle" style="color: green;" title="Complete"></i>
                                            </a>
                                            @endif

                                            <a href="{{ route('user.reminders.edit', $reminder->id) }}">
                                                <i class="mdi mdi-pencil" style="color: blue;" title="Edit"> </i>
                                            </a>

                                            <a href="{{ route('user.reminders.show', $reminder->id) }}"
                                                title="View">
                                                <i class="mdi mdi-eye" style="color: #007bff; font-size: 14px;"></i>
                                            </a>

                                            <a href="{{ route('user.reminders.delete', $reminder->id) }}" onclick="return confirm('Are you sure you want to delete this reminder?')">
                                                <i class="mdi mdi-delete-forever" style="color: red;" title="Delete"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center"> No Reminders Found </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $reminders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection