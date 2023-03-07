@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>New Testimonial</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Testimonials</a></li>
                <li class="active">New</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-10">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-name">Add Testimonial</h3>
                        </div>
                        <form id="add-testimonial-form" method="post" action="{{url('cpldashrbcs/testimonials/create')}}">
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <h4>Name</h4>
                                    <input type="text" class="form-control" id="testmonial-name" name="name"/>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                    <h4>Description</h4>
                                    <textarea id="text-description" name="description" rows="10" cols="80"></textarea>
                                </div>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                                <div class="form-group">
                                    <h4>Image</h4>
                                    <textarea id="text-image" name="image" rows="10" cols="80"></textarea>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary pull-right">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

