@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Edit Testimonial</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{url('cpldashrbcs/testimonials')}}">Testimonials</a></li>
                <li class="active">Edit</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-10">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-name">Edit Testimonial</h3>
                        </div>
                        <form id="add-testimonial-form" method="post" action="{{url('cpldashrbcs/testimonials/update')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$testimonial->id}}"/>
                            <div class="box-body">
                                <div class="form-group">
                                    <h4>Name</h4>
                                    <input type="text" class="form-control" id="testmonial-name" name="name" value="{{$testimonial->name}}"/>
                                </div>
                               <div id="desc" class="hidden">
                                   @php echo html_entity_decode($testimonial->description); @endphp
                               </div>
                                <div class="form-group">
                                    <h4>Description</h4>
                                    <textarea id="text-desc" name="description" rows="10" cols="80" class="form-control">
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <h4>Image</h4>
                                    <textarea id="text-image" name="image" rows="10" cols="80">
                                        @php echo html_entity_decode($testimonial->image); @endphp
                                    </textarea>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary pull-right">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
<script src="{{asset('js/admin/jquery/jquery.min.js')}}"></script>
<script>
    $(document).ready(function(){
       var spantxt = $('#desc p').text();
       $('#text-desc').val(spantxt);
    });
</script>
