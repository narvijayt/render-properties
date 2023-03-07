@if(isset($regPage) && !empty($regPage))
    @if($regPage->header != '')
        @php echo html_entity_decode($regPage->header); @endphp
    @else
        <h4 class="text-center">Register to enjoy these benefits:</h4>
        ​​<ul>
            <li>Connect with active, productive buyers real estate agents</li>
            <li>Build your real estate agent referral/lead network</li>
            <li>Search and find top producing buyer real estate agents in your area that want to be connected to a new lender</li>
            <li>Low cost mortgage pre-approval leads available</li>
            <li>Receive reviews from your connection</li>
            <li>Receive 30 days mortgage coaching from nationally renowned Bill "The Coach" Sparkman</li>
            <li>Online marketing presence for consumers searching mortgage professionals</li>
        </ul>
        ​
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="{{ route('pub.terms-and-conditions.index') }}">View Terms &amp; Conditions</a>
            </div>
        </div>
    @endif
@endif
{{--@include('partials.svg.lender-benefits-venn-diagram')--}}
