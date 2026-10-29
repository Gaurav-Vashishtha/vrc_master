@extends('user.template.base')

@section('title', 'Add Work Report')

@section('content')

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Add Work Report</h3>
        </div>

        <div class="card">
            <div class="card-body">

                <form action="{{ route('user.work.reports.store') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <!-- User -->
                    <!-- <div class="form-group">
                        <label>User</label>

                        <select name="user_id" class="form-control" required>
                            <option value="">
                                Select User
                            </option>

                            @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->first_name }}
                                {{ $user->last_name }}
                            </option>
                            @endforeach

                        </select>
                    </div> -->

                    <!-- Project -->
                    <div class="form-group mt-3">
                        <label>Project</label>

                        <select name="project_id"
                            class="form-control select2"
                            required>

                            <option value=""> Select Project </option>
                            <option value="-1">Other</option>

                            @foreach($projects as $project)
                            <option value="{{ $project->id }}">
                                {{ $project->project_name }}
                            </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Other Project Details -->
                    <div id="otherProjectSection" style="display:none;" class="mt-3">
                        <div class="form-group">
                            <label>Other Project Name</label>
                            <input type="text" value="Other" name="other_project_name" class="form-control" placeholder="Enter Project Name">
                        </div>
                    </div>


                    <!-- Report Date -->
                    <div class="form-group mt-3">
                        <label>Report Date</label>
                        <input type="date" name="report_date" class="form-control" required>
                    </div>

                    <!-- Working Hours -->
                    <div class="form-group mt-3">
                        <label>Working Hours</label>
                        <input type="text" name="working_hours" class="form-control" placeholder="8" required>
                    </div>

                    <!-- Project Issue -->
                    <div class="form-group mt-3">
                        <label>Project Issue</label>
                        <textarea name="project_issue" rows="4" class="form-control" required></textarea>
                    </div>

                    <!-- Issue Status -->
                    <div class="form-group mt-3">
                        <label>Issue Status</label>

                        <select name="issue_status" id="issue_status" class="form-control" required>
                            <option value="">
                                Select Status
                            </option>

                            <option value="Pending">
                                Pending
                            </option>

                            <option value="Completed">
                                Completed
                            </option>

                        </select>
                    </div>

                    <!-- Pending Section -->
                    <div id="pendingSection" style="display:none;">

                        <div class="form-group mt-3">
                            <label>Pending Issue</label>

                            <textarea name="pending_issue"
                                rows="3"
                                class="form-control"></textarea>
                        </div>

                        <div class="form-group mt-3">
                            <label>Pending Reason</label>

                            <textarea name="pending_reason"
                                rows="3"
                                class="form-control"></textarea>
                        </div>

                    </div>

                    <!-- Fixed Section -->
                    <div id="fixedSection"
                        style="display:none;">

                        <div class="form-group mt-3">
                            <label>Fixed Issue</label>

                            <textarea name="fixed_issue"
                                rows="3"
                                class="form-control"></textarea>
                        </div>

                    </div>

                    <!-- Before Image -->
                    <div class="form-group mt-3">
                        <label>Before Image</label>
                        <input type="file" name="before_image" class="form-control">
                    </div>

                    <!-- After Image -->
                    <div class="form-group mt-3">
                        <label>After Image</label>
                        <input type="file" name="after_image" class="form-control">
                    </div>

                    <!-- Status -->
                    <div class="form-group mt-3">
                        <label>Status</label>

                        <select name="status" class="form-control">
                              <option value="1">
                                Active
                            </option>

                            <option value="0">
                                Inactive
                            </option>

                        </select>
                    </div>

                    <div class="mt-4">

                        <button type="submit" class="btn btn-success">
                            Save Work Report
                        </button>

                        <a href="{{ route('user.work.reports.list') }}" class="btn btn-secondary">
                            Back
                        </a>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        let issueStatus =
            document.getElementById('issue_status');

        issueStatus.addEventListener('change', function() {

            let value = this.value;

            document.getElementById('pendingSection')
                .style.display = 'none';

            document.getElementById('fixedSection')
                .style.display = 'none';

            if (value === 'Pending') {

                document.getElementById('pendingSection')
                    .style.display = 'block';
            }

            if (value === 'Completed') {

                document.getElementById('fixedSection')
                    .style.display = 'block';
            }

        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        let projectSelect =
            document.querySelector('select[name="project_id"]');

        projectSelect.addEventListener('change', function() {

            let value = this.value;

            if (value === '-1') {
                document.getElementById('otherProjectSection')
                    .style.display = 'block';
            } else {
                document.getElementById('otherProjectSection')
                    .style.display = 'none';
            }

        });

    });
</script>

@endsection