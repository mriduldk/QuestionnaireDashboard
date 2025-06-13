<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Favicon icon-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/logo/btc.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/logo/btc.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/logo/btc.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/images/logo/btc.png') }}" color="#8b3dff">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/btc.png') }}">
    <meta name="msapplication-TileColor" content="#8b3dff">
    <!-- <meta name="msapplication-config" content="{{ asset('assets/images/favicon/tile.xml') }}"> -->


    <link href="{{ asset('assets/libs/prismjs/themes/prism-okaidia.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" />

    <!-- Color modes -->
    <script src="{{ asset('assets/js/vendors/color-modes.js') }}"></script>

    <!-- Libs CSS -->
    <link href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/bootstrap-icons/font/bootstrap-icons.min.css') }}" rel="stylesheet">

    <!-- Scroll Cue -->
    <link rel="stylesheet" href="{{ asset('assets/libs/scrollcue/scrollCue.css') }}">

    <!-- Box icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/css/boxicons.min.css') }}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">
    <title> BTR Grievance Redressal Portel </title>

    <link href="{{ asset('assets-metronics/css/timeline.css') }}" rel="stylesheet" type="text/css" />

    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('assets-metronics/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets-metronics/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('assets-metronics/js/scripts.bundle.js') }}"></script>
    <!--end::Global Theme Bundle-->


</head>

<body>
<!-- Navbar -->
<header>
    <nav class="navbar navbar-expand-lg w-100">
        <div class="container px-3">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo/btc.png') }}" width="60px" alt=""/>
            </a>
            <button class="navbar-toggler offcanvas-nav-btn" type="button">
                <i class="bi bi-list"></i>
            </button>
            <div class="offcanvas offcanvas-start offcanvas-nav" style="width: 20rem">
                <div class="offcanvas-header">
                    <a href="{{ url('/') }}" class="text-inverse">
                        <img src="{{ asset('assets/images/logo/btc.png') }}" width="60px"  alt=""/>
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body pt-0 align-items-center">
                    <ul class="navbar-nav mx-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}" role="button"
                               aria-expanded="false">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/about') }}" role="button"
                               aria-expanded="false">About</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('/doc') }}" role="button"
                               aria-expanded="false">Notification</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('/contact') }}" role="button"
                               aria-expanded="false">Contact</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{ url('/track') }}" role="button"
                               aria-expanded="false">Track Grievance</a>
                        </li>
                    </ul>
                    <div class="mt-3 mt-lg-0 d-flex align-items-center">
                        <a href="{{ url('/login') }}" class="btn btn-primary mx-2 btn-sm"> <i class="bi bi-person-fill-add"></i>  User Login</a>
                        <a href="{{ url('/adminLogin') }}" class="btn btn-danger btn-sm"> <i class="bi bi-person-fill-check"></i> Officer Login</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

{{ $slot }}

<footer class="mt-7" >
    <div class="container pb-4">
        <hr>
        <div class="row align-items-center">
            <div class="col-md-3">
                <a class="mb-4 mb-lg-0 d-block text-inverse" href=".{{ url('/') }}"><img
                        src="./assets/images/logo/btc.png" width="30%" alt="" /></a>
            </div>
            <div class="col-md-9 col-lg-6">

                <div class="count text-sm-center">
                    <span class="text btn btn-outline-primary btn-sm mb-2">Total Visitors : <span id="visitor-count"></span> </span> <br>
                </div>
                <div class="small mb-3 mb-lg-0 text-lg-center">
                    Copyright © 2025

                    <span class="text-primary"><a href="#">B-GRAMS</a></span>
                    | Designed & Developed by
                    <span class="text-primary"><a href="https://jypko.com">Jypko</a></span>
                </div>

            </div>
            <div class="col-lg-3">
                <div class="text-lg-end d-flex align-items-center justify-content-lg-end">
                    <div class="dropdown">
                        <button class="btn btn-light btn-icon rounded-circle d-flex align-items-center" type="button"
                                aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                            <i class="bi theme-icon-active lh-1"><i class="bi theme-icon bi-sun-fill"></i></i>
                            <span class="visually-hidden bs-theme-text">Toggle theme</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bs-theme-text">
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center active"
                                        data-bs-theme-value="light" aria-pressed="true">
                                    <i class="bi theme-icon bi-sun-fill"></i>
                                    <span class="ms-2">Light</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center"
                                        data-bs-theme-value="dark" aria-pressed="false">
                                    <i class="bi theme-icon bi-moon-stars-fill"></i>
                                    <span class="ms-2">Dark</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center"
                                        data-bs-theme-value="auto" aria-pressed="false">
                                    <i class="bi theme-icon bi-circle-half"></i>
                                    <span class="ms-2">Auto</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="ms-3 d-flex gap-2">
                        <a href="#!" class="btn btn-instagram btn-light btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-instagram" viewBox="0 0 16 16">
                                <path
                                    d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z">
                                </path>
                            </svg>
                        </a>
                        <a href="#!" class="btn btn-facebook btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-facebook" viewBox="0 0 16 16">
                                <path
                                    d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z">
                                </path>
                            </svg>
                        </a>
                        <a href="#!" class="btn btn-twitter btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-twitter" viewBox="0 0 16 16">
                                <path
                                    d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Scroll top -->
<div class="btn-scroll-top">
    <svg class="progress-square svg-content" width="100%" height="100%" viewBox="0 0 40 40">
        <path
            d="M8 1H32C35.866 1 39 4.13401 39 8V32C39 35.866 35.866 39 32 39H8C4.13401 39 1 35.866 1 32V8C1 4.13401 4.13401 1 8 1Z" />
    </svg>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Set default theme to light
        document.documentElement.setAttribute("data-bs-theme", "light");

        // Update button states
        document.querySelectorAll('.dropdown-item').forEach(btn => {
            btn.classList.remove('active');
            btn.setAttribute('aria-pressed', 'false');
        });

        // Set Light theme button as active
        let lightThemeBtn = document.querySelector('[data-bs-theme-value="light"]');
        if (lightThemeBtn) {
            lightThemeBtn.classList.add('active');
            lightThemeBtn.setAttribute('aria-pressed', 'true');
        }
    });
</script>

<script>
    var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1400
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };
</script>
<!--end::Global Config-->


<script>
    // Function to track visitor
    function trackVisitor() {
        $.ajax({
            url: "{{ url('/track-visitor') }}",  // API endpoint
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}", // CSRF Token
            },
            success: function(response) {
                console.log("Visitor Tracked");
                getVisitorCount(); // Refresh the visitor count after tracking
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }

    // Function to get the total visitor count
    function getVisitorCount() {
        $.ajax({
            url: "{{ url('/visitor-count') }}",  // API endpoint
            type: "GET",
            success: function(response) {
                $('#visitor-count').text(response.total_visitors); // Update the count on the page
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }

    // Call trackVisitor on page load
    $(document).ready(function() {
        trackVisitor();  // Track the visitor when the page loads
        getVisitorCount();  // Get the total visitor count
    });
</script>



<script src="{{ asset('js/home/home-dashboard.js') }}"></script>

<!-- Libs JS -->
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/headhesive/dist/headhesive.min.js') }}"></script>

<!-- Theme JS -->
<script src="{{ asset('assets/js/theme.min.js') }}"></script>

<script src="{{ asset('assets/libs/scrollcue/scrollCue.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/scrollcue.js') }}"></script>

<script src="{{ asset('assets/js/vendors/password.js') }}"></script>

</body>

</html>
