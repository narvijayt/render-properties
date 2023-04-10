@extends('layouts.app')

@section('content')
    @component('pub.components.container')
        @if(!auth()->user()->verified)
            <div class="alert alert-info alert" role="alert">
                <strong>Please check your email inbox/spam to verify your email.</strong> If email didn't received, please click on resend button
                <form action="{{ route('auth.resend-email-verification') }}" method="POST" style="display: inline;">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary btn-sm">Resend Email</button>
                </form>
            </div>
        @endif

        @if(!auth()->user()->mobile_verified)
            <div class="alert alert-info alert" role="alert">
                <strong>Your Phone Number is not verified.</strong> Please click on the button to verify your Phone Number
                <form action="{{ route('otp.sendnewotp', ['id' => auth()->user()->user_id]) }}" method="get" style="display: inline;">
                    <button type="submit" class="btn btn-primary btn-sm">Verify Phone Number</button>
                </form>
            </div>
        @endif


           <!---@if(auth()->user()->user_type)
          @if(auth()->user()->user_type == 'realtor' || auth()->user()->user_type== 'broker')
            @if(auth()->user()->braintree_id == 'NULL' || auth()->user()->braintree_id == '' || auth()->user()->braintree_id == '6')
            @php $userid = auth()->user()->user_id; @endphp
            <div class="alert alert-danger alert" role="alert">
          <strong><span class="upgradetext">Upgrade your account Only</span> with <span class="upgradetext">$120</span> and more benefits.</strong></br>
            <strong>You will get more features after upgrading with premium account.Like: Introduction video, Map location etc. <span class="upgradetext">Learn More</span> 
            <a href="{{url('/upgrade/plan',[$userid])}}"><button  type="submit" class="btn btn-danger btn-sm upgradebtn">Upgrade Now</button></a></strong>
            </strong>
        </div>
            @endif
            @if(auth()->user()->braintree_id == '12')
            @php $userid = auth()->user()->user_id; @endphp
            <div class="alert alert-success alert" role="alert">
            <strong>Thanks {{ucfirst(auth()->user()->first_name)}} for upgrading account Plan to $120.00 annually.
              <a href="{{url('/cancel/upgrade',[$userid])}}"><button type="submit" class="btn btn-danger btn-sm">Cancel Annual Plan</button></a>
             </strong>
            </div>
            @endif
           @endif
         @endif---->
        
       @if(Session::has('message'))
            <p id="payment-msg" class="alert alert-success">
                 {{ Session::get('message') }}
            </p>
        @endif
         @if (Session::has('emailmsg'))
            <p class="alert alert-info">
                {{ Session::get('emailmsg') }}
            </p>
        @endif
        @component('pub.components.page-standard')
            @slot('page_header')
                <h2>@yield('title')</h2>
                
            @endslot
            
            
           @if(\Request()->segment(1) != 'upgrade')
            @component('pub.components.sidebar-left')
            @endif
         
                @slot('sidebar')
                   @if(\Request()->segment(1) != 'upgrade')
                @include('pub.profile.partials.nav')
                 @endif
                @endslot
            @yield('page_content')

            @if(\Request()->segment(1) != 'upgrade')
            @endcomponent
            @endif

        @endcomponent {{-- page layout --}}
    @endcomponent {{-- container --}}
@endsection