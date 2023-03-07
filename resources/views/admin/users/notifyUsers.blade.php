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
                        <h3 class="box-title">Brokers</h3>
                    </div>
                    <div class="box-body">
                        <table id="realor_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Email</th>
                                    <th>Zip</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($users) && !empty($users))
                                @php $i = 1; @endphp
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$user['email']}}</td>
                                        <td>{{$user['zip']}}</td>
                                        <td>{{date('d M, Y',strtotime($user['created_at']))}}</td>
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