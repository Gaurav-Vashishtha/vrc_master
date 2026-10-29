@extends('admin.template.base')

@section('title', 'Reminder Details')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h3 class="page-title">Reminder Details</h3>
                <p class="text-muted mb-0">
                    View complete information about this reminder
                </p>
            </div>

            <a href="{{ route('admin.reminders') }}"
               class="btn btn-light btn-sm">
                <i class="mdi mdi-arrow-left"></i>
                Back
            </a>
        </div>

        <div class="row">

            {{-- Main Details --}}
            <div class="col-lg-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <div class="d-flex align-items-center">
                                <div class="mr-3"
                                     style="
                                        width:48px;
                                        height:48px;
                                        border-radius:12px;
                                        background:rgba(0,123,255,0.15);
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                     ">
                                    <i class="mdi mdi-bell-outline"
                                       style="font-size:26px; color:#0090ff;"></i>
                                </div>

                                <div>
                                    <h4 class="card-title mb-1">
                                        {{ $reminder->title }}
                                    </h4>

                                    <small class="text-muted">
                                        Reminder #{{ $reminder->id }}
                                    </small>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div>
                                @if($reminder->status === 'completed')

                                    <span class="badge badge-success"
                                          style="padding:8px 14px; font-size:13px;">
                                        <i class="mdi mdi-check-circle mr-1"></i>
                                        Completed
                                    </span>

                                @elseif($reminder->status === 'cancelled')

                                    <span class="badge badge-danger"
                                          style="padding:8px 14px; font-size:13px;">
                                        <i class="mdi mdi-close-circle mr-1"></i>
                                        Cancelled
                                    </span>

                                @else

                                    <span class="badge badge-warning"
                                          style="padding:8px 14px; font-size:13px;">
                                        <i class="mdi mdi-clock-outline mr-1"></i>
                                        Pending
                                    </span>

                                @endif
                            </div>

                        </div>


                        {{-- Information Grid --}}
                        <div class="row">

                            {{-- Reminder Type --}}
                            <div class="col-md-6 mb-4">
                                <div class="p-3"
                                     style="
                                        border:1px solid rgba(255,255,255,0.08);
                                        border-radius:10px;
                                     ">

                                    <div class="d-flex align-items-center mb-2">
                                        <i class="mdi mdi-format-list-bulleted mr-2"
                                           style="font-size:20px; color:#0090ff;"></i>

                                        <span class="text-muted">
                                            Reminder Type
                                        </span>
                                    </div>

                                    <h6 class="mb-0">
                                        {{ ucwords(str_replace('_', ' ', $reminder->reminder_type)) }}
                                    </h6>

                                </div>
                            </div>


                            {{-- Reminder Date --}}
                            <div class="col-md-6 mb-4">
                                <div class="p-3"
                                     style="
                                        border:1px solid rgba(255,255,255,0.08);
                                        border-radius:10px;
                                     ">

                                    <div class="d-flex align-items-center mb-2">
                                        <i class="mdi mdi-calendar mr-2"
                                           style="font-size:20px; color:#0090ff;"></i>

                                        <span class="text-muted">
                                            Reminder Date
                                        </span>
                                    </div>

                                    <h6 class="mb-0">
                                        {{ $reminder->reminder_date->format('d-M-Y') }}
                                    </h6>

                                </div>
                            </div>


                            {{-- Remind Before --}}
                            <div class="col-md-6 mb-4">
                                <div class="p-3"
                                     style="
                                        border:1px solid rgba(255,255,255,0.08);
                                        border-radius:10px;
                                     ">

                                    <div class="d-flex align-items-center mb-2">
                                        <i class="mdi mdi-bell-ring-outline mr-2"
                                           style="font-size:20px; color:#0090ff;"></i>

                                        <span class="text-muted">
                                            Remind Before
                                        </span>
                                    </div>

                                    <h6 class="mb-0">
                                        {{ $reminder->remind_before_days }} Days
                                    </h6>

                                </div>
                            </div>


                            {{-- Repeat --}}
                            <div class="col-md-6 mb-4">
                                <div class="p-3"
                                     style="
                                        border:1px solid rgba(255,255,255,0.08);
                                        border-radius:10px;
                                     ">

                                    <div class="d-flex align-items-center mb-2">
                                        <i class="mdi mdi-repeat mr-2"
                                           style="font-size:20px; color:#0090ff;"></i>

                                        <span class="text-muted">
                                            Repeat
                                        </span>
                                    </div>

                                    <h6 class="mb-0">
                                        {{ ucfirst($reminder->repeat_type) }}
                                    </h6>

                                </div>
                            </div>


                            {{-- Amount --}}
                            @if($reminder->amount)

                                <div class="col-md-6 mb-4">
                                    <div class="p-3"
                                         style="
                                            border:1px solid rgba(255,255,255,0.08);
                                            border-radius:10px;
                                         ">

                                        <div class="d-flex align-items-center mb-2">
                                            <i class="mdi mdi-currency-inr mr-2"
                                               style="font-size:20px; color:#0090ff;"></i>

                                            <span class="text-muted">
                                                Amount
                                            </span>
                                        </div>

                                        <h6 class="mb-0">
                                            ₹{{ number_format($reminder->amount, 2) }}
                                        </h6>

                                    </div>
                                </div>

                            @endif

                        </div>


                        {{-- Description --}}
                        @if($reminder->description)

                            <div class="mt-2 mb-4">

                                <h5 class="mb-3">
                                    <i class="mdi mdi-text-box-outline mr-2"
                                       style="color:#0090ff;"></i>

                                    Description
                                </h5>

                                <div class="p-3"
                                     style="
                                        border-left:3px solid #0090ff;
                                        background:rgba(0,144,255,0.05);
                                        border-radius:5px;
                                     ">

                                    <p class="mb-0 text-muted">
                                        {{ $reminder->description }}
                                    </p>

                                </div>

                            </div>

                        @endif


                        {{-- Action Buttons --}}
                        <div class="mt-4 pt-3"
                             style="border-top:1px solid rgba(255,255,255,0.08);">

                            @if($reminder->status === 'pending')

                                <a href="{{ route('admin.reminders.complete', $reminder->id) }}"
                                   class="btn btn-success mr-2"
                                   onclick="return confirm('Are you sure you want to complete this reminder?')">

                                    <i class="mdi mdi-check-circle mr-1"></i>
                                    Mark Complete
                                </a>

                            @endif

                            <a href="{{ route('admin.reminders.edit', $reminder->id) }}"
                               class="btn btn-primary mr-2">

                                <i class="mdi mdi-pencil mr-1"></i>
                                Edit
                            </a>

                            <a href="{{ route('admin.reminders') }}"
                               class="btn btn-secondary">

                                <i class="mdi mdi-arrow-left mr-1"></i>
                                Back
                            </a>

                        </div>

                    </div>
                </div>
            </div>


            {{-- Right Side --}}
            <div class="col-lg-4 grid-margin stretch-card">

                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-4">
                            <i class="mdi mdi-information-outline mr-2"
                               style="color:#0090ff;"></i>
                            Reminder Information
                        </h4>


                        {{-- Created --}}
                        <div class="d-flex mb-4">

                            <div class="mr-3">
                                <i class="mdi mdi-calendar-plus"
                                   style="font-size:25px; color:#0090ff;"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Created At
                                </small>

                                <span>
                                    {{ $reminder->created_at->format('d-M-Y h:i A') }}
                                </span>
                            </div>

                        </div>


                        {{-- Completed --}}
                        @if($reminder->completed_at)

                            <div class="d-flex mb-4">

                                <div class="mr-3">
                                    <i class="mdi mdi-check-circle"
                                       style="font-size:25px; color:#00d25b;"></i>
                                </div>

                                <div>
                                    <small class="text-muted d-block">
                                        Completed At
                                    </small>

                                    <span>
                                        {{ $reminder->completed_at->format('d-M-Y h:i A') }}
                                    </span>
                                </div>

                            </div>

                        @endif


                        {{-- Reminder Start --}}
                        @php
                            $startDate = $reminder->reminder_date->copy()
                                ->subDays($reminder->remind_before_days);
                        @endphp

                        <div class="d-flex mb-4">

                            <div class="mr-3">
                                <i class="mdi mdi-bell-ring"
                                   style="font-size:25px; color:#ffab00;"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Reminder Starts
                                </small>

                                <span>
                                    {{ $startDate->format('d-M-Y') }}
                                </span>
                            </div>

                        </div>


                        {{-- Due Date --}}
                        <div class="d-flex">

                            <div class="mr-3">
                                <i class="mdi mdi-calendar-check"
                                   style="font-size:25px; color:#0090ff;"></i>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Due Date
                                </small>

                                <span>
                                    {{ $reminder->reminder_date->format('d-M-Y') }}
                                </span>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection