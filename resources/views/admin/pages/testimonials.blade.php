@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <a href="{{url('cpldashrbcs/testimonials/new')}}">
            <button class="btn btn-success pages-btn">
                Add Testimonial  <i class="fa fa-plus-circle"></i>
            </button>
        </a>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Testimonials</a></li>
            <li class="active">All Testimonial</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List</h3>
                    </div>
                    <div class="box-body">
                        <div id="dlt-msg" class="alert alert-success" style="display:none;"></div>
                        <table id="realor_table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($testimonials) && !empty($testimonials))
                                @php $i = 1; @endphp
                                @foreach($testimonials as $testimonial)
                                    <tr class="row_<?= $testimonial['id']; ?>">
                                        <td>{{$i++}}</td>
                                        <td>{{ucwords($testimonial['name'])}}</td>
                                        <td>@php echo substr(html_entity_decode($testimonial['description']), 0,200) @endphp ...</td>
                                        <td>
                                            <div class="testi-img">
                                                @php echo html_entity_decode($testimonial['image']) @endphp
                                            </div>
                                        </td>
                                        <td>{{date('d M, Y',strtotime($testimonial['updated_at']))}}</td>
                                        <td>
                                            <a href="{{url("cpldashrbcs/testimonial/edit/{$testimonial['id']}")}}" class="edit-icon" data-toggle="tooltip" data-placement="top" title="Edit Testimonial">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="delete-icon" data-toggle="tooltip" data-placement="top" title="Delete Testimonial" onclick="deleteTestimonial(<?= $testimonial['id'] ?>)">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            <a href="{{url("cpldashrbcs/testimonial/{$testimonial['id']}")}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View Testimonial">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>No Records Found.</tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection