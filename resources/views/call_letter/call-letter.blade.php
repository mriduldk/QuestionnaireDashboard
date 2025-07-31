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

                            @if (!session('showOtp'))
                                <form class="needs-validation mb-6" action="{{ route('validate') }}" method="POST"
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
                                        <button class="btn btn-info" type="submit">Generate OTP</button>
                                    </div>

                                </form>

                            @endif
                            @if (session('showOtp'))
                                <form class="needs-validation mb-6" action="{{ route('printPdf') }}" method="POST"
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
                                        <button class="btn btn-info" type="submit">Download Call Letter</button>
                                    </div>

                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
{{--            <div class="row">--}}
{{--                <div class="col-lg-12">--}}
{{--                    <div class="text-center">--}}
{{--                        <div class="small mb-3 mb-lg-0 text-body-tertiary">--}}
{{--                            Copyright © 2024 | Designed & Developed By--}}
{{--                            <span class="text-primary"><a href="https://education.bodoland.gov.in/">Department of--}}
{{--                                    Grievance, BTR</a></span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </section>


</x-app-layout>
