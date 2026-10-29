php
@extends('user.template.base')

@section('title', 'Website History')

@section('content')

<style>
    .card-body {
        padding: 25px;
    }

    .table th,
    .table td {
        vertical-align: middle;
        padding: 12px 15px;
    }

    .status-working {
        background: #28a745;
        color: #fff;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 12px;
    }

    .status-problem {
        background: #dc3545;
        color: #fff;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 12px;
    }

    .website-url {
        word-break: break-all;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Website History</h3>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- Website Details --}}
        <div class="card mb-4">
            <div class="card-body">

                <h4 class="mb-3">
                    {{ $website->website_name }}
                </h4>

                <p class="mb-0">
                    <strong>Website URL:</strong>

                    <a href="{{ $website->website_url }}"
                       target="_blank"
                       class="website-url">
                        {{ $website->website_url }}
                    </a>
                </p>

                <p class="mb-0">
                    <strong>Website Description:</strong>

                    {{ $website->description ?? 'No Description' }}
                </p>

            </div>
        </div>

        {{-- Daily Website Check --}}
        <div class="card mb-4">
            <div class="card-body">

                <h4 class="card-title mb-4">
                    Daily Website Check
                </h4>

                <form action="{{ route('user.websites.storeCheck', $website->id) }}"
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

        {{-- Website History --}}
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">
                    Previous History
                </h4>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th width="70">#</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Message</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($histories as $key => $history)

                                <tr>

                                    <td>
                                        {{ $key + 1 }}
                                    </td>

                                    <td>
                                        {{ $history->created_at->format('d M Y, h:i A') }}
                                    </td>

                                    <td>

                                        @if($history->status == 'working')

                                            <span class="status-working">
                                                Working
                                            </span>

                                        @else

                                            <span class="status-problem">
                                                Problem
                                            </span>

                                        @endif

                                    </td>

                                    <td>
                                        {{ $history->message }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4"
                                        class="text-center">
                                        No history found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{--@if($histories->hasPages())
                    <div class="mt-3">
                        {{ $histories->links() }}
                    </div>
                @endif--}}

            </div>
        </div>

    </div>
</div>

@endsection