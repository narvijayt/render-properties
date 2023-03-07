@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <a href="{{url('cpldashrbcs/add-designation')}}">
            <button class="btn btn-success pages-btn">
                Add User Designation  <i class="fa fa-plus-circle"></i>
            </button>
        </a>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">All Users With Designation</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
             @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                         @endif
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List</h3>
                    </div>
                    <div class="box-body">
                        <table id="realor_table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Name</th>
                                 <th>Email</th>
                                  <th>Phone No</th>
                                <th>Designation</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($user) && !empty($user))
                                @php $i = 1; @endphp
                                @foreach($user as $users)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$users->first_name}} {{$users->last_name}} @if($users->username)({{$users->username}})@endif</td>
                                        <td>{{$users->email}}</td>
                                         <td>{{$users->phone_number}}</td>
                                        <td>{{$users->designation}}</td>
                                        <td><a href="{{url('cpldashrbcs/edit-user',[$users->user_id])}}"><i class="fa fa-pencil-square-o"></i></a></td>
                                      </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>No Records Found.</tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection