@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends("layouts.app")
@section('title') Search By Category @endsection
@section('meta')
    @php
        $description = 'Connect with real estate agents and brokers in your area and around the country'
    @endphp
    {{ meta('description', $description) }}
    {{ meta('keywords', 'Search Vendor Profile, Credit Repair, Health Insurance,Home Inspection, Hvac Service') }}
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

<div class="outer bg-grey">
    @component('pub.components.banner', ['banner_class' => 'connect'])
        @if(Request::segment(1) == 'search-lender-profiles')
            <h1 class="banner-title">Search Lenders Profiles</h1>
        @endif
        
        @if(Request::segment(1) == 'search-realtor-profiles')
            <h1 class="banner-title">Search Realtors Profiles</h1>
        @endif
        @if(Request::segment(1) == 'search-vendor-profiles')
            <h1 class="banner-title">Search Vendor Profiles</h1>
        @endif
        @if(Request::segment(1) == 'search-vendor')
        <h1 class="banner-title">Search By Category</h1>
        @endif
        @if(Request::segment(1) == 'search-profiles')
             <h1 class="banner-title">Connect with Members</h1>
        @endif
     @endcomponent
 <div class="container">
        @include('pub.partials.connect.search-vendor')
     <div class="row">
            <div class="col-md-9">
			@if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
             @if(session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
         @endif
                 <h4 class="mb-2">Search By Category</h4>
                <div class="row">
                    @foreach($findVendorCategory as $category)

                    <div class="col-md-4">					 
                    <a class="search-cat-box" href="{{url('/vendor-category',[$category->slug])}}">
					 @if($category->file_name !="")
					     <div class="img-wrap"><img src="{{asset('services/')}}/{{$category->file_name}}"></div>
					    @else
					    <div class="img-wrap"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-qUdyTvpIG6w35K4hWPUkTeSyMIoUcaXGsTXqmfBK8bXWQqJf&s"></div>
					 @endif
					 <span>{{$category->name}}</span>					
					  </a>
                   </div>
                    @endforeach
                  <div class="search-result-vendor">
                  </div>
              </div>
            </div>
			<div class="col-md-3">
			     	<div id='div-gpt-ad-1552396650444-0' style='height:600px; width:100%;'>
					<script>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1552396650444-0'); });
					</script>
					</div>
					<div id='div-gpt-ad-1552397962554-0' style='height:250px; width:100%;margin-top:25px'>
					<script>
					googletag.cmd.push(function() { googletag.display('div-gpt-ad-1552397962554-0'); });
					</script>
					</div>
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