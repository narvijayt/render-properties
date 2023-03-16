@php $states = app('App\Http\Utilities\Geo\USStates'); @endphp
@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>Industry List</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Vendors</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All Vendor Industry</h3>
                    </div>
                    	<div id="dlt-msg" class="alert alert-success" style="display:none;"></div>
                   <div class="box-body">
                   
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Name</th>
                                      <th>Action</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($fetchAllIndustry) && !empty($fetchAllIndustry))
                                    @php $i = 1; @endphp
                                     @foreach($fetchAllIndustry as $industry)
                                     <tr class="row_<?= $industry['id']; ?>">
                                            <td>{{$i++}}</td>
                                            <td>{{$industry->name}}</td>
                                            <td>
                                                    <a href="{{url('cpldashrbcs/edit-industry',[$industry['id']])}}" class="edit-icon" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fa fa-edit"></i></a>
                                                  </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>No Records Found.</tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="page-div">
                        @if(isset($fetchAllIndustry) && !empty($fetchAllIndustry))
                            {{ $fetchAllIndustry->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    
   
@endsection

