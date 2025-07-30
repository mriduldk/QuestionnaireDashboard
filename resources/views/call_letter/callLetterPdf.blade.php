<!DOCTYPE html>
<html>
    <head>
        <title>Grievance Details</title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Roboto';
                border: 1px solid black;
                padding: 20px;
            }

            .header {
                text-align: center;
                font-size: 12px;
                font-weight: bold;
                margin-bottom: 20px;
                text-decoration: underline;
            }

            .content {
                font-size: 16px;
            }

            .footer {
                text-align: left;
                font-size: 10px;
            }

            .nb {
                position: fixed;
                display: flex;
                padding-top: 10px;
                padding-left: 10px;
                padding-right: 10px;
                bottom: 120px;
                left: 16px;
                right: 16px;
                font-size: 11px;
                text-align: center;
            }

            .print-info-container {
                position: fixed;
                display: flex;
                border-top: 1px solid #ccc;
                padding-top: 10px;
                padding-left: 10px;
                padding-right: 10px;
                bottom: 100px;
                left: 16px;
                right: 16px;
            }

            .print-details {
                position: absolute;
                left: 0;
                font-size: 12px;
                text-align: left;
                width: 80%;
            }

            .qr-container {
                position: absolute;
                right: 0;
                text-align: right;
            }

        </style>
    </head>
    <body>
        <div class="header">
            <img src="{{ public_path('assets/images/logo/btc.png') }}" alt="Logo" width="100">
            <h2>Grievance Application Acknowledgement</h2>
        </div>

        <div class="content">
            <span style="float: left;">Acknowledgement No: {{ $user->name }}</span>
            <span style="float: right;">Date: {{ $user->name }}</span>
        </div>
        <div style="clear: both;"></div>

        <div class="content" style="margin-top: 10px">
            <span>Dear {{ $user->name }},</span>
        </div>

        <div class="content" style="margin-top: 20px; text-align: justify;">
            <span>Your grievance application regarding the <i><b>{{ $user->name }}</b></i> has been successfully submitted on {{ \Carbon\Carbon::parse($user->created_at)->format('F j, Y \a\t h:i:s A') }}.</span>
            </br></br><span>Your Acknowledgement Number is <b>{{ $user->name }}</b>, and the concerned department is <b>{{ $user->name }}</b>. Please use this number to track your application and for any future correspondence. If your application is accepted by the concerned department, a resolution will be provided within 15 to 30 days.</span>
            </br></br><span>For any queries or feedback, you may contact us at 1800-000-0000 (Monday to Friday, 10 AM – 5 PM) or email us at grievance@bodoland.gov.in.</span>
        </div>

        <div class="content" style="margin-top: 20px; text-align: justify;">
            <span><b>Petitioner Name:</b> {{ $user->name }}</span>
            </br>
            <span><b>Contact Number:</b> {{ $user->name }}</span>
        </div>

        <div class="footer" style="margin-top: 60px">
            <span style="font-size: 16px; font-weight: bold;">B-GRMS</span></br>
            <span style="font-size: 16px;">Bodoland Territorial Council</span></br>
            <span style="font-size: 16px;">Kokrajhar</span>
        </div>

        @php
            function getBrowserName() {
                $userAgent = $_SERVER['HTTP_USER_AGENT'];

                if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
                if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
                if (strpos($userAgent, 'Safari') !== false) return 'Safari';
                if (strpos($userAgent, 'Opera') !== false || strpos($userAgent, 'OPR') !== false) return 'Opera';
                if (strpos($userAgent, 'Edge') !== false) return 'Edge';
                if (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) return 'Internet Explorer';

                return 'Unknown';
            }

            function getIpAddress() {
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    // Check for multiple IPs (comma-separated) and take the first one
                    $ip = explode(',', $ip)[0];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED'];
                } elseif (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_FORWARDED_FOR'];
                } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
                    $ip = $_SERVER['HTTP_FORWARDED'];
                } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $ip = 'UNKNOWN';
                }

                return trim($ip);
            }
        @endphp

        <div class="nb">
            NB: Computer generated acknowledgement copy.
        </div>

        <div class="print-info-container">
            <!-- Print Details on the Left -->
            <div class="print-details">
                <span>Browser: {{ getBrowserName() }}</span><br>
                <span>IP Address: {{ getIpAddress() }}</span><br>
                <span>Print Date/Time: {{ date('Y-m-d H:i:s') }}</span><br>
                <span>Printed By: {{ $user->name }}</span>
            </div>

            <!-- QR Code on the Right -->
            {{-- <div class="qr-container">
                <img
                    src="data:image/png;base64,{{ base64_encode(QrCode::size(80)->generate("Acknowledgement No: " . $user->name . ", Grievance Date: " . $user->name . ", Printed By: " . $user->name . ", Browser: " . getBrowserName() . ", IP Address: " . getIpAddress() . ", Print Date: " . date('Y-m-d H:i:s'))) }}"
                    alt="QR Code">
            </div> --}}
        </div>

    </body>
</html>
