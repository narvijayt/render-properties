@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Vendor Register</h1>
            @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
             @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                         @endif
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Vendor Register</li>
                
             </ol>
        </section>
         
        <section class="content">
            <div class="row">
                <div class="col-md-10">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                        </div>
                        
                        <form id="registerVendor" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                             <div class="box-body">
                            <div class="col-md-6 {{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="fname">First Name</label>
                    		<input id="fname" type="text" class="form-control" name="first_name"  value="{{ old('first_name') }}" required>
                    			<span class="help-block">
                    		@if ($errors->has('first_name'))
                    			<strong>{{ $errors->first('first_name') }}</strong>
                    		@endif
                    		</span>
                        	</div>
                        	<div class="col-md-6 {{ $errors->has('last_name') ? ' has-error' : '' }}">
                        	<label for="lname">Last Name</label>
                    		<input id="lname" type="text" class="form-control" name="last_name"  value="{{ old('last_name') }}" required>
                    			<span class="help-block">
                    		@if ($errors->has('last_name'))
                    			<strong>{{ $errors->first('last_name') }}</strong>
                    		@endif
                    		</span>
                    	    </div>  
                            </div>
                            <div class="box-body">
                            <div class="col-md-6 {{ $errors->has('company_name') ? ' has-error' : '' }}">
                                <label for="cname">Company Name</label>
                            	<input id="cname" type="text" class="form-control" name="company_name"  value="{{ old('company_name') }}" required>
                            		@if ($errors->has('company_name'))
                            		<span class="help-block">
                            			<strong>{{ $errors->first('company_name') }}</strong>
                            		</span>
                            	@endif
                            </div>
                            
                               <div class="col-md-6 {{ $errors->has('website') ? ' has-error' : '' }}">
                                <label for="website">Website</label>
                            	<input id="website" type="text" class="form-control" name="website"  value="{{ old('website') }}">
                            		@if ($errors->has('website'))
                            		<span class="help-block">
                            			<strong>{{ $errors->first('website') }}</strong>
                            		</span>
                            	@endif
                            </div> 
                            </div>
                            <div class="box-body">
                             <div class="col-md-6 {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="emailaddvend">Email Address</label>
                            	<input id="emailaddvend" type="text" class="form-control" name="email"  value="{{ old('email') }}" required>
                            	<p id="email_vendors_error" class="error"></p>
                            	@if ($errors->has('email'))
                            		<span class="help-block">
                            			<strong>{{ $errors->first('email') }}</strong>
                            		</span>
                            	@endif
                            </div>
                            <div class="col-md-6 {{ $errors->has('phone_no') ? ' has-error' : '' }}">
                            <label for="website">Phone No</label>
                        	<input id="phone_vendor_no_vendor" type="phone_no" class="form-control" name="phone_no"  value="{{ old('phone_no') }}" required>
                        		<p id="phone-vendors-error" class="error"></p>
                		    @if ($errors->has('phone_number'))
                				<span class="help-block">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                			@endif
                            </div>
                           </div>
                           <div class="box-body">
                               <div class="col-md-12 {{ $errors->has('vendor_coverage_units') ? ' has-error' : '' }}">
                                    <label for="langOpt">Do you cover a City, County, State or the entire USA? </label>  
                            	<textarea rows="2" cols="20"class="form-control"  name="vendor_coverage_units" required></textarea>
                            @if ($errors->has('vendor_coverage_units'))
                            				<span class="help-block">
                                                <strong>{{ $errors->first('vendor_coverage_units') }}</strong>
                                            </span>
                            			@endif
                            </div>
                            </div>
                            <div class="box-body">
                            <link rel="stylesheet" type="text/css" href="{{ asset('multicss/example-styles.css')}}">
                            <div class="col-md-12 form-group">
                             <label for="langOpt">What Industry are you in?</label>  </br>
                            <select name="select_category[]" class="form-control {{ $errors->has('select_category[]') ? ' has-error' : '' }}" multiple id="adminMultiservice" required>
                                <option value="1">Auto</option>
                                <option value="2">Flooring</option>
                                <option value="3">Mortgage</option>
                                <option value="4">Appliance</option>
                                <option value="5">Home Warranty</option>
                                <option value="6">Moving</option>
                                <option value="7">Builder</option>
                                <option value="8">Inspection</option>
                                <option value="9">Photography</option>
                                <option value="10">Carpet Cleaning</option>
                                <option value="11">Insurance</option>
                                <option value="12">Property Management</option>
                                <option value="13">Cleaning</option>
                                <option value="14">Landscaping</option>
                                <option value="15">Roofing</option>
                                <option value="16">Crawl Spacing</option>
                                <option value="17">Locks</option>
                                <option value="18">Staging</option>
                            </select>
                            @if ($errors->has('select_category[]'))
                            		<span class="help-block">
                            			<strong>{{ $errors->first('select_category[]') }}</strong>
                            		</span>
                            	@endif
                            </div>
                            </div>
                            <div class="box-body">
                               <div class="col-md-6 {{ $errors->has('services') ? ' has-error' : '' }}">
                                   <label for="services">What services do you offer?</label>  
                                	<textarea rows="2" cols="3"class="form-control"  id="services" name="services"  required></textarea>
                                	@if ($errors->has('services'))
                                				<span class="help-block">
                                                    <strong>{{ $errors->first('services') }}</strong>
                                                </span>
                                			@endif
                                </div>
                                <div class="col-md-6 {{ $errors->has('short_description') ? ' has-error' : '' }}">
                                    <label for="shotDesc">Short Description</label>  
                                	<textarea rows="2" cols="3"class="form-control"  id="shotDesc" name="short_description"  required></textarea>
                                	@if ($errors->has('short_description'))
                                				<span class="help-block">
                                                    <strong>{{ $errors->first('short_description') }}</strong>
                                                </span>
                                			@endif
                                </div>
                            </div>
                            <div class="box-body">
                                	<div class="col-md-6 {{ $errors->has('password') ? ' has-error' : '' }}">
                                	    <label for="password">Password</label>  
                            					<input id="password" type="password" class="form-control" name="password"  value="{{ old('password') }}" required>
                            					@if ($errors->has('password'))
                            						<span class="help-block">
                            							<strong>{{ $errors->first('password') }}</strong>
                            						</span>
                            					@endif
                            				</div>
                            <div class="col-md-6 {{ $errors->has('cpassword') ? ' has-error' : '' }}">
                                <label for="cpassword">Confirm Password</label>
                            	<input id="cpassword" type="password" class="form-control" name="cpassword"  value="{{ old('cpassword') }}" required>
                            </div>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                        	    <label>Upload Your Advertisement Banner</label>
                        			<div class="full editp">
                        				<div class="form-group">
                        						<div class="checkbox">
                        							<a href="javascript:uploadBannerImage()" style="text-decoration: none;" class="btn btn-warning">
                        							<i class="fa fa-edit"></i> Browse File </a>&nbsp;&nbsp;
                        					</div>
                        					</div>
                        					<div id="image">
                        						<img width="100%" height="100%" id="uploaded_preview_image" src="{{asset('attach-1.png')}}" style="display:none;" />
                        						<i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw" style="position: absolute;left: 40%;top: 40%;display: none"></i>
                        					</div>
                        					<input type="file" id="uploadFile" style="display: none" />
                        				<input type="hidden" name="file_name" id="file_name" />
                        			</div>
                        	</div>
                        	</div>
                        	<div class="box-body">
                        	<div class="checkbox receive_checkbox">
                        	<label>
                        	<input class="rcv_email" type="checkbox" name="agree"/>
                        		<small>
                        		May our vendors contact you in regards to this program?
                        		</small>
                        	</label>
                        </div>
                      </div>
                        <div class="box-footer">
                                <button type="submit" class="btn btn-primary btn-block" id="regVend">Register</button>
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
    $('#adminMultiservice').multiSelect();
    var j = jQuery.noConflict();
    function uploadBannerImage() {
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
              url: "{{url('advertisement/banner')}}",
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
                      j('#uploaded_preview_image').attr('src', '{{URL::to('/banner/')}}/' + data);
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


