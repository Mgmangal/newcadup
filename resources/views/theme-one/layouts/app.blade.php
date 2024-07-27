<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Twitter -->
    <meta name="twitter:site" content="@cadup">
    <meta name="twitter:creator" content="@cadup">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="cadup">
    <meta name="twitter:description" content="ERP Solution for Civil Aviation Department, Government of Uttar Pradesh ">
    <meta name="twitter:image" content="{{asset('front/img/Erp-Cadup-logo.png')}}">
    <!-- Facebook -->
    <meta property="og:url" content="http://cadup.com/">
    <meta property="og:title" content="DashForge">
    <meta property="og:description" content="ERP Solution for Civil Aviation Department, Government of Uttar Pradesh ">

    <meta property="og:image" content="{{asset('front/img/Erp-Cadup-logo.png')}}">
    <meta property="og:image:secure_url" content="{{asset('front/img/Erp-Cadup-logo.png')}}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">
    <!-- Meta -->
    <meta name="description" content="ERP Solution for Civil Aviation Department, Government of Uttar Pradesh ">
    <meta name="author" content="cadup">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('front/img/favicon.ico')}}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- vendor css -->
    <link href="{{asset('assets/theme_one/lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('assets/theme_one/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet"> -->
    <link href="{{asset('assets/theme_one/lib/remixicon/fonts/remixicon.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('assets/theme_one/lib/jqvmap/jqvmap.min.css')}}" rel="stylesheet"> -->
    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{asset('assets/theme_one/css/dashforge.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('assets/theme_one/css/dashforge.dashboard.css')}}"> -->
    @yield('css')
    <style>
        .navbar-menu {
            justify-content: center !important;
            max-width: 100%;
        }
        .required:after {
            content: "*";
            position: relative;
            font-size: inherit;
            color: red;
            padding-left: 0rem!important;
            font-weight: 600;
        }
    </style>
</head>

<body class="page-profile">
    <header class="navbar navbar-header navbar-header-fixed">
        <a href="javascript:void(0);" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
        <div class="navbar-brand">
            <a href="{{route('user.home')}}" class="df-logo">
                <!-- dash<span>forge</span> -->
                <img src="{{asset('front/img/Erp-Cadup-logo.png')}}" class="w-100 d-none d-md-block" alt="logo">
            </a>
        </div><!-- navbar-brand -->
        <div id="navbarMenu" class="navbar-menu-wrapper">
            <div class="navbar-menu-header">
                <a href="{{route('user.home')}}" class="df-logo">
                <img src="{{asset('front/img/Erp-Cadup-logo.png')}}" class="w-70" alt="logo">
                </a>
                <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
            </div><!-- navbar-menu-header -->
            <ul class="nav navbar-menu">
                <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">Main Navigation</li>
                <li class="nav-item active">
                    <a href="{{route('user.home')}}" class="nav-link">
                        Home
                    </a>
                </li>
                <li class="nav-item with-sub">
                    <a href="" class="nav-link">
                        <i data-feather="layers"></i> Masters
                    </a>
                    <ul class="navbar-menu-sub">
                        {{-- @can('Aircraft Type View') --}}
                        <li class="nav-sub-item">
                            <a href="{{route('user.master.aircraft_type')}}" class="nav-sub-link"><i data-feather="loader"></i> Aircraft Type</a>
                        </li>
                        {{-- @endcan --}}
                        {{-- @can('Aircraft Type View') --}}
                        <li class="nav-sub-item">
                            <a href="{{route('user.master.amp')}}" class="nav-sub-link"><i data-feather="loader"></i> AMP</a>
                        </li>
                        {{-- @endcan --}}
                        @can('Department View')
                        <li class="nav-sub-item">
                            <a href="{{route('user.master.department')}}" class="nav-sub-link"><i data-feather="loader"></i> Department</a>
                        </li>
                        @endcan
                        @can('Designation View')
                        <li class="nav-sub-item">
                            <a href="{{route('user.master.designation')}}" class="nav-sub-link"><i data-feather="loader"></i> Designation</a>
                        </li>
                        @endcan
                        @can('Job Function View')
                        <li class="nav-sub-item">
                            <a href="{{route('user.master.job_function')}}" class="nav-sub-link"><i data-feather="loader"></i> Job Function</a>
                        </li>
                        @endcan
                        @can('Role View')
                        <li class="nav-sub-item">
                            <a href="{{route('user.master.role')}}" class="nav-sub-link"><i data-feather="loader"></i> Roles</a>
                        </li>
                        @endcan
                        @can('Section View')
                        <li class="nav-sub-item">
                            <a href="{{route('user.master.section')}}" class="nav-sub-link"><i data-feather="loader"></i> Section</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                {{-- @can('Contract') --}}
                <li class="nav-item with-sub">
                    <a href="" class="nav-link">
                        <i data-feather="layers"></i> ATA
                    </a>
                    <ul class="navbar-menu-sub">
                        {{-- @can('Contract') --}}
                        <li class="nav-sub-item">
                            <a href="{{route('user.ata')}}" class="nav-sub-link"><i data-feather="archive"></i>ATA</a>
                        </li>
                        {{-- @endcan --}}
                        {{-- @can('Contract') --}}
                        <li class="nav-sub-item">
                            <a href="{{route('user.ata.category')}}" class="nav-sub-link"><i data-feather="archive"></i>ATA Category</a>
                        </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
                {{-- @endcan --}}
                @can('Flying')
                <li class="nav-item with-sub">
                    <a href="" class="nav-link">
                        <i data-feather="package"></i> Flying
                    </a>
                    <ul class="navbar-menu-sub">
                        @can('Sortie')
                        <li class="nav-sub-item">
                            <a href="{{route('user.flying.shortie')}}" class="nav-sub-link">
                                <i data-feather="calendar"></i>Sortie</a>
                        </li>
                        @endcan
                        @can('My Sortie')
                        <li class="nav-sub-item">
                            <a href="{{route('user.flying.myShortie')}}" class="nav-sub-link">
                                <i data-feather="calendar"></i>My Sortie</a>
                        </li>
                        @endcan
                        @can('Flying')
                        <li class="nav-sub-item">
                            <a href="{{route('user.flying.index')}}" class="nav-sub-link">
                                <i data-feather="message-square"></i>Flying</a>
                        </li>
                        @endcan
                        @can('My Flying')
                        <li class="nav-sub-item">
                            <a href="{{route('user.flying.myFlying')}}" class="nav-sub-link">
                                <i data-feather="message-square"></i>My Flying</a>
                        </li>
                        @endcan
                        @can('FDTL')
                        <li class="nav-sub-item">
                            <a href="{{route('user.fdtl.index')}}" class="nav-sub-link">
                                <i data-feather="message-square"></i>FDTL</a>
                        </li>
                        @endcan
                        @can('My FDTL')
                        <li class="nav-sub-item">
                            <a href="{{ route('user.fdtl.myFdtlReport') }}" class="nav-sub-link">
                                <i data-feather="message-square"></i>My FDTL</a>
                        </li>
                        @endcan
                        @can('Statistic')
                        <li class="nav-sub-item">
                            <a href="{{route('user.flying.statistics')}}" class="nav-sub-link">
                                <i data-feather="message-square"></i>Statistic</a>
                        </li>
                        @endcan
                        @can('My Statistic')
                        <li class="nav-sub-item">
                            <a href="{{route('user.flying.myStatistics')}}" class="nav-sub-link">
                                <i data-feather="message-square"></i>My Statistic</a>
                        </li>
                        @endcan
                        @can('Voilations')
                        <li class="nav-sub-item">
                            <a href="{{route('user.fdtl.voilations')}}" class="nav-sub-link">
                                <i data-feather="message-square"></i>Voilations</a>
                        </li>
                        @endcan
                        @can('My Voilations')
                        <li class="nav-sub-item">
                            <a href="{{route('user.fdtl.MyVoilations')}}" class="nav-sub-link">
                                <i data-feather="message-square"></i>My Voilations</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('SFA List')
                <li class="nav-item with-sub">
                    <a href="" class="nav-link">
                        <i data-feather="layers"></i> SFA
                    </a>
                    <ul class="navbar-menu-sub">
                        @can('SFA Generate')
                        <li class="nav-sub-item">
                            <a href="{{route('user.sfa.sfaGenerate')}}" class="nav-sub-link">
                                <i data-feather="calendar"></i>SFA Generate</a>
                        </li>
                        @endcan
                        @can('My SFA Generate')
                        <li class="nav-sub-item">
                            <a href="{{route('user.sfa.mySfaGenerate')}}" class="nav-sub-link">
                                <i data-feather="calendar"></i>My SFA Generate</a>
                        </li>
                        @endcan
                        @can('SFA List')
                        <li class="nav-sub-item">
                            <a href="{{route('user.sfa.sfaList')}}" class="nav-sub-link">
                                <i data-feather="message-square"></i>SFA List</a>
                        </li>
                        @endcan
                        @can('My SFA List')
                        <li class="nav-sub-item">
                            <a href="{{route('user.sfa.mySfaList')}}" class="nav-sub-link">
                                <i data-feather="message-square"></i>My SFA List</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('Contract')
                <li class="nav-item with-sub">
                    <a href="" class="nav-link">
                        <i data-feather="layers"></i> Contract
                    </a>
                    <ul class="navbar-menu-sub">
                        @can('Contract')
                        <li class="nav-sub-item">
                            <a href="{{route('user.contract')}}" class="nav-sub-link"><i data-feather="archive"></i> Contract</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                <li class="nav-item with-sub">
                    <a href="" class="nav-link">
                        <i data-feather="layers"></i> Certificate
                    </a>
                    <ul class="navbar-menu-sub">
                        @can('Licence')
                        <li class="nav-sub-item">
                            <a href="{{route('user.certificate.licence')}}" class="nav-sub-link">
                                <i data-feather="shield"></i>Licence</a>
                        </li>
                        @endcan
                        @can('My Licence')
                        <li class="nav-sub-item">
                            <a href="{{route('user.certificate.myLicence')}}" class="nav-sub-link">
                                <i data-feather="shield"></i>My Licence</a>
                        </li>
                        @endcan
                        @can('Training')
                        <li class="nav-sub-item">
                            <a href="{{route('user.certificate.trainings')}}" class="nav-sub-link">
                                <i data-feather="shield"></i>Training</a>
                        </li>
                        @endcan
                        @can('My Training')
                        <li class="nav-sub-item">
                            <a href="{{route('user.certificate.myTrainings')}}" class="nav-sub-link">
                                <i data-feather="shield"></i>My Training</a>
                        </li>
                        @endcan
                        @can('Medical')
                        <li class="nav-sub-item">
                            <a href="{{route('user.certificate.medicals')}}" class="nav-sub-link">
                                <i data-feather="shield"></i>Medical</a>
                        </li>
                        @endcan
                        @can('My Medical')
                        <li class="nav-sub-item">
                            <a href="{{route('user.certificate.myMedicals')}}" class="nav-sub-link">
                                <i data-feather="shield"></i>My Medical</a>
                        </li>
                        @endcan
                        @can('Qualification')
                        <li class="nav-sub-item">
                            <a href="{{route('user.certificate.qualifications')}}" class="nav-sub-link">
                                <i data-feather="shield"></i>Qualification</a>
                        </li>
                        @endcan
                        @can('My Qualification')
                        <li class="nav-sub-item">
                            <a href="{{route('user.certificate.myQualifications')}}" class="nav-sub-link">
                                <i data-feather="shield"></i>My Qualification</a>
                        </li>
                        @endcan
                        @can('Ground Training')
                        <li class="nav-sub-item">
                            <a href="{{route('user.certificate.groundTrainings')}}" class="nav-sub-link">
                                <i data-feather="shield"></i>Ground Training</a>
                        </li>
                        @endcan
                        @can('My Ground Training')
                        <li class="nav-sub-item">
                            <a href="{{route('user.certificate.myGroundTrainings')}}" class="nav-sub-link">
                                <i data-feather="shield"></i>My Ground Training</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                <li class="nav-item with-sub">
                    <a href="" class="nav-link">
                        <i data-feather="layers"></i> Curency
                    </a>
                    <ul class="navbar-menu-sub">
                        <li class="nav-sub-item">
                            <a href="{{route('user.reports.pilotFlyingCurrency')}}" class="nav-sub-link">
                                <i data-feather="calendar"></i>Show</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item with-sub">
                    <a href="" class="nav-link">
                        <i data-feather="layers"></i> Reports
                    </a>
                    <ul class="navbar-menu-sub">
                        @can('External Flying')
                        <li class="nav-sub-item">
                            <a href="{{ route('user.reports.externalFlying') }}" class="nav-sub-link">
                                <i data-feather="file-text"></i>External Flying</a>
                        </li>
                        @endcan
                        @can('Pilot Flying Hours')
                        <li class="nav-sub-item">
                            <a href="{{ route('user.reports.pilotFlyingHours') }}" class="nav-sub-link">
                                <i data-feather="file-text"></i>Pilot Flying Hours</a>
                        </li>
                        @endcan
                        @can('Pilot Ground Training')
                        <li class="nav-sub-item">
                            <a href="{{ route('user.reports.pilotGroundTraining') }}" class="nav-sub-link">
                                <i data-feather="file-text"></i>Pilot Ground Training</a>
                        </li>
                        @endcan
                        @can('VIP Recency')
                        <li class="nav-sub-item">
                            <a href="{{ route('user.reports.vipRecency') }}" class="nav-sub-link">
                                <i data-feather="file-text"></i>VIP Recency</a>
                        </li>
                        @endcan
                        @can('Flight Statistics')
                        <li class="nav-sub-item">
                            <a href="{{ route('user.flying.statistics') }}" class="nav-sub-link">
                                <i data-feather="file-text"></i>Flight Statistics</a>
                        </li>
                        @endcan
                        @can('Pilot Flying Currency')
                        <li class="nav-sub-item">
                            <a href="{{ route('user.reports.pilotFlyingCurrency') }}" class="nav-sub-link">
                                <i data-feather="file-text"></i>Pilot Flying Currency</a>
                        </li>
                        @endcan
                        @can('SFA Report')
                        <li class="nav-sub-item">
                            <a href="{{ route('user.sfa.sfaList') }}" class="nav-sub-link">
                                <i data-feather="file-text"></i>SFA Report</a>
                        </li>
                        @endcan
                        @can('FDTL Report')
                        <li class="nav-sub-item">
                            <a href="{{ route('user.fdtl.index') }}" class="nav-sub-link">
                                <i data-feather="file-text"></i>FDTL Report</a>
                        </li>
                        @endcan
                        @can('Violations Summary')
                        <li class="nav-sub-item">
                            <a href="{{ route('user.fdtl.voilations') }}" class="nav-sub-link">
                                <i data-feather="file-text"></i>Violations Summary</a>
                        </li>
                        @endcan
                        @can('Violations Report')
                        <li class="nav-sub-item">
                            <a href="{{ route('user.fdtl.voilations.report') }}" class="nav-sub-link">
                                <i data-feather="file-text"></i>Violations Report</a>
                        </li>
                        @endcan
                        @can('AAI Reports')
                        <li class="nav-sub-item">
                            <a href="{{ route('user.reports.aaiReports') }}" class="nav-sub-link">
                                <i data-feather="file-text"></i>AAI Reports</a>
                        </li>
                        @endcan
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link"><i data-feather="box"></i> Fuel</a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link"><i data-feather="archive"></i> Incidence</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('user.my.leave')}}" class="nav-link"><i data-feather="archive"></i> Leave</a>
                </li>
                @can('Load & Trim')
                <li class="nav-item">
                    <a href="{{route('user.loadTrim')}}" class="nav-link"><i data-feather="archive"></i> Load & Trim</a>
                </li>
                @endcan
                @can('Employee View')
                <li class="nav-item">
                    <a href="{{route('user.users')}}" class="nav-link"><i data-feather="archive"></i> Employees</a>
                </li>
                @endcan
                @can('Aircraft Type View')
                <li class="nav-item">
                    <a href="{{route('user.aircrafts')}}" class="nav-link"><i data-feather="archive"></i> Aircrafts</a>
                </li>
                @endcan
            </ul>
        </div><!-- navbar-menu-wrapper -->
        <div class="navbar-right">
            <!-- dropdown -->
            <div class="dropdown dropdown-notification">
                <!-- <a href="" role="button" class="dropdown-link new-indicator" data-bs-toggle="dropdown">
                    <i data-feather="bell"></i>
                    <span>2</span>
                </a> -->
                <div class="dropdown-menu dropdown-menu-end">
                    <div class="dropdown-header">Notifications</div>
                    <a href="" class="dropdown-item">
                        <div class="media">
                            <div class="avatar avatar-sm avatar-online"><img src="https://placehold.co/500"
                                    class="rounded-circle" alt=""></div>
                            <div class="media-body mg-l-15">
                                <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
                                <span>Mar 15 12:32pm</span>
                            </div><!-- media-body -->
                        </div><!-- media -->
                    </a>
                    <a href="" class="dropdown-item">
                        <div class="media">
                            <div class="avatar avatar-sm avatar-online"><img src="https://placehold.co/500"
                                    class="rounded-circle" alt=""></div>
                            <div class="media-body mg-l-15">
                                <p><strong>Adrian Monino</strong> added new comment on your photo</p>
                                <span>Mar 12 10:40pm</span>
                            </div><!-- media-body -->
                        </div><!-- media -->
                    </a>
                    <div class="dropdown-footer"><a href="">View all Notifications</a></div>
                </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
            <div class="dropdown dropdown-profile">
                <a href="javascript:void(0);" role="button" class="dropdown-link" data-bs-toggle="dropdown"
                    data-bs-display="static">
                    <div class="avatar avatar-sm">
                        <img src="https://placehold.co/387" class="rounded-circle" alt="">
                    </div>
                </a><!-- dropdown-link -->
                <div class="dropdown-menu dropdown-menu-end tx-13">
                    <div class="avatar avatar-lg mg-b-15">
                        <img src="https://placehold.co/387" class="rounded-circle" alt="">
                    </div>
                    <h6 class="tx-semibold mg-b-5">{{ Auth::user()->fullName() }}</h6>
                    <p class="mg-b-25 tx-12 tx-color-03">{{ Auth::user()->email }}</p>
                    <a href="{{route('user.profile')}}" class="dropdown-item">
                        <i data-feather="edit-3"></i> Edit Profile
                    </a>
                    <a href="{{route('user.password')}}" class="dropdown-item">
                        <i data-feather="user"></i> Change Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('user.profile')}}" class="dropdown-item">
                        <i data-feather="help-circle"></i> Help Center
                    </a>
                    <a href="{{route('user.profile')}}" class="dropdown-item"><i data-feather="settings"></i>Account
                        Settings</a>
                    <a href="javascript:$('#logout-form').submit();" class="dropdown-item"><i
                            data-feather="log-out"></i>Sign Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
        </div><!-- navbar-right -->
    </header><!-- navbar -->
    <div class="container-fluid content-fixed pb-5 mb-5">
        <div class="row pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div class="pd-y-10">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{route('user.home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                            @if(!empty($sub_title))
                            <li class="breadcrumb-item active" aria-current="page">{{ $sub_title }}</li>
                            @endif
                        </ol>
                    </nav>
                    @if(empty($sub_title))
                    <h4 class="mg-b-0 tx-spacing--1">Welcome {{Auth::user()->fullName()}}</h4>
                    @endif
                </div>
                <!-- <div class="d-none d-md-block">
                        <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="mail"
                                class="wd-10 mg-r-5"></i> Email</button>
                        <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="printer"
                                class="wd-10 mg-r-5"></i> Print</button>
                        <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="file"
                                class="wd-10 mg-r-5"></i> Generate Report</button>
                    </div> -->
            </div>
            <div class="col-md-12">
            @yield('content')
            </div>
            <!-- row -->
        </div><!-- container -->
    </div><!-- content -->
    <footer class="footer fixed-bottom">
        <div>
            <span>&copy; {{date('Y')}} {{env('APP_NAME')}} v1.0.0. </span>
            <span>Created by <a href="{{route('user.home')}}">{{env('APP_NAME')}}</a></span>
        </div>
        <div>
            <nav class="nav">
                <a href="#" class="nav-link">Licenses</a>
                <a href="#" class="nav-link">Change Log</a>
                <a href="#" class="nav-link">Get Help</a>
            </nav>
        </div>
    </footer>
    <script src="{{asset('assets/theme_one/lib/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/theme_one/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/theme_one/lib/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/theme_one/lib/ionicons/ionicons/ionicons.esm.js')}}" type="module"></script>
    <script src="{{asset('assets/theme_one/lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <!-- <script src="{{asset('assets/theme_one/lib/jquery.flot/jquery.flot.js')}}"></script> -->
    <!-- <script src="{{asset('assets/theme_one/lib/jquery.flot/jquery.flot.stack.js')}}"></script> -->
    <!-- <script src="{{asset('assets/theme_one/lib/jquery.flot/jquery.flot.resize.js')}}"></script> -->
    <!-- <script src="{{asset('assets/theme_one/lib/chart.js/Chart.bundle.min.js')}}"></script> -->
    <!-- <script src="{{asset('assets/theme_one/lib/jqvmap/jquery.vmap.min.js')}}"></script> -->
    <!-- <script src="{{asset('assets/theme_one/lib/jqvmap/maps/jquery.vmap.usa.js')}}"></script> -->
    <script src="{{asset('assets/theme_one/lib/jqueryui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/theme_one/js/dashforge.js')}}"></script>
    <!-- <script src="{{asset('assets/theme_one/js/dashforge.sampledata.js')}}"></script> -->
    <!-- <script src="{{asset('assets/theme_one/js/dashboard-one.js')}}"></script> -->

    <!-- append theme customizer -->
    <script src="{{asset('assets/theme_one/lib/js-cookie/js.cookie.js')}}"></script>
    <!-- <script src="{{asset('assets/theme_one/js/dashforge.settings.js')}}"></script> -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script>
        $(document).ready(function() {
            @if (Session::has('warning'))
                warning("{{ Session::get('warning') }}");
            @elseif(Session::has('success'))
                success("{{ Session::get('success') }}");
            @elseif(Session::has('error'))
                error("{{ Session::get('error') }}");
            @endif
        });
        function success(message) {
            swal({
                title: "Success",
                text: message,
                icon: "success",
                button: "OK",
            });
        }

        function info(message) {
            swal({
                title: "Info",
                text: message,
                icon: "info",
                button: "OK",
            });
        }

        function error(message) {
            swal({
                title: "Error",
                text: message,
                icon: "error",
                button: "OK",
            });
        }

        function warning(message) {
            swal({
                title: "Warning",
                text: message,
                icon: "warning",
                button: "OK",
            });
        }
        function deleted(url) {
            swal({
                title: "Are you sure?",
                text: "Are you sure you want to delete this item?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        type: 'get',
                        data: {},
                        dataType: 'json',
                        success: function(data) {
                            if (data.success) {
                                swal("Success!", data.message, "success");
                            } else {
                                swal("Error!", data.message, "error");
                            }
                            dataList();
                        }
                    });
                } else {}
            });
        }
    </script>
    @yield('js')
</body>

</html>
