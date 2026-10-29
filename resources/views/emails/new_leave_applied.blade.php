<!-- <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Leave Application</title>
</head>

<body>

    <h2>New Leave Application</h2>
    <p>A new leave application has been submitted.</p>
    <hr>
    <p> <strong>Employee Name:</strong> {{ $leave->user->first_name ?? '' }} {{ $leave->user->last_name ?? '' }} </p>
    <p>  <strong>Leave Type:</strong> {{ $leave->leave_type }} </p>
    <p> <strong>From Date:</strong> {{ $leave->from_date->format('d-m-Y') }} </p>
    <p> <strong>To Date:</strong> {{ $leave->to_date->format('d-m-Y') }} </p>
    <p> <strong>Total Days:</strong> {{ $leave->total_days }} </p>
    <p> <strong>Reason:</strong> {{ $leave->leave_reason }} </p>
    <p> <strong>Status:</strong> Pending </p>
    <hr>
    <p>Please login to the <a href="{{ route('admin.login') }}">admin</a> to review this leave application.</p>

</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Leave Application</title>
</head>

<body style="margin:0; padding:0; background:#ffffff; font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="background:#012982; padding:25px;">
    <tr>
        <td align="center">

            <!-- Main Container -->
            <table width="480" cellpadding="0" cellspacing="0" border="0"
                style="
                    max-width:455px;
                    width:100%;
                    background:#fff;
                    border:1px solid #183b9b;
                    border-radius:12px;
                    overflow:hidden;
                ">

                <!-- Logo -->
                <tr>
                    <td align="center" style="padding:12px 15px 10px 15px;">
                        <a href="https://www.vrwebconsulting.com" target="_blank">
                            <img src="https://www.vrwebconsulting.com/images/logo/vrc-logo.png"
                                alt="VR Web Consulting"
                                width="170"
                                style="display:block; border:0; max-width:170px;">
                        </a>
                    </td>
                </tr>

                <!-- Blue Line -->
                <tr>
                    <td style="padding:0 15px;">
                        <div style="height:2px; background:#183b9b; width:100%;"></div>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:20px 15px 10px 15px;">

                        <h2 style="
                            margin:0 0 16px 0;
                            font-size:18px;
                            color:#333333;
                            font-weight:bold;
                            text-align:center;
                        ">
                            New Leave Application
                        </h2>

                        <p style="
                            margin:0 0 15px 0;
                            font-size:13px;
                            line-height:20px;
                            color:#8a99b3;
                            text-align:center;
                        ">
                            A new leave application has been submitted.
                        </p>

                        <hr style="
                            border:0;
                            border-top:1px solid #e2e5eb;
                            margin:15px 0;
                        ">

                        <!-- Leave Details -->

                        <p style="margin:8px 0; font-size:12px; color:#333333;">
                            <strong>Employee Name:</strong>
                            {{ $leave->user->first_name ?? '' }}
                            {{ $leave->user->last_name ?? '' }}
                        </p>

                        <p style="margin:8px 0; font-size:12px; color:#333333;">
                            <strong>Leave Type:</strong>
                            {{ $leave->leave_type }}
                        </p>

                        <p style="margin:8px 0; font-size:12px; color:#333333;">
                            <strong>From Date:</strong>
                            {{ $leave->from_date->format('d-m-Y') }}
                        </p>

                        <p style="margin:8px 0; font-size:12px; color:#333333;">
                            <strong>To Date:</strong>
                            {{ $leave->to_date->format('d-m-Y') }}
                        </p>

                        <p style="margin:8px 0; font-size:12px; color:#333333;">
                            <strong>Total Days:</strong>
                            {{ $leave->total_days }}
                        </p>

                        <p style="margin:8px 0; font-size:12px; color:#333333;">
                            <strong>Reason:</strong>
                            {{ $leave->leave_reason }}
                        </p>

                        <p style="margin:8px 0; font-size:12px; color:#333333;">
                            <strong>Status:</strong>
                            Pending
                        </p>

                        <hr style="
                            border:0;
                            border-top:1px solid #e2e5eb;
                            margin:18px 0;
                        ">

                       

                    </td>
                </tr>

                <!-- Button -->
                <tr>
                    <td align="center" style="padding:8px 15px 18px 15px;">

                        <a href="{{ route('admin.login') }}"
                            target="_blank"
                            style="
                                display:inline-block;
                                background:#012982;
                                color:#ffffff;
                                text-decoration:none;
                                font-size:14px;
                                padding:11px 20px;
                                border-radius:4px;
                            ">
                            Login to Admin
                        </a>

                    </td>
                </tr>

              

                <!-- Company Details -->
                <tr>
                    <td align="center" style="padding:5px 15px 12px 15px;">

                        <p style="
                            margin:0 0 5px 0;
                            font-size:11px;
                            color:#183b9b;
                            font-weight:bold;
                        ">
                            Thanks
                        </p>

                        <p style="
                            margin:0 0 5px 0;
                            font-size:11px;
                            color:#183b9b;
                            font-weight:bold;
                        ">
                            VR Web Consulting
                        </p>

                        <a href="https://www.vrwebconsulting.com/"
                            target="_blank"
                            style="
                                font-size:10px;
                                color:#2876d4;
                                text-decoration:underline;
                            ">
                            www.vrwebconsulting.com
                        </a>

                        <br>

                    
                    </td>
                </tr>

                <!-- Divider -->
                <tr>
                    <td style="padding:0 15px;">
                        <div style="
                            height:1px;
                            background:#e2e5eb;
                            width:100%;
                        "></div>
                    </td>
                </tr>
 <tr>
                    <td style="padding:0 15px 5px 15px;">
                        <div style="
                            height:2px;
                            background:#183b9b;
                            width:100%;
                        "></div>
                    </td>
                </tr>
                <!-- Footer -->
                <tr>
                    <td style="padding:15px 15px 10px 15px;">

                        <p style="
                            margin:0;
                            font-size:10px;
                            line-height:16px;
                            color:#8a99b3;
                            text-align:center;
                        ">
                            This is an automated email regarding a new leave application.
                        </p>

                    </td>
                </tr>

                <!-- Bottom Blue Line -->
                

            </table>

        </td>
    </tr>
</table>

</body>
</html>