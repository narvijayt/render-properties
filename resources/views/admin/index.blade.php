@extends('admin.layouts.main')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Users</span>
                        <span class="info-box-number">{{$all}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Realtors</span>
                        <span class="info-box-number">{{$realtors}}</span>
                    </div>
                </div>
            </div>
            <div class="clearfix visible-sm-block"></div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Lenders</span>
                        <span class="info-box-number">{{$lenders}}</span>
                        <small><strong>Paid:</strong> {{$lenders_paid}}</small>&nbsp;
                        <small><strong>UnPaid:</strong> {{$lenders_unpaid}}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Customers</span>
                        <span class="info-box-number">{{$consumers}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Latest Members</h3>
                        <div class="box-tools pull-right">
                            <span class="label label-danger">{{count($users)}} New Members</span>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="users-list clearfix">
                            @foreach($users as $user)
                                <li>
                                    <img src="{{$user->avatarUrl()}}" alt="{{ $user->full_name() }}">
                                    <a class="users-list-name" href="#">{{ucfirst($user['first_name']).' '.ucfirst($user['last_name'])}}</a>
                                    <span class="users-list-date">{{date('d M, Y',strtotime($user['register_ts']))}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="box-footer text-center">
                        <a href="{{route('admin.users.index')}}" class="uppercase">View All Users</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection