@php $states = app('App\Http\Utilities\Geo\USStates'); @endphp
@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>Users List uploaded by Sheet</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Users</a></li>
            <li class="active">List</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Upload Users from Excel Sheet</h3>
                    </div>

                    <div class="box-body">
                        <div id="dlt-msg" class="alert alert-success" style="display:none;"></div>

                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif

                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach

                        <form action="{{ route('importusers') }}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <input type="file" name="file" class="form-file-control">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-success">Import Users</button>
                                </div>
                            </div>
                        </form>
                        
                        <form id="users-filter-form" method="post">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label for="user-registered">Verified</label>
                                    <div class="form-input">
                                        <select name="registered" class="form-control">
                                            <option value="">All Users</option>
                                            <option value="1" {{app('request')->input('registered') == "1" ? "selected" : ""}}>Yes</option>
                                            <option value="0" {{app('request')->input('registered') == "0" ? "selected" : ""}}>Pending</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div for="form-filter-submit-btn">&nbsp;</div>
                                    <input type="submit" name="filter_users" class="btn btn-primary" value="Filter" />
                                </div>                                
                            </div>
                        </form>

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Type</th>
                                    <th>Uploaded on</th>
                                    <th>Verified</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($users) && !empty($users))
                                    @php $i = 1; @endphp
                                     @foreach($users as $user)
                                        <tr class="row_<?= $user['user_id']; ?>">
                                            <td>{{$i++}}</td>
                                            <td style="width:10%;"><img src="{{$user->avatarUrl()}}" width="100%" alt="{{ $user->full_name() }}"/></td>
                                            <td>{{ucfirst($user['first_name']).' '.ucfirst($user['last_name'])}}</td>
                                            <td>{{$user['email']}}</td>
                                            <td>{{str_replace('-', '', $user['phone_number'])}}</td>
                                            <td>
											@if($user['user_type'] != '')
												{{$user['user_type']}}
											@else
												customer
											@endif
											</td>
                                            <td>{{date('d M, Y',strtotime($user['register_ts']))}}</td>
                                            
                                            <td>
                                                @if($user['registered'] == 1)
                                                    Yes
                                                @else
                                                    Pending
                                                @endif
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" class="delete-icon" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteUser(<?= $user['user_id'] ?>)"><i class="fa fa-trash-o"></i></a>
                                                
                                                <!-- <a href="{{url('/cpldashrbcs/edit-user',[$user['user_id']])}}" class="edit-icon" data-toggle="tooltip" data-placement="top" title="Edit User"><i class="fa fa-pencil-square-o"></i></a></td> -->
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>No Records Found.</tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="page-div">
                        @if(isset($users) && !empty($users))
                            {{ $users->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

