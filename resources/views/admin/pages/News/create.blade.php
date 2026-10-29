@extends('admin.template.base')

@section('title', 'Add News')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Add News</h3>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.news.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">
                        <label>Title <span class="text-danger">*</span></label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title') }}"
                               required>

                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label>Description <span class="text-danger">*</span></label>
<textarea name="description"
          id="description"
          class="form-control"
          required>{{ old('description') }}</textarea>

                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label>Image</label>

                        <input type="file"
                               name="image"
                               class="form-control">

                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label>Status</label>

                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>

                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit"
                                class="btn btn-success">
                            Save News
                        </button>

                        <a href="{{ route('admin.news.index') }}"
                           class="btn btn-secondary">
                            Back
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection


@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

<script>
$(document).ready(function () {
    $('#description').summernote({
        height: 300
    });
});
</script>
@endsection