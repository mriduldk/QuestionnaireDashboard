<x-app-layout>


    <div class="pattern-square"></div>
    <!--Pageheader start-->
    <section class="py-5 py-lg-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 offset-xl-4 col-md-12 col-12">
                    <div class="text-center">

                        <a href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/logo/btc.png') }}" alt="brand" class="mb-3"
                                width="40%" />
                        </a>

                        <h2 class="mb-1">CEM's Special Initiative</h2>
                        <p class="mb-0">
                            Provide your information to download Call Letter.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Pageheader end-->
    <!--Sign up start-->
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8 col-12">
                    <div class="card shadow-sm mb-6">
                        <div class="card-body">

                            <form class="needs-validation mb-6" action="{{ route('validate') }}" method="POST" id="validateForm"
                                  novalidate>
                                @csrf
                                <meta name="csrf-token" content="{{ csrf_token() }}">

                                <div class="alert alert-success alert-dismissible fade show success-message" role="alert">
                                    <span class="success-message-text"></span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                                <div class="alert alert-warning alert-dismissible fade show error-message" role="alert">
                                    <span class="error-message-text"></span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>

                                <div class="mb-3">
                                    <label for="phone1" class="form-label">
                                        Phone Number
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="phone1" name="phone1" placeholder="Enter Phone Number"
                                           required />
                                    <div class="invalid-feedback">Please enter phone number.</div>
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-info" type="button" onclick="sentOtp2()">Generate OTP</button>
                                </div>

                            </form>


                            <form class="needs-validation mb-6" action="{{ route('printPdf') }}" method="POST" id="printPdfForm"
                                  novalidate>
                                @csrf

                                <div class="alert alert-success alert-dismissible fade show success-message" role="alert">
                                    <span class="success-message-text"></span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                                <div class="alert alert-warning alert-dismissible fade show error-message" role="alert">
                                    <span class="error-message-text"></span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">
                                        Phone Number
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number"
                                           required value="{{ session('phone') }}" readonly />
                                    <div class="invalid-feedback">Please enter phone number.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="otp" class="form-label">OTP</label>
                                    <input type="number" class="form-control" id="otp"
                                           name="otp" required />
                                    <div class="invalid-feedback">Please enter OTP.</div>
                                </div>

                                <input type="text" class="form-control" id="token"
                                       name="token" hidden=""/>

                                <div class="d-grid">
                                    <button class="btn btn-info" type="button" onclick="verifyOTP()">Download Call Letter</button>
                                </div>

                                <div class="mt-4 text-center">
                                    <button type="button" id="resendOtpBtn" class="btn btn-sm btn-outline-primary" onclick="resendOtp()" disabled>
                                        Resend OTP <span id="resendTimer">(30s)</span>
                                    </button>
                                </div>

                            </form>

                            @if (session('showOtp'))
                                <form class="needs-validation mb-6" action="{{ route('validate') }}" method="POST" id="validateForm"
                                      novalidate>
                                    @csrf

                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">
                                            Phone Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number"
                                               required />
                                        <div class="invalid-feedback">Please enter phone number.</div>
                                    </div>

                                    <div class="d-grid">
                                        <button class="btn btn-info" type="button" onclick="sentOtp2()">Generate OTP</button>
                                    </div>

                                </form>

                            @endif
                            @if (session('showOtp'))
                                <form class="needs-validation mb-6" action="{{ route('printPdf') }}" method="POST" id="printPdfForm"
                                      novalidate>
                                    @csrf

                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">
                                            Phone Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number"
                                               required value="{{ session('phone') }}" readonly />
                                        <div class="invalid-feedback">Please enter phone number.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="otp" class="form-label">OTP</label>
                                        <input type="number" class="form-control" id="otp"
                                               name="otp" required />
                                        <div class="invalid-feedback">Please enter OTP.</div>
                                    </div>

                                    <div class="d-grid">
                                        <button class="btn btn-info" type="button" onclick="verifyOTP()">Download Call Letter</button>
                                    </div>

                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script type="text/javascript">
        var configuration = {
            widgetId: "326b426c6f37393930323939",
            tokenAuth: "383102TpxSHyrxgU638459f1P1",
            identifier: "",
            exposeMethods: true,
            captchaRenderId: '', // id(must be unique) of html element where to render captcha, only works if there is exposedMethod is true,.
            success: (data) => {
                document.getElementById('printPdfForm').submit();
            },
            failure: (error) => {
                console.log('failure reason', error);
                $(".success-message").hide();
                $(".error-message").show();
                $(".error-message-text").text(error.message);
            },

        };

        $("#printPdfForm").hide();
        $(".success-message").hide();
        $(".error-message").hide();

    </script>
    <script type="text/javascript" onload="initSendOTP(configuration)" src="https://verify.msg91.com/otp-provider.js"></script>

    <script>

        var messageId = ""
        function sentOtp2() {

            var phone = $("#phone1").val();

            fetch('/validate-user-json', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ phone: phone })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.status) {

                        window.sendOtp(
                            '91' + phone, // mandatory
                            (data1) => {
                                debugger;
                                console.log('OTP sent successfully.' + data1)
                                //document.getElementById('validateForm').submit();

                                $("#printPdfForm").show();
                                $("#validateForm").hide();
                                $("#phone").val($("#phone1").val())

                                $(".success-message").show();
                                $(".success-message-text").text(data.message);
                                $(".error-message").hide();


                                showResendButton();
                            },
                            (error) => console.log('Error occurred')
                        );

                    } else {

                        $("#printPdfForm").hide();
                        $("#validateForm").show();

                        $(".success-message").hide();
                        $(".error-message").show();
                        $(".error-message-text").text(data.message);

                    }
                });
        }

        function verifyOTP() {

            var otp = Number($("#otp").val());
            window.verifyOtp(
                otp,
                (data) => {
                    console.log('OTP verified: ', data)
                },
                (error) => console.log(error),
            );


        }

        let resendCooldown = 30; // seconds
        let resendInterval;

        function startResendTimer() {
            let timeLeft = resendCooldown;
            const resendBtn = document.getElementById("resendOtpBtn");
            const timerSpan = document.getElementById("resendTimer");

            resendBtn.disabled = true;
            timerSpan.textContent = `(${timeLeft}s)`;

            resendInterval = setInterval(() => {
                timeLeft--;
                timerSpan.textContent = `(${timeLeft}s)`;

                if (timeLeft <= 0) {
                    clearInterval(resendInterval);
                    resendBtn.disabled = false;
                    timerSpan.textContent = "";
                }
            }, 1000);
        }

        // Call this after initial OTP is sent
        function showResendButton() {
            document.getElementById("resendOtpBtn").style.display = "inline-block";
            startResendTimer();
        }

        // Call this to resend OTP manually
        function resendOtp() {
            const phone = $("#phone1").val();

            window.sendOtp(
                '91' + phone,
                (data) => {
                    console.log('OTP resent successfully.', data);
                    messageId = data.messageId;
                    startResendTimer();

                    $(".success-message").text("OTP resent successfully").show();
                    $(".error-message").hide();
                },
                (error) => {
                    console.error('Resend OTP failed:', error);
                    $(".success-message").hide();
                    $(".error-message").text("Failed to resend OTP").show();
                }
            );
        }

    </script>


</x-app-layout>
