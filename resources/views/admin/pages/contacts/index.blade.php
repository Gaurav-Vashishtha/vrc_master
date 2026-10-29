@extends('admin.template.base')

@section('title', 'Contacts List')

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
            <h3 class="page-title">All Contacts List - <a href="https://vrwebconsulting.com/contact/" target="_blank">https://vrwebconsulting.com/contact/</a></h3>
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
        <form action="{{ url('admin/contacts-list') }}" method="get">
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Thread ID</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->fullname }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->contact }}</td>
                                        <td>
                                            @if($user->thread_id)
                                            <a href="{{ route('admin.chatbox.show', $user->thread_id ?? '-') }}" title="Click for view chat">
                                                {{ $user->thread_id ?? '-' }}
                                            </a>
                                            @else
                                                {{'-'}}
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                       
                                        <td>

                                            <a href="{{ url('admin/contacts-view', $user->id) }}">
                                               <i class="mdi mdi-eye" style="color: blue;" title="View"></i>
                                            </a>

                                           <!-- <form action="{{ url('admin/contacts-delete', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this contact?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="border: none; background: none;" title="Delete">
                                                    <i class="mdi mdi-delete-forever" style="color: red;"></i>
                                                </button>
                                            </form>-->
                                        </td>
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