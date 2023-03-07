@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>View Testimonial</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{url('cpldashrbcs/testimonials')}}">Testimonials</a></li>
            <li class="active">Show</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary profile_box">
                    <div class="col-md-2 col-sm-2 col-md-12 ">
                        <div class="img_box">
                            @php echo html_entity_decode($testimonial->image); @endphp
                        </div>
                    </div>
                    <div class="col-md-10 col-sm-10 col-md-12 ">
                        <div class="testi-name">
                            <h2>{{ucfirst($testimonial->name)}}</h2>
                            <span>Date: {{date('d M, Y',strtotime($testimonial['updated_at']))}}</span>
                            <p>
                                @php echo html_entity_decode($testimonial->description); @endphp
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
