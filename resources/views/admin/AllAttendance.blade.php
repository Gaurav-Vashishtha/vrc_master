@extends('admin.template.base')

@section('title', 'Admin Home Page')

@section('styles')
    <style>
        /* body{
            color: red !important;
        } */
        label{
            padding-top: 7px;
            padding-left: 15px;
        }
        .mdi:hover{
            cursor: pointer;
        }
        .modal-body label{
            color: black !important;
        }
        input{
            border: 1px solid black !important;
        }
        .fa-spin{
            color: green;
        }
    </style>
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
                    <div class="form-group">
                        <form action="{{url('/admin/attendance')}}" method="get">
                            @csrf
                            <label for="">Employee Code:</label> 
                            <select name="emp_code">
                                <option value="">--select Employee--</option>
                                @foreach($employees as $employee)
                                    <option value="{{$employee->emp_code}}" @if(Request::get('emp_code')==$employee->emp_code) selected @endif>{{$employee->first_name}} {{$employee->last_name}} ({{$employee->emp_code}})</option>
                                @endforeach
                            </select>

                            <label for="">From Date:</label>
                            <input type="date" name="from_date" @if(Request::get('from_date')) value="{{Request::get('from_date')}}" @else  value="{{date('Y-m-01')}}" @endif>

                            <label for="">To Date:</label>
                            <input type="date" name="to_date" @if(Request::get('to_date')) value="{{Request::get('to_date')}}" @else  value="{{date('Y-m-d')}}" @endif>

                            
                            <button class="btn btn-primary" style="margin-left: 10px;" type="submit" name="search" title="Click for search">Search</button>
                            <!-- start code for excel export -->
                            <button class="btn btn-warning" style="padding: 2px 2px 2px 6px;margin-left: 10px" type="submit" name="excel" title="Click for export excel"><i class="mdi mdi-file-excel" style="font-size:20px;"></i></button>
                            <!-- end code for excel export   -->
                        </form>

                    </div>
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
                            <!-- Button trigger modal -->
                            @if(empty($employee->rating))
                                <th><i class="mdi mdi-star-outline doRating" style="color: #6c7293;" title="Click for rating" data-toggle="modal" data-target="#exampleModal" empID="{{$employee->id}}" empCode="{{$employee->emp_code}}"></i></th>
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
                                            {{--<a href="/admin/request_workRating_{{$employee->id}}"><i title="Click for send request for rating" class="mdi mdi-star-outline RequestRating" style="color: #6c7293;" aria-hidden = "true"  empID="{{$employee->id}}" empCode="{{$employee->emp_code}}"></i></a>--}}
                                            <i title="Click for send request for rating" class="mdi mdi-star-outline RequestRating" style="color: #6c7293;" aria-hidden = "true"  empID="{{$employee->id}}" empCode="{{$employee->emp_code}}"></i></a>
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
                            </th>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content" style="background-color: white;text-align: center;">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel"  style="color: black;">Daily Work Raiting</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <i class="mdi mdi-star-outline rating-str" style="color: green; font-size: 40px" aria-hidden = "true" id = "st1"></i><i class="mdi mdi-star rating-rstr" style="color: yellow; font-size: 40px; display:none;" aria-hidden = "true" id = "rst1"></i>
                                    <i class="mdi mdi-star-outline rating-str" style="color: green; font-size: 40px" aria-hidden = "true" id = "st2"></i><i class="mdi mdi-star rating-rstr" style="color: yellow; font-size: 40px; display:none;" aria-hidden = "true" id = "rst2"></i>
                                    <i class="mdi mdi-star-outline rating-str" style="color: green; font-size: 40px" aria-hidden = "true" id = "st3"></i><i class="mdi mdi-star rating-rstr" style="color: yellow; font-size: 40px; display:none;" aria-hidden = "true" id = "rst3"></i>
                                    <i class="mdi mdi-star-outline rating-str" style="color: green; font-size: 40px" aria-hidden = "true" id = "st4"></i><i class="mdi mdi-star rating-rstr" style="color: yellow; font-size: 40px; display:none;" aria-hidden = "true" id = "rst4"></i>
                                    <i class="mdi mdi-star-outline rating-str" style="color: green; font-size: 40px" aria-hidden = "true" id = "st5"></i><i class="mdi mdi-star rating-rstr" style="color: yellow; font-size: 40px; display:none;" aria-hidden = "true" id = "rst5"></i>

                                    <br>
                                    <input type="hidden" name="rating" id="rating">
                                    <input type="hidden" name="empID" id="empID">
                                    <input type="hidden" name="empCode" id="empCode">
                                    <textarea name="description" id="description" cols="30" rows="4" placeholder="Description"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <div id="ResMsg" style="font-size: 13px;">&nbsp;</div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="sendRating">Send Rating</button>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>
                </div>
            </div>
            </div>
        </div>
@endsection


@section('scripts')
<script src="{{ URL::asset('admin/js/datatables-simple-demo.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script>
    $(document).ready(function() {
        $("#st1").click(function() {
            $("#st1").hide();
            $("#rst1").show();
            $('#rating').val('1');

        });
        $("#st2").click(function() {
            $("#st1, #st2").hide();
            $("#rst1, #rst2").show();
            $('#rating').val('2');
        });
        $("#st3").click(function() {
            $("#st1, #st2, #st3").hide();
            $("#rst1, #rst2, #rst3").show();
            $('#rating').val('3');
        });
        $("#st4").click(function() {
            $("#st1, #st2, #st3, #st4").hide();
            $("#rst1, #rst2, #rst3, #rst4").show();
            $('#rating').val('4');
        });
        $("#st5").click(function() {
            $("#st1, #st2, #st3, #st4, #st5").hide();
            $("#rst1, #rst2, #rst3, #rst4, #rst5").show();
            $('#rating').val('5');
        });


        $("#rst1").click(function() {
            $("#rst1, #st2, #st3, #st4, #st5").show();
            $("#st1, #rst2, #rst3, #rst4, #rst5").hide();
            $('#rating').val('1');
        });
        $("#rst2").click(function() {
            $("#rst1, #rst2, #st3, #st4, #st5").show();
            $("#st1, #st2, #rst3, #rst4, #rst5").hide();
            $('#rating').val('2');
        });
        $("#rst3").click(function() {
            $("#rst1, #rst2 , #rst3, #st4, #st5").show();
            $("#st1, #st2 , #st3, #rst4, #rst5").hide();
            $('#rating').val('3');
        });
        $("#rst4").click(function() {
            $("#rst1, #rst2, #rst3, #rst4, #st5").show();
            $("#st1, #st2, #st3, #st4, #rst5").hide();
            $('#rating').val('4');
        });
        $("#rst5").click(function() {
            $("#st1, #st2, #st3, #st4, #st5").hide();
            $("#rst1, #rst2, #rst3, #rst4, #rst5").show();
            $('#rating').val('5');
        });
    });

    jQuery(document).on('click','.doRating',function(){
        var btn     = jQuery(this);
        var empID   = jQuery(this).attr('empID');
        var empCode = jQuery(this).attr('empCode');
        jQuery('#empID').val(empID);
        jQuery('#empCode').val(empCode);
    });

    jQuery(document).on('click','#sendRating',function(){
        var btn     = jQuery(this);
        var rating  = jQuery('#rating').val();
        var empID   = jQuery('#empID').val();
        var empCode = jQuery('#empCode').val();
        var descr   = jQuery('#description').val();
        var msg     = jQuery('#ResMsg');
        var url     = '/admin/workRating';
        if (rating!='') {
            jQuery.ajax({
                type: "get",
                url: url,
                data : { rating : rating, empID : empID, empCode: empCode, descr: descr},
                beforeSend:function(){
                    btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Send Rating");
                },
                success: function(data) {
                    if (data.status=='1') {
                        // Ajax call completed successfully
                        msg.html(data.msg).css('color', 'green');
                        btn.html("Send Rating");
                        setTimeout(() => {
                            location.reload();
                        },3500);
                    } else {
                        msg.html(data.msg).css('color', 'red');
                        btn.html("Send Rating");
                    }
                },
                error: function(data) {
                    // Some error in ajax call
                    msg.html("Some error while Rating").css('color', 'red');
                    btn.html("Send Rating");
                }
            });   
        }
        else{
            msg.html("Please Rate").css('color', 'red');
        }
        // setTimeout(() => {
        //     msg.html('&nbsp;');
        // },3500);
    });

    

    // // Send Request
    jQuery(document).on('click','.RequestRating',function(){
        var btn     = jQuery(this);
        var empID   = jQuery(this).attr('empID');
        var empCode = jQuery(this).attr('empCode');
        jQuery.ajax({
            type: "get",
            url: '/admin/request_workRating',
            data : { id : empID, empCode: empCode},
            beforeSend:function(){
                btn.html("<i class='fa fa-circle-o-notch fa-spin'></i>");
            },
            success: function(data) {
                if (data.status=='1') {
                    // Ajax call completed successfully
                    btn.removeClass('mdi-star-outline');
                    btn.html('<span style="color: green;">Requested</span>');
                    btn.removeClass('RequestRating');
                } else {
                    // msg.html(data.msg).css('color', 'red');
                    btn.html("&nbsp");

                }
            },
            error: function(data) {
                // Some error in ajax call
                // msg.html("Some error").css('color', 'red');
                btn.html("&nbsp");
            }
        });
    });
</script>
@endsection