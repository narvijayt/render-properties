@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>Home Page</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{url('cpldashrbcs/pages')}}">Pages</a></li>
            <li class="active">Home</li>
        </ol>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body pad">
                        @if(session()->has('success'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ session()->has('success') }}</p>
                        @endif
                        <form id="add-page-form" method="post" action="{{url('cpldashrbcs/homepage/update')}}">
                            {{csrf_field()}}

                            <div class="form-group">
                                <h4>Banner</h4>
                                <textarea id="editor1" name="banner" rows="10" cols="80">
                                    @php $banner = !is_null($getHomePage->banner) ? $getHomePage->banner : '' @endphp
                                    {{ $banner}}
                                </textarea>
                            </div>

                            <div class="clearfix"></div>
                            <div class="form-group ">
                                <h4>Section 1</h4>
                                <textarea id="editor2" name="section1" rows="10" cols="80">
                                    @php $section1 = !is_null($getHomePage->section_1) ? $getHomePage->section_1 : '' @endphp
                                    {{ $section1}}
                                </textarea>
                            </div>

                            <div class="form-group">
                                <h4>Section 2</h4>
                                <textarea id="editor3" name="section2" rows="10" cols="80">
                                    @php $section2 = !is_null($getHomePage->section_2) ? $getHomePage->section_2 : '' @endphp
                                    {{ $section2 }}
                                </textarea>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <h4>Section 3</h4>
                                <textarea id="editor4" name="section3" rows="10" cols="80">
                                   @php $section3 = !is_null($getHomePage->section_3) ? $getHomePage->section_3 : '' @endphp
                                    {{ $section3 }}
                                </textarea>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <h4>Section 4</h4>
                                <textarea id="editor5" name="section4" rows="10" cols="80">
                                   @php $section4 = !is_null($getHomePage->section_4) ? $getHomePage->section_4 : '' @endphp
                                    {{ $section4 }}
                                </textarea>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <h4>Section 5</h4>
                                <textarea id="editor6" name="section5" rows="10" cols="80">
                                   @php $section5 = !is_null($getHomePage->section_5) ? $getHomePage->section_5 : '' @endphp
                                    {{ $section5 }}
                                </textarea>
                            </div>
                            <div class="clearfix"></div>

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