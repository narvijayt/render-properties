@inject('states', 'App\Http\Utilities\Geo\USStates')
<div class="form-group {{ $errors->has('bio') ? 'has-error' : '' }}">
    <label class="control-label" for="bio">
        @if($errors->has('bio'))<i class="fa fa-times-circle-o"></i>@endif Bio
    </label>
    <textarea type="text" class="form-control" placeholder="Enter a short biography" name="bio" rows=10>{{ old('bio', (isset($user->bio) ? $user->bio : '')) }}</textarea>
    @if($errors->has('bio'))
        <span class="help-block">{{ $errors->first('bio') }}</span>
    @endif
</div>

@if(auth()->user()->user_type == 'vendor')
 @if(count($vendorDet) != 0)
  @foreach($vendorDet as $vendorDetails)
<input type="hidden" name="vendor_id" value="{{$vendorDetails->user_id}}">
<div class="form-group {{ $errors->has('vendor_coverage_units') ? 'has-error' : '' }}">
    <label class="control-label" for="vendor_coverage_units">
        @if($errors->has('vendor_coverage_units'))<i class="fa fa-times-circle-o"></i>@endif Do you cover a City, County, State or the entire USA?
    </label>
    <textarea type="text" class="form-control" placeholder="Do you cover a City, County, State or the entire USA?" name="vendor_coverage_units" rows=2 required>{{ old('bio', (isset($vendorDetails->vendor_coverage_area) ? $vendorDetails->vendor_coverage_area : '')) }}</textarea>
    @if($errors->has('vendor_coverage_units'))
        <span class="help-block">{{ $errors->first('vendor_coverage_units') }}</span>
    @endif
</div>


<div class="form-group {{ $errors->has('services') ? 'has-error' : '' }}">
    <label class="control-label" for="services">
        @if($errors->has('services'))<i class="fa fa-times-circle-o"></i>@endif What services do you offer? 
    </label>
    <textarea type="text" class="form-control" placeholder="What services do you offer? " name="services" rows=2 required>{{ old('bio', (isset($vendorDetails->vendor_service) ? $vendorDetails->vendor_service : '')) }}</textarea>
    @if($errors->has('services'))
        <span class="help-block">{{ $errors->first('services') }}</span>
    @endif
</div>
    @endforeach
    @if(count($category)>0)
   <div class="form-group {{ $errors->has('selectcategory[]') ? 'has-error' : '' }}">
       <label class="control-label" for="selectcat">
        @if($errors->has('selectcategory[]'))<i class="fa fa-times-circle-o"></i>@endif What Industry are you in?  
    </label>
<select name="selectcategory[]" class="form-control {{ $errors->has('selectcategory[]') ? ' has-error' : '' }}" multiple required>
    @foreach($allcat as $categoryVendor)
     <option value="{{$categoryVendor->id}}" @if(in_array($categoryVendor->id, $category['category']))selected @endif>{{$categoryVendor->name}}</option>
    @endforeach
</select>
@if ($errors->has('selectcategory[]'))
		<span class="help-block">
			<strong>{{ $errors->first('selectcategory[]') }}</strong>
		</span>
	@endif
</div>
  @endif
  @endif
 @endif
 
 @if(auth()->user()->user_type == 'vendor')
  @if(count($category)>0)
  @if(in_array('19', $category['category']))
  @if($category['description'] !="" && $category['description'] !="NULL")
  <div class="form-group {{ $errors->has('other_description') ? 'has-error' : '' }}" id="firstDesc">
    <label class="control-label" for="bio">
        @if($errors->has('other_description'))<i class="fa fa-times-circle-o"></i>@endif Other Industry Description
    </label>
    <input type="text" class="form-control" name="other_description" value="{{$category['description']}}" id="desc_first" required>
    @if($errors->has('other_description'))
        <span class="help-block">{{ $errors->first('other_description') }}</span>
    @endif
</div>
 @endif
@endif
 <div class="form-group {{ $errors->has('other_description') ? 'has-error' : '' }}" id="OtherDescription" style="display:none">
    <label class="control-label" for="bio">
        @if($errors->has('other_description'))<i class="fa fa-times-circle-o"></i>@endif Other Industry Description
    </label>
    <input type="text" class="form-control" name="other_description_optional" Placeholder="Other Industry Description" id="otherIndustryDesc">
    @if($errors->has('other_description'))
        <span class="help-block">{{ $errors->first('other_description') }}</span>
    @endif
</div>
@endif

  @endif

@if(auth()->user()->user_type != 'vendor')
    @if(auth()->user()->user_type == 'realtor')
    {{--
        <div class="form-group {{ $errors->has('specialties') ? 'has-error' : '' }}">
            <label class="control-label" for="specialties">
                @if($errors->has('specialties'))<i class="fa fa-times-circle-o"></i>@endif Do you work with commercial buyers?    
            </label>
    		<input type="text" class="form-control" placeholder="Do you work with commercial buyers?" name="specialties" value="{{ $user->specialties }}" required>
    		@if($errors->has('specialties'))
                <span class="help-block">{{ $errors->first('specialties') }}</span>
            @endif
        </div>
    --}}
	@else
	    <div class="form-group {{ $errors->has('specialties') ? 'has-error' : '' }}">
            <label class="control-label" for="specialties">
                @if($errors->has('specialties'))<i class="fa fa-times-circle-o"></i>@endif Specialties    
            </label>
		    <input type="text" class="form-control" placeholder="Specialties" name="specialties" value="{{ $user->specialties }}">
            @if($errors->has('specialties'))
                <span class="help-block">{{ $errors->first('specialties') }}</span>
            @endif
        </div>
    @endif
@endif

@if(auth()->user()->user_type != null)
    @if(auth()->user()->user_type != 'broker'  && auth()->user()->user_type != 'realtor' && auth()->user()->user_type != 'vendor')
        <div class="form-group{{ $errors->has('units_closed_monthly') ? ' has-error' : '' }}">
            <label class="control-label" for="units_closed_monthly">
                @if($errors->has('units_closed_monthly'))<i class="fa fa-times-circle-o"></i>@endif Number of Units Closed Monthly
            </label>
            <select class="form-control" name="units_closed_monthly" id="units_closed_monthly">
                @php
                    $selected = '';
                    $selected1 = '';
                    $selected2 = '';
                @endphp
                @if($user->units_closed_monthly === '0-5')
                    @php $selected = 'selected'; @endphp
                @elseif($user->units_closed_monthly === "6-10")
                    @php $selected1 = 'selected'; @endphp
                @elseif($user->units_closed_monthly === '20+')
                    @php $selected2 = 'selected'; @endphp
                @endif
                 <option value="">Select Unit Closed Monthly</option>
                <option value="0-5" {{$selected}}>0 - 5</option>
                <option value="6-10" {{$selected1}}>6 - 10</option>
                <option value="20+" {{$selected2}}>20+</option>
            </select>
            @if ($errors->has('units_closed_monthly'))
                <span class="help-block">
                    <strong>{{ $errors->first('units_closed_monthly ') }}</strong>
                </span>
            @endif
        </div>
		@else
			<input type="hidden" name="units_closed_monthly"/>
	    @endif
@if(auth()->user()->user_type != 'vendor' && auth()->user()->user_type != 'broker')

        {{--
        <div class="form-group{{ $errors->has('volume_closed_monthly') ? ' has-error' : '' }}">
            <label class="control-label" for="volume_closed_monthly">
                @if($errors->has('volume_closed_monthly'))<i class="fa fa-times-circle-o"></i>@endif Buyer Side Transactions closed in the last 12 months
            </label>
            <select class="form-control" name="volume_closed_monthly" id="volume_closed_monthly">
                @if(!isset($user->volume_closed_monthly))
                    <option value="">Select Buyer Side Transcttion</option>
                @endif
                <option value="0-5" {{(isset($user->volume_closed_monthly)) && $user->volume_closed_monthly == '0-5' ? 'selected' : ''}}>0-5 Transactions</option>
                <option value="6-12" {{(isset($user->volume_closed_monthly)) && $user->volume_closed_monthly == '6-12' ? 'selected' : ''}}>6-12 Transactions </option>
                <option value="12-20" {{(isset($user->volume_closed_monthly)) && $user->volume_closed_monthly == '12-20' ? 'selected' : ''}}>12-20 Transactions</option>
                <option value="20+" {{(isset($user->volume_closed_monthly)) && $user->volume_closed_monthly == '20+' ? 'selected' : ''}}>20+ Transactions</option>
            </select>
            @if ($errors->has('volume_closed_monthly'))
                <span class="help-block">
                    <strong>{{ $errors->first('volume_closed_monthly') }}</strong>
                </span>
            @endif
        </div>
        --}}
        
        <div class="form-group{{ $errors->has('how_long_realtor') ? ' has-error' : '' }}">
            <label class="control-label" for="how_long_realtor">
                @if($errors->has('how_long_realtor'))<i class="fa fa-times-circle-o"></i>@endif How long have you been a Realtor?
            </label>
            <input type="text" class="form-control" placeholder="How long have you been a Realtor?" name="how_long_realtor" value="{{ $user->how_long_realtor }}">
        </div>    
        @endif
@endif
<!---Previous City Text Input----->
<!----<div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
    <label class="control-label" for="city">
        @if($errors->has('city'))<i class="fa fa-times-circle-o"></i>@endif City
    </label>
    <input type="text" class="form-control" placeholder="Enter City" name="city" value="{{ old('city', (isset($user->city) ? $user->city : '')) }}">
    @if($errors->has('city'))
        <span class="help-block">{{ $errors->first('city') }}</span>
    @endif
</div>-->
<!---End Previous City Text Input Section--->

<!----Latest City Drop Down------->

 <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
            <label for="state" class="control-label">State</label>
            <select id="editProfileState" class="form-control" name="state" required>
                <option value="">Choose a state</option>
                @foreach($states::all() as $abbr => $stateName)
                    <option value="{{ $abbr }}" {{
                        collect(old('state', (isset($user->state) ? $user->state : null)))->contains($abbr) ? 'selected' : ''
                    }}>{{ $stateName }}</option>
                @endforeach
            </select>
            @if ($errors->has('state'))
                <span class="help-block">
                    <strong>{{ $errors->first('state') }}</strong>
                </span>
            @endif
        </div>

<div class="row">
    <input type="hidden" name="profile_city" id="previous_city" value="{{ old('city', (isset($user->city) ? $user->city : '')) }}">  
 <div class="col-md-7">
    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
        <label class="control-label" for="city">
               @if($errors->has('city'))<i class="fa fa-times-circle-o"></i>@endif City
    </label>
    <!---Old city dropdown field --> 
      	<!----<select class="form-control" name="city" id="editProfilecity" required>
		<option value="">Select City</option>
    	</select>-->
    <!--End City Dropdown ---->
	 <input type="text" name="city" class="form-control" id="newProfileCity" value="{{ old('city', (isset($user->city) ? $user->city : '')) }}" placeholder="Enter City" required>
	@if ($errors->has('city'))
		<span class="help-block">
			<strong>{{ $errors->first('city') }}</strong>
		</span>
	@endif
</div>
<div class="form-group" id="another-city">
<input type="hidden" name="anotherCity" placeholder="Add another city"  class="form-control" />
</div>
</div>

<!---End City Drop Down --->

<!-----Previous State DropDown---->
    <!---<div class="col-md-7">
        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
            <label for="state" class="control-label">State</label>
            <select class="form-control" name="state" required>
                <option value="">Choose a state</option>
                @foreach($states::all() as $abbr => $stateName)
                    <option value="{{ $abbr }}" {{
                        collect(old('state', (isset($user->state) ? $user->state : null)))->contains($abbr) ? 'selected' : ''
                    }}>{{ $stateName }}</option>
                @endforeach
            </select>
            @if ($errors->has('state'))
                <span class="help-block">
                    <strong>{{ $errors->first('state') }}</strong>
                </span>
            @endif
        </div>
    </div>-->
    
    <!---End Previous State Drop Down-->
    <div class="col-md-5">
        <div class="form-group {{ $errors->has('zip') ? 'has-error' : '' }}">
            <label class="control-label" for="zip">
                @if($errors->has('zip'))<i class="fa fa-times-circle-o"></i>@endif Zip
            </label>
            <input type="text" class="form-control" placeholder="Enter Zip Code" name="zip" value="{{ old('zip', (isset($user->zip) ? $user->zip : '')) }}" />            @if($errors->has('zip'))
                <span class="help-block">{{ $errors->first('zip') }}</span>
            @endif
        </div>
    </div>
    
    @if(auth()->user()->user_type == 'realtor')
    
    <div class="col-md-12">

    <div class="form-group {{ $errors->has('referral_fee_acknowledged') ? 'has-error' : '' }}">
            <label class="control-label">
                @if($errors->has('referral_fee_acknowledged'))<i class="fa fa-times-circle-o"></i>@endif 
                Are you interested in working with Render home buyer leads with zero upfront fees and paying a 17% referral at closing for buyer leads?
            </label>
        	<div class="radio fancy_radio">
        		<div class="input-radio-group">
            		<label class="radio-inline">
            		    <input id="referral_fee_acknowledged_yes" class="form-control" type="radio" name="referral_fee_acknowledged" value="Yes" @if (isset($user->referral_fee_acknowledged) && $user->referral_fee_acknowledged == "Yes") checked="checked" @endif /> <span>Yes</span>
            		</label>
            		<label class="radio-inline">
            		    <input id="referral_fee_acknowledged_no" class="form-control" type="radio" name="referral_fee_acknowledged" value="No" @if (isset($user->referral_fee_acknowledged) && $user->referral_fee_acknowledged == "No") checked="checked" @endif /><span>No</span>
            		</label>
        		</div>
        	</div>
        	 @if($errors->has('rbc_free_marketing'))
                <span class="help-block">{{ $errors->first('rbc_free_marketing') }}</span>
            @endif
        </div>
        
        {{--
        <div class="form-group {{ $errors->has('rbc_free_marketing') ? 'has-error' : '' }}">
            <label class="control-label">
                @if($errors->has('rbc_free_marketing'))<i class="fa fa-times-circle-o"></i>@endif Are you interested in working with free buyer leads as these can help expand your network and potentially increase your business opportunities?
            </label>
        	<div class="radio fancy_radio">
        		<div class="input-radio-group">
            		<label class="radio-inline">
            		    <input id="rbc_free_marketing_yes" class="form-control" type="radio" name="rbc_free_marketing" value="Yes" @if (isset($user->rbc_free_marketing) && $user->rbc_free_marketing == "Yes") checked="checked" @endif /> <span>Yes</span>
            		</label>
            		<label class="radio-inline">
            		    <input id="rbc_free_marketing_no" class="form-control" type="radio" name="rbc_free_marketing" value="No" @if (isset($user->rbc_free_marketing) && $user->rbc_free_marketing == "No") checked="checked" @endif /><span>No</span>
            		</label>
        		</div>
        	</div>
        	 @if($errors->has('rbc_free_marketing'))
                <span class="help-block">{{ $errors->first('rbc_free_marketing') }}</span>
            @endif
        </div>
        
        
        
        
        <div class="form-group">
            <label class="control-label">
                @if($errors->has('open_to_lender_relations'))<i class="fa fa-times-circle-o"></i>@endif Are you open to new lender relationships that will benefit your business?
            </label>
        	<div class="radio fancy_radio">
        		<div class="input-radio-group">
            		<label class="radio-inline">
            		    <input id="open_to_lender_relations_yes" class="form-control" type="radio" name="open_to_lender_relations" value="Yes" @if (isset($user->open_to_lender_relations) && $user->open_to_lender_relations == "Yes") checked="checked" @endif /> <span>Yes</span>
            		</label>
            		<label class="radio-inline">
            		    <input id="open_to_lender_relations_no" class="form-control" type="radio" name="open_to_lender_relations" value="No" @if (isset($user->open_to_lender_relations) && $user->open_to_lender_relations == "No") checked="checked" @endif /><span>No</span>
            		</label>
        		</div>
        	</div>
        </div>
        
        
        <div class="form-group">
            <label class="control-label">
                @if($errors->has('co_market'))<i class="fa fa-times-circle-o"></i>@endif Would you like to find a loan officer to co-market with Zillow, Realtor.com or other lead sources with you?
            </label>
        	<div class="radio fancy_radio">
        		<div class="input-radio-group">
            		<label class="radio-inline">
            		    <input id="co_market_yes" class="form-control" type="radio" name="co_market" value="Yes" @if (isset($user->co_market) && $user->co_market == "Yes") checked="checked" @endif /> <span>Yes</span>
            		</label>
            		<label class="radio-inline">
            		    <input id="co_market_no" class="form-control" type="radio" name="co_market" value="No" @if (isset($user->co_market) && $user->co_market == "No") checked="checked" @endif /><span>No</span>
            		</label>
        		</div>
        	</div>
        </div>
        --}}
        
        
        <div class="form-group-row">
            <label class="control-label">
            @if($errors->has('contact_me_for_match'))<i class="fa fa-times-circle-o"></i>@endif 
                Render referral fees are low because Render matches our loan officer members with Realtor members. Can our loan officers contact you to see if you would be a match to work together?
            </label>
        	<div class="radio fancy_radio">
        		<div class="input-radio-group">
            		<label class="radio-inline">
            		    <input id="contact_me_for_match_yes" class="form-control" type="radio" name="contact_me_for_match" value="Yes" @if (isset($user->contact_me_for_match) && $user->contact_me_for_match == "Yes") checked="checked" @endif > <span>Yes</span>
            		</label>
            		<label class="radio-inline">
            		    <input id="contact_me_for_match_no" class="form-control" type="radio" name="contact_me_for_match" value="No" @if (isset($user->contact_me_for_match) && $user->contact_me_for_match == "No") checked="checked" @endif ><span>No</span>
            		</label>
        		</div>
        	</div>
        </div>
        
        <div class="form-group-row">
            <label class="control-label">
                @if($errors->has('open_to_lender_relations'))<i class="fa fa-times-circle-o"></i>@endif 
                Are you open to new lender relationships that will benefit your business?
            </label>
        	<div class="radio fancy_radio">
        		<div class="input-radio-group">
            		<label class="radio-inline">
            		    <input id="open_to_lender_relations_yes" class="form-control" type="radio" name="open_to_lender_relations" value="Yes" @if (isset($user->open_to_lender_relations) && $user->open_to_lender_relations == "Yes") checked="checked" @endif > <span>Yes</span>
            		</label>
            		<label class="radio-inline">
            		    <input id="open_to_lender_relations_no" class="form-control" type="radio" name="open_to_lender_relations" value="No" @if (isset($user->open_to_lender_relations) && $user->open_to_lender_relations == "No") checked="checked" @endif ><span>No</span>
            		</label>
        		</div>
        	</div>
        </div>
        
        <div class="form-group-row">
            <label class="control-label">
                @if($errors->has('lo_matching_acknowledged'))<i class="fa fa-times-circle-o"></i>@endif 
                I understand that I have to match with a Render Loan Officer to be part of the home buyer leads program.
            </label>
        	<div class="radio fancy_radio">
        		<div class="input-radio-group">
            		<label class="radio-inline">
            		    <input id="lo_matching_acknowledged_yes" class="form-control" type="radio" name="lo_matching_acknowledged" value="Yes" @if (isset($user->lo_matching_acknowledged) && $user->lo_matching_acknowledged == "Yes") checked="checked" @endif > <span>Yes</span>
            		</label>
            		<label class="radio-inline">
            		    <input id="lo_matching_acknowledged_no" class="form-control" type="radio" name="lo_matching_acknowledged" value="No" @if (isset($user->lo_matching_acknowledged) && $user->lo_matching_acknowledged == "No") checked="checked" @endif ><span>No</span>
            		</label>
        		</div>
        	</div>
        </div>
        
    </div>
    @endif
</div>
@if(auth()->user()->user_type != 'realtor')
<div class="form-group">
    <label class="control-label" for="video_url">
       Video Content  <i class="fa fa-video-camera"></i>
    </label>
    <input type="text" id="video_url" class="form-control" placeholder="https://youtu.be/dNFn6g4RLLk" name="video_url" value="{{ old('video_url', (isset($user->video_url) ? $user->video_url : '')) }}"/>
</div>
@endif
@if(auth()->user()->user_type == 'vendor')
<div class="form-group">
	    <label>Upload Your Advertisement Banner</label>
			<div class="full editp">
				<div class="form-group">
						<div class="checkbox">
							<a href="javascript:uploadBannerImage()" style="text-decoration: none;" class="btn btn-warning">
							<i class="fa fa-edit"></i> Browse File </a>&nbsp;&nbsp;
					</div>
					</div>
					<div id="image">
					    @if(count($findBanner)>0)
					     <?php  $ext = pathinfo($findBanner[0]->banner_image, PATHINFO_EXTENSION);
                        if($ext == 'pdf'){ ?>
					    <img width="50%" height="50%" id="previous_img" src="{{URL::to('/banner/')}}/preview_pdf.png"/>
					    <?php }else{ ?>
					   <img width="50%" height="50%" id="previous_img" src="{{URL::to('/banner/')}}/{{$findBanner[0]->banner_image}}"/>
					   <?php } ?>
					    @endif
						<img width="20%" height="20%" id="preview_image" src="{{asset('attach-1.png')}}" style="display:none;" />
						<i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw" style="position: absolute;left: 40%;top: 40%;display: none"></i>
					</div>
					<input type="file" id="file" style="display: none" />
				<input type="hidden" name="file_name" id="file_name" />
			</div>
	</div>
	@endif
