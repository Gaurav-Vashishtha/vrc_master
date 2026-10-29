@extends('admin.template.base')

@section('title', 'Employee Registration')

@section('styles')
@endsection

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">                    
                <div class="col-12 grid-margin">
                    <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Register New Employee</h4>
                        <form class="form-sample" id="myForm" action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                        <p class="card-description"> Personal info </p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
@endsection