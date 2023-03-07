@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>{{$title}} - Category</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{url('cpldashrbcs/taxonomies')}}">Taxonomies</a></li>
            <li class="active">Edit</li>
        </ol>
    </section>
    <section class="content">
        <form id="add-blog-form" method="post" action="{{url('cpldashrbcs/taxonomies/update')}}" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box box-info">
                        <div class="box-body pad">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$taxonomy_id}}"/>
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <h4>Title</h4>
                                <input type="text" class="form-control" id="name" name="name" value="{{ucfirst($title)}}"/>
                                <span id="taxonomies-error"></span>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                <h4>Content</h4>
                                <textarea name="description" class="form-control">@php echo $taxonomies->description; @endphp</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Update</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </section>
@endsection