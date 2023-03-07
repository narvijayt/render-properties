@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <a href="{{url('cpldashrbcs/taxonomies/new')}}">
            <button class="btn btn-success pages-btn">
                Add Category <i class="fa fa-plus-circle"></i>
            </button>
        </a>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Categories</a></li>
            <li class="active">All Categories</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Categories List</h3>
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
                            @if(isset($taxonomies) && !empty($taxonomies))
                                @php $i = 1; @endphp
                                @foreach($taxonomies as $taxonomy)
                                    @php $name = strtolower(str_replace(' ', '-', $taxonomy['name'])); @endphp
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{ucwords($taxonomy['name'])}}</td>
                                        <td>
                                            <a href="{{url("cpldashrbcs/taxonomies/{$taxonomy['id']}")}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>

                                            <form name="delete-taxonomy" class="d-block" method="post" action="{{url('cpldashrbcs/taxonomies/delete')}}">
                                                <input type="hidden" name="taxonomy_id" value="{{$taxonomy->id}}" />
                                                <button type="submit" onclick="return confirm('Are you sure?')" name="delete_taxonomy" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-trash"></i> </button>
                                            </form>
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