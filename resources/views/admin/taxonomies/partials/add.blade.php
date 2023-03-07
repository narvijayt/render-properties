@extends('admin.layouts.main')
@section('content')
    
    <section class="content-header">
        <h1>New Category</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Categories</a></li>
            <li class="active">New</li>
        </ol>
    </section>
    <section class="content">
        <form id="add-blog-form" method="post" action="{{url('cpldashrbcs/taxonomies/create')}}" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Category</h3>
                        </div>

                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="taxonomy">Title</label>
                                <input type="text" class="form-control" id="taxonomy" name="name"/>
                                <span id="taxonomies-error"></span>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description">Content</label>
                                <textarea class="form-control" name="description"></textarea>
                                <span id="taxonomies-error"></span>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                    

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </section>
    
@endsection

