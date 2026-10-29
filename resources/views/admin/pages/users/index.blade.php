@extends('admin.template.base')

@section('title', 'Users List')

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

        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title">All Users - <a href="https://vrwebconsulting.com/admin/user/login" target="_blank">https://vrwebconsulting.com/admin/user/login</a></h3>

            <a href="{{ route('admin.users.create') }}"
               class="btn btn-success"> 
                Add User
            </a>
        </div>


        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">

                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.users.index') }}">
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
                                   <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2 btn-fixed">Reset</a>
                                  <a href="{{ route('admin.users.export', request()->query()) }}" class="btn btn-success btn-fixed">Export CSV</a>
                                 </div>
                              
                            </div>
                        </form>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">

                            <table class="table table-hover" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>User Type</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>

                                @forelse($users as $key => $user)
                                    @php $index = 1; @endphp
                                    <tr>
                                        <td>{{ $key + 1  }}</td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ @getUserRoleByID($user->id) }}</td>
                                        <td>
                                            @if($user->status == 1)
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
                                            {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                        </td>

                                        <td>

                                            <!-- Edit -->
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                               title="Edit">
                                                <i class="mdi mdi-pencil"
                                                   style="color:blue;font-size:18px;"></i>
                                            </a>

                                            <!-- Delete -->
                                            <form action="{{ route('admin.users.delete', $user->id) }}"
                                                  method="POST"
                                                  style="display:inline;"
                                                  onsubmit="return confirm('Are you sure you want to delete this user?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" style="border:none;background:none;">
                                                    <i class="mdi mdi-delete-forever" style="color:red;font-size:18px;"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No Users Found</td>
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