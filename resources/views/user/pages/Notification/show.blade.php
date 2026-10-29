@extends('user.template.base')

@section('title', 'View Notification')

@section('styles')

<style>
    .card-body {
        padding: 25px !important;
    }

    .notification-detail {
        margin-bottom: 22px;
    }

    .notification-detail label {
        display: block;
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .notification-value {
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 12px 15px;
        min-height: 45px;
        overflow-wrap: anywhere;
        color: #ffffff !important;
    }

    .notification-message {
        min-height: 120px;
        white-space: pre-wrap;
    }

    .notification-detail label {
        color: #ffffff !important;
    }

    .priority-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 5px;
        font-size: 13px;
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

    .btn-fixed {
        min-width: 120px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>

@endsection

@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title">View Notification</h3>

            <a href="{{ route('user.notifications.index') }}"
                class="btn btn-secondary btn-fixed">
                <i class="mdi mdi-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="notification-detail">
                    <label>Title</label>
                    <div class="notification-value">
                        {{ $notification->title }}
                    </div>
                </div>

                <div class="notification-detail">
                    <label>Message</label>
                    <div class="notification-value notification-message">{{ $notification->description }}</div>
                </div>

                <div class="notification-detail">
                    <label>Priority</label>
                    <div>
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
                    </div>
                </div>

                <div class="notification-detail mb-0">
                    <label>Sent Date</label>
                    <div class="notification-value">
                        {{ $notification->created_at?->format('d-M-Y h:i A') ?? '-' }}
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection