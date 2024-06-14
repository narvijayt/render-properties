@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends("layouts.app")
@section('title')
    @if ($params->search_type === 'radius')
        {{ $params->location }} Connections
    @elseif ($params->search_type === 'state')
        {{ $states::fullFromAbbr($params->state) }} Connections
    @else
        Connect
    @endif
@endsection

@section('meta')
    @php
        $description = 'Connect with real estate agents and brokers in your area and around the country'
    @endphp
    {{ meta('description', $description) }}
    @if(Request::segment(1) == 'search-lender-profiles')
            {{ meta('keywords','Search Lenders Profiles, Loan Officers') }}
        @endif
         @if(Request::segment(1) == 'search-realtor-profiles')
            {{ meta('keywords','Search Realtors Profiles,Gold Standard Brokers,Real Estate Agents') }}
        @endif
        @if(Request::segment(1) == 'search-vendor-profiles')
            {{ meta('keywords','Search Vendor Profiles') }}
        @endif
        @if(Request::segment(1) == 'search-vendor')
        {{ meta('keywords','Search Vendor Profile, Search by Vendor Industry, Credit Repair, Health Insurance, Home Inspection') }}
        @endif
        @if(Request::segment(1) == 'search-profiles')
         {{ meta('keywords','Connect with Members, Search Profiles, Best Real Estate Industry Professionals') }}
        @endif
    @if ($params->search_type === 'radius')
        {{ openGraph('og:title', $params->location.' Connections') }}
        {{ twitter('twitter:title', $params->location.' Connections') }}
        {{ googlePlus('name', $params->location.' Connections') }}
    @elseif ($params->search_type === 'state')
        {{ openGraph('og:title', $states::fullFromAbbr($params->state) .' Connections') }}
        {{ twitter('twitter:title', $states::fullFromAbbr($params->state) .' Connections') }}
        {{ googlePlus('name', $states::fullFromAbbr($params->state) .' Connections') }}
    @else
        {{ openGraph('og:title', 'Connect') }}
        {{ twitter('twitter:title', 'Connect') }}
        {{ googlePlus('name', 'Connect') }}
    @endif
    {{ openGraph('og:type', 'product') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}
    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection
@section("content")
    @component('pub.components.banner', ['banner_class' => 'connect'])
        @if(Request::segment(1) == 'search-lender-profiles')
            Search Lenders Profiles
        @endif
        
        @if(Request::segment(1) == 'search-realtor-profiles')
            Search Realtors Profiles
        @endif
        @if(Request::segment(1) == 'search-vendor-profiles')
            Search Vendor Profiles
        @endif
        @if(Request::segment(1) == 'search-vendor')
        Search Vendor Profile
        @endif
        @if(Request::segment(1) == 'search-profiles')
             Connect with Members
        @endif
     @endcomponent

    <div class="container">
        @include('pub.partials.connect.search-filters')
     <div class="row">
            <div class="col-md-8">
               <!----@if(count($goldUsers) > 0 )
                <div class="row">
                @foreach($goldUsers as $user)
                    @include('pub.partials.connect.search-result', ['user' => $user])
                @endforeach
                </div>
                @endif
                
                @if(count($paidUser) > 0 )
                <div class="row">
                @foreach($paidUser as $user)
                    @include('pub.partials.connect.search-result', ['user' => $user])
                @endforeach
                </div>
                @endif
                
                @if(count($unpaidUser) > 0 )
                <div class="row">
                @foreach($unpaidUser as $user)
                    @include('pub.partials.connect.search-result', ['user' => $user])
                @endforeach
                </div>
                @endif--->
              <div class="row">
                @foreach($users as $user)
                    @include('pub.partials.connect.search-result', ['user' => $user])
                @endforeach
              </div>
            </div>
				
			<div class="col-md-4">
			  <!-- /21803544343/RBC-HP -->
					<div id='div-gpt-ad-1552396650444-0' style='height:600px; width:300px;'>
					<script>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1552396650444-0'); });
					</script>
					</div>
					
					<!-- /21803544343/RBC-MR1 -->
					<div id='div-gpt-ad-1552397962554-0' style='height:250px; width:300px;margin-top:25px'>
					<script>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1552397962554-0'); });
					</script>
					</div>
			
			
              </div>			
				
            <!--<div class="col-md-3">
                @include('pub.partials.connect.sponsors')
            </div>-->
        </div>
        {{ $users->links() }}
    </div>
@endsection