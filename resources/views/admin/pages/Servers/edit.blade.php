@extends('admin.template.base')

@section('title', 'Edit Server')

@section('content')

<style>
    .card-body {
        padding: 25px !important;
    }

    .form-control {
        height: 42px;
    }

    textarea.form-control {
        height: auto;
        min-height: 120px;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header d-flex justify-content-between align-items-center">
            <h3 class="page-title">Edit Server</h3>

            <a href="{{ route('admin.servers.index') }}"
                class="btn btn-secondary">
                Back
            </a>
        </div>

        <div class="card">
            <div class="card-body">

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('admin.servers.update', $server->id) }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        <!-- Server Name -->
                        <div class="col-md-6 mb-3">
                            <label>Server Name<strong><span class="text-danger">*</span></strong></label>

                            <input type="text"
                                name="server_name"
                                class="form-control"
                                value="{{ old('server_name', $server->server_name) }}"
                                required>
                        </div>

                        <!-- Server URL -->
                        <div class="col-md-6 mb-3">
                            <label>Server URL<strong><span class="text-danger">*</span></strong></label>

                            <input type="text"
                                name="server_url"
                                class="form-control"
                                value="{{ old('server_url', $server->server_url) }}"
                                required>
                        </div>

                        <!-- Select User -->
                        <div class="col-md-6 mb-3">
                            <label>Select User<strong><span class="text-danger">*</span></strong></label>

                            <select name="user_id"
                                class="form-control"
                                id="user_id"
                                required>

                                <option value="">Select User</option>

                                @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $server->user_id) == $user->id ? 'selected' : '' }}>

                                    {{ $user->first_name }} {{ $user->last_name }}

                                </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label>Status</label>

                            <select name="status"
                                class="form-control"
                                required>

                                <option value="active"
                                    {{ old('status', $server->status) == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="inactive"
                                    {{ old('status', $server->status) == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Server Username</label>
                            <input type="text" name="username" class="form-control"  value="{{ old('username', $server->username) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Server Password</label>
                            <input type="text" name="password" class="form-control"  value="{{ old('password', $server->password) }}" required>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label>Description</label>

                            <textarea name="description"
                                class="form-control"
                                rows="5"
                                placeholder="Enter description">{{ old('description', $server->description) }}</textarea>
                        </div>

                        <!-- Server Logo -->
                        <div class="col-md-6 mb-3">
                            <label>Server Logo</label>

                            <input type="file"
                                name="logo"
                                class="form-control">

                            @if($server->logo)
                            <div class="mt-3">

                                <p class="mb-2">
                                    Current Logo:
                                </p>

                                <a href="{{ asset('uploads/servers/'.$server->logo) }}"
                                    target="_blank">

                                    <img src="{{ asset('uploads/servers/'.$server->logo) }}"
                                        alt="Server Logo"
                                        style="width:70px;height:70px;object-fit:contain;border:1px solid #ddd;padding:5px;">

                                </a>

                            </div>
                            @endif

                        </div>

                    </div>

                    <button type="submit"
                        class="btn btn-success">
                        Update Server
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