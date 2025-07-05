<x-app-layout>


    <div class="pattern-square"></div>
    <!--Pageheader start-->
    <section class="py-5 py-lg-8">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 offset-xl-4 col-md-12 col-12">
                    <div class="text-center">

                        <a href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/logo/btc.png') }}" alt="brand" class="mb-3"
                                width="40%" />
                        </a>

                        <h1 class="mb-1">Welcome To Questionnaire Portal</h1>
                        <p class="mb-0">
                            Login into your account.
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

                            <form class="needs-validation mb-6" action="{{ route('admin.login-post') }}" method="POST"
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
                                    <label for="email" class="form-label">
                                        Email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="identifier" name="identifier"
                                        required />
                                    <div class="invalid-feedback">Please enter email.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="password-field position-relative">
                                        <input type="password" class="form-control fakePassword" id="password"
                                            name="password" required />
                                        <span><i class="bi bi-eye-slash passwordToggler"></i></span>
                                        <div class="invalid-feedback">Please enter password.</div>
                                    </div>
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="role" class="form-label">Select Admin Type</label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="" selected disabled>Select admin type</option>
                                        <option value="admin">Admin</option>
                                        <option value="chd">CHD</option>
                                        <option value="pmu">PMU</option>
                                        <option value="committee">Committee</option>
                                        <option value="em">EM</option>
                                        <option value="cem">CEM</option>
                                    </select>
                                    <div class="invalid-feedback">Please select admin type.</div>
                                </div> --}}


                                <div class="mb-4 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rememberMeCheckbox" />
                                        <label class="form-check-label" for="rememberMeCheckbox">Remember me</label>
                                    </div>

                                    <div><a href="../forget-password.html" class="text-primary">Forgot Password</a>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit">Sign In</button>
                                </div>

                            </form>

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
