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
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('success') }}</p>
                        @endif

                        @if(session()->has('error'))
                            <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
                        @endif

                        <form id="add-page-form" method="post" action="{{ route('admin.pages.update-home-page') }}">
                            {{csrf_field()}}

                            <!-- Banner -->
                            <div class="form-group">
                                <h4>Banner</h4>
                                <textarea id="editor1" name="banner" rows="10" cols="80">
                                    @php $banner = !is_null($getHomePage->banner) ? $getHomePage->banner : '' @endphp
                                    {{ $banner}}
                                </textarea>
                            </div>
                            <div class="clearfix"></div>
                            <!-- END.// Banner  -->


                            <!-- Section 1 -->
                            <div class="form-group ">
                                <h4>Section 1</h4>
                                <textarea id="editor2" name="section1" rows="10" cols="80">
                                    @php $section1 = !is_null($getHomePage->section_1) ? $getHomePage->section_1 : '' @endphp
                                    {{ $section1}}
                                </textarea>
                            </div>
                            <!-- END.// Section 1  -->

                            <!-- Section 2 (Sub Section 1, 2, 3 and 4) -->
                            @php
                                $section2Array = '';
                                if (!is_null($getHomePage->section_2)):
                                    $section2Array = (array) json_decode($getHomePage->section_2, true);
                                endif;
                            @endphp
                            <div class="form-group">
                                <h4>Section 2 (Sub Section 1)</h4>
                                <textarea id="editor3" name="section2[subsection1]" rows="10" cols="80">
                                    @php echo html_entity_decode($section2Array[subsection1]); @endphp
                                </textarea>
                            </div>
                            <div class="clearfix"></div>


                            <div class="form-group">
                                <h4>Section 2 (Sub Section 2)</h4>
                                <textarea id="editor4" name="section2[subsection2]" rows="10" cols="80">
                                    @php echo html_entity_decode($section2Array[subsection2]); @endphp
                                </textarea>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <h4>Section 2 (Sub Section 3)</h4>
                                <textarea id="editor5" name="section2[subsection3]" rows="10" cols="80">
                                    @php echo html_entity_decode($section2Array[subsection3]); @endphp
                                </textarea>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <h4>Section 2 (Sub Section 4)</h4>
                                <textarea id="editor6" name="section2[subsection4]" rows="10" cols="80">
                                    @php echo html_entity_decode($section2Array[subsection4]); @endphp
                                </textarea>
                            </div>
                            <div class="clearfix"></div>
                            <!-- END.// Section 2 (Sub Section 1, 2, 3 and 4)  -->



                            <!-- Section 3 (Sub Section 1, 2 and 3) -->
                            @php
                                $section3Array = '';
                                if (!is_null($getHomePage->section_3)):
                                    $section3Array = (array) json_decode($getHomePage->section_3, true);
                                endif;
                            @endphp
                            <div class="form-group">
                                <h4>Section 3 (Sub Section 1)</h4>
                                <textarea id="editor7" name="section3[subsection1]" rows="10" cols="80">
                                    @php echo html_entity_decode($section3Array[subsection1]); @endphp
                                </textarea>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <h4>Section 3 (Sub Section 2)</h4>
                                <textarea id="editor8" name="section3[subsection2]" rows="10" cols="80">
                                    @php echo html_entity_decode($section3Array[subsection2]); @endphp
                                </textarea>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <h4>Section 3 (Sub Section 3)</h4>
                                <textarea id="editor9" name="section3[subsection3]" rows="10" cols="80">
                                    @php echo html_entity_decode($section3Array[subsection3]); @endphp
                                </textarea>
                            </div>
                            <div class="clearfix"></div>
                            <!-- END.// Section 3 (Sub Section 1, 2 and 3) -->



                            <div class="form-group">
                                <h4>Section 4</h4>
                                <textarea id="editor10" name="section4" rows="10" cols="80">
                                   @php $section4 = !is_null($getHomePage->section_4) ? $getHomePage->section_4 : '' @endphp
                                    {{ $section4 }}
                                </textarea>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group">
                                <h4>Section 5</h4>
                                <textarea id="editor11" name="section5" rows="10" cols="80">
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