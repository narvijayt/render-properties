@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>New Page</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Pages</a></li>
                <li class="active">New</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-10">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Page</h3>
                        </div>
                        <form id="add-page-form" method="post" action="{{url('cpldashrbcs/pages/create')}}">
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label for="page">Title</label>
                                    <input type="text" class="form-control" id="page" name="title"/>
                                    <span id="pages-error"></span>
                                </div>
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

