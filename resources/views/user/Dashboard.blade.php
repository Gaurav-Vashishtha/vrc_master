@extends('user.template.base')

@section('title', 'Employee Dashboard')

@section('styles')
<style>
    .fa-spin{
        color: blue;
    }
    small{
        font-weight: 100;
    }
    .punches{
        border: 1px solid white;
        border-radius: 30px;
        margin-top: 10px;
        padding: 5px 0px;
        text-align: center;
        background-color: #07134c;
    }
    .mdi-clock{
        color: blue;
    }
    .card{
        padding: 15px 15px !important;
        margin-top: 10px;
        min-height: 200px;
        text-align: center !important;
    }
    .puchHeading{
        /* color: yellow; */
    }
    .clockDIV{
        margin-top: 60px;
    }
    .progressbar{
        background-color: red;
        height: 100px;
        width: 100px;
        border-radius: 50%;
        padding-top: 40px;
        margin-left: 33%;
    }
    .col-xl-4.col-sm-4.grid-margin.stretch-card.carddetails .card .card-body .d-flex.align-items-center.justify-content-between.border-bottom.py-3 {
    padding: 5px 0px !important;
}

  .data-scroll {
    overflow-y: scroll;
    max-height: 130px;
    padding: 0px 10px;
  }

  .data-scroll::-webkit-scrollbar {
    width: 5px;
  }

  .data-scroll::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
  }

  .data-scroll::-webkit-scrollbar-track {
    background: transparent;
  }

.col-xl-4.col-sm-4.grid-margin.stretch-card.carddetails .card .card-body {
    padding: 0px;
    text-align: left;
}
</style>
@endsection

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-xl-4 col-md-4 col-sm-6">
                <!-- <i class="mdi mdi-clock"></i>  -->
                    @if(!$todayCheckedIn)
                        <button class="btn btn-primary" id="check-in">Check-In</button>
                        <button class="btn btn-primary" id="check-out-show" style="display: none;" data-toggle="modal"  data-target="#exampleModal">Check-Out</button>
                    @else
                        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Check-Out</button>
                    @endif
                    <div id="ResMsg" style="font-size: 13px;">&nbsp;</div>

                    <div class="card">
                        @php $newdatet = date("D, d M Y"); @endphp
                        <h5 class="card-title">{{$newdatet}}</h5>
                        <div class="punches">
                            <p class="mb-0 puchHeading">Punch In Time</p>
                            @if($lastChecked)
                                <small class="checkInShow">{{date("d-M-Y h:i:s A", strtotime($lastChecked->check_in))}}</small>
                            @else
                                <small class="checkInShow">Not Checked In !!</small>
                            @endif
                        </div>
                        
                        <div class="punches">
                            <p class="mb-0 puchHeading">Punch Out Time</p>
                            @if($todayCheckedOut && $lastChecked->att_flag=='O')
                                <small class="checkOutShow">{{date("d-M-Y h:i:s A", strtotime($lastChecked->check_out))}}</small>
                            @else
                                <small class="checkOutShow">Not Checked Out !!</small>
                            @endif
                    </div>
                    </div>


                    
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6">
                    <div class="card clockDIV">
                        <h5 class="card-title">Total Working Hours</h5>
                        <div class="punch-hours progressbar">
                            <span id="total_hours">00:00:00</span>
                        </div>
                    </div>
                </div>

                  {{-- Active Reminders --}}

                <div class="col-xl-4 col-sm-4 grid-margin stretch-card carddetails" style="padding-top: 50px;">
                    <div class="card ">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">
                            <i class="mdi mdi-bell-outline"></i>
                            Active Reminders
                        </h4>

                        <a href="{{ route('user.reminders') }}"
                            class="btn btn-primary btn-sm">
                            View All
                        </a>
                        </div>
                        <div class="data-scroll">
                        @forelse($activeReminders as $reminder)

                        <div class="d-flex align-items-center justify-content-between border-bottom py-3">

                            <div>
                            <h6 class="mb-1">
                                {{ $reminder->title }}
                            </h6>

                            <p class="text-muted mb-1">
                                Due Date:
                                {{ $reminder->reminder_date->format('d-M-Y') }}
                            </p>

                            @if($reminder->amount)
                            <small class="text-muted">
                                Amount: ₹{{ number_format($reminder->amount, 2) }}
                            </small>
                            @endif
                            </div>

                            <div class="d-flex align-items-center">

                            @if($reminder->reminder_date->toDateString() === now()->toDateString())
                            <span class="badge badge-warning mr-3">
                                Due Today
                            </span>
                            @elseif($reminder->reminder_date->toDateString() < now()->toDateString())
                                <span class="badge badge-danger mr-3">
                                Overdue
                                </span>
                                @else
                                <span class="badge badge-info mr-3">
                                Upcoming
                                </span>
                                @endif

                                <a href="{{ route('user.reminders.complete', $reminder->id) }}"
                                onclick="return confirm('Are you sure you want to complete this reminder?')"
                                title="Complete">
                                <i class="mdi mdi-check-circle"
                                    style="color: green; font-size: 22px;"></i>
                                </a>

                            </div>

                        </div>


                        @empty
                        </div>
                        <div class="text-center py-4">
                        <i class="mdi mdi-bell-off-outline"
                            style="font-size: 35px;"></i>

                        <p class="text-muted mb-0">
                            No active reminders.
                        </p>
                        </div>

                        @endforelse

                    </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-0">
                                    <i class="mdi mdi-bell-outline"></i>
                                    Notifications
                                </h4>
                            </div>

                            @forelse($notification as $item)
                                <div class="border-bottom py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-1">{{ $item->title }}</h6>
                                        <small class="text-muted">{{ $item->created_at?->format('d-M-Y h:i A') }}</small>
                                    </div>
                                    <p class="text-muted mb-0">{{ $item->description }}</p>
                                    @if($item->priority)
                                        <small class="text-muted">Priority: {{ $item->priority }}</small>
                                    @endif
                                </div>
                            @empty
                                <p class="text-muted mb-0">You have no notifications.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="background-color: white;text-align: center;">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel"  style="color: black;">Daily Work</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="padding: 3rem;">
                            <textarea name="description" id="description" cols="30" rows="4" placeholder="Description"></textarea>
                        </div>
                        <div class="modal-footer" style="display: inline;">
                            <div id="ResMsg2" style="font-size: 13px;">&nbsp;</div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="check-out">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
@endsection


@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script>
jQuery(document).ready(function(){
    jQuery('#check-in').on('click', function(){
        var btn  = jQuery(this);
        var msg  = jQuery('#ResMsg');
        var url = '/check-in';
        if(confirm('Are you sure for Check-In ?')){
            jQuery.ajax({
                type: "get",
                url: url,
                beforeSend:function(){
                    btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Check-In");
                },
                success: function(data) {
                    if (data.status=='1') {
                        // Ajax call completed successfully
                        msg.html(data.msg).css('color', 'green');
                        btn.html("Check-In");
                        btn.hide();
                        jQuery('#check-out-show').show();
                        jQuery('.checkInShow').html(data.time);
                        jQuery('.checkOutShow').html('Not Checked Out !!');
                        setTimeout(() => {
                            msg.html('&nbsp;');
                        },5000);
                    } else {
                        msg.html(data.msg).css('color', 'red');
                        btn.html("Check-In");
                    }
                },
                error: function(data) {
                    // Some error in ajax call
                    msg.html("Some error while Check-In").css('color', 'red');
                    btn.html("Check-In");
                }
            });
        } 
    });

    jQuery('#check-out').on('click', function(){
        var btn  = jQuery(this);
        var msg  = jQuery('#ResMsg2');
        var dcs  = jQuery('#description').val();
        var url = '/check-out';
        if (dcs!='') {
            if(confirm('Are you sure for Check-Out ?')){
                jQuery.ajax({
                    type: "get",
                    url: url,
                    data: {dcs: dcs},
                    beforeSend:function(){
                        btn.html("<i class='fa fa-circle-o-notch fa-spin'></i> Check-Out");
                    },
                    success: function(data) {
                        if (data.status=='1') {
                            // Ajax call completed successfully
                            msg.html(data.msg).css('color', 'green');
                            btn.html("Check-Out");
                            jQuery('.checkOutShow').html(data.time);
                            setTimeout(() => {
                                msg.html('&nbsp;');
                                location.reload();
                            },3500);
                        } else {
                            msg.html(data.msg).css('color', 'red');
                            btn.html("Check-Out");
                        }
                    },
                    error: function(data) {
                        // Some error in ajax call
                        msg.html("Some error while Check-Out").css('color', 'red');
                        btn.html("Check-Out");
                    }
                });
            }
        }
        else{
            msg.html("Please write some description of today work").css('color', 'red');
        }
    });
});


// function fetchdata(){
//     $.ajax({
//         url: '/getTimer',
//         type: 'get',
//         success: function(data){
//             if (data.status=='1') {
//                 // Ajax call completed successfully
//                 // jQuery('#total_hours').html(data.checkIn);
//                 var checkIn = (data.checkIn);
//                 var current = new Date(); 
//                 var seconds = Math.floor((current - (new Date(checkIn)))/1000);
                
//                 var minutes = Math.floor(seconds/60);
//                 var hours = Math.floor(minutes/60);
//                 var days = Math.floor(hours/24);
//                 hours = hours-(days*24);
//                 minutes = minutes-(days*24*60)-(hours*60);
//                 seconds = seconds-(days*24*60*60)-(hours*60*60)-(minutes*60);
//                 // statistics calculation
//                 if(hours <0)
//                 hours = 0;
//                 // var daytarget = (hours*60*100+minutes)/510;
//                 // jQuery('#set_target').css('width' ,daytarget+'%');
                
//                 if(seconds.toString().length == 1){
//                     seconds = '0'+seconds;
//                 } if(minutes.toString().length == 1){
//                     minutes = '0'+minutes;
//                 } if(hours.toString().length == 1){
//                     hours = '0'+hours;
//                 }
                
//                 var finat_watch = hours + ":" +  minutes + ":" + seconds;
//                 jQuery('#total_hours').html(finat_watch);
//             }
//             if (data.status=='2') {
//                 jQuery('#total_hours').html(data.checkOut);
//             }
//         }
//     });
// }

// $(document).ready(function(){
//     setInterval(fetchdata,1000);
// });
</script>
@endsection