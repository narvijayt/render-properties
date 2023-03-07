@if(isset($regPage) && !empty($regPage))
    @if($regPage->content != '')
        @php echo html_entity_decode($regPage->content); @endphp
    @else
        <h4 class="text-center">Register to enjoy these benefits:</h4>​​
        <ul>
            <li>Build your referral/lead network with active real estate buyer agents / You keep 100% of the referral fee</li>
            <li>Marketing of your bio and personal website</li>
            <li>Receive 30 days real estate coaching from nationally renowned Bill "The Coach" Sparkman</li>
            <li>Online marketing presence for consumers searching for real estate professionals</li>
            <li>Receive Mortgage pre approved buyer leads from Lenders. 95% of the clients looking to get pre approved do not
                have a real estate agent and our lender partners refer them out to real estate agents on the site.</li>
            <li>Connect with a Lender that will be a benefit to your career</li>
        </ul>        ​
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="{{ route('pub.terms-and-conditions.index') }}">View Terms &amp; Conditions</a>
            </div>
        </div>
    @endif
@endif
{{--@include('partials.svg.realtor-benefits-venn-diagram')--}}
