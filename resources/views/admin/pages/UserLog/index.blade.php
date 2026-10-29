@extends('admin.template.base')

@section('title', 'Users Logs')

@section('content')
<style>
    /* .d-flex.mainbtn {
    justify-content: space-around;
    padding-top: 31px;
    width: 154px;
} */

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
    </style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Users Logs</h3>
            <!-- <a href="{{ url('/admin/contact/create') }}">
                <i class="mdi mdi-plus btn btn-success" title="Click to add new contact"></i>
            </a> -->
        </div>

        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">

<div class="card-body p-4">

    <!-- Filter Section -->
    <div class="mb-4">
        <form action="{{ url('admin/user-logs') }}" method="get">
            <div class="d-flex align-items-end gap-3 flex-wrap" style="gap:5px">

                <div>
                    <label class="form-label mb-2"><strong>From Date</strong></label>
                    <input type="date" name="from_date" class="form-control"
                        value="{{ request('from_date') }}">
                </div>

                <div>
                    <label class="form-label mb-2"><strong>To Date</strong></label>
                    <input type="date" name="to_date" class="form-control"
                        value="{{ request('to_date') }}">
                </div>

                <div class="d-flex gap-2" style="gap:3px";>
                    <button type="submit" class="btn btn-primary btn-fixed">
                        Search
                    </button>

                    <a href="{{ url('admin/contacts-list') }}"
                        class="btn btn-warning btn-fixed">
                        Reset
                    </a>

                    <a href="{{ route('admin.contacts.export', request()->all()) }}"
                        class="btn btn-success btn-fixed">
                        Export CSV
                    </a>
                </div>

            </div>
        </form>
    </div>

    <div id="alertBox" class="mb-3"></div>

    <div class="table-responsive">
        <!-- Table -->
    </div>
 
</div>
                        <div id="alertBox" class="mt-2"></div>

                        {{-- Users Table --}}
                        <div class="table-responsive">

                            <table class="table table-hover" id="datatablesSimple">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>IP Address</th>
                                        <th>User Agent</th>
                                         <th>Created Date</th>
                                         
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user?->user?->first_name ?? '' }} {{ $user?->user?->last_name ?? '' }}</td>
                                        <td>{{ $user->action }}</td>
                                        <td>{{ $user->ip_address }}</td>
                                        <td>{{ $user->user_agent }}</td>
                                        <th>{{ $user->created_at ? $user->created_at->format('d-m-Y H:i:s') : '-' }}</th>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No Contacts Found</td>
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