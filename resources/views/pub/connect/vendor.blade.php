@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends("layouts.app")
@section('title')
 @if($selectedCategory->name !="") {{$selectedCategory->name}} Services @endif
@endsection
@section('meta')
    @php
        $description = 'Connect with real estate agents and brokers in your area and around the country'
    @endphp
    {{ meta('description', $description) }}
    @if($selectedCategory->name !="")
    {{ meta('keywords', 'Search Vendor Profile,'.$selectedCategory->name.' Services') }}
     @endif
    {{ openGraph('og:title', 'Connect') }}
    {{ twitter('twitter:title', 'Connect') }}
    {{ googlePlus('name', 'Connect') }}
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
             @if($selectedCategory->name !="") <h1 class="banner-title">{{$selectedCategory->name}} Services </h1>@endif
     @endcomponent
 <div class="container">
        @include('pub.partials.connect.search-vendor')
     <div class="row">
            <div class="col-md-8">
                <div class="row">
                  <h4 class="margin-top-none">@if($selectedCategory->name !="") {{$selectedCategory->name}} Services @endif</h4>
                <!---- <strong>Results:</strong> @if($users !="") {{count($users)}} @endif <br>-->
                </div>
                <div class="row">
                   @foreach($users as $user)
                        <div class="col-md-3 col-xs-6 text-center mb-1 @if ($user->designation !="" && $user->designation !='null') standard-agent @endif">
                        	 <div class="profile-box-inner">
                        	 <div class="designation" style="display:none"><label>@if($user->designation !="" && $user->designation !="null"){{$user->designation}}@endif </label> <img src="{{ asset('img/ribben.png') }}"></div>
                                <img src="{{ $user->avatarUrl() }}" class="search-result__avatar"/>
                                <h4 class="mb-0 pb-0">
                        		<a href="{{ route('pub.user.show', $user->user_id) }}">{{ $user->first_name }}</a></h4>
                                 @if($user->state !="") <p><i class="fa fa-map-marker"></i> @if($user->city !=""){{ $user->city }},@endif {{ $user->state }}</p>@endif
                                <p><a href="{{ route('pub.user.show', $user->user_id) }}" class="btn btn-warning search-result__profile-link">View Profile</a></p>
                              </div>
                            </div>
                    @endforeach
                  <div class="search-result-vendor">
                    
                 </div>
              </div>
                {{$users->links()}}
            </div>
             
			<div class="col-md-4">
			     	<div id='div-gpt-ad-1552396650444-0' style='height:600px; width:300px;'>
					<script>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1552396650444-0'); });
					</script>
					</div>
					<div id='div-gpt-ad-1552397962554-0' style='height:250px; width:300px;margin-top:25px'>
					<script>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1552397962554-0'); });
					</script>
					</div>
			 </div>			
        </div>
          
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
/*$(document).ready(function(){
    var firstElement = $(".currentCat").first();
    $(".currentCat").click(function()
     {
    $('.search-result-vendor').empty();
    var CategoryId = $(this).attr("data-id");
     if(CategoryId !=""){
          var form_data = new FormData();
          form_data.append('categoryid', CategoryId);
          form_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
          $.ajax({
              url: app_url + 'check-vendor-category',
              data: form_data,
              type: 'POST',
              contentType: false,
              processData: false,
              success: function(data) {
                  if (data.fail) {
                    alert(data.errors['file']);
                  } else {
                      var htmlText = '';
                          $.each(JSON.parse(data), function(idx, obj) {
                          htmlText += '<div class="col-md-3 col-xs-6 text-center mb-1>';
                    	  htmlText += '<div class="profile-box-inner">';
                    	  if(obj.avatars ==""){
                            htmlText += '<img src="" class="search-result__avatar"/>';
                    	  }else{
                    	    htmlText += '<img src="" class="search-result__avatar"/>';
                    	  }
                          htmlText += '<h4 class="mb-0 pb-0">';
		                  htmlText += '<a href="'+app_url+'user/'+obj.user_id+'">'+obj.first_name+'</a></h4>';
		                  if(obj.city !="" && obj.city !="null" && obj.state !="" && obj.state !="null"){
                            htmlText += '<p><i class="fa fa-map-marker"></i> '+obj.city+', '+obj.state+'</p>';
		                  }else{
		                    htmlText += '<p><i class="fa fa-map-marker"></i>N/A</p>';  
		                  }
                          htmlText += '<p><a href="'+app_url+'user/'+obj.user_id+'" class="btn btn-warning search-result__profile-link">View Profile</a></p>';
                          htmlText += '</div>';
                          htmlText += '</div>';
                        });
                         $('.search-result-vendor').append(htmlText)  
                   }
              },
              error: function(xhr, status, error) {
                  alert(xhr.responseText);
          
              }
          });
     }
  });
});*/
</script>
@endsection