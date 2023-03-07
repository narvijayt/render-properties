@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>{{$title}} Page</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{url('cpldashrbcs/pages')}}">Pages</a></li>
            <li class="active">Edit</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body pad">
                        <form id="add-page-form" method="post" action="{{url('cpldashrbcs/pages/update')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$page_id}}"/>
                            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                <h4>Title</h4>
                                <input type="text" class="form-control" id="title" name="title" value="{{ucfirst($title)}}"/>
                                <span id="pages-error"></span>
                            </div>
                            <div class="form-group">
                                @if(Request::segment(3) == 'register')
                                    <h4>Lender Content</h4>
                                @else
                                    <h4>Banner</h4>
                                @endif
                                <textarea id="editor1" name="header" rows="10" cols="80">
                                   @php echo html_entity_decode($pages->header); @endphp
                                </textarea>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group ">
                                @if(Request::segment(3) == 'register')
                                    <h4>Realtor Content</h4>
                                @else
                                    <h4>Section1</h4>
                                @endif
                                <textarea id="editor2" name="content" rows="10" cols="80">
                                    @php echo html_entity_decode($pages->content); @endphp
                                </textarea>
                            </div>
                            <div class="form-group">
                                @if(Request::segment(3) == 'register')
                                    <h4>Default Image / Content</h4>
                                @else
                                    <h4>Section2</h4>
                                @endif
                                <textarea id="editor3" name="footer" rows="10" cols="80">
                                    @php echo html_entity_decode($pages->footer); @endphp
                                </textarea>
                            </div>
                            <div class="clearfix"></div>
                            <h4>Seo</h4>
                             <div class="form-group">
                                @if(Request::segment(3) == 'register')
                                    <h4>Meta Keyword</h4>
                                @else
                                    <h4>Meta Keyword</h4>
                                @endif
                            <input type="text" class="form-control" id="meta-keyword" name="meta_keyword" value="{{$keyword}}" placeholder="Enter Meta Keyword"/>
                                <span id="pages-error"></span>
                            </div>
                            <div class="form-group">
                                @if(Request::segment(3) == 'register')
                                    <h4>Meta Description</h4>
                                @else
                                    <h4>Meta Description</h4>
                                @endif
                            <textarea id="editor4" name="meta_description" rows="10" cols="80" placeholder="Enter Meta Description">
                                    @php echo html_entity_decode($description); @endphp
                                </textarea>
                                <span id="pages-error"></span>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary pull-right">Update</button>
                            </div>
                         </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection