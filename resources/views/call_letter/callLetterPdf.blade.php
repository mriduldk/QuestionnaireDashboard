<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to CEM Special Initiative Schemes, BTR</title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
        <style>
            body {
                border: 1px solid black;
                padding: 20px;
            }

            .header {
                text-align: center;
                font-size: 12px;
                font-weight: bold;
                margin-bottom: 20px;
            }

            .text-header {
                font-size: 20px;
            }
            .text-sub-header {
                font-size: 14px;
            }
            .center-table {
                margin-left: auto;
                margin-right: auto;
                font-weight: bold;
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
            {{--<img src="{{ public_path('assets/images/logo/btc.png') }}" alt="Logo" width="100">--}}
            <span >OFFICE OF THE</span><br>
            <span class="text-header">PROJECT MANAGEMENT UNIT</span><br>
            <span class="text-sub-header">CEM SPECIAL INITIATIVE SCHEME</span><br>
            <span >Amguri, Near Don Bosco School, Haltugaon, Kokrajhar, Assam - 783370</span>
        </div>


        <div class="content">
            <span style="float: left;">
                <table>
                    <tbody>
                        <tr>
                            <td>To,</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Shri/Smt./Miss.</td>
                            <td>:</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td>C/O </td>
                            <td>:</td>
                            <td>{{ $user->father_name }}</td>
                        </tr>
                        <tr>
                            <td>Address </td>
                            <td>:</td>
                            <td>{{ $user->address }}</td>
                        </tr>
                        <tr>
                            <td>Roll No </td>
                            <td>:</td>
                            <td>{{ $user->roll }}</td>
                        </tr>
                        <tr>
                            <td>Post Name </td>
                            <td>:</td>
                            <td>{{ $user->post_name }}</td>
                        </tr>
                        <tr>
                            <td>Subject </td>
                            <td>:</td>
                            <td style="font-weight: bold">CALL LETTER</td>
                        </tr>
                    </tbody>
                </table>
            </span>
            <span style="float: right; border: 1px solid black;">
                <img src="{{ public_path('assets/images/avatar/placeholder.png') }}" alt="Image" width="100" style="border: 1px solid black;">
            </span>
        </div>
        <div style="clear: both;"></div>

        <div class="content" style="margin-top: 10px">
            <span>Dear Candidate,</span>
        </div>

        <div class="content" style="margin-top: 20px; text-align: justify;">
            <span>With reference to your application for the position of <b>'Disabled Friendly BTR Champion'</b> under CEM Special Initiative Scheme, You're requested to attend the interview and physical test as per the schedule given bellow :</span>

            <table class="center-table ">
                <tbody>
                    <tr>
                        <td>Venue</td>
                        <td>:</td>
                        <td>{{ $user->venue }}</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($user->date)->format('Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <td>Time </td>
                        <td>:</td>
                        <td>{{ $user->time }}</td>
                    </tr>
                </tbody>
            </table>

        </div>

        <div style="margin-top: 20px; text-align: center;">
            <span><u><b>INSTRUCTIONS</b></u></span>
        </div>

        <div style="font-size: 16px;">
            <ol>
                <li>
                    You are requested to bring this Call Letter to the interview and physical test.
                    Without the call letter, you will not be allowed for interview and physical test.
                </li>
                <li>
                    You are hereby instructed to report at the venue as per the mentioned time.
                    No TA/DA will be admissible for this purpose.
                </li>
                <li>
                    Candidates are advised to bring original as well as Xerox copies of all the documents mentioned below:
                    <ul>
                        <li>Photo ID Proof (PAN/Aadhaar Card).</li>
                        <li>Up-to-dated Resume/CV/Bio-Data along with Photo.</li>
                        <li>Age Proof (HSLC Admit or Birth Certificate).</li>
                        <li>Highest Qualification Certificate.</li>
                        <li>Caste Certificate (if applicable).</li>
                        <li>VCDC Certificate (Original).</li>
                        <li>Disability Certificate issued by competent authority.</li>
                    </ul>
                </li>
            </ol>

        </div>


        <div style="text-align: right; margin-top: 20px;">
            {{--Yours Faithfully<br>--}}
            <img src="{{ public_path('assets/images/sign-csis.jpeg') }}" alt="Logo" width="100"><br>
            <strong>PMU Head</strong><br>
            CEM Special Initiative<br>
            NRDS Management Pvt. Ltd.
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
