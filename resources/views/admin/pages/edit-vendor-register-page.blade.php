@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>Vendor Register Page</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{url('cpldashrbcs/pages')}}">Pages</a></li>
            <li class="active">Vendor Register Page</li>
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

                        <form id="add-page-form" method="post" action="{{ route('admin.pages.update-register-page') }}">
                            {{csrf_field()}}

                            <!-- Banner -->
                            <div class="form-group">
                                <h4>Banner</h4>
                                <textarea id="editor1" name="banner" rows="10" cols="80">
                                    @php $banner = !is_null($getVendorRegisterPage->banner) ? $getVendorRegisterPage->banner : '' @endphp
                                    {{ $banner}}
                                </textarea>
                            </div>
                            <div class="clearfix"></div>
                            <!-- END.// Banner  -->


                            <!-- Section 1 -->
                            <div class="form-group">
                                <h4>Section 1 Header</h4>
                                <textarea class="tinyTextArea" name="sectionOneHeader" rows="10" cols="80">
                                    @php $section1Header = !is_null($getVendorRegisterPage->section_1_Header) ? $getVendorRegisterPage->section_1_Header : '' @endphp
                                    {{ $section1Header}}
                                </textarea>
                            </div>
                            <div class="clearfix"></div>
                            
                            
                            <div class="addNewSections mb-2">
                                @if (isset($getVendorRegisterPage->section_1))
                                    @php
                                        $section1Array = (array) json_decode($getVendorRegisterPage->section_1, true);
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

                            <div class="text-center mb-2"><button type="button" class="btn btn-primary" id="addSubSections">Add New Sub Section</button></div>
                            
                            <!-- END.// Section 1  -->


                            <!-- Section 2 -->
                            <div class="form-group">
                                <h4>Section 2</h4>
                                <textarea id="editor11" name="section2" rows="10" cols="80">
                                    @php $section2 = !is_null($getVendorRegisterPage->section_2) ? $getVendorRegisterPage->section_2 : '' @endphp
                                    {{ $section2 }}
                                </textarea>
                            </div>
                            <div class="clearfix"></div>
                            <!-- END.// Section 2  -->

                            <div class="box-footer">
                                <input type="hidden" name="page" value="vendor" />
                                <button type="submit" class="btn btn-primary pull-right">Update</button>
                            </div>
                         </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection