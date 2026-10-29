@extends('user.template.base')

@section('title', 'Servers List')

@section('content')
<style>
    .btn-fixed {
        height: 38px;
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
        height: 42px;
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
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Assigned Servers</h3><br><br>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">

                    <div class="card-body">
                        {{--
                        <form method="GET" action="{{ route('user.servers.index') }}">
                            <div class="d-flex align-items-end gap-3 flex-wrap" style="gap:5px">

                                <div class="mb-2">
                                    <label><strong>From Date</strong></label>
                                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                </div>

                                <div class="mb-2">
                                    <label><strong>To Date</strong></label>
                                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                </div>

                                <div class="d-flex gap-2  mb-2" style="gap:3px">
                                    <button type="submit" class="btn btn-primary me-2 btn-fixed">Filter</button>
                                    <a href="{{ route('user.servers.index') }}" class="btn btn-secondary me-2 btn-fixed">Reset</a>
                                </div>

                            </div>
                        </form>
                        --}}


                        <div class="table-responsive">

                            <table class="table table-hover" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Server Name</th>
                                        <th>Server URL</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Logo</th>
                                        <th>Status</th>
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

                                        <td>
                                            @if($server->status == 'active')
                                            <span class="badge bg-primary">
                                                Active
                                            </span>
                                            @else
                                            <span class="badge bg-danger">
                                                Inactive
                                            </span>
                                            @endif
                                        </td>

                                        <td>

                                            <i class="mdi mdi-comment text-success view-daily-server-check"
                                                style="cursor: pointer;"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Comment Daily Server Check"
                                                data-daily-server-check-id="{{ $server->id ?? '' }}">
                                            </i>
                                        
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

                                            <a href="{{ route('user.servers.history', $server->id) }}" class="btn btn-sm btn-primary">
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


<!-- Comment Daily Server Check Modal -->
<div class="modal fade" id="SailyserversChec" tabindex="-1" role="dialog" aria-labelledby="SailyserversCheckLabe" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="SailyserversCheckLabe">
                    Comment Daily Server Check
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Daily Server Check --}}
                <div class="card mb-4">
                    <div class="card-body">

                        <h4 class="card-title mb-4">
                            Daily Server Check
                        </h4>

                        <form id="SailyserversCheckFor" action=""
                            method="POST">

                            @csrf

                            <div class="form-group">
                                <label>
                                    Status <span class="text-danger">*</span>
                                </label>

                                <select name="status"
                                        class="form-control"
                                        required>

                                    <option value="">
                                        Select Status
                                    </option>

                                    <option value="working"
                                        {{ old('status') == 'working' ? 'selected' : '' }}>
                                        Working
                                    </option>

                                    <option value="problem"
                                        {{ old('status') == 'problem' ? 'selected' : '' }}>
                                        Problem
                                    </option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label>
                                    Message <span class="text-danger">*</span>
                                </label>

                                <textarea name="message"
                                        class="form-control"
                                        rows="4"
                                        placeholder="Enter server checking message..."
                                        required>{{ old('message') }}</textarea>
                            </div>

                            <button type="submit"
                                    class="btn btn-primary">
                                Submit
                            </button>

                        </form>

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
    var baseUrl = "{{ url('/') }}";
    $('[data-toggle="tooltip"]').tooltip();
    $('.view-daily-server-check').on('click', function () {
        let SailyserversCheckI = $(this).data('daily-server-check-id');
        $('#SailyserversCheckFor').attr('action', baseUrl + '/user/server-check/' + SailyserversCheckI);
        $('#SailyserversChec').modal('show');
    });
    $('.view-daily-server-history').on('click', function () {
        let SailyservershistoryI = $(this).data('daily-server-history-table');
        $('#SailyServersHistoryTable').html(SailyservershistoryI);
        $('#SailyServersHistory').modal('show');
    });
});
</script>
@endsection