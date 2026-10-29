@extends('user.template.base')

@section('title', 'Employee Personal Information')

@section('styles')
@endsection

@section('content')

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
            <h3 class="page-title"> Employees Attendance Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <!-- <li class="breadcrumb-item"><a href="#">Tables</a></li> -->
                <!-- <li class="breadcrumb-item active" aria-current="page">Basic tables</li> -->
                </ol>
            </nav>
            </div>
            <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <!-- <h4 class="card-title">Hoverable Table</h4>
                    <p class="card-description"> Add class <code>.table-hover</code> -->
                    </p>
                    <div class="table-responsive">
                    <table class="table table-hover" id="datatablesSimple">
                        <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Employee Name</th>
                            <th>Employee Code</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Total Working Time</th>
                            <th>Description</th>
                            <th>Rating</th>
                            <th>Weekly Ratings</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $x=1; @endphp
                        @foreach($attendance as $employee)
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$employee->emp_name}} </td>
                            <td>{{$employee->emp_code}}</td>
                            <td>{{date("d-m-Y h:i:s A", strtotime($employee->check_in))}}</td>
                            <td>@if(!empty($employee->check_out)) {{date("d-m-Y h:i:s A", strtotime($employee->check_out))}}  @else - @endif</td>
                            <td>@if(!empty($employee->total_work)) {{$employee->total_work}} Hours @else - @endif</td>
                            <td>
                                <span title="{{$employee->work_description}}" style="cursor: pointer;">{{ substr($employee->work_description, 0,  25) }} @if(strlen($employee->work_description)>25) .... @endif</span>
                            </td>
                            @if(empty($employee->rating))
                                <th></th>
                            @else
                                @if($employee->rating=='1')
                                <th>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                </th>
                                @elseif($employee->rating=='2')
                                <th>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                </th>
                                @elseif($employee->rating=='3')
                                <th>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                </th>
                                @elseif($employee->rating=='4')
                                <th>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                </th>
                                @elseif($employee->rating=='5')
                                <th>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                    <i title="{{$employee->description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                </th>
                                @endif
                            @endif

                            <th>@if(!empty($employee->check_in)) 
                                    @if(date("D", strtotime($employee->check_in))=='Mon') 
                                        @if($employee->rt_status=='') 
                                            
                                        @elseif($employee->rt_status=='RQ')
                                           <i><span style="color: green;">Requested</span></i>
                                           @elseif($employee->rt_status=='RT') 
                                            @if($employee->cln_rating=='1')
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                                @elseif($employee->cln_rating=='2')
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                                @elseif($employee->cln_rating=='3')
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                                @elseif($employee->cln_rating=='4')
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star-outline" style="color: green;" aria-hidden = "true"></i>
                                                @elseif($employee->cln_rating=='5')
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                    <i title="{{$employee->cln_description}}" class="mdi mdi-star" style="color: yellow;" aria-hidden = "true"></i>
                                                @endif
                                        @endif
                                    @endif
                                @else
                                - 
                                @endif
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