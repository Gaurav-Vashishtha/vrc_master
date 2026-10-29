@extends('admin.template.base')

@section('title', 'Edit News')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Edit News</h3>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.news.update', $news->id) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $news->title) }}"
                               required>
                    </div>

                    <div class="form-group mt-3">
                        <label>Description</label>
                        <textarea name="description" id="description"
                                  class="form-control"
                                  rows="5"
                                  required>{{ old('description', $news->description) }}</textarea>
                    </div>

                    <div class="form-group mt-3">
                        <label>Current Image</label>
                        <br>

                        @if($news->image)
                            <img src="{{ asset('uploads/news/'.$news->image) }}"
                                 width="120">
                        @else
                            <p>No Image</p>
                        @endif
                    </div>

                    <div class="form-group mt-3">
                        <label>Change Image</label>
                        <input type="file"
                               name="image"
                               class="form-control">
                    </div>

                    <div class="form-group mt-3">
                        <label>Status</label>

                        <select name="status"
                                class="form-control">

                            <option value="1"
                                {{ $news->status == 1 ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0"
                                {{ $news->status == 0 ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit"
                                class="btn btn-primary">
                            Update News
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