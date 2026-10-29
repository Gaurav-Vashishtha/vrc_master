@extends('user.template.base')

@section('title', 'Your All Notifications')

@section('styles')
@endsection

@section('content')

    <div class="main-panel">
        <div class="content-wrapper">
            <i class="mdi mdi-keyboard-backspace" style="font-size: 25px; color:blue; cursor:pointer;" onclick="history.back()"></i>     
            <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Your All Notifications</h4>
                    <div class="table-responsive">
                        <table class="table table-hover" id="datatablesSimple">
                            <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Priority</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $x=1; @endphp
                            @foreach($notification as $datas)
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$datas->title}}</td>
                                <td>
                                    <span title="{{$datas->description}}" style="cursor: pointer;">{{ substr($datas->description, 0,  35) }} @if(strlen($datas->description)>35) .... @endif</span>
                                </td>
                                <td>
                                    @if($datas->priority=='1')
                                    <label style="color: green">High</label>
                                    @elseif($datas->priority=='2')
                                    <label style="color: yellow">Medium</label>
                                    @elseif($datas->priority=='3')
                                    <label style="color: blue">Low</label>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
@endsection


@section('scripts')
<script src="{{ URL::asset('js/datatables-simple-demo.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection