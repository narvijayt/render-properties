@extends('admin.layouts.main')
@section('content')
@inject('states', 'App\Http\Utilities\Geo\USStates')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Update Vendor</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Update Vendor</li>
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
                        <input type="hidden" name="id" value="{{$users->user_id}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="col-md-6 {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="fname">First Name</label>
                                <input id="fname" type="text" class="form-control" name="first_name"
                                    value="{{$users->first_name}}" required>
                                <span class="help-block">
                                    @if ($errors->has('first_name'))
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                    @endif
                                </span>
                            </div>
                            <div class="col-md-6 {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="lname">Last Name</label>
                                <input id="lname" type="text" class="form-control" name="last_name"
                                    value="{{$users->last_name}}" required>
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
                                <input id="cname" type="text" class="form-control" name="company_name"
                                    value="{{$users->firm_name}}" required>
                                @if ($errors->has('company_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('company_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6 {{ $errors->has('website') ? ' has-error' : '' }}">
                                <label for="website">Website</label>
                                <input id="website" type="text" class="form-control" name="website"
                                    value="{{$users->website}}">
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
                                <input id="emailaddvend" type="text" class="form-control" name="email"
                                    value="{{$users->email}}" required>
                                <p id="email_vendors_error" class="error"></p>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6 {{ $errors->has('phone_no') ? ' has-error' : '' }}">
                                <label for="website">Phone No</label>
                                <input id="phone_vendor_no_vendor" type="phone_no" class="form-control" name="phone_no"
                                    value="{{$users->phone_number}}" required>
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
                                <textarea rows="2" cols="20" class="form-control" name="vendor_coverage_units"
                                    required>@if(count($vendorDet) > 0 ){{$vendorDet[0]->vendor_coverage_area}}@endif</textarea>
                                @if ($errors->has('vendor_coverage_units'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('vendor_coverage_units') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <?php 
                          if(count($allCat) > 0){
                              $category = $allCat['category'];
                              $allcategory = explode(',',$category);
                           }
                          ?>
                        <div class="box-body">
                            <div class="col-md-12 form-group">
                                <label for="langOpt">What Industry are you in?</label> </br>
                                <select name="select_category[]"
                                    class="form-control {{ $errors->has('select_category[]') ? ' has-error' : '' }}"
                                    id="multSelCat" multiple required>
                                    @foreach($allcat as $categoryVendor)
                                    <option value="{{$categoryVendor->id}}" @if(in_array($categoryVendor->id,
                                        $allcategory))selected @endif>{{$categoryVendor->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('select_category[]'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('select_category[]') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        @if(count($allCat)>0)
                        @if(in_array('19', $allcategory))
                        @if($allCat['description'] !="" && $allCat['description'] !="NULL")
                        <div class="box-body">
                            <div class="col-md-12 form-group {{ $errors->has('other_description') ? 'has-error' : '' }}"
                                id="otherDesc">
                                <label class="control-label" for="bio">
                                    @if($errors->has('other_description'))<i class="fa fa-times-circle-o"></i>@endif
                                    Other Industry Description
                                </label>
                                <input type="text" class="form-control" name="other_description"
                                    value="{{$allCat['description']}}" id="deafult_desc" required>
                                @if($errors->has('other_description'))
                                <span class="help-block">{{ $errors->first('other_description') }}</span>
                                @endif
                            </div>
                        </div>
                        @endif
                        @endif
                        <div class="box-body">
                            <div class="col-md-12 form-group {{ $errors->has('other_description') ? 'has-error' : '' }}"
                                id="AdditionalDesc" style="display:none">
                                <label class="control-label" for="bio">
                                    @if($errors->has('other_description'))<i class="fa fa-times-circle-o"></i>@endif
                                    Other Industry Description
                                </label>
                                <input type="text" class="form-control" name="other_description_optional"
                                    Placeholder="Other Industry Description" id="inputAdditional">
                                @if($errors->has('other_description'))
                                <span class="help-block">{{ $errors->first('other_description') }}</span>
                                @endif
                            </div>
                            <div>
                                @endif
                                <div class="box-body">
                                    <div
                                        class="col-md-12 form-group {{ $errors->has('services') ? ' has-error' : '' }}">
                                        <label for="services">What services do you offer?</label>
                                        <textarea rows="2" cols="3" class="form-control" id="services" name="services"
                                            required>@if(count($vendorDet) > 0 ){{$vendorDet[0]->vendor_service}}@endif</textarea>
                                        @if ($errors->has('services'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('services') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div
                                        class="col-md-12 form-group {{ $errors->has('short_description') ? ' has-error' : '' }}">
                                        <label for="shotDesc">Short Description</label>
                                        <textarea rows="2" cols="3" class="form-control" id="shotDesc"
                                            name="short_description" placeholder="Enter Short Description"
                                            required>@if($users->bio !="" && $users->bio !='null'){{$users->bio}}@endif</textarea>
                                        @if ($errors->has('short_description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('short_description') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-12 form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                        <label for="state" class="control-label">State</label>
                                        <select id="editProfileState" class="form-control" name="state" required>
                                            <option value="">Choose a state</option>
                                            @foreach($states::all() as $abbr => $stateName)
                                            <option value="{{ $abbr }}" @if ($abbr==$users->state) selected
                                                @endif>{{ $stateName }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('state'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('state') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <input type="hidden" name="profile_city" id="previous_city"
                                        value="{{ old('city', (isset($user->city) ? $user->city : '')) }}">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                            <label class="control-label" for="city">
                                                @if($errors->has('city'))<i class="fa fa-times-circle-o"></i>@endif City
                                            </label>
                                            <input type="text" name="city" class="form-control" id="newProfileCity"
                                                value="{{$users->city}}" placeholder="Enter City" required>
                                            @if ($errors->has('city'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group" id="another-city">
                                            <input type="hidden" name="anotherCity" placeholder="Add another city"
                                                class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('zip') ? 'has-error' : '' }}">
                                            <label class="control-label" for="zip">
                                                @if($errors->has('zip'))<i class="fa fa-times-circle-o"></i>@endif Zip
                                            </label>
                                            <input type="text" class="form-control" placeholder="Enter Zip Code"
                                                name="zip" value="{{$users->zip}}" />
                                            @if($errors->has('zip'))
                                            <span class="help-block">{{ $errors->first('zip') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Payment Status</label>
                                            <select class="form-control" id="payment_status" name="payment_status">
                                                <option value="1" @if($users->payment_status == 1) selected @endif>Paid</option>
                                                <option value="0" @if($users->payment_status == 0) selected @endif>Unpaid</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Upload Your Advertisement ArtWork</label>
                                        <div class="full editp">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <a href="javascript:uploadBannerImage()"
                                                        style="text-decoration: none;" class="btn btn-warning">
                                                        <i class="fa fa-edit"></i> Browse File </a>&nbsp;&nbsp;
                                                </div>
                                            </div>
                                            <div id="image">
                                                @if(count($findBanner) > 0 )
                                                <?php  $ext = pathinfo($findBanner[0]->banner_image, PATHINFO_EXTENSION);
                        					    if($ext == 'pdf'){ ?>
                                                <img width="20%" height="20%" id="uploaded_preview_image"
                                                    src="{{URL::to('/banner/')}}/preview_{{$ext}}.png" />
                                                <?php }else{ ?>
                                                <img width="20%" height="20%" id="uploaded_preview_image"
                                                    src="{{URL::to('/banner/')}}/{{$findBanner[0]->banner_image}}" />
                                                <?php } ?>
                                                @endif
                                                <img width="100%" height="100%" id="uploaded_preview_image"
                                                    src="{{asset('attach-1.png')}}" style="display:none;" />
                                                <i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw"
                                                    style="position: absolute;left: 40%;top: 40%;display: none"></i>
                                            </div>
                                            <input type="file" id="uploadFile" style="display: none" />
                                            <input type="hidden" name="file_name" id="file_name_uploaded" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary btn-block" id="regVend">Update</button>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/jquery-2.2.4.min.js')}}"></script>
<script type="text/javascript">
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
                j('#uploaded_preview_image').attr('src', '{{URL::to(' / public / attach - 1. png ')}}');
                alert(data.errors['file']);
            } else {
                var ext = data.split('.').pop();
                if (ext == 'pdf') {
                    j('#file_name_uploaded').val(data);
                    j('#uploaded_preview_image').css('display', 'block');
                    j('#uploaded_preview_image').attr('src', '{{URL::to(' / banner / ')}}/' +
                        'preview_pdf.png');
                } else {
                    j('#file_name_uploaded').val(data);
                    j('#uploaded_preview_image').css('display', 'block');
                    j('#uploaded_preview_image').attr('src', '{{URL::to(' / banner / ')}}/' + data);
                }
            }
            j('#loading').css('display', 'none');
        },
        error: function(xhr, status, error) {
            alert(xhr.responseText);
            j('#uploaded_preview_image').attr('src', '{{URL::to(' / public / attach - 1. png ')}}');
        }
    });
}

j('#multSelCat').on('change', function() {
    var selected = j(this).find("option:selected");
    var arrSelected = [];
    selected.each((idx, val) => {
        arrSelected.push(val.value);
    });
    if (j.inArray('19', arrSelected) >= 0) {
        var description = j('#deafult_desc').val();
        if (typeof description === "undefined") {
            j('#AdditionalDesc').css('display', 'block');
            j('#inputAdditional').css('display', 'block');
        } else {
            j('#AdditionalDesc').css('display', 'none');
            j('#inputAdditional').val('');
            j('#inputAdditional').css('display', 'none');
            j('#otherDesc').css('display', 'block');
        }
    } else {
        j('#AdditionalDesc').css('display', 'none');
        j('#inputAdditional').val('');
        j('#inputAdditional').css('display', 'none');
        j('#otherDesc').css('display', 'none');
    }
});
j('#deafult_desc').keypress(function() {
    var txtVal = this.value;
    j('#deafult_desc').val(txtVal);
});
</script>
@endsection