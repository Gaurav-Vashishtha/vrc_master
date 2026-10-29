<!-- <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Leave Approved</title>
</head>

<body>

    <h2>Leave Approved</h2>

    <p> Hello {{ $leave->user->first_name ?? 'User' }}, </p>
    <p> Your leave application has been <strong>approved</strong> by the Admin. </p>
    <hr>
    <p>  <strong>Leave Type:</strong> {{ $leave->leave_type }} </p>
    <p> <strong>From Date:</strong> {{ $leave->from_date->format('d-m-Y') }} </p>
    <p> <strong>To Date:</strong> {{ $leave->to_date->format('d-m-Y') }} </p>
    <p> <strong>Total Days:</strong> {{ $leave->total_days }} </p>
    <p> <strong>Reason:</strong> {{ $leave->leave_reason }} </p>
    <p> <strong>Status:</strong> Approved </p>
    <hr>
    <p>Thank you.</p>

</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Approved</title>
</head>

<body style="margin:0; padding:0; background:#ffffff; font-family:Arial, Helvetica, sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#012982; padding:25px;">
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
                <tr>
                    <td style="padding:0 15px;">
                        <div style="height:2px; background:#183b9b; width:100%;"></div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:20px 15px 10px 15px;">

                        <h2 style="
                            margin:0 0 16px 0;
                            font-size:18px;
                            color:#333333;
                            font-weight:bold;
                            text-align:center;
                        ">
                            Leave Approved
                        </h2>

                        <p style="
                            margin:0 0 10px 0;
                            font-size:13px;
                            line-height:20px;
                            color:#333333;
                            text-align:center;
                        ">
                            Hello {{ $leave->user->first_name ?? 'User' }},
                        </p>

                        <p style="
                            margin:0 0 15px 0;
                            font-size:13px;
                            line-height:20px;
                            color:#8a99b3;
                            text-align:center;
                        ">
                            Your leave application has been
                            <strong style="color:#28a745;">approved</strong>
                            by the Admin.
                        </p>

                        <hr style="
                            border:0;
                            border-top:1px solid #e2e5eb;
                            margin:15px 0;
                        ">

                        <!-- Leave Details -->

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
                            <span style="color:#28a745; font-weight:bold;">
                                Approved
                            </span>
                        </p>

                        <hr style="
                            border:0;
                            border-top:1px solid #e2e5eb;
                            margin:18px 0;
                        ">
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding:20px 15px 12px 15px;">

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
                    </td>
                </tr>

                <!-- Blue Line -->
                <tr>
                    <td style="padding:0 15px 5px 15px;">
                        <div style="
                            height:2px;
                            background:#183b9b;
                            width:100%;
                        "></div>
                    </td>
                </tr>
                <tr>
                    <td style="padding:15px 15px 10px 15px;">

                        <p style="
                            margin:0;
                            font-size:10px;
                            line-height:16px;
                            color:#8a99b3;
                            text-align:center;
                        ">
                            This is an automated email regarding your leave application.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>