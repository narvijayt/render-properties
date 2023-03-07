@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <a href="{{url('cpldashrbcs/pages/new')}}">
            <button class="btn btn-success pages-btn">
                Add Page  <i class="fa fa-plus-circle"></i>
            </button>
        </a>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Pages</a></li>
            <li class="active">All Pages</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List</h3>
                    </div>
                    <div class="box-body">
                        <table id="realor_table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($pages) && !empty($pages))
                                @php $i = 1; @endphp
                                @foreach($pages as $page)
                                    @php $title = strtolower(str_replace(' ', '-', $page['title'])); @endphp
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{ucwords($page['title'])}}</td>
                                        <td>
                                            <a href="{{url("cpldashrbcs/pages/{$title}/{$page['id']}")}}" class="edit-icon" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            
                                           
                                            <a href="{{url("/{$title}")}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View {{$title}}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
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