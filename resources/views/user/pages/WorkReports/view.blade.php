@extends('user.template.base')

@section('title','View Work Report')

@section('styles')
<style>
    pre {
        background: #191c24;
        padding: 15px;
        font-size: 14px;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header d-flex justify-content-between">

            <h3 class="page-title">
                Work Report Details
            </h3>

            <a href="{{ route('user.work.reports.list') }}"
                class="btn btn-secondary">
                Back
            </a>

        </div>

        <div class="card">
            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="250">User Name</th>
                        <td>
                            {{ $workreport->user?->first_name }}
                            {{ $workreport->user?->last_name }}
                        </td>
                    </tr>

                    <tr>
                        <th>Project</th>
                        <td>
                            @if($workreport->project_id == -1)
                                {{ $workreport?->project_name }}
                            @else
                                {{ $workreport?->project?->project_name }}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Report Date</th>
                        <td>
                            {{ date('d-m-Y',strtotime($workreport->report_date)) }}
                        </td>
                    </tr>

                    <tr>
                        <th>Working Hours</th>
                        <td> {{ $workreport->working_hours }} </td>
                    </tr>

                    <tr>
                        <th>Issue Status</th>
                        <td> {{ $workreport->issue_status }} </td>
                    </tr>

                    <tr>
                        <th>Project Issue</th>
                        <td> {{ $workreport->project_issue ?? '-' }} </td>
                    </tr>

                    <tr>
                        <th>Pending Issue</th>
                        <td> {{ $workreport->pending_issue ?? '-' }} </td>
                    </tr>

                    <tr>
                        <th>Pending Reason</th>
                        <td> {{ $workreport->pending_reason ?? '-' }} </td>
                    </tr>

                    <tr>
                        <th>Fixed Issue</th>
                        <td><pre>{{ $workreport->fixed_issue ?? '-' }} </pre> </td>
                    </tr>

                    <tr>
                        <th>Before Image</th>
                        <td>

                            @if($workreport->before_image)

                            <img src="{{ asset('uploads/workreports/'.$workreport->before_image) }}"
                                width="250">

                            @else

                            N/A

                            @endif

                        </td>
                    </tr>

                    <tr>
                        <th>After Image</th>
                        <td>

                            @if($workreport->after_image)

                            <img src="{{ asset('uploads/workreports/'.$workreport->after_image) }}"
                                width="250">

                            @else

                            N/A

                            @endif

                        </td>
                    </tr>

                    <tr>
                        <th>Status</th>

                        <td>

                            @if($workreport->status==1)

                            <span class="badge bg-success">
                                Active
                            </span>

                            @else

                            <span class="badge bg-danger">
                                Inactive
                            </span>

                            @endif

                        </td>

                    </tr>

                    <tr>
                        <th>Created At</th>

                        <td>

                            {{ $workreport->created_at->format('d M Y h:i A') }}

                        </td>

                    </tr>

                </table>

            </div>
        </div>

    </div>
</div>
@endsection