@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>Brokers Users List</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Users</a></li>
            <li class="active">Brokers</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <div class="col-md-10">
                            <h3 class="box-title">Brokers</h3>
                        </div>
                        <div class="col-md-2 text-right">
                            <h4>Total: {{ $users->total() }}</h4>
                        </div>
                    </div>
                    <div class="box-body">
                        <form name="broker-form" action="{{ route('admin.brockers') }}" method="get">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>By Name/Email</label>
                                    <div class="form-input">
                                        <input type="text" name="search" class="form-control" value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <div class="form-input">
                                        <select class="form-control" name="payment_status">
                                            <option value="all">All</option>
                                            <option value="online_paid" {{ (isset($_REQUEST['payment_status']) && $_REQUEST['payment_status'] == "online_paid" ) ? "selected" : "" }}>Online Payment</option>
                                            <option value="manual_paid" {{ (isset($_REQUEST['payment_status']) && $_REQUEST['payment_status'] == "manual_paid" ) ? "selected" : "" }}>Manual Payment</option>
                                            <option value="unpaid" {{ (isset($_REQUEST['payment_status']) && $_REQUEST['payment_status'] == "unpaid" ) ? "selected" : "" }}>Unpaid</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <div class="form-input">
                                    <button type="submit" id="filter_brokers" class="btn btn-success">Filter</button>
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
                                <th>Billing</th>
                                <th>Status</th>
                                <th>Last Activity</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($users) && !empty($users))
                                @php $i = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? ( ($_REQUEST['page']-1)*20) + 1 : 1; @endphp
                                @foreach($users as $user)
                                    <tr class="row_<?= $user['user_id']; ?>">
                                        <td>{{$i++}}</td>
                                        <td>{{ucfirst($user['first_name']).' '.ucfirst($user['last_name'])}}</td>
                                        <td>{{$user['email']}}</td>
                                        <td>{{str_replace('-', '', $user['phone_number'])}}</td>
                                        <td>
                                            @if($user['payment_status'] == 1)
                                                Paid
                                            @else
                                                Unpaid
                                            @endif
                                        </td>
                                        <td>
                                            @if($user['active'] == 1)
                                                Active
                                            @else
                                               Inactive
                                            @endif
                                        </td>
                                        <td>{{$user->time_elapsed_string($user['last_activity'])}}</td>
                                        <td>
                                            <!---<a href="{{url('cpldashrbcs/brokers/'.$user["user_id"])}}" class="edit-icon" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>-->
                                            <a href="javascript:void(0)" class="delete-icon" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteUser(<?= $user['user_id'] ?>)">
												<i class="fa fa-trash-o"></i>
											</a>
											<a href="{{url('/cpldashrbcs/edit-user',[$user['user_id']])}}" class="edit-icon" data-toggle="tooltip" data-placement="top" title="Edit User">
                                                    <i class="fa fa-pencil-square-o"></i></a></td>
										
                                          
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
                                {{ $users->appends($_GET)->links() }}
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
@endsection