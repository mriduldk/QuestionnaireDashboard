<!DOCTYPE html>

<html lang="en">

<head>
    <base href="../../">
    <meta charset="utf-8" />
    <title>Admin Dashboard</title>
    <meta name="description" content="Aside light theme example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('assets-metronics/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
          type="text/css" />
    <link href="{{ asset('assets-metronics/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets-metronics/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet"
          type="text/css" />
    <link href="{{ asset('assets-metronics/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets-metronics/css/themes/layout/header/base/light.css') }}" rel="stylesheet"
          type="text/css" />
    <link href="{{ asset('assets-metronics/css/themes/layout/header/menu/light.css') }}" rel="stylesheet"
          type="text/css" />
    <link href="{{ asset('assets-metronics/css/themes/layout/brand/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets-metronics/css/themes/layout/aside/light.css') }}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/btc.png') }}" />

    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('assets-metronics/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets-metronics/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
    <script src="{{ asset('assets-metronics/js/scripts.bundle.js') }}"></script>
    <!--end::Global Theme Bundle-->

    <script src="{{ asset('assets-metronics/js/pages/features/miscellaneous/sweetalert2.js') }}"></script>

    <link href="{{ asset('assets-metronics/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets-metronics/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets-metronics/js/pages/crud/datatables/basic/basic.js') }}"></script>

    <style>
        @media (max-width: 768px) {
            .mobile-margin {
                margin-top: 10px;
            }
        }
        @media (min-width: 768px) {
            .mobile-margin {
                margin-top: -40px;
            }
        }
    </style>

    @stack('styles')

</head>

<body id="kt_body"
      class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
    <!--begin::Logo-->
    <a href="{{ url('/') }}">
        <img alt="Logo" src="{{ asset('assets/images/logo/btc.png') }}" width="60px"/>
    </a>
    <!--end::Logo-->
    <div class="d-flex align-items-center">
        <!--begin::Aside Mobile Toggle-->
        <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
            <span></span>
        </button>
        <!--end::Aside Mobile Toggle-->
        <!--begin::Header Menu Mobile Toggle-->
        <button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
            <span></span>
        </button>
        <!--end::Header Menu Mobile Toggle-->
        <!--begin::Topbar Mobile Toggle-->
        <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                <span class="svg-icon svg-icon-xl">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                         height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            <path
                                d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
        </button>
        <!--end::Topbar Mobile Toggle-->
    </div>
</div>
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-row flex-column-fluid page">
        <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
            <div class="brand flex-column-auto" id="kt_brand">
                <a href="{{ url('/') }}" class="brand-logo">
                    <img alt="Logo" src="{{ asset('assets/images/logo/btc.png') }}" width="60px" />
                </a>
                <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
                        <span class="svg-icon svg-icon svg-icon-xl">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path
                                        d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                                        fill="#000000" fill-rule="nonzero"
                                        transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                                    <path
                                        d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                                        fill="#000000" fill-rule="nonzero" opacity="0.3"
                                        transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                </button>
            </div>
            <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
                     data-menu-dropdown-timeout="500">

                    <ul class="menu-nav">
                        @foreach ($adminMenu as $item)
                            @if ($item['type'] === 'section')
                                <li class="menu-section">
                                    <h4 class="menu-text">{{ $item['title'] }}</h4>
                                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                </li>
                            @elseif ($item['type'] === 'link')
                                <li class="menu-item {{ Request::routeIs($item['route']) ? 'menu-item-active' : '' }}" aria-haspopup="true">
                                    <a href="{{ route($item['route']) }}" class="menu-link">
                                        <span class="svg-icon menu-icon">
                                            @include('icons.' . $item['icon'])
                                        </span>
                                        <span class="menu-text">{{ $item['title'] }}</span>
                                    </a>
                                </li>
                            @elseif ($item['type'] === 'logout')
                                <li class="menu-item mt-6">
                                    <a href="{{ route($item['route']) }}"
                                    class="menu-link"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <span class="svg-icon menu-icon">
                                            @include('icons.' . $item['icon'])
                                        </span>
                                        <span class="menu-text">{{ $item['title'] }}</span>
                                    </a>
                                    <form id="logout-form" action="{{ route($item['route']) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                    <!--end::Menu Nav-->
                </div>
                <!--end::Menu Container-->
            </div>
            <!--end::Aside Menu-->
        </div>
        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            <!--begin::Header-->
            <div id="kt_header" class="header header-fixed">
                <!--begin::Container-->
                <div class="container-fluid d-flex align-items-stretch justify-content-between">
                    <!--begin::Header Menu Wrapper-->
                    <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                        <!--begin::Header Menu-->
                        <div id="kt_header_menu"
                             class="header-menu header-menu-mobile header-menu-layout-default">

                            <h1 class="mt-4">Questionnaire (Admin Dashboard)</h1>

                        </div>
                        <!--end::Header Menu-->
                    </div>
                    <!--end::Header Menu Wrapper-->
                    <!--begin::Topbar-->
                    <div class="topbar">

                        <div class="topbar-item">
                            <!--begin::Daterange-->
                            <span class="btn btn-sm btn-light font-weight-bold mr-2"
                                  id="kt_dashboard_daterangepicker"
                                  title="" data-placement="left">
                                    <span class="text-muted font-size-base font-weight-bold mr-2"
                                          id="kt_dashboard_daterangepicker_title">Today</span>
                                    <span class="text-primary font-size-base font-weight-bolder"
                                          id="kt_dashboard_daterangepicker_date"></span>
                                </span>
                            <!--end::Daterange-->
                        </div>


                        <!--begin::User-->
                        <div class="topbar-item">
                            <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                                 id="kt_quick_user_toggle">
                                    <span
                                        class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                                <span
                                    class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">
                                    {{-- {{ Auth::user()->name }} --}}
                                </span>
                                <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                                        <span class="symbol-label font-size-h5 font-weight-bold">
                                                 {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </span>
                                    </span>
                            </div>
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Topbar-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                <!--begin::Entry-->
                <div class="d-flex flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container-fluid">

                        <div class="row">

                            <div class="col-lg-12 mobile-margin">
                                {{ $slot }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                <!--begin::Container-->
                <div
                    class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <!--begin::Copyright-->
                    <div class="text-dark order-2 order-md-1">
                        <span class="text-muted font-weight-bold mr-2">
                            Copyright © 2025
                            <span class="text-primary">
                                <a href="#"></a>
                            </span>
                            | Designed & Developed By
                        </span>
                        <span class="text-primary">
                            <a href="https://jypko.com/">Jypko</a>
                        </span>
                    </div>
                    <!--end::Copyright-->

                </div>
                <!--end::Container-->
            </div>
        </div>
    </div>
</div>


<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop">
        <span class="svg-icon">
            <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                 height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <polygon points="0 0 24 0 24 24 0 24" />
                    <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10"
                          rx="1" />
                    <path
                        d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                        fill="#000000" fill-rule="nonzero" />
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>
</div>
<!--end::Scrolltop-->


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

    var table = $('#kt_datatables');

    table.DataTable({
        responsive: true,
        pagingType: 'full_numbers',
        order: [],
        dom: '<"float-left"><"float-right"f>rt<"row"<"col-sm-3"B><"col-sm-3"l><"col-sm-3"i><"col-sm-3"p>>',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        lengthMenu: [
            [10, 25, 50, 100, -1],
            ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
        ]
    });

    table.init();

</script>

<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('assets-metronics/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM"></script>
<script src="{{ asset('assets-metronics/plugins/custom/gmaps/gmaps.js') }}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->

<script src="{{ asset('assets-metronics/js/pages/widgets.js') }}"></script>
<script src="{{ asset('assets-metronics/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets-metronics/js/pages/crud/datatables/basic/basic.js') }}"></script>

@stack('scripts')

</body>
<!--end::Body-->

</html>
