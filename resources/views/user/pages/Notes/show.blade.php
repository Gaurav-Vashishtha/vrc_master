@extends('user.template.base')

@section('title','View Note')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">
                View Note
            </h3>
        </div>

        <div class="card">
            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="220">Note Title</th>
                        <td>{{ $note->title }}</td>
                    </tr>

                    <tr>
                        <th>Category</th>
                        <td>{{ $note->category ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Priority</th>
                        <td>{{ $note->priority }}</td>
                    </tr>

                    <!-- <tr>
                        <th>Reminder Date</th>
                        <td>
                            @if($note->reminder_date)
                                {{ date('d-m-Y',strtotime($note->reminder_date)) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr> -->

                    <tr>
                        <th>Status</th>
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
                    </tr>

                    <tr>
                        <th>Description</th>
                        <td>
                            {!! nl2br(e($note->description)) !!}
                        </td>
                    </tr>

                    <tr>
                        <th>Attachment</th>

                        <td>

                            @if($note->attachment)

                                <a href="{{ asset('uploads/notes/'.$note->attachment) }}"
                                   target="_blank"
                                   class="btn btn-info btn-sm">

                                    View Attachment

                                </a>

                            @else

                                No Attachment

                            @endif

                        </td>

                    </tr>

                    <tr>
                        <th>Created At</th>
                        <td>{{ date('d-m-Y h:i A',strtotime($note->created_at)) }}</td>
                    </tr>

                </table>

                <a href="{{ route('user.notes.index') }}"
                   class="btn btn-secondary">

                    Back

                </a>

                <a href="{{ route('user.notes.edit',$note->id) }}"
                   class="btn btn-primary">

                    Edit Note

                </a>

            </div>
        </div>

    </div>
</div>

@endsection