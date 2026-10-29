@extends('admin.template.base')

@section('title', 'Add Server')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Add Server</h3>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.servers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Server Name<span class="text-danger">*</span></label>
                            <input type="text" name="server_name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Server URL<span class="text-danger">*</span></label>
                            <input type="text" name="server_url" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Select User<span class="text-danger">*</span></label>
                            <select name="user_id" class="form-control" id="user_id" required>
                                <option value="">Select User</option>

                                @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Server Logo</label>
                            <input type="file" name="logo" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Server Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Server Password</label>
                            <input type="text" name="password" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="4"
                                placeholder="Enter description"></textarea>
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
                        Save Server
                    </button>

                    <a href="{{ route('admin.servers.index') }}"
                        class="btn btn-secondary">
                        Back
                    </a>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection