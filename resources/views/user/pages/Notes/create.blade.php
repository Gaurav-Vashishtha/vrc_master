@extends('user.template.base')

@section('title', 'Add Note')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Add Note</h3>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('user.notes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Note Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">

                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Category</label>
                            <input type="text" name="category" class="form-control" value="{{ old('category') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Priority</label>

                            <select name="priority" class="form-control">
                                <option value="Low">Low</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>

                        <!-- <div class="col-md-6 mb-3">
                            <label>Reminder Date</label>
                            <input type="date" name="reminder_date" class="form-control" value="{{ old('reminder_date') }}">
                        </div> -->

                        <div class="col-md-6 mb-3">
                            <label>Status</label>

                            <select name="status" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Archived">Archived</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Attachment</label>

                            <input type="file" name="attachment" class="form-control">

                            @error('attachment')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Description <span class="text-danger">*</span></label></label>

                            <textarea name="description"
                                      rows="5"
                                      class="form-control">{{ old('description') }}</textarea>

                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        Save Note
                    </button>

                    <a href="{{ route('user.notes.index') }}" class="btn btn-secondary">
                        Back
                    </a>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection