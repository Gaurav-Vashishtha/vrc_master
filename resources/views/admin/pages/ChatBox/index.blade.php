@extends('admin.template.base')

@section('title', 'ChatBot Sessions')

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
        min-width: 180px;
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
            <h3 class="page-title">ChatBot Sessions - <a href="https://vrwebconsulting.com/" target="_blank">https://vrwebconsulting.com/</a></h3>
        </div>

        <div class="row">
            <div class="col-12 grid-margin">

                <div class="card">
                    <div class="card-body">

                        <!-- Filter -->
                        <form action="{{ route('admin.chatbox.index') }}" method="GET">

                            <div class="d-flex align-items-end gap-3 flex-wrap" style="gap:5px;">

                                <div>
                                    <label><strong>From Date</strong></label>
                                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                </div>

                                <div>
                                    <label><strong>To Date</strong></label>
                                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                </div>

                                <div class="d-flex gap-2" style="gap:5px;">

                                    <button class="btn btn-primary btn-fixed">
                                        Search
                                    </button>

                                    <a href="{{ route('admin.chatbox.index') }}"
                                        class="btn btn-warning btn-fixed">
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
                                        <th>Thread ID</th>
                                        <th>Client</th>
                                        <th>IP Address</th>
                                        <th>User Agent</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse($chatSessions as $key => $session)

                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $session->thread_id }}</td>
                                        <td>{{ $session->client }}</td>
                                        <td>{{ $session->ip_address }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($session->user_agent,50) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($session->created_at)->format('d-m-Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.chatbox.show', $session->thread_id) }}" style="margin-right:12px;">
                                                <i class="mdi mdi-eye" style="color:#0d6efd;font-size:20px;" title="View"></i>
                                            </a>
                                            <form action="{{ route('admin.chatbox.pin',$session->id) }}"
                                                method="POST"
                                                style="display:inline;">

                                                @csrf

                                                <button type="submit"
                                                    style="border:none;background:none;padding:0;cursor:pointer;">

                                                    @if($session->is_pinned)

                                                    <i class="mdi mdi-pin"
                                                        style="color:red;font-size:20px;"
                                                        title="Unpin"></i>

                                                    @else

                                                    <i class="mdi mdi-pin-off"
                                                        style="color:gray;font-size:20px;"
                                                        title="Pin"></i>

                                                    @endif

                                                </button>

                                            </form>

                                        </td>
                                    </tr>

                                    @empty

                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No Chat Sessions Found
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

@endsection

@section('scripts')
@endsection