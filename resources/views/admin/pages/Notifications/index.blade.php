@extends('admin.template.base')

@section('title', 'Notifications')

@section('styles')
<style>
    /* Pagination wrapper */
    .content-wrapper nav[aria-label="Pagination Navigation"] {
        font-family: inherit;
    }

    /* Page container */
    .content-wrapper nav .inline-flex {
        gap: 6px;
    }

    /* Page buttons */
    .content-wrapper nav a,
    .content-wrapper nav span[aria-current="page"] span,
    .content-wrapper nav span[aria-disabled="true"] span {
        border-radius: 6px !important;
        min-width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    /* Normal page links */
    .content-wrapper nav a {
        background-color: #fff !important;
        color: #495057 !important;
        border: 1px solid #dee2e6 !important;
        transition: all 0.2s ease-in-out;
    }

    .content-wrapper nav a:hover {
        background-color: #f1f3f5 !important;
        color: #000 !important;
    }
    


    /* Active page */
    .content-wrapper nav span[aria-current="page"] span {
        background-color: #0d6efd !important;
        color: #fff !important;
        border-color: #0d6efd !important;
        font-weight: 600;
    }

    /* Disabled buttons */
    .content-wrapper nav span[aria-disabled="true"] span {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Arrow buttons */
    .content-wrapper nav svg {
        width: 18px;
        height: 18px;
    }

    /* Previous / Next buttons */
    .content-wrapper nav a[rel="prev"],
    .content-wrapper nav a[rel="next"] {
        background-color: #fff !important;
        border: 1px solid #dee2e6 !important;
    }

    .content-wrapper nav a[rel="prev"]:hover,
    .content-wrapper nav a[rel="next"]:hover {
        background-color: #e9ecef !important;
    }

    .datatable-top,
    .datatable-bottom {
        display: none;
    }

    .datatable-selector {
        display: none;
    }

    .content-wrapper nav[aria-label="Pagination Navigation"] .flex.gap-2.items-center.justify-between.sm\:hidden {
        display: none;
    }

    span.inline-flex.rtl\:flex-row-reverse.shadow-sm.rounded-md {
        align-items: center;
        justify-content: center;
        display: flex;
    }

    .content-wrapper nav svg {
        width: 18px;
        height: 18px;
        filter: invert(1);
    }

    @media (max-width: 640px) {
        .content-wrapper nav .sm\\:hidden {
            display: none !important;
        }
    }

    .card-body {
        padding: 25px !important;
    }

    .form-control {
        min-width: 180px;
        height: 42px;
    }

    .btn-fixed {
        min-width: 120px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    table#datatablesSimple tr td {
    min-width: 165px;
        word-wrap: anywhere;
}
</style>
@endsection
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title">Notifications</h3>
            <a href="{{ route('admin.notifications.create') }}" class="btn btn-success">Send Notification</a>
        </div>

        <div class="card">
            <div class="card-body">

                <form method="GET" action="{{ route('admin.notifications.index') }}">
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
                            <select name="search_user" class="form-control search select2">
                                <option value="">Select User</option>
                                @foreach(@getAllEmployees() as $user)
                                <option value="{{ $user->id }}"
                                    {{ request('search_user') == $user->id ? 'selected' : '' }}>
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex gap-2 mb-2" style="gap:3px">

                            <button type="submit"
                                class="btn btn-primary btn-fixed">
                                Filter
                            </button>

                            <a href="{{ route('admin.notifications.index') }}"
                                class="btn btn-secondary btn-fixed">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Recipient</th>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Sent</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notifications as $notification)
                            <tr>
                                <td>{{ $notifications->firstItem() + $loop->index }}</td>
                                <td>
                                    @if($notification->user)
                                    {{ $notification->user->first_name }} {{ $notification->user->last_name }}
                                    @else
                                    User #{{ $notification->user_id }}
                                    @endif
                                </td>
                                <td>{{ $notification->title }}</td>
                                <td>{{ $notification->description }}</td>
                                <td>{{ $notification->priority }}</td>
                                <td>
                                    @if($notification->status === 'Unseen')
                                    <span class="badge bg-danger">Unseen</span>
                                    @else
                                    <span class="badge bg-success">Seen</span>
                                    @endif
                                </td>
                                <td>{{ $notification->created_at?->format('d-M-Y h:i A') ?? '-' }}</td>

                                <td class="text-nowrap">
                                    <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this notification?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="btn btn-link btn-sm"
                                            title="Delete"
                                            style="padding: 5px; text-decoration: none; color: #dc3545;">
                                            <i class="mdi mdi-delete" style="font-size: 20px;"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No notifications have been sent.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection