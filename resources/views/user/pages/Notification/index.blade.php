@extends('user.template.base')

@section('title', 'My Notifications')

@section('styles')

<style>
    .content-wrapper nav[aria-label="Pagination Navigation"] {
        font-family: inherit;
    }

    .content-wrapper nav .inline-flex {
        gap: 6px;
    }

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

    .content-wrapper nav span[aria-current="page"] span {
        background-color: #0d6efd !important;
        color: #fff !important;
        border-color: #0d6efd !important;
        font-weight: 600;
    }

    .content-wrapper nav span[aria-disabled="true"] span {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .content-wrapper nav svg {
        width: 18px;
        height: 18px;
    }

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
    .datatable-bottom,
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

    .notification-message {
        min-width: 200px;
        max-width: 400px;
        white-space: normal;
        overflow-wrap: anywhere;
    }

    .priority-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .priority-high {
        background: #f8d7da;
        color: #842029;
    }

    .priority-medium {
        background: #fff3cd;
        color: #664d03;
    }

    .priority-low {
        background: #d1e7dd;
        color: #0f5132;
    }

    .action-btn {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        background: transparent;
        color: #0d6efd !important;
        text-decoration: none !important;
        font-size: 18px;
    }

    .action-btn:hover {
        background: transparent;
        color: #0b5ed7 !important;
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
            <h3 class="page-title">My Notifications</h3>
        </div>

        <div class="card">
            <div class="card-body">

                <form method="GET" action="{{ route('user.notifications.index') }}">
                    <div class="d-flex align-items-end gap-3 flex-wrap" style="gap:5px;">

                        <div class="mb-2">
                            <label>From Date</label>
                            <input
                                type="date"
                                name="from_date"
                                class="form-control"
                                value="{{ request('from_date', date('Y-m-01')) }}">
                        </div>

                        <div class="mb-2">
                            <label>To Date</label>
                            <input
                                type="date"
                                name="to_date"
                                class="form-control"
                                value="{{ request('to_date', date('Y-m-d')) }}">
                        </div>

                        <div class="d-flex gap-2 mb-2" style="gap:3px;">
                            <button type="submit" class="btn btn-primary btn-fixed">
                                Filter
                            </button>

                            <a href="{{ route('user.notifications.index') }}"
                                class="btn btn-secondary btn-fixed">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table table-hover" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Priority</th>
                                <th>Sent</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($notifications as $notification)
                            <tr>
                                <td>
                                    {{ $notifications->firstItem() + $loop->index }}
                                </td>

                                <td>{{ $notification->title }}</td>

                                <td>
                                    <div class="notification-message">
                                        {{ $notification->description }}
                                    </div>
                                </td>

                                <td>
                                    @php
                                    $priority = strtolower($notification->priority ?? 'low');

                                    $priorityClass = match($priority) {
                                    'high' => 'priority-high',
                                    'medium' => 'priority-medium',
                                    default => 'priority-low',
                                    };
                                    @endphp

                                    <span class="priority-badge {{ $priorityClass }}">
                                        {{ $notification->priority ?? 'Low' }}
                                    </span>
                                </td>

                                <td>
                                    {{ $notification->created_at?->format('d-M-Y h:i A') ?? '-' }}
                                </td>

                                <td>
                                    <a href="{{ route('user.notifications.show', $notification->id) }}"
                                        class="action-btn"
                                        title="View Notification"
                                        aria-label="View Notification">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    No notifications found.
                                </td>
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