@extends('admin.template.base')

@section('title', 'Server History')

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

    .server-info {
        margin-bottom: 20px;
    }

    .server-info h4 {
        margin-bottom: 8px;
    }

    .server-info a {
        word-break: break-all;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Server History</h3>

            <div class="d-flex">
                <a href="{{ route('admin.servers.index') }}"
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

                <div class="server-info">
                    <h4>{{ $server->server_name }}</h4>

                    <p class="mb-1">
                        <strong>Server URL:</strong>
                        <a href="{{ $server->server_url }}" target="_blank">
                            {{ $server->server_url }}
                        </a>
                    </p>

                    @if($server->user)
                        <p class="mb-0">
                            <strong>Assigned User: </strong>
                            {{ $server?->user?->first_name }} {{ $server?->user?->last_name }}
                        </p>
                    @endif

                    @if($server->user)
                        <p class="mb-0">
                            <strong>Username: </strong>{{ $server?->username }}
                        </p>
                    @endif

                    @if($server->user)
                        <p class="mb-0">
                            <strong>Password: </strong>{{ $server?->password }}
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
