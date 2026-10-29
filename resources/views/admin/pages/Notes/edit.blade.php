@extends('admin.template.base')

@section('title', 'Edit Note')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Edit Note</h3>
        </div>

        <div class="card">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.notes.update',$note->id) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label><strong>Note Title <span class="text-danger">*</span></label></strong></label>

                            <input type="text"
                                   name="title"
                                   class="form-control"
                                   value="{{ old('title',$note->title) }}"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label><strong>Category</strong></label>

                            <input type="text"
                                   name="category"
                                   class="form-control"
                                   value="{{ old('category',$note->category) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label><strong>Priority</strong></label>

                            <select name="priority" class="form-control">
                                <option value="Low" {{ $note->priority=='Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ $note->priority=='Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ $note->priority=='High' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>

                        <!-- <div class="col-md-6 mb-3">
                            <label><strong>Reminder Date</strong></label>

                            <input type="date"
                                   name="reminder_date"
                                   class="form-control"
                                   value="{{ old('reminder_date',$note->reminder_date) }}">
                        </div> -->

                        <div class="col-md-6 mb-3">
                            <label><strong>Status</strong></label>

                            <select name="status" class="form-control">
                                <option value="Active" {{ $note->status=='Active' ? 'selected' : '' }}>Active</option>
                                <option value="Archived" {{ $note->status=='Archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label><strong>Attachment</strong></label>

                            <input type="file"
                                   name="attachment"
                                   class="form-control">

                            @if($note->attachment)
                                <br>

                                <a href="{{ asset('uploads/notes/'.$note->attachment) }}" target="_blank">
                                    Current File
                                </a>
                            @endif
                        </div>

                        <div class="col-md-12 mb-3">
                            <label><strong>Description <span class="text-danger">*</span></label></strong></label>

                            <textarea name="description"
                                      rows="5"
                                      class="form-control"
                                      required>{{ old('description',$note->description) }}</textarea>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save"></i>
                        Update Note
                    </button>

                    <a href="{{ route('admin.notes.index') }}" class="btn btn-secondary">
                        Back
                    </a>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection