<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$page_title}}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{asset('css/admin/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/font/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/Ionicons/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/admin.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/icheck/blue.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/login.css')}}">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('home') }}">
            <!--<img src="{{asset('img/logo_inner.png')}}" class="img-responsive"/>-->
            <img src="{{asset('img/logo-02.png')}}" class="img-responsive"/>
        </a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Sign in</p>
        @if (Session::has('message'))
            <p class="alert alert-danger">{{ Session::get('message') }}</p>
        @endif
        <form id="login-form" method="post" action="{{url('cpldashrbcs/login')}}">
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember_me"> Remember Me
                        </label>
                    </div>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{asset('js/admin/jquery/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="{{asset('js/admin/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('js/admin/icheck/icheck.min.js')}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
    });

    $(function() {
        $("#login-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>
</body>
</html>
