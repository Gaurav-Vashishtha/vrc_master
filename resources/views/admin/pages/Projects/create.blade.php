@extends('admin.template.base')

@section('title', 'Add Project')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Add Project</h3>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Project Name</label>
                            <input type="text" name="project_name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Project URL</label>
                            <input type="text" name="project_url" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Project Logo</label>
                            <input type="file" name="logo" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-success">
                        Save Project
                    </button>

                    <a href="{{ route('admin.projects.list') }}"
                        class="btn btn-secondary">
                        Back
                    </a>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection