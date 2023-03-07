@extends('admin.layouts.main')
@section('content')
    
    <section class="content-header">
        <h1>New Blog</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Blogs</a></li>
            <li class="active">New</li>
        </ol>
    </section>
    <section class="content">
        <form id="add-blog-form" method="post" action="{{url('cpldashrbcs/blogs/create')}}" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-9">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Blog</h3>
                        </div>
                        
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="blog">Title</label>
                                <input type="text" class="form-control" id="blog" name="title" value="{{ old('title') }}"/>
                                <span id="blogs-error"></span>
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="blog">Content</label>
                                <textarea id="editor2" name="description" rows="10" cols="80">{{ old('description') }}</textarea>
                                <span id="blogs-error"></span>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="form-group {{ $errors->has('excerpt') ? ' has-error' : '' }}">
                                <label for="blog">Excerpt</label>
                                <textarea class="form-control" name="excerpt">{{ old('excerpt') }}</textarea>
                                <span id="blogs-error"></span>
                                @if ($errors->has('excerpt'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('excerpt') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group {{ $errors->has('video_embedded_link') ? ' has-error' : '' }}">
                                <label for="blog">YouTube Video Embedded Link</label>
                                <input type="text" class="form-control" name="video_embedded_link" value="{{ old('video_embedded_link') }}" />
                                <span id="blogs-error"></span>
                                @if ($errors->has('video_embedded_link'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('video_embedded_link') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                    
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Blog Details</h3>
                        </div>

                        <div class="box-body">
                            <div class="form-group {{ $errors->has('thumbnail') ? ' has-error' : '' }}">
                                <label for="blog">Thumbnail</label>
                                <input type="file" name="thumbnail" class="form-control">

                                @if ($errors->has('thumbnail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('thumbnail') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('taxonomy') ? ' has-error' : '' }}">
                                <label for="blog">Category</label>
                                @if($taxonomies)
                                    @foreach($taxonomies as $taxonomy)
                                    <div class="radio">
                                        <label><input type="radio" name="taxonomy" value="{{$taxonomy->id}}" {{ ( old('taxonomy') && old('taxonomy')==$taxonomy->id) ? "checked" : "" }}>{{$taxonomy->name}}</label>
                                    </div>
                                    @endforeach

                                    @if ($errors->has('taxonomy'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('taxonomy') }}</strong>
                                        </span>
                                    @endif
                                @endif
                            </div>
                            
                            <div class="form-group {{ $errors->has('blog_profile') ? ' has-error' : '' }}">
                                <label for="blog">Blog Profile</label>
                                
                                <select name="blog_profile" id="blog_profile" class="form-control">
                                    <option value="">Select Blog Profile</option>
                                    <option value="Lenders" {{ old("blog_profile") == "Lenders" ? "selected" : "" }}>Mortgage Blog</option>
                                    <option value="Agents" {{ old("blog_profile") == "Agents" ? "selected" : "" }}>Real Estate Blog</option>
                                </select>
                                

                                @if ($errors->has('blog_profile'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('blog_profile') }}</strong>
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

