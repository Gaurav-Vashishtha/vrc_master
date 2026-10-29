@extends('admin.template.base')

@section('title', 'Projects List')

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
            <h3 class="page-title">All Projects</h3>

            <a href="{{ route('admin.projects.create') }}"
                class="btn btn-success">
                Add Project
            </a>
        </div>


        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">

                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.projects.list') }}">
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
                                    <a href="{{ route('admin.projects.list') }}" class="btn btn-secondary me-2 btn-fixed">Reset</a>
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
                                        <th>Project Name</th>
                                        <th>Project URL</th>
                                        <th>Start Date</th>
                                        <th>Logo</th>
                                        <th>status</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($projects as $key => $project)
                                    @php $index = 1; @endphp
                                    <tr>
                                        <td>
                                            {{ $key + 1  }}
                                        </td>

                                        <td>{{ $project->project_name }}</td>
                                        <td> <a href="{{ $project->project_url }}" target="_blank">{{$project->project_url}}</a>
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($project->start_date)) }}</td>
                                        <td>
                                            @if($project->logo)
                                                <a href="{{ asset('uploads/projects/'.$project->logo) }}" target="_blank">
                                                    <img src="{{ asset('uploads/projects/'.$project->logo) }}" alt="Logo" style="width:40px;height:40px;">
                                                </a>
                                            @else
                                            No Logo
                                            @endif
                                        </td>
                                        <td>
                                            @if($project->status == 'Active')
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

                                    @empty

                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No Websites Found
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