@inject('states', 'App\Http\Utilities\Geo\USStates')
<div class="form-group {{ $errors->has('bio') ? 'has-error' : '' }}">
    <label class="control-label" for="bio">
        @if($errors->has('bio'))<i class="fa fa-times-circle-o"></i>@endif Bio
    </label>
    <textarea type="text" class="form-control" placeholder="Enter a short biography" name="bio"
        rows=10>{{ old('bio', (isset($user->bio) ? $user->bio : '')) }}</textarea>
    @if($errors->has('bio'))
    <span class="help-block">{{ $errors->first('bio') }}</span>
    @endif
</div>


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
            <input type="text" name="city" class="form-control" id="newProfileCity" value="{{ old('city', (isset($user->city) ? $user->city : '')) }}" placeholder="Enter City" required>
            @if ($errors->has('city'))
            <span class="help-block">
                <strong>{{ $errors->first('city') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group" id="another-city">
            <input type="hidden" name="anotherCity" placeholder="Add another city" class="form-control" />
        </div>
    </div>

    <!---End Previous State Drop Down-->
    <div class="col-md-5">
        <div class="form-group {{ $errors->has('zip') ? 'has-error' : '' }}">
            <label class="control-label" for="zip">
                @if($errors->has('zip'))<i class="fa fa-times-circle-o"></i>@endif Zip
            </label>
            <input type="text" class="form-control" placeholder="Enter Zip Code" name="zip" value="{{ old('zip', (isset($user->zip) ? $user->zip : '')) }}" /> @if($errors->has('zip'))
            <span class="help-block">{{ $errors->first('zip') }}</span>
            @endif
        </div>
    </div>
</div>

@if(auth()->user()->user_type == 'vendor')
    @if(count($category)>0)
        <div class="form-group {{ $errors->has('selectcategory[]') ? 'has-error' : '' }}">
            <label class="control-label" for="selectcat">
                @if($errors->has('selectcategory[]'))<i class="fa fa-times-circle-o"></i>@endif What Industry are you in?
            </label>
            <select name="selectcategory[]" class="form-control {{ $errors->has('selectcategory[]') ? ' has-error' : '' }}" multiple required>
                @foreach($allcat as $categoryVendor)
                    <option value="{{$categoryVendor->id}}" @if(in_array($categoryVendor->id, $category['category'])) selected @endif>{{$categoryVendor->name}}</option>
                @endforeach
            </select>
            @if ($errors->has('selectcategory[]'))
            <span class="help-block">
                <strong>{{ $errors->first('selectcategory[]') }}</strong>
            </span>
            @endif
        </div>
    @endif

    <div class="form-group {{ $errors->has('experties') ? 'has-error' : '' }}">
        <label class="control-label" for="experties">
            @if($errors->has('experties'))<i class="fa fa-times-circle-o"></i>@endif Can you describe your area of expertise and the specific services you offer to real estate professionals?
        </label>
        <input type="text" class="form-control" placeholder="" name="experties" value="{{ $user->vendorMeta->experties }}">
        @if($errors->has('experties'))
            <span class="help-block">{{ $errors->first('experties') }}</span>
        @endif
    </div>
    
    <div class="form-group {{ $errors->has('special_services') ? 'has-error' : '' }}">
        <label class="control-label" for="special_services">
            @if($errors->has('special_services'))<i class="fa fa-times-circle-o"></i>@endif What distinguishes your services from competitors in the industry, and can you provide examples of successful projects you’ve worked on?
        </label>
        <input type="text" class="form-control" placeholder="" name="special_services" value="{{ $user->vendorMeta->special_services }}">
        @if($errors->has('special_services'))
            <span class="help-block">{{ $errors->first('special_services') }}</span>
        @endif
    </div>
    
    <div class="form-group {{ $errors->has('service_precautions') ? 'has-error' : '' }}">
        <label class="control-label" for="service_precautions">
            @if($errors->has('service_precautions'))<i class="fa fa-times-circle-o"></i>@endif How do you ensure your services align with the needs and preferences of realtors and their clients?
        </label>
        <input type="text" class="form-control" placeholder="" name="service_precautions" value="{{ $user->vendorMeta->service_precautions }}">
        @if($errors->has('service_precautions'))
            <span class="help-block">{{ $errors->first('service_precautions') }}</span>
        @endif
    </div>

    <div class="form-group-row">
        <label class="control-label">
            @if($errors->has('connect_realtor'))<i class="fa fa-times-circle-o"></i>@endif
            Are you open to collaborating with real estate professionals on an ongoing basis, and do you have experience working as part of a real estate team?
        </label>
        <div class="radio fancy_radio">
            <div class="input-radio-group">
                <label class="radio-inline">
                    <input id="connect_realtor_yes" class="form-control" type="radio"
                        name="connect_realtor" value="yes" @if (isset($user->vendorMeta->connect_realtor) &&
                    $user->vendorMeta->connect_realtor == "1") checked="checked" @endif > <span>Yes</span>
                </label>
                <label class="radio-inline">
                    <input id="connect_realtor_no" class="form-control" type="radio"
                        name="connect_realtor" value="no" @if (isset($user->vendorMeta->connect_realtor) &&
                    $user->vendorMeta->connect_realtor == "0") checked="checked" @endif ><span>No</span>
                </label>
            </div>
        </div>
    </div>
    
    <div class="form-group-row">
        <label class="control-label">
            @if($errors->has('connect_memebrs'))<i class="fa fa-times-circle-o"></i>@endif
            Are you open to collaborating with real estate professionals on an ongoing basis, and do you have experience working as part of a real estate team?
        </label>
        <div class="radio fancy_radio">
            <div class="input-radio-group">
                <label class="radio-inline">
                    <input id="connect_memebrs_yes" class="form-control" type="radio"
                        name="connect_memebrs" value="yes" @if (isset($user->vendorMeta->connect_memebrs) &&
                    $user->vendorMeta->connect_memebrs == "1") checked="checked" @endif > <span>Yes</span>
                </label>
                <label class="radio-inline">
                    <input id="connect_memebrs_no" class="form-control" type="radio"
                        name="connect_memebrs" value="no" @if (isset($user->vendorMeta->connect_memebrs) &&
                    $user->vendorMeta->connect_memebrs == "0") checked="checked" @endif ><span>No</span>
                </label>
            </div>
        </div>
    </div>

    {{--
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
    @endif
    

    @if(count($category)>0)
        @if(in_array('19', $category['category']))
            @if($category['description'] !="" && $category['description'] !="NULL")
            <div class="form-group {{ $errors->has('other_description') ? 'has-error' : '' }}" id="firstDesc">
                <label class="control-label" for="bio">
                    @if($errors->has('other_description'))<i class="fa fa-times-circle-o"></i>@endif Other Industry Description
                </label>
                <input type="text" class="form-control" name="other_description" value="{{$category['description']}}"
                    id="desc_first" required>
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
    --}}
@endif


@if(auth()->user()->user_type == 'broker')
    <div class="form-group {{ $errors->has('specialties') ? 'has-error' : '' }}">
        <label class="control-label" for="specialties">
            @if($errors->has('specialties'))<i class="fa fa-times-circle-o"></i>@endif 
            What type of Home Loans do you prefer to work with? i.e. Primary homes, second homes, and investment property. All of them
        </label>
        <input type="text" class="form-control" placeholder="Specialties" name="specialties"
            value="{{ $user->specialties }}">
        @if($errors->has('specialties'))
        <span class="help-block">{{ $errors->first('specialties') }}</span>
        @endif
    </div>

    {{-- 
    <div class="form-group {{ $errors->has('stay_updated') ? 'has-error' : '' }}">
        <label class="control-label" for="stay_updated">
            @if($errors->has('stay_updated'))<i class="fa fa-times-circle-o"></i>@endif
            How do you stay updated on changes in the mortgage industry, and what steps do you take to ensure you can offer
            the best financing solutions to your clients?
        </label>
        <input type="text" class="form-control" placeholder="" name="stay_updated"
            value="{{ $user->lenderDetail->stay_updated }}">
        @if($errors->has('stay_updated'))
        <span class="help-block">{{ $errors->first('stay_updated') }}</span>
        @endif
    </div>
    --}}
    <div class="form-group {{ $errors->has('handle_challanges') ? 'has-error' : '' }}">
        <label class="control-label" for="handle_challanges">
            @if($errors->has('handle_challanges'))<i class="fa fa-times-circle-o"></i>@endif
            Do you work with clients with low credit scores or non-traditional income sources?
        </label>
        <input type="text" class="form-control" placeholder="" name="handle_challanges"
            value="{{ $user->lenderDetail->handle_challanges }}">
        @if($errors->has('handle_challanges'))
        <span class="help-block">{{ $errors->first('handle_challanges') }}</span>
        @endif
    </div>
    {{-- 
    <div class="form-group {{ $errors->has('unique_experties') ? 'has-error' : '' }}">
        <label class="control-label" for="unique_experties">
            @if($errors->has('unique_experties'))<i class="fa fa-times-circle-o"></i>@endif
            What sets you apart from other loan officers in terms of the level of service and expertise you provide to your
            clients, and how do you ensure a smooth and efficient mortgage application process?
        </label>
        <input type="text" class="form-control" placeholder="" name="unique_experties"
            value="{{ $user->lenderDetail->unique_experties }}">
        @if($errors->has('unique_experties'))
        <span class="help-block">{{ $errors->first('unique_experties') }}</span>
        @endif
    </div>
    --}}
    <div class="form-group-row">
        <label class="control-label">
            @if($errors->has('partnership_with_realtor'))<i class="fa fa-times-circle-o"></i>@endif
            Are you open to forming partnerships with real estate professionals to receive referrals, and can other members
            of the Render community contact you for collaboration opportunities?
        </label>
        <div class="radio fancy_radio">
            <div class="input-radio-group">
                <label class="radio-inline">
                    <input id="partnership_with_realtor_yes" class="form-control" type="radio"
                        name="partnership_with_realtor" value="Yes" @if (isset($user->lenderDetail->partnership_with_realtor) &&
                    $user->lenderDetail->partnership_with_realtor == "1") checked="checked" @endif > <span>Yes</span>
                </label>
                <label class="radio-inline">
                    <input id="partnership_with_realtor_no" class="form-control" type="radio"
                        name="partnership_with_realtor" value="No" @if (isset($user->lenderDetail->partnership_with_realtor) &&
                    $user->lenderDetail->partnership_with_realtor == "0") checked="checked" @endif ><span>No</span>
                </label>
            </div>
        </div>
    </div>
@endif

@if(auth()->user()->user_type != null)
    @if(auth()->user()->user_type != 'broker' && auth()->user()->user_type != 'realtor' && auth()->user()->user_type !='vendor')
        <div class="form-group{{ $errors->has('units_closed_monthly') ? ' has-error' : '' }}">
            <label class="control-label" for="units_closed_monthly">
                @if($errors->has('units_closed_monthly'))<i class="fa fa-times-circle-o"></i>@endif Number of Units Closed
                Monthly
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
        <input type="hidden" name="units_closed_monthly" />
    @endif

    @if(auth()->user()->user_type != 'vendor' && auth()->user()->user_type != 'broker')
        {{--
            <div class="form-group{{ $errors->has('volume_closed_monthly') ? ' has-error' : '' }}">
                <label class="control-label" for="volume_closed_monthly">
                    @if($errors->has('volume_closed_monthly'))<i class="fa fa-times-circle-o"></i>@endif Buyer Side Transactions closed
                    in the last 12 months
                </label>
                <select class="form-control" name="volume_closed_monthly" id="volume_closed_monthly">
                    @if(!isset($user->volume_closed_monthly))
                    <option value="">Select Buyer Side Transcttion</option>
                    @endif
                    <option value="0-5"
                        {{(isset($user->volume_closed_monthly)) && $user->volume_closed_monthly == '0-5' ? 'selected' : ''}}>0-5
                        Transactions</option>
                    <option value="6-12"
                        {{(isset($user->volume_closed_monthly)) && $user->volume_closed_monthly == '6-12' ? 'selected' : ''}}>6-12
                        Transactions </option>
                    <option value="12-20"
                        {{(isset($user->volume_closed_monthly)) && $user->volume_closed_monthly == '12-20' ? 'selected' : ''}}>12-20
                        Transactions</option>
                    <option value="20+"
                        {{(isset($user->volume_closed_monthly)) && $user->volume_closed_monthly == '20+' ? 'selected' : ''}}>20+
                        Transactions</option>
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
                @if($errors->has('how_long_realtor'))<i class="fa fa-times-circle-o"></i>@endif How long have you been a
                Realtor?
            </label>
            <input type="text" class="form-control" placeholder="How long have you been a Realtor?" name="how_long_realtor" value="{{ $user->how_long_realtor }}">
        </div>
    @endif
@endif

<!----Latest City Drop Down------->

<div class="row">
    @if(auth()->user()->user_type == 'realtor')
        <div class="col-md-12">
            <div class="form-group-row">
                <label class="control-label">
                    @if($errors->has('require_financial_solution'))<i class="fa fa-times-circle-o"></i>@endif
                    Are you actively seeking financing solutions for your clients?
                </label>
                <div class="radio fancy_radio">
                    <div class="input-radio-group">
                        <label class="radio-inline">
                            <input id="require_financial_solution_yes" class="form-control" type="radio"
                                name="require_financial_solution" value="Yes" @if (isset($user->realtorDetail->require_financial_solution) &&
                            $user->realtorDetail->require_financial_solution == "1") checked="checked" @endif > <span>Yes</span>
                        </label>
                        <label class="radio-inline">
                            <input id="require_financial_solution_no" class="form-control" type="radio"
                                name="require_financial_solution" value="No" @if (isset($user->realtorDetail->require_financial_solution) &&
                            $user->realtorDetail->require_financial_solution == "0") checked="checked" @endif ><span>No</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-group-row">
                <label class="control-label">
                    @if($errors->has('require_professional_service'))<i class="fa fa-times-circle-o"></i>@endif
                    Do you require professional services such as photography, home staging, or property inspection for your property listings?
                </label>
                <div class="radio fancy_radio">
                    <div class="input-radio-group">
                        <label class="radio-inline">
                            <input id="require_professional_service_yes" class="form-control" type="radio"
                                name="require_professional_service" value="Yes" @if (isset($user->realtorDetail->require_professional_service) &&
                            $user->realtorDetail->require_professional_service == "1") checked="checked" @endif > <span>Yes</span>
                        </label>
                        <label class="radio-inline">
                            <input id="require_professional_service_no" class="form-control" type="radio"
                                name="require_professional_service" value="No" @if (isset($user->realtorDetail->require_professional_service) &&
                            $user->realtorDetail->require_professional_service == "0") checked="checked" @endif ><span>No</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="form-group-row">
                <label class="control-label">
                    @if($errors->has('partnership_with_lender') || $errors->has('partnership_with_vendor'))<i class="fa fa-times-circle-o"></i>@endif
                    Are you interested in forming partnerships with reputable lenders and vendors in your area to enhance your real estate services?
                </label>
                <div>Lender</div>
                <div class="radio fancy_radio">
                    <div class="input-radio-group">
                        <label class="radio-inline">
                            <input id="partnership_with_lender_yes" class="form-control" type="radio"
                                name="partnership_with_lender" value="Yes" @if (isset($user->realtorDetail->partnership_with_lender) &&
                            $user->realtorDetail->partnership_with_lender == "1") checked="checked" @endif > <span>Yes</span>
                        </label>
                        <label class="radio-inline">
                            <input id="partnership_with_lender_no" class="form-control" type="radio"
                                name="partnership_with_lender" value="No" @if (isset($user->realtorDetail->partnership_with_lender) &&
                            $user->realtorDetail->partnership_with_lender == "0") checked="checked" @endif ><span>No</span>
                        </label>
                    </div>
                </div>
                
                <div class="mt-1">Vendor</div>
                <div class="radio fancy_radio mb-1">
                    <div class="input-radio-group">
                        <label class="radio-inline">
                            <input id="partnership_with_vendor_yes" class="form-control" type="radio"
                                name="partnership_with_vendor" value="Yes" @if (isset($user->realtorDetail->partnership_with_vendor) &&
                            $user->realtorDetail->partnership_with_vendor == "1") checked="checked" @endif > <span>Yes</span>
                        </label>
                        <label class="radio-inline">
                            <input id="partnership_with_vendor_no" class="form-control" type="radio"
                                name="partnership_with_vendor" value="No" @if (isset($user->realtorDetail->partnership_with_vendor) &&
                            $user->realtorDetail->partnership_with_vendor == "0") checked="checked" @endif ><span>No</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group-row">
                <label class="control-label">
                    @if($errors->has('can_realtor_contact'))<i class="fa fa-times-circle-o"></i>@endif
                    Can other Realtors contact you with Referrals?
                </label>
                <div class="radio fancy_radio">
                    <div class="input-radio-group">
                        <label class="radio-inline">
                            <input id="can_realtor_contact_yes" class="form-control" type="radio"
                                name="can_realtor_contact" value="Yes" @if (isset($user->realtorDetail->can_realtor_contact) &&
                            $user->realtorDetail->can_realtor_contact == "1") checked="checked" @endif > <span>Yes</span>
                        </label>
                        <label class="radio-inline">
                            <input id="can_realtor_contact_no" class="form-control" type="radio"
                                name="can_realtor_contact" value="No" @if (isset($user->realtorDetail->can_realtor_contact) &&
                            $user->realtorDetail->can_realtor_contact == "0") checked="checked" @endif ><span>No</span>
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
        Video Content <i class="fa fa-video-camera"></i>
    </label>
    <input type="text" id="video_url" class="form-control" placeholder="https://youtu.be/dNFn6g4RLLk" name="video_url" value="{{ old('video_url', (isset($user->video_url) ? $user->video_url : '')) }}" />
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
            <img width="50%" height="50%" id="previous_img" src="{{URL::to('/banner/')}}/preview_pdf.png" />
            <?php }else{ ?>
            <img width="50%" height="50%" id="previous_img"
                src="{{URL::to('/banner/')}}/{{$findBanner[0]->banner_image}}" />
            <?php } ?>
            @endif
            <img width="20%" height="20%" id="preview_image" src="{{asset('attach-1.png')}}" style="display:none;" />
            <i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw"
                style="position: absolute;left: 40%;top: 40%;display: none"></i>
        </div>
        <input type="file" id="file" style="display: none" />
        <input type="hidden" name="file_name" id="file_name" />
    </div>
</div>
@endif