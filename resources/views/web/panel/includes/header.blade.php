<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="author" content="Azad Memon">
    <link rel="icon" href="{{ URL::asset('panel/assets/images/favicon.png') }}" type="image/x-icon">
    @php
        $currentPath = request()->path();
    @endphp

    <title>Konrad - {{ $currentPath === 'maintenance' ? 'Maintenance' : $pageTitle ?? 'Dashboard' }}</title>

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('panel/assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('panel/assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('panel/assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('panel/assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('panel/assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('panel/assets/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('panel/assets/css/vendors/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('panel/assets/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('panel/assets/css/vendors/animate.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('panel/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link id="color" rel="stylesheet" href="{{ URL::asset('panel/assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('panel/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('panel/assets/css/responsive.css') }}">

    <!-- Sweet Alert -->
    <link href="{{ URL::asset('panel/assets/libs/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css">

    <link rel="stylesheet" href="{{ URL::asset('panel/assets/css/toastr.css') }}" />
</head>
