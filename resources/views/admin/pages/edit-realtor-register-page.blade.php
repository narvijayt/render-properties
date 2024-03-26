@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>Realtor Register Page</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{url('cpldashrbcs/pages')}}">Pages</a></li>
            <li class="active">Realtor Register Page</li>
        </ol>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-body pad">
                        @if(session()->has('success'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
                        @endif

                        @if(session()->has('error'))
                            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
                        @endif

                        <form id="add-page-form" method="post" action="{{url('cpldashrbcs/realtor/update')}}">
                            {{csrf_field()}}

                            <!-- Banner -->
                            <div class="form-group">
                                <h4>Banner</h4>
                                <textarea id="editor1" name="banner" rows="10" cols="80">
                                    @php $banner = !is_null($getRealtorRegisterPage->banner) ? $getRealtorRegisterPage->banner : '' @endphp
                                    {{ $banner}}
                                </textarea>
                            </div>
                            <div class="clearfix"></div>
                            <!-- END.// Banner  -->


                            <!-- Section 1 -->
                            <div class="d-flex">
                                <h4>Section 1</h4><button type="button" class="btn btn-primary" id="addSubSections">Add New Sub Section</button>
                            </div>

                            <div class="form-group">
                                <h4>Header</h4>
                                <textarea class="tinyTextArea" name="sectionOneHeader" rows="10" cols="80">
                                    @php $section1Header = !is_null($getRealtorRegisterPage->section_1_Header) ? $getRealtorRegisterPage->section_1_Header : '' @endphp
                                    {{ $section1Header}}
                                </textarea>
                            </div>
                            <div class="clearfix"></div>
                            
                            
                            <div class="addNewSections mb-2">
                                @if (isset($getRealtorRegisterPage->section_1))
                                    @php
                                        $section1Array = (array) json_decode($getRealtorRegisterPage->section_1, true);
                                        $counter = 1;
                                    @endphp

                                    @if (!empty(section1Array))
                                        @foreach ($section1Array as $key => $value)
                                            <div class="section-box form-group" key={{$key}}>
                                                <h4>Section 1 (Sub Section {{ $counter++ }})</h4>
                                                <textarea class="tinyTextArea" name="section1[]" rows="10" cols="80">{{ $value }}</textarea>
                                                <a class='btn btn-danger ms-1 remove_section_field'>Remove</a>
                                            </div>        
                                            <div class="clearfix"></div>
                                        @endforeach
                                    @endif

                                @endif
                            </div>
                            <!-- END.// Section 1  -->


                            <!-- Section 2 -->
                            <div class="form-group">
                                <h4>Section 2</h4>
                                <textarea id="editor11" name="section2" rows="10" cols="80">
                                    @php $section2 = !is_null($getRealtorRegisterPage->section_2) ? $getRealtorRegisterPage->section_2 : '' @endphp
                                    {{ $section2 }}
                                </textarea>
                            </div>
                            <div class="clearfix"></div>
                            <!-- END.// Section 2 (Sub Section 1, 2, 3 and 4)  -->

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