<h4 class="margin-top-none">Navigation</h4>
<div class="nav nav-stacked">
    {{--<li><a href="{{ route('pub.profile.index') }}">Home</a></li>--}}
    <li><a href="{{ route('pub.profile.detail.edit') }}">Edit Profile</a></li>
    <li><a href="{{ route('pub.profile.password.edit') }}">Change Password</a></li>
    {{--
    @if(auth()->user()->user_type != 'vendor')
      <li><a href="{{ route('pub.profile.matches.index') }}">Manage Matches <span class="badge badge-brand" style="background-color:red;">@if(auth()->user()->pendingMatchCount() > 0){{ auth()->user()->pendingMatchCount() }} @endif</span></a></li>
    @endif
    --}}
    <li><a href="{{ route('pub.profile.matches.index') }}">Manage Matches <span class="badge badge-brand" style="background-color:red;">@if(auth()->user()->pendingMatchCount() > 0){{ auth()->user()->pendingMatchCount() }} @endif</span></a></li>

    <li><a href="{{ route('pub.message-center.index') }}">Message Center <span class="badge badge-brand" style="background-color:red;">@if(auth()->user()->unread_message_count() > 0){{ auth()->user()->unread_message_count() }}@endif</span></a></li>
   
   
    {{--@if(auth()->user()->isA('realtor') || auth()->user()->isA('broker'))--}}
    {{--<li><a href="{{ route('pub.profile.sales.index') }}">Sales History</a></li>--}}
    {{--@endif--}}
    {{--<li><a href="{{ route('pub.profile.broker-profile.index') }}">Broker Profile</a></li>--}}
    
          @php $userSubscription = Auth::user()->userSubscription; @endphp
          @if($userSubscription->exists == true)
               <li><a href="{{ route('pub.profile.subscription.index') }}">Billing Info</a></li>
          @endif
    
    @if(auth()->user()->user_type == 'vendor' && auth()->user()->braintree_id !="")
    <!-- <li><a href="{{ route('pub.profile.payment.plans') }}">Billing Info</a></li> -->
    @endif
    <li><a href="{{ route('pub.profile.profileSocialReviews') }}">Social Reviews</a></li>

    @if (auth()->user()->user_type === "broker"|| auth()->user()->user_type === "realtor")
      <li><a href="{{ route('pub.profile.leads.property') }}">Property Leads</a></li>
    @endif

    @if (auth()->user()->user_type === "broker")
      <li><a href="{{ route('pub.profile.leads.refinance') }}">Refinance Leads</a></li>
    @endif

    @if(auth()->user()->user_type != 'vendor')
    <li><a href="{{ route('pub.profile.settings.index') }}">Settings</a></li>
    @endif
</div>