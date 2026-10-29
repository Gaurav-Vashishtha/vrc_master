@extends('admin.template.base')

@section('title', 'Edit Website')

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
            <h3 class="page-title">Edit Website</h3>

            <a href="{{ route('admin.websites.index') }}"
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

                <form action="{{ route('admin.websites.update', $website->id) }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        <!-- Website Name -->
                        <div class="col-md-6 mb-3">
                            <label><strong>Website Name</strong></label>

                            <input type="text"
                                name="website_name"
                                class="form-control"
                                value="{{ old('website_name', $website->website_name) }}"
                                required>
                        </div>

                        <!-- Website URL -->
                        <div class="col-md-6 mb-3">
                            <label><strong>Website URL</strong></label>

                            <input type="text"
                                name="website_url"
                                class="form-control"
                                value="{{ old('website_url', $website->website_url) }}"
                                required>
                        </div>

                        <!-- Select User -->
                        <div class="col-md-6 mb-3">
                            <label><strong>Select User</strong></label>

                            <select name="user_id"
                                class="form-control"
                                id="user_id"
                                required>

                                <option value="">Select User</option>

                                @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $website->user_id) == $user->id ? 'selected' : '' }}>

                                    {{ $user->first_name }} {{ $user->last_name }}

                                </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label><strong>Status</strong></label>

                            <select name="status"
                                class="form-control"
                                required>

                                <option value="active"
                                    {{ old('status', $website->status) == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="inactive"
                                    {{ old('status', $website->status) == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label><strong>Description</strong></label>

                            <textarea name="description"
                                class="form-control"
                                rows="5"
                                placeholder="Enter description">{{ old('description', $website->description) }}</textarea>
                        </div>

                        <!-- Website Logo -->
                        <div class="col-md-6 mb-3">
                            <label><strong>Website Logo</strong></label>

                            <input type="file"
                                name="logo"
                                class="form-control">

                            @if($website->logo)
                            <div class="mt-3">

                                <p class="mb-2">
                                    <strong>Current Logo:</strong>
                                </p>

                                <a href="{{ asset('uploads/websites/'.$website->logo) }}"
                                    target="_blank">

                                    <img src="{{ asset('uploads/websites/'.$website->logo) }}"
                                        alt="Website Logo"
                                        style="width:70px;height:70px;object-fit:contain;border:1px solid #ddd;padding:5px;">

                                </a>

                            </div>
                            @endif

                        </div>

                    </div>

                    <button type="submit"
                        class="btn btn-success">
                        Update Website
                    </button>

                    <a href="{{ route('admin.websites.index') }}"
                        class="btn btn-secondary">
                        Back
                    </a>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection