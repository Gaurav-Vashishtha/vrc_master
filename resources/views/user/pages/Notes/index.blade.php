@extends('user.template.base')

@section('title', 'Notes List')

@section('content')

<style>
    .btn-fixed {
        height: 42px;
        min-width: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-control {
        min-width: 180px;
        height: 42px;
    }

    .card-body {
        padding: 25px !important;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="d-flex justify-content-between mb-4">

            <h4>Notes List</h4>

            <a href="{{ route('user.notes.create') }}" class="btn btn-success">
               
                Add Note
            </a>

        </div>
        <div class="card">
            <div class="card-body">



                <form action="{{ route('user.notes.index') }}" method="GET">

                    <div class="d-flex flex-wrap align-items-end" style="gap:10px">

                        <div>

                            <label><strong>From Date</strong></label>

                            <input type="date"
                                name="from_date"
                                class="form-control"
                                value="{{ request('from_date') }}">

                        </div>

                        <div>

                            <label><strong>To Date</strong></label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>

                        <button class="btn btn-primary btn-fixed">
                            Search
                        </button>

                        <a href="{{ route('user.notes.index') }}"
                            class="btn btn-warning btn-fixed">

                            Reset

                        </a>

                    </div>

                </form>

                <br>

                @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

                @endif

                <div class="table-responsive">

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover" id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Priority</th>
                                    <!-- <th>Reminder Date</th> -->
                                    <th>Status</th>
                                    <th>Attachment</th>
                                    <th width="120">Action</th>
                                </tr>

                            </thead>

                            <tbody>

                                @forelse($notes as $index=>$note)

                                <tr>

                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $note->title }}</td>
                                    <td>{{ $note->category ?? '-' }}</td>
                                    <td>{{ $note->priority }}</td>
                                    <!-- <td>

                                        @if($note->reminder_date)

                                        {{ date('d-m-Y',strtotime($note->reminder_date)) }}

                                        @else

                                        -

                                        @endif
                                    </td> -->
                                    <td>
                                        @if($note->status=='Active')

                                        <span class="badge badge-success">
                                            Active
                                        </span>

                                        @else

                                        <span class="badge badge-danger">
                                            Archived
                                        </span>

                                        @endif

                                    </td>

                                    <td>

                                        @if($note->attachment)

                                        <a href="{{ asset('uploads/notes/'.$note->attachment) }}"
                                            target="_blank">

                                            View

                                        </a>

                                        @else

                                        -

                                        @endif

                                    </td>

                                    <td>
                                        <a href="{{ route('user.notes.show',$note->id) }}" title="View">
                                            <i class="mdi mdi-eye" style="color:green;font-size:20px;"></i>
                                        </a>

                                        &nbsp;

                                        <a href="{{ route('user.notes.edit',$note->id) }}" title="Edit">
                                            <i class="mdi mdi-pencil" style="color:blue;font-size:20px;"></i>
                                        </a>

                                        &nbsp;

                                        <a href="{{ route('user.notes.delete',$note->id) }}"
                                            onclick="return confirm('Are you sure you want to delete this note?')"
                                            title="Delete">

                                            <i class="mdi mdi-delete" style="color:red;font-size:20px;"></i>

                                        </a>

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="8" class="text-center">

                                        No Notes Found

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

    @endsection

    @section('scripts')
    @endsection