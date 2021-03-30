<?php
// get the user role value in session
$session_value = session('userRole');
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="description" content="petrosmart">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/custom/toggle/bootstrap-toggle.min.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Montserrat:400,500,600,700", "Noto+Sans:400,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/img/app_logo.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/img/app_logo.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/img/app_logo.png')}}">
    <!-- Stylesheet -->

    <link rel="stylesheet" href="{{asset('assets/vendors/css/base/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-select/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/css/base/elisyam-1.5.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animate/animate.css')}}">


    <!-- Datatables -->
    <link rel="stylesheet" href="{{asset('assets/css/datatables/datatables.min.css')}}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/custom/loader/red-loader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom/w3/w3.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom/sweetAlert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom/toast-master/css/jquery.toast.css')}}">


    <!-- Tweaks for older IEs-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

    <!-- save the userrole data into storage -->
    <script type="text/javascript">
        var userRoleSession = '<?php echo $session_value; ?>';
        sessionStorage.setItem("userRoleSession", userRoleSession.toUpperCase());
    </script>
</head>

<body id="page-top">
    <!-- Begin Preloader -->
    <div id="preloader">
        <div class="canvas">
            <img src="assets/img/app_logo.png" alt="Petrosmart" class="loader-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- End Preloader -->

    <div class="page">
        <header class="header">
            <nav class="navbar fixed-top">
                <!-- Begin Search Box-->
                <div class="search-box">
                    <button class="dismiss"><i class="ion-close-round"></i></button>
                    <form id="searchForm" action="#" role="search">
                        <input type="search" placeholder="Search something ..." class="form-control">
                    </form>
                </div>
                <!-- End Search Box-->
                <!-- Begin Topbar -->
                <div class="navbar-holder d-flex align-items-center align-middle justify-content-between">
                    <!-- Begin Logo -->
                    <div class="navbar-header">
                        <a href="#" class="navbar-brand">
                            <div class="brand-image brand-big">
                                <img src="assets/img/app_logo.png" alt="Petrosmart_Logo" class="logo-small">
                                <span>Petrosmart</span>
                            </div>
                            <div class="brand-image brand-small">
                                <img src="assets/img/app_logo.png" alt="petrosmart_Logo" class="logo-small">
                            </div>
                        </a>
                        <!-- Toggle Button -->
                        <a id="toggle-btn" href="#" class="menu-btn active">
                            <span></span>
                            <span></span>
                            <span></span>
                        </a>
                        <!-- End Toggle -->
                    </div>

                    <!-- Error messages -->
                    <div class="row">

                        <div class="col-md-12">
                            <!--Loader and notification messages-->
                            <div class="modal_loader" style="display: none;">
                                <div align="center" style="margin-bottom:15px;" class="">
                                    <div class="-spinner-ring -error-"></div>
                                    <h5><span class="msgAlertPlaceHolder"></span></h5>
                                </div>
                            </div>

                            <div align="center">
                                <h5><span class="msgAlertPlaceHolder"></span></h5>
                            </div>

                        </div>

                    </div>
                    <!-- End Logo -->
                    <!-- Begin Navbar Menu -->
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center pull-right">
                        <!-- <h6 class="page-header-title"><span id="showUsername"></span></h6> -->

                        <!-- User -->
                        <li class="nav-item dropdown"><a id="user" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><img src="{{asset('assets/img/avatar/avatar-01.jpg')}}" alt="..." class="avatar rounded-circle"></a>
                            <ul aria-labelledby="user" class="user-size dropdown-menu">
                                <li class="welcome">

                                    <img src="{{asset('assets/img/avatar/avatar-01.jpg')}}" alt="..." class="rounded-circle">
                                </li>

                                <li>
                                    <a href="/logout">
                                        <span class="icon logout"></span>
                                        <span class="text">Logout</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- End User -->
                        <!-- Begin Quick Actions -->
                        <!-- End Quick Actions -->
                    </ul>
                    <!-- End Navbar Menu -->
                </div>
                <!-- End Topbar -->
            </nav>
        </header>

        @yield('content')

    </div>
    <!-- End Page Content -->

    <!-- Begin Vendor Js -->
    <script src="{{asset('assets/vendors/js/base/jquery.min.js')}}"></script>

    <!-- End Vendor Js -->



    <!-- Begin Page Vendor Js -->
    <script src="{{asset('assets/vendors/js/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/datatables/jszip.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/datatables/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/datatables/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/vendors/js/datatables/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/nicescroll/nicescroll.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/datepicker/moment.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/datepicker/daterangepicker.js')}}"></script>

    <!-- End Page Vendor Js -->
    <!-- Begin Page Snippets -->
    <!-- <script src="{{asset('assets/js/components/tables/tables.js')}}"></script> -->

    <!-- Sweet Alert JS -->
    <script src="{{asset('assets/css/custom/sweetAlert/sweetalert2.min.js')}}"></script>


    <!-- BOOSTRAP.JS -->
    <script src="{{asset('assets/vendors/js/base/core.min.js')}}"></script>
    <script src="{{asset('assets/vendors/js/bootstrap-select/bootstrap-select.min.js')}}"></script>

    <!--TOAST JS-->
    <script src="{{asset('assets/css/custom/toast-master/js/jquery.toast.js')}}"></script>

    <script src="{{asset('assets/vendors/js/chart/chart.min.js')}}"></script>
    <script src="{{asset('assets/js/components/chartjs/chartjs.min.js')}}"></script>

    <!-- Begin Page Vendor Js -->
    <script src="{{asset('assets/vendors/js/app/app.min.js')}}"></script>
    <!-- End Page Vendor Js -->

    <script src="{{asset('assets/css/custom/toggle/bootstrap-toggle.min.js')}}"></script>
    <!-- APP.JS -->
    <script src="{{asset('assets/js/app.js')}}"></script>

    @stack('pageScripts')
</body>

</html>