<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="description" content="Petrosmart">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Google Fonts -->
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

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/custom/loader/red-loader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom/w3/w3.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom/toast-master/css/jquery.toast.css')}}">
    <!-- Tweaks for older IEs-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>

<body class="bg-white">
    @yield('content')

    <!-- Begin Vendor Js -->
    <script src="{{asset('assets/vendors/js/base/jquery.min.js')}}"></script>
    <!-- <script src="{{asset('assets/vendors/js/base/core.min.js')}}"></script> -->
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
    <!-- Begin Page Vendor Js -->
    <script src="{{asset('assets/vendors/js/app/app.min.js')}}"></script>
    <!-- End Page Vendor Js -->
    <!-- APP.JS -->
    <script src="{{asset('assets/js/app.js')}}"></script>

</body>

</html>