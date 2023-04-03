<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$page_title}}</title>
	 <link rel="icon" href="/img/icon.png" sizes="32x32" type="image/png"> 
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{asset('css/admin/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/font/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/Ionicons/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/datatables/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/admin.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/skins/_all-skins.min.css')}}">
	 <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper">
        @include('admin.partials.header')
        @include('admin.partials.sidebar')
        <div class="content-wrapper">
            @yield('content')
        </div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs"></div>
            <strong>Copyright &copy; {{date('Y')}} <a href="#">{!! get_application_name() !!}</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    @include('admin.partials.footer')
</body>
</html>