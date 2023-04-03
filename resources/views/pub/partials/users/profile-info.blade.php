<div class="row">
    <div class="col-md-6">
        <h4>Contact Info</h4>
        <ul class="list-unstyled">
            <li>
                <strong>Profession:</strong>
                @if($user->user_type !="vendor")
                {{ title_case($user->user_type === 'broker' ? 'lender' : 'real estate agent') }}
                @else
                Vendor 
                @endif
            </li>
            <li>
                <strong>Name:</strong>
                {{ $user->full_name() }}
            </li>
            @if($user->firm_name)
            <li>
                <strong>Company:</strong>
                {{ $user->firm_name }}
            </li>
            @endif
            <li>
                <strong>City:</strong>
                {{ $user->city }}
            </li>
            <li>
                <strong>State:</strong>
                {{ $user->state }}
            </li>
            <li>
                <strong>Email:</strong>
                @if(Auth::user())
                    <a href="mailto:{{$user->email}}">
                        {{ $user->email }}
                    </a>
                @else
                    <a class="text-link" href="{{ route('login') }}">Login to view contact details</a> 
                @endif
            </li>
            
            @if($user->phone_number)
            <li><strong>Phone Number:</strong>
                @if(Auth::user())
                    <a class="text-link" href="tel:{{ $user->phone_number }}">{{ $user->phone_number }}</a>
                    @if ($user->phone_ext)
                        Ext: {{ $user->phone_ext }}
                    @endif
                @else
                    <a class="text-link" href="{{ route('login') }}">Login to view contact details</a> 
                @endif
            </li>
            @endif
            
            @if($user->website)
            <li><strong>Website links:</strong>
            <a href="{{ real_url($user->website) }}" target="_blank">
                {{ $user->website }}
            </a>
            </li>
            @endif
        </ul>
        <div class="clearfix"></div>
        <h4>Experience</h4>
        <ul class="list-unstyled">
            @if($user->user_type == 'vendor')
                <li><strong>Industry: </strong>
                @if(!empty($categoryName))
                    @if(count($categoryName)>0){{implode(',', $categoryName)}}@endif
                    @else
                    N/A
                    @endif
                </li>
                <li><strong>Services Offered: </strong>
                
                    @if($fetchOverallData[0]->vendor_details->isNotEmpty())
                        {{$fetchOverallData[0]->vendor_details[0]->vendor_service}}
                    @else
                    N/A.
                    @endif
                </li>
                <li><strong>Area Covered: </strong>
                    @if($fetchOverallData[0]->vendor_details->isNotEmpty())
                    {{$fetchOverallData[0]->vendor_details[0]->vendor_coverage_area}} 
                    @else
                    N/A
                    @endif
                </li>
            @endif
            @if(isset($user->license))
                <li><strong>License#:</strong>
                {{$user->license}}
                </li>
            @endif
            @if(isset($user->specialties))
                <li><strong>Specialties:</strong>
                {{ $user->specialties }}
                </li>
            @endif
            @if($user->user_type !="broker")
            @if(isset($user->units_closed_monthly))
                <li><strong>Number of units closed monthly:</strong>
                {{ $user->units_closed_monthly }}
                </li>
            @endif
            @if(isset($user->volume_closed_monthly))
                <li><strong>Average volume closed monthly:</strong>
                {{ $user->volume_closed_monthly }}
                </li>
            @endif
            @endif
            <li><strong>Areas/Locations served:</strong>
            {{ $user->city }}, {{ $user->state }}
            </li>
            <li><strong>Biographical information:</strong>
            {{ $user->bio }}
            </li>
            
            
        </ul>
    </div>
    <div class="col-md-6" style="padding:0;">
        
        
        <div style="max-width:336px">
            @include('pub.partials.google-map', [
            'markers' => [
            [
            'lat' => $user->latitude,
            'lng' => $user->longitude
            ]
            ]
            ])
        </div>
        <div id='div-gpt-ad-1552397044238-0' style='height:280px; width:336px;margin-top:25px'>
            <script>
            googletag.cmd.push(function() { googletag.display('div-gpt-ad-1552397044238-0'); });
            </script>
        </div>
        
        @if(Auth::user())
            <ul class="list-unstyled details-list-icons mt-2">
                
                @if($user->referral_fee_acknowledged == "Yes")
                    <li><strong> Interested in working with {!! get_application_name() !!} home buyer leads with zero upfront fees and paying a 17% referral at closing for buyer leads..</strong></li>
                @endif
                
                {{--
                    @if($user->open_to_lender_relations == "Yes")
                        <li><i class="fa fa-check user-profile-icon" aria-hidden="true"></i><strong> Open to new lender relationships.</strong></li>
                    @endif
                --}}
                
                @if($user->contact_me_for_match == "Yes")
                    <li><strong> Loan Officers can contact to work together.</strong></li>
                @endif
            </ul>
        @endif
    </div>
</div>