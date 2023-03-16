@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Update Vendor Industry</h1>
          
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Vendor Industry</li>
                
             </ol>
        </section>
         
        <section class="content">
            <div class="row">
                <div class="col-md-10">
                       @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
             @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                         @endif
                    <div class="box box-primary">
                        <div class="box-header with-border">
                        </div>
                        <form id="registerVendor" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="industry_id" value="{{$fetchAllIndustry->id}}">
                            {{csrf_field()}}
                             <div class="box-body">
                            <div class="col-md-12 {{ $errors->has('industry_name') ? ' has-error' : '' }}">
                            <label for="fname">Industry Name</label>
                    		<input id="industryname" type="text" class="form-control" name="industry_name"  value="{{$fetchAllIndustry->name}}" required>
                    			<span class="help-block">
                    		@if ($errors->has('first_name'))
                    			<strong>{{ $errors->first('industry_name') }}</strong>
                    		@endif
                    		</span>
                        	</div>
                             <div class="box-body">
                                <div class="col-md-12">
                        	    <label>Upload Industry Featured Image</label>
                        			<div class="full editp">
                        				<div class="form-group">
                        						<div class="checkbox">
                        							<a href="javascript:uploadIndustryImage()" style="text-decoration: none;" class="btn btn-warning">
                        							<i class="fa fa-edit"></i> Browse File </a>&nbsp;&nbsp;
                        					</div>
                        					</div>
                        					<div id="image">
                        					    @if($fetchAllIndustry->file_name !="")
                        					    <img width="20%" height="20%" id="previeImg" src="{{asset('services/')}}/{{$fetchAllIndustry->file_name}}" />
                        					    @endif
                        						<img width="100%" height="100%" id="uploaded_preview_image" src="{{asset('attach-1.png')}}" style="display:none;" />
                        						<i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw" style="position: absolute;left: 40%;top: 40%;display: none"></i>
                        					</div>
                        					<input type="file" id="uploadFile" style="display: none" />
                        				<input type="hidden" name="file_name" id="file_name" />
                        			</div>
                        	</div>
                        	</div>
                        	
                        <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-block" id="regVend">Update Industry</button>
                            </div>
                        </form>
                    </div>
                </div>
             </div>
        </section>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-2.2.4.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.multi-select.js')}}"></script>
    <script type="text/javascript">
     var j = jQuery.noConflict();
    function uploadIndustryImage() {
          j('#uploadFile').click();
      }
    
      j('#uploadFile').change(function() {
          if (j(this).val() != '') {
              uploadBannerImg(this);
          }
      });
      function uploadBannerImg(img) {
          var form_data = new FormData();
          form_data.append('file', img.files[0]);
          form_data.append('_token', '{{csrf_token()}}');
          j('#loading').css('display', 'block');
          j.ajax({
              url: "{{url('cpldashrbcs/industry/file-upload')}}",
              data: form_data,
              type: 'POST',
              contentType: false,
              processData: false,
              success: function(data) {
                  if (data.fail) {
                      j('#uploaded_preview_image').attr('src', '{{URL::to('/public/attach - 1. png ')}}');
                          alert(data.errors['file']);
                  } else {
                      j('#file_name').val(data);
                      j('#uploaded_preview_image').css('display', 'block');
                      j('#uploaded_preview_image').attr('src', '{{URL::to('/services/')}}/' + data);
                  }
                  j('#loading').css('display', 'none');
              },
              error: function(xhr, status, error) {
                  alert(xhr.responseText);
                  j('#uploaded_preview_image').attr('src', '{{URL::to('/public/attach - 1.png')}}');
              }
          });
      }
      
 </script>
@endsection


