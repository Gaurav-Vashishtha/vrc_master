@extends('user.template.base')

@section('title', 'Employee Personal Information')

@section('styles')
    <style>
        .valueDyn{
            color: green;
            padding-left: 3px;
        }
        input{
            background-color: #191c24;
            color: green;
            border: none;
            border-bottom: 2px solid white !important;
            display: none;
        }
        .mdi-content-save{
            color: blue;
            display: none;
        }
        p{
            padding-left: 10px;
        }
        i{
            cursor: pointer;
        }
    </style>
@endsection

@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-xl-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-0">Profile Datails</h4><br>
                        <div class="row">
                            <div class="col-xl-4 col-sm-4">
                                @if(!empty($employee->profile_photo))
                                    <img class="img-lg rounded-circle" src="../images/employees/{{$employee->profile_photo}}" alt="Profile Pic">
                                @else
                                    <img class="img-lg rounded-circle" src="{{ URL::asset('images/employees/user.jpg')}}" alt="Profile Pic">
                                @endif
                            </div>
                            <div class="col-xl-8 col-sm-8">
                                <p class="col-form-label">Name:<label class="valueDyn"> {{$employee->first_name}} {{$employee->last_name}}</label></p>
                                <p class="col-form-label">Job Position :<label class="valueDyn"> {{$employee->position}}</label></p>
                                <p class="col-form-label">Employee Code:        <label class="valueDyn">{{$employee->emp_code}}</label></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-xl-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-0">Personal Datails</h4><br>
                        <p class="col-form-label">Father Name:          <label class="valueDyn">{{$employee->father_name}}</label></p>
                        <p class="col-form-label">DOB:                  <label class="valueDyn">{{date("d-m-Y", strtotime($employee->DOB))}}</label></p>
                        <p class="col-form-label">Current Address:          <label class="valueDyn">{{$employee->current_add}}</label></p>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-xl-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-0">Contact Datails</h4><br>
                        <p class="col-form-label">Personal Email:       <label class="valueDyn">{{$employee->personal_email}}</label>  <i class="mdi mdi-table-edit" style="color: red;"></i><input type="email" bd_name="personal_email" id=""><i class="mdi mdi-content-save"></i><br><label class='errorMassage'>&nbsp;</label></p>
                        <p class="col-form-label">Company Email:        <label class="valueDyn">{{$employee->company_email}}</label><br><br></p>
                        <p class="col-form-label">Personal Mobile:      <label class="valueDyn">{{$employee->personal_mobile}}</label> <i class="mdi mdi-table-edit" style="color: red;"></i><input type="text" bd_name="personal_mobile" id=""><i class="mdi mdi-content-save"></i><br><label class='errorMassage'>&nbsp;</label></p>
                        <p class="col-form-label">Company Mobile:       <label class="valueDyn">{{$employee->company_mobile}}</label></p>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 col-xl-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-0">Account Datails</h4><br>
                        <p class="col-form-label">Sallary:              <label class="valueDyn">{{$employee->sallary}}</label></p><br>
                        <p class="col-form-label">Bank Name:            <label class="valueDyn">{{$employee->bank_name}}</label>    <i class="mdi mdi-table-edit" style="color: red;"></i><input type="text" bd_name="bank_name" id=""><i class="mdi mdi-content-save"></i><br><label class='errorMassage'>&nbsp;</label></p>
                        <p class="col-form-label">Acc. No :             <label class="valueDyn">{{$employee->acc_no}}</label>       <i class="mdi mdi-table-edit" style="color: red;"></i><input type="text" bd_name="acc_no" id=""><i class="mdi mdi-content-save"></i><br><label class='errorMassage'>&nbsp;</label></p>
                        <p class="col-form-label">IFSC Code:            <label class="valueDyn">{{$employee->ifsc}}</label>         <i class="mdi mdi-table-edit" style="color: red;"></i><input type="text" bd_name="ifsc" id=""><i class="mdi mdi-content-save"></i><br><label class='errorMassage'>&nbsp;</label></p>
                    </div>
                </div>
            </div>
        </div>
    <!-- content-wrapper ends -->
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script>
            jQuery(document).on('click','.mdi-table-edit',function(){
                var btn = jQuery(this);
                btn.hide();
                var content = btn.closest('.col-form-label').find('.valueDyn').html();
                btn.closest('.col-form-label').find('.valueDyn').html('&nbsp;');
                btn.closest('.col-form-label').find('input').show().val(content).css('display', 'inline');
                btn.closest('.col-form-label').find('.mdi-content-save').show();
            });

            jQuery(document).on('click','.mdi-content-save',function(){
                var btn     =   jQuery(this);
                var val     =   btn.closest('.col-form-label').find('input').val();
                var bd_name =   btn.closest('.col-form-label').find('input').attr('bd_name');
                var msg     =   btn.closest('.col-form-label').find('.errorMassage');
                // var loader  =   btn.closest('.loader');

                var url = '/update_emp_details';
                jQuery.ajax({
                    type: 'get',
                    url: url,
                    data : { val : val, bd_name : bd_name },
                    beforeSend:function(){
                        btn.html("<i class='fa fa-circle-o-notch fa-spin'></i>");
                    },
                    success: function(data) {
                        if (data.status=='1') {
                            // Ajax call completed successfully
                            // loader.html("<i class='mdi mdi-content-save'></i>");
                            btn.html("").hide();
                            btn.closest('.col-form-label').find('input').hide();
                            btn.closest('.col-form-label').find('.valueDyn').html(val);
                            btn.closest('.col-form-label').find('.mdi-table-edit').show();
                            msg.html(data.msg).css('color', 'blue');
                            setTimeout(() => {
                                msg.html("&nbsp;");
                            },3500);
                        } else {
                            msg.show().html(data.msg).css('color', 'red');
                        }
                    },
                    error: function(data) {
                        // Some error in ajax call
                        msg.html("some Error").css('color', 'red');
                    }
                });  
            });
        </script>
@endsection