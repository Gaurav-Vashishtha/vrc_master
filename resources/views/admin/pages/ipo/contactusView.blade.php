@extends('admin.template.base')

@section('title', 'View Contact')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">IPO Contact Details</h3>

            <a href="{{ route('admin.ipo.contactus') }}"
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
                                <td>{{ $contact->name }}</td>
                            </tr>

                            <tr>
                                <th>Company</th>
                                <td>{{ $contact->company }}</td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td>{{ $contact->email }}</td>
                            </tr>

                            <tr>
                                <th>Phone</th>
                                <td>{{ $contact->phone }}</td>
                            </tr>
                            <tr>
                                <th>IPO Stage</th>
                                <td>{{ $contact->ipo_stage }}</td>
                            </tr>
                            
                            <tr>
                                <th>Validation Points</th>
                                <td>{{ $contact->validation_points }}</td>
                            </tr>

                            <tr>
                                <th>Message</th>
                                <td style="white-space:normal;text-align: justify;">
                                    {{ $contact->message }}
                                </td>
                            </tr>

                            <tr>
                                <th>Date</th>
                                <td>{{ $contact->created_at->format('d-m-Y h:i A') }}</td>
                            </tr>
                        </table>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection