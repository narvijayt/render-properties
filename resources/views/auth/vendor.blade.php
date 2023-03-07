@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('layouts.app')
@section('title', 'Vendor Register')
@section('meta')
    @php
        $description = 'Register for Render'
    @endphp
    {{ meta('description', $description) }}
    {{ meta('keywords', 'Vendor Registration, Render') }}

    {{ openGraph('og:title', 'Register') }}
    {{ openGraph('og:type', 'product') }}
    {{ openGraph('og:url', Request::url()) }}
    {{ openGraph('og:image', config('seo.image')) }}
    {{ openGraph('og:description', $description) }}
    {{ openGraph('og:site_name', config('app.name')) }}
    {{ openGraph('fb:admins', config('seo.facebook_id')) }}
    {{ twitter('twitter:card', 'summary') }}
    {{ twitter('twitter:title', 'Register') }}
    {{ twitter('twitter:site', config('seo.twitter_handle')) }}
    {{ twitter('twitter:description', $description) }}
    {{ twitter('twitter:creator', config('seo.twitter_handle')) }}
    {{ twitter('twitter:image', config('seo.image')) }}
    {{ googlePlus('name', 'Register') }}
    {{ googlePlus('description', $description) }}
    {{ googlePlus('image', config('seo.image')) }}
@endsection
@section('content')
    @component('pub.components.banner', ['banner_class' => 'lender'])
        <h1 class="banner-title">Register</h1>
			<!--- <h3 class="pl-0 text-white" style="margin-top:0"><i class="fa fa-mobile"></i> Call us Today: <a href="tel:704-946-6980" style="color:orange;font-weight:bold;">704-946-6980</a> for questions about our program</h3>-->
    @endcomponent
	
<style>.banner{margin:0}.footer{margin-top:0}</style>	
<section class="bg-grey py-3">
	
    <div class="container">
        
		<!--- <div class="col-md-3"></div>
		 <div class="col-md-6 alert alert-success">During this time of crisis. Render stands with our members. Until further notice all membership monthly payments will be waived at this time.</div>
		 	 <div class="col-md-3"></div>---->
		 
		<div class="row">
            @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
             @if(session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
         @endif
            <form id="vendor_registers" class="" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
				
			 <div class="col-md-6 ">
			 <div class="vendor-reg-box">
			      
                @include('partials.registration.vendor-register-package')
                
                </div>	
                </div>	
          <div class="col-md-6">

                @include('partials.registration.vendor-register')
           </div>
           
           </form>
        </div>
    </div>
    </section>
@endsection

@push('scripts-footer')
  <script>
   var j = jQuery.noConflict();
    function uploadBannerImage() {
          j('#file').click();
      }
    
      j('#file').change(function() {
          if (j(this).val() != '') {
              uploadBannerImg(this);
          }
      });
    
      function uploadBannerImg(img) {
          var form_data = new FormData();
          form_data.append('file', img.files[0]);
          form_data.append('_token', '{{csrf_token()}}');
          j('#loading').css('display', 'block');
          j.ajax({
              url: "{{url('advertisement/banner')}}",
              data: form_data,
              type: 'POST',
              contentType: false,
              processData: false,
              success: function(data) {
                  if (data.fail) {
                      j('#preview_image').attr('src', '{{URL::to('/public/attach - 1. png ')}}');
                          alert(data.errors['file']);
                  } else {
                       var ext = data.split('.').pop();
                       if(ext == 'pdf'){
                          j('#preview_image').css('display', 'block');
                          j('#preview_image').attr('src', '{{URL::to('/banner/')}}/' + 'preview_pdf.png');
                     }else{
                      j('#file_name').val(data);
                      j('#preview_image').css('display', 'block');
                      j('#preview_image').attr('src', '{{URL::to('/banner/')}}/' + data);
                  }
                  j('#loading').css('display', 'none');
              }
              },
              error: function(xhr, status, error) {
                  alert(xhr.responseText);
                  j('#preview_image').attr('src', '{{URL::to('/public/attach - 1.png')}}');
              }
          });
      }
    /*********State Package Option ****************************/  
     
    var stateCounter = 0;
    $('#vendor_registers').on('click', '#addmorBtn', function() 
    {
    $('#additionalStateFields').append('<tr id="row'+stateCounter+'"><td ><div class="odd gradeX" >'+'<input type="text" id="add_additionalState' + stateCounter + '" name="additional_state[' + stateCounter + ']' + '" placeholder="Enter Additional State" class="form-control required" />'+'</div> </td><td>'+
            '<button type="button" name="remove" id="'+stateCounter+'" class="btn btn-warning btn_removestate"><i class="fa fa-close"></i></button></td></tr>');
        var initialCount = 8995+6995;
        var addiStateAmount = 6995;
        if(stateCounter == 0)
        {
            $('#current_state').val(initialCount);
            $('#totalStatePrice').html('$'+initialCount);
        }else{
            var stateVal = $('#current_state').val();
            var additionalStateVal = parseInt(stateVal)+parseInt(addiStateAmount);
            $('#current_state').val(additionalStateVal);
            $('#totalStatePrice').html('$'+additionalStateVal);
        }
         ++stateCounter;
       });
      $(document).on('click', '.btn_removestate', function()
      {  
      if (confirm('Are you sure you want to delete this Additional State Name?'))
      {
          var button_id = $(this).attr("id");   
          $('#row'+button_id+'').remove();  
          var initialAmount = 8995;
          var itrDeduction = 6995;
          var stateAmount = $('#current_state').val();
          var stateAddDeduction = parseInt(stateAmount)-parseInt(itrDeduction);
          $('#current_state').val(stateAddDeduction);
          $('#totalStatePrice').html('$'+stateAddDeduction);
      }
    }); 
  /********************End State Package Option**************/
    /*******************City Package Option*******************/
     var itr = 0;
    $('#vendor_registers').on('click', '#addMoreCity', function() 
    {
         $('#totalPrice').empty();
        $('#additionalFields').append('<tr id="row'+itr+'"><td ><div class="odd gradeX">'+'<input type="text" id="add_additionalCity' + itr + '" name="additional_city[' + itr + ']' + '" placeholder="Enter Additional City" class="form-control required" />'+'</div> </td><td>'+
            '<button type="button" name="remove" id="'+itr+'" class="btn btn-warning btn_remove"><i class="fa fa-close"></i></button></td></tr>');
         var firstItr = 995+795;
         var addPrice = 795;
         if(itr == 0)
         {
             $('#current_city').val(firstItr);
             $('#totalPrice').html('$'+firstItr);
         }else{
             var cityVal = $('#current_city').val();
             var addItr =   parseInt(cityVal)+parseInt(addPrice);
             $('#current_city').val(addItr);
             $('#totalPrice').html('$'+addItr);
         }
         ++itr;
       });
      $(document).on('click', '.btn_remove', function()
      {  
      if (confirm('Are you sure you want to delete this Additional City Name?'))
      {
         var button_id = $(this).attr("id");   
         $('#row'+button_id+'').remove();
         var initalVal = 995;
         var deductionAmount = 795;
          var currAmnt = $('#current_city').val();
          var AddDeductionAmount =   parseInt(currAmnt)-parseInt(deductionAmount);
          $('#current_city').val(AddDeductionAmount);
          $('#totalPrice').html('$'+AddDeductionAmount);
     }
    }); 
    /**********************End City Package Option**************/
    
    $('#langOpt').multiSelect();
    </script>
    @endpush
