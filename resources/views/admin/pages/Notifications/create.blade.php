@extends('admin.template.base')

@section('title', 'Send Notification')

@section('content')
<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Send Notification</h3>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.notifications.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="title">Title <span class="text-danger">*</span></label>
                        <input id="title" type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Message <span class="text-danger">*</span></label>
                        <textarea id="description" name="description" rows="5" class="form-control" required>{{ old('description') }}</textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <select id="priority" name="priority" class="form-control" required>
                            @foreach(['Low', 'Medium', 'High'] as $priority)
                                <option value="{{ $priority }}" {{ old('priority', 'Medium') === $priority ? 'selected' : '' }}>
                                    {{ $priority }}
                                </option>
                            @endforeach
                        </select>
                        @error('priority')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Recipients <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" name="audience" value="all" class="form-check-input"
                                    {{ old('audience', 'all') === 'all' ? 'checked' : '' }}>
                                All active employees
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" name="audience" value="selected" class="form-check-input"
                                    {{ old('audience') === 'selected' ? 'checked' : '' }}>
                                Select employees
                            </label>
                        </div>
                        @error('audience')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group" id="employee-selection" style="display: none;">
                        <label for="user_ids">Employees</label>
                        <select id="user_ids" name="user_ids[]" class="form-control select2" multiple>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ in_array($user->id, old('user_ids', [])) ? 'selected' : '' }}>
                                    {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_ids')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                        @error('user_ids.*')
                            <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Send Notification</button>
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const recipientOptions = document.querySelectorAll('input[name="audience"]');
        const employeeSelection = document.getElementById('employee-selection');
        const userSelect = document.getElementById('user_ids');

        function updateRecipientSelection() {
            const selectEmployees = document.querySelector('input[name="audience"]:checked')?.value === 'selected';
            employeeSelection.style.display = selectEmployees ? 'block' : 'none';
            userSelect.disabled = !selectEmployees;
        }

        recipientOptions.forEach(function (option) {
            option.addEventListener('change', updateRecipientSelection);
        });

        updateRecipientSelection();
    });
</script>
@endsection
