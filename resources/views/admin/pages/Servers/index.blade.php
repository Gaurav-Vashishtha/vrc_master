@extends('admin.template.base')

@section('title', 'Servers List')


@section('styles')
<style>
    /* .d-flex.mainbtn {
    justify-content: space-around;
    padding-top: 31px;
    width: 154px;
} */

    .btn-fixed {
        height: 42px !important;
        min-width: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-control {
        height: 38px;
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
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table-responsive {
        margin-top: 15px;
    }

    .table th,
    .table td {
        padding: 14px 12px;
        vertical-align: middle;
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
    .status-problem-blink {
        border-radius: 50%;
        animation: problemBlink 1s ease-in-out infinite;
    }

    @keyframes problemBlink {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
        }

        50% {
            box-shadow:
                0 0 0 5px rgba(220, 53, 69, 0.35),
                0 0 12px 3px rgba(220, 53, 69, 0.6);
        }
    }
    @media (min-width: 576px) {
        #SailyServersHistory .modal-dialog {
            max-width: 900px;
            margin: 30px auto;
        }
    }
</style>
@endsection

@section('content')
<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title">All Servers</h3>

            <a href="{{ route('admin.servers.create') }}"
                class="btn btn-success">
                <i class="mdi mdi-plus"></i>
                Add Server
            </a>
        </div>


        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">

                    <div class="card-body">
                        <!-- Filter Form -->
                        <form method="GET"
                            action="{{ route('admin.servers.index') }}">
                            <div class="d-flex align-items-end gap-3 flex-wrap" style="gap:5px">
                                <div class="mb-2">
                                    <select name="search_user"  class="form-control search select2">
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

                                    <a href="{{ route('admin.servers.index') }}"
                                        class="btn btn-secondary btn-fixed">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">

                            <table class="table table-hover" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Server Name</th>
                                        <th>Server URL</th>
                                        <th>User</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Logo</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($servers as $key => $server)
                                    @php $index = 1; @endphp
                                    <tr>
                                        <td>
                                            {{ $key + 1  }}
                                        </td>

                                        <td>{{ $server->server_name }}</td>
                                        <td> <a href="{{ $server->server_url }}" target="_blank">{{$server->server_url}}</a>
                                        </td>
                                        <td>
                                            {{ $server->user->first_name ?? '' }}
                                            {{ $server->user->last_name ?? '' }}
                                        </td>
                                        
                                        <td>{{ $server->username }}</td>
                                        <td>{{ $server->password }}</td>

                                        <td>
                                            @if($server->logo)
                                            <a href="{{ asset('uploads/servers/'.$server->logo) }}" target="_blank">
                                                <img src="{{ asset('uploads/servers/'.$server->logo) }}" alt="Logo" style="width:40px;height:40px;">
                                            </a>
                                            @else
                                            No Logo
                                            @endif
                                        </td>
                                        <!-- <td>
                                            {{ $server->description ?? 'No Description' }}
                                        </td> -->

                                        <td>
                                            @if($server->status == 'active')
                                            <span class="badge bg-success">
                                                Active
                                            </span>
                                            @else
                                            <span class="badge bg-danger">
                                                Inactive
                                            </span>
                                            @endif
                                        </td>

                                        <td>
                                            @php
                                                $class = '';

                                                if ($server?->histories?->first()?->status === 'problem') {
                                                    $class = 'status-problem-blink';
                                                }
                                            @endphp

                                            <i class="mdi mdi-history text-warning view-daily-server-history {{ $class ?? '' }}"
                                                style="cursor: pointer;"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Comment Daily Server History"
                                                data-daily-server-history-table="
                                                    <thead>
                                                        <tr>
                                                            <th width='70'>#</th>
                                                            <th>Date</th>
                                                            <th>User</th>
                                                            <th>Status</th>
                                                            <th>Message</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @forelse($server?->histories as $key => $history)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $history->created_at->format('d M Y, h:i A') }}</td>
                                                                <td>{{ $history->user->first_name ?? '' }} {{ $history->user->last_name ?? '' }}</td>
                                                                <td>
                                                                    @if($history->status == 'working')
                                                                        <span class='status-working'>
                                                                            Working
                                                                        </span>
                                                                    @else
                                                                        <span class='status-problem'>
                                                                            Problem
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $history->message }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan='5' class='text-center'>
                                                                    No history found.
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                ">
                                            </i>

                                            <a href="{{ route('admin.servers.edit', $server->id) }}"><i class="mdi mdi-pencil"></i></a>
                                            <a href="{{ route('admin.servers.history', $server->id) }}" class="btn btn-sm btn-primary">
                                                </i>Details
                                            </a>
                                        </td>

                                    </tr>

                                    @empty

                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No Servers Found
                                        </td>
                                    </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Comment Daily Server History Modal -->
<div class="modal fade" id="SailyServersHistory" tabindex="-1" role="dialog" aria-labelledby="SailyserversHistoryLabe" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="SailyserversHistoryLabe">
                    Comment Daily Server History
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Daily Server History --}}
                <div class="card mb-4">
                    <div class="card-body">

                        <h4 class="card-title mb-4">
                            Daily Server History
                        </h4>

                        <table id="SailyServersHistoryTable" class="table table-bordered">
                            {{-- Table content will be dynamically populated via JavaScript --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $('.view-daily-server-history').on('click', function () {
        let SailyservershistoryI = $(this).data('daily-server-history-table');
        $('#SailyServersHistoryTable').html(SailyservershistoryI);
        $('#SailyServersHistory').modal('show');
    });
});
</script>
@endsection