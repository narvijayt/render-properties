@php $states = app('App\Http\Utilities\Geo\USStates'); @endphp
@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>Users List</h1>
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
                        <h3 class="box-title">All Users</h3>
                    </div>
                    	<div id="dlt-msg" class="alert alert-success" style="display:none;"></div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Type</th>
                                    <th>License#</th>
                                    <th>Sales</th>
                                    <th>Company</th>
                                    <th>Address</th>
                                    <th>Registered</th>
                                    <th>Last Activity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($users) && !empty($users))
                                    @php $i = 1; @endphp
                                     @foreach($users as $user)
                                        <tr class="row_<?= $user['user_id']; ?>">
                                            <td>{{$i++}}</td>
                                            <td><img src="{{$user->avatarUrl()}}" width="100%" alt="{{ $user->full_name() }}"/></td>
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
                                            <td>{{$user['license']}}</td>
                                            <td>{{$user['monthly_sales']}}</td>
                                            <td>{{ucwords(substr($user['firm_name'], 0, 50))}}</td>
                                            <td>
                                                {{ucfirst($user['city']).', '}}
                                                @foreach($states::all() as $abbr => $stateName)
                                                    {{collect(isset($user['state']) ? $user['state'] : null)->contains($abbr) ? $stateName : '' }}
                                                @endforeach
                                                {{', '.$user['zip']}}
                                            </td>
                                            <td>{{date('d M, Y',strtotime($user['register_ts']))}}</td>
                                            <td>{{$user->time_elapsed_string($user['last_activity'])}}</td>
                                            <td>
                                                @if($user['active'] == 1)
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </td>
                                            <td><a href="javascript:void(0)" class="delete-icon" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteUser(<?= $user['user_id'] ?>)">
                                                    <i class="fa fa-trash-o"></i>
                                                    </a>
                                                    <a href="{{url('/cpldashrbcs/edit-user',[$user['user_id']])}}" class="edit-icon" data-toggle="tooltip" data-placement="top" title="Edit User">
                                                    <i class="fa fa-pencil-square-o"></i></a></td>
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

