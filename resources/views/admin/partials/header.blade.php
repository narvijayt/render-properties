@php
use App\User;
$user = User::find(3);
@endphp
<header class="main-header">
    <a href="#" class="logo">
        <span class="logo-mini"><b>{!! get_application_name() !!}</b></span>
        <span class="logo-lg"><b>{!! get_application_name() !!}</b></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">0</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">No Notification</li>
                    </ul>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('img/default-avatar.png')}}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ucfirst($user->username)}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{asset('img/default-avatar.png')}}" class="img-circle" alt="User Image">
                            <p>  {{ucfirst($user->username)}} <small>Member since {{date('M, Y',strtotime($user->register_ts))}}</small></p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="{{ url('cpldashrbcs/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>