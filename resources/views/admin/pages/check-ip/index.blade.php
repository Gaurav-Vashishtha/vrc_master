@extends('admin.template.base')

@section('title', 'Second Master')

@section('content')

<style>
    .form-control {
        height: 45px;
        border-radius: 8px;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .card-body {
        padding: 30px !important;
    }

    .day-box {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 15px;
    }

    .day-item {
        position: relative;
    }

    .day-item input[type="checkbox"] {
        display: none;
    }

    .day-item label {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 55px;
        border: 2px solid #dee2e6;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: .3s;
        background: #fff;
        color: #495057;
        margin: 0;
    }

    .day-item label:hover {
        border-color: #0d6efd;
    }

    .day-item input:checked+label {
        background: #198754;
        color: #fff;
        border-color: #198754;
        box-shadow: 0 5px 12px rgba(25, 135, 84, .3);
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 18px;
    }

    .ip-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
    }
</style>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                IP Day Settings
            </h3>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        <form action="{{url('admin/required-ip/update')}}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- IP Address -->
                                <div class="col-md-4">
                                    <label class="form-label">
                                        <strong>IP Address</strong>
                                    </label>
                                    <input type="text"
                                        name="ip_address"
                                        class="form-control"
                                        placeholder="Enter IP Address"
                                        value="{{ $secondMaster->ip_address ?? '' }}">
                                </div>

                                <div class="col-md-4 d-flex align-items-end">
                                    <div class="form-check mb-2">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="force_update_ip"
                                            value="1"
                                            id="forceUpdateIp">
                                        <label class="form-check-label ms-2" for="forceUpdateIp">
                                            <strong>Force Update IP</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <label class="form-label">
                                <strong>Select IP Check Days</strong>
                            </label>
                            @php

                            $days = [
                            'Monday',
                            'Tuesday',
                            'Wednesday',
                            'Thursday',
                            'Friday',
                            'Saturday',
                            'Sunday'
                            ];

                            @endphp
                            <div class="day-box">
                                @foreach($days as $day)
                                <div class="day-item">
                                    <input type="checkbox" id="{{ $day }}" class="btn btn-success"
                                        name="days[{{ $day }}]"
                                        value="1"
                                        @if(!empty($secondMaster->days[$day]))
                                    checked
                                    @endif
                                    >
                                    <label for="{{ $day }}">
                                        {{ $day }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success px-5">
                                <i class="mdi mdi-content-save"></i> Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection