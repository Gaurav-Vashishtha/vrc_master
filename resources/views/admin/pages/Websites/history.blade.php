php
@extends('admin.template.base')

@section('title', 'Website History')

@section('content')

<style>
    .card-body {
        padding: 25px;
    }

    .table th,
    .table td {
        vertical-align: middle;
        padding: 12px 15px;
    }

    .status-working {
        background: #28a745;
        color: #fff;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 12px;
    }

    .status-problem {
        background: #dc3545;
        color: #fff;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 12px;
    }

    .website-info {
        margin-bottom: 20px;
    }

    .website-info h4 {
        margin-bottom: 8px;
    }

    .website-info a {
        word-break: break-all;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Website History</h3>

            <div class="d-flex">
                <a href="{{ route('admin.websites.index') }}"
                   class="btn btn-secondary btn-fixed">
                    Back
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">

                <div class="website-info">
                    <h4>{{ $website->website_name }}</h4>

                    <p class="mb-1">
                        <strong>Website URL:</strong>
                        <a href="{{ $website->website_url }}" target="_blank">
                            {{ $website->website_url }}
                        </a>
                    </p>

                    @if($website->user)
                        <p class="mb-0">
                            <strong>Assigned User:</strong>
                            {{ $website?->user?->first_name }} {{ $website?->user?->last_name }}
                        </p>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th width="70">#</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Message</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($histories as $key => $history)

                                <tr>
                                    <td>
                                        {{ $key + 1 }}
                                    </td>

                                    <td>
                                        {{ $history->created_at->format('d M Y, h:i A') }}
                                    </td>

                                    <td>
                                        {{ $history->user->first_name ?? '' }} {{ $history->user->last_name ?? '' }}
                                    </td>

                                    <td>
                                        @if($history->status == 'working')
                                            <span class="status-working">
                                                Working
                                            </span>
                                        @else
                                            <span class="status-problem">
                                                Problem
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $history->message }}
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center">
                                        No history found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

                {{--@if($histories->hasPages())
                    <div class="mt-3">
                        {{ $histories->links() }}
                    </div>
                @endif--}}

            </div>
        </div>

    </div>
</div>

@endsection
