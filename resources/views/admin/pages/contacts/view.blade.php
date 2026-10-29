@extends('admin.template.base')

@section('title', 'View Contact')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Contact Details</h3>

            <a href="{{ url('admin/contacts-list') }}"
               class="btn btn-primary">
                Back
            </a>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin">

                <div class="card">
                    <div class="card-body">

                        <table class="table table-bordered">

                            <tr>
                                <th width="200">Name</th>
                                <td>{{ $contact->fullname }}</td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td>{{ $contact->email }}</td>
                            </tr>

                            <tr>
                                <th>Phone</th>
                                <td>{{ $contact->contact }}</td>
                            </tr>

                            <tr>
                                <th>Date</th>
                                <td>{{ $contact->created_at->format('d-m-Y h:i A') }}</td>
                            </tr>

                            <tr>
                                <th>Message</th>
                                <td style="white-space:normal;text-align: justify;">
                                    {{ $contact->message }}
                                </td>
                            </tr>

                             <tr>
                                <th>Address</th>
                                <td>
                                    {!! nl2br(e($contact->address)) !!}
                                </td>
                            </tr>

                              <tr>
                                <th>Budget</th>
                                <td>
                                    {!! nl2br(e($contact->budget)) !!}
                                </td>
                            </tr>

                            <tr>
                                <th>Requirement</th>
                                <td>
                                    {!! nl2br(e($contact->requirement)) !!}
                                </td>
                            </tr>

                            <tr>
                                <th>Chat Thread ID</th>
                                <td>
                                    @if($contact->thread_id)
                                        <a href="{{ route('admin.chatbox.show', $contact->thread_id ?? '-') }}" title="Click for view chat">
                                            {{ $contact->thread_id ?? '-' }}
                                        </a>
                                    @else
                                        {{'-'}}
                                    @endif
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection