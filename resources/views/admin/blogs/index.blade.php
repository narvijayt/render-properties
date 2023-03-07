@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <a href="{{url('cpldashrbcs/blogs/new')}}">
            <button class="btn btn-success pages-btn">
                Add Blog <i class="fa fa-plus-circle"></i>
            </button>
        </a>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Blogs</a></li>
            <li class="active">All Blogs</li>
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
                        <h3 class="box-title">Blogs List</h3>
                    </div>
                    <form id="blog-filter-form" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3 form-group">
                                    <label for="blog-profile">Blog Profile</label>
                                    <div class="form-input">
                                        <select name="blog_profile" class="form-control">
                                            <option value="">All Blogs</option>
                                            <option value="Lenders" {{app('request')->input('blog_profile') == "Lenders" ? "selected" : ""}}>Mortgage Blogs</option>
                                            <option value="Agents" {{app('request')->input('blog_profile') == "Agents" ? "selected" : ""}}>Real Estate Blogs</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div for="form-filter-submit-btn">&nbsp;</div>
                                    <input type="submit" name="filter_blogs" class="btn btn-primary" value="Filter Blogs" />
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="box-body">
                        <table id="realor_table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Title</th>
                                <th>Profile</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($blogs) && !empty($blogs))
                                @php $i = 1; @endphp
                                @foreach($blogs as $blog)
                                    @php $title = strtolower(str_replace(' ', '-', $blog['title'])); @endphp
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{ucwords($blog['title'])}}</td>
                                        <td>{{ucwords($blog['blog_profile'])}}</td>
                                        <td>
                                            <a href="{{url("cpldashrbcs/blogs/{$blog['id']}")}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            
                                           
                                            @if($blog->blog_profile == "Lenders")
                                                <a href="{{ route('lenderBlogView', ['title' =>$blog->slug]) }}" class="btn btn-sm btn-info" target="_blank" data-toggle="tooltip" data-placement="top" title="View">
                                            @elseif($blog->blog_profile == "Agents")
                                                <a href="{{ route('agentBlogView', ['title' =>$blog->slug]) }}" class="btn btn-sm btn-info" target="_blank" data-toggle="tooltip" data-placement="top" title="View">
                                            @endif
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            <form name="delete-blog" class="d-block" method="post" action="{{url('cpldashrbcs/blogs/delete')}}">
                                                <input type="hidden" name="blog_id" value="{{$blog->id}}" />
                                                <button type="submit" onclick="return confirm('Are you sure?')" name="delete_blog" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-trash"></i> </button>
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