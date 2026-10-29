@extends('user.template.base')

@section('title', 'Websites List')

@section('content')
<style>
    /* .d-flex.mainbtn {
    justify-content: space-around;
    padding-top: 31px;
    width: 154px;
} */

    .btn-fixed {
        height: 38px;
        min-width: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-control {
        height: 38px;
    }

    .card-body {
        padding: 25px !important;
    }

    .form-control {
        min-width: 180px;
        height: 42px;
    }

    .btn-fixed {
        min-width: 120px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table-responsive {
        margin-top: 15px;
    }

    .table th,
    .table td {
        padding: 14px 12px;
        vertical-align: middle;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">

                    <div class="card-body">
                        {{--
                        <form method="GET" action="{{ route('user.websites.index') }}">
                            <div class="d-flex align-items-end gap-3 flex-wrap" style="gap:5px">

                                <div class="mb-2">
                                    <label><strong>From Date</strong></label>
                                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                </div>

                                <div class="mb-2">
                                    <label><strong>To Date</strong></label>
                                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                </div>

                                <div class="d-flex gap-2  mb-2" style="gap:3px">
                                    <button type="submit" class="btn btn-primary me-2 btn-fixed">Filter</button>
                                    <a href="{{ route('user.websites.index') }}" class="btn btn-secondary me-2 btn-fixed">Reset</a>
                                </div>

                            </div>
                        </form>
                        --}}


                        <div class="table-responsive">

                            <table class="table table-hover" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Website Name</th>
                                        <th>Website URL</th>
                                        <th>User</th>
                                        <th>Logo</th>
                                        <!-- <th>Description</th> -->
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($websites as $key => $website)
                                    @php $index = 1; @endphp
                                    <tr>
                                        <td>
                                            {{ $key + 1  }}
                                        </td>

                                        <td>{{ $website->website_name }}</td>
                                        <td> <a href="{{ $website->website_url }}" target="_blank">{{$website->website_url}}</a>
                                        </td>
                                        <td>
                                            {{ $website->user->first_name ?? '' }}
                                            {{ $website->user->last_name ?? '' }}
                                        </td>

                                        <td>
                                            @if($website->logo)
                                            <a href="{{ asset('uploads/websites/'.$website->logo) }}" target="_blank">
                                                <img src="{{ asset('uploads/websites/'.$website->logo) }}" alt="Logo" style="width:40px;height:40px;">
                                            </a>
                                            @else
                                            No Logo
                                            @endif
                                        </td>
                                        <!-- <td>
                                            {{ $website->description ?? 'No Description' }}
                                        </td> -->

                                        <td>
                                            @if($website->status == 'active')
                                            <span class="badge bg-success">
                                                Active
                                            </span>
                                            @else
                                            <span class="badge bg-danger">
                                                Inactive
                                            </span>
                                            @endif
                                        </td>

                                        <td>

                                            <i class="mdi mdi-comment text-primary view-daily-website-check"
                                                style="cursor: pointer;"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Comment Daily Website Check"
                                                data-daily-website-check-id="{{ $website->id ?? '' }}">
                                            </i>

                                            <a href="{{ route('user.websites.history', $website->id) }}" class="btn btn-sm btn-primary">
                                                <i class="mdi mdi-history"></i>Check
                                            </a>
                                        </td>
                                    </tr>

                                    @empty

                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No Websites Found
                                        </td>
                                    </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Comment Daily Website Check Modal -->
<div class="modal fade" id="dailyWebsiteCheck" tabindex="-1" role="dialog" aria-labelledby="dailyWebsiteCheckLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="dailyWebsiteCheckLabel">
                    Comment Daily Website Check
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Daily Website Check --}}
                <div class="card mb-4">
                    <div class="card-body">

                        <h4 class="card-title mb-4">
                            Daily Website Check
                        </h4>

                        <form id="dailyWebsiteCheckForm" action=""
                            method="POST">

                            @csrf

                            <div class="form-group">
                                <label>
                                    Status <span class="text-danger">*</span>
                                </label>

                                <select name="status"
                                        class="form-control"
                                        required>

                                    <option value="">
                                        Select Status
                                    </option>

                                    <option value="working"
                                        {{ old('status') == 'working' ? 'selected' : '' }}>
                                        Working
                                    </option>

                                    <option value="problem"
                                        {{ old('status') == 'problem' ? 'selected' : '' }}>
                                        Problem
                                    </option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label>
                                    Message <span class="text-danger">*</span>
                                </label>

                                <textarea name="message"
                                        class="form-control"
                                        rows="4"
                                        placeholder="Enter website checking message..."
                                        required>{{ old('message') }}</textarea>
                            </div>

                            <button type="submit"
                                    class="btn btn-primary">
                                Submit
                            </button>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection



@section('scripts')
<script>
$(document).ready(function () {
    var baseUrl = "{{ url('/') }}";
    $('[data-toggle="tooltip"]').tooltip();
    $('.view-daily-website-check').on('click', function () {
        let dailyWebsiteCheckId = $(this).data('daily-website-check-id');
        $('#dailyWebsiteCheckForm').attr('action', baseUrl + '/user/website-check/' + dailyWebsiteCheckId);
        $('#dailyWebsiteCheck').modal('show');
    });
});
</script>
@endsection