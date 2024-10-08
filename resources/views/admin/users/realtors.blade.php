@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>Realtors Users List</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Users</a></li>
            <li class="active">Realtors</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Realtors</h3>
                    </div>
                    <div class="box-body">
                        <form name="broker-form" action="{{ route('admin.realtors') }}" method="get">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>By Name/Email</label>
                                    <div class="form-input">
                                        <input type="text" name="search" class="form-control" value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <div class="form-input">
                                    <button type="submit" id="filter_realtors" class="btn btn-success">Filter</button>
                                </div>
                            </div>
                        </form>
						<div id="dlt-msg" class="alert alert-success" style="display:none;"></div>
                        <table id="realor_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Registered</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($users) && !empty($users))
                                    @php $i = 1; @endphp
                                    @foreach($users as $user)
                                        <tr class="row_<?= $user['user_id']; ?>">
                                            <td>{{$i++}}</td>
                                            <td>{{ucfirst($user['first_name']).' '.ucfirst($user['last_name'])}}</td>
                                            <td>{{$user['email']}}</td>
                                            <td>{{str_replace('-', '', $user['phone_number'])}}</td>
                                            <td>
                                                @if($user['active'] == 1)
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </td>
                                            <td>{{date('d M, Y',strtotime($user['register_ts']))}}</td>
                                            <td>
                                                <!---<a href="{{url('cpldashrbcs/realtors/'.$user["user_id"])}}" class="edit-icon" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>-->
                                               <a href="javascript:void(0)" class="delete-icon" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteUser(<?= $user['user_id'] ?>)">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                                <a href="{{url('/cpldashrbcs/edit-user',[$user['user_id']])}}" class="edit-icon" data-toggle="tooltip" data-placement="top" title="Edit User">
                                                    <i class="fa fa-pencil-square-o"></i></a>
                                                <a href="{{ route('admin.user.leads', ['user_id' => $user['user_id']]) }}" class="edit-icon" data-toggle="tooltip" data-placement="top" title="View Leads">
                                                <i class="fa fa-eye"></i></a>
                                            </td>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>No Records Found.</tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="page-div">
                            @if(isset($users) && !empty($users))
                                {{ $users->links() }}
                            @endif
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

