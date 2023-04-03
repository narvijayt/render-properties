@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('layouts.app')
@section('title', 'Payment Package')
@section('meta')
    @php
        $description = 'Register for Render'
    @endphp
    {{ meta('description', $description) }}
    {{ meta('keywords', config('seo.keyword')) }}
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
        Payment Package
    @endcomponent
  
<style>.banner{margin:0}.footer{margin-top:0}</style> 
<section class="bg-grey py-3">
 <div class="container">
        <div class="row">
            @if(session()->has('message'))
                    <div class="alert">
                        {{ session()->get('message') }}
                    </div>
                    @endif
             @if(session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
         @endif
         
          @if(app('request')->input('package') =='pick-a-city' || app('request')->input('package') =='pick-a-state' || app('request')->input('package') =='united-states')
            <form class="vendor_register" id="vendor_register" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="col-md-6 p-0 vendor-billingInfo">
              <div class="vendor-reg-box">
                 <div class="box-title-box">
                  <h1 class="box-title line-left family-mont">Billing Details</h1>
                    </div>
                    <input type="hidden" name="user_id" value="{{$userDetails->user_id}}" /> 
                    <div class="row">
                    <div class="form-group col-md-6">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" class="form-control" name="first_name" value="{{$userDetails->first_name}}" required="" aria-required="true" />
                    </div>
                    <div class="form-group col-md-6">
                       <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" class="form-control" name="last_name" value="{{$userDetails->last_name}}" required="" aria-required="true" />
                    </div>
                    </div>
                <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" name="email" value="{{$userDetails->email}}" required="" aria-required="true" />
                </div>
                <div class="form-group">
                    <label for="company">Company</label>
                    <input type="text" id="company" class="form-control" name="firm_name" value="{{$userDetails->firm_name}}"/>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label for="address1">Billing Address1</label>
                    <input type="text" id="address1" class="form-control" name="address" placeholder="Billing Address 1" value="{{$userDetails->billing_address_1}}" required="" aria-required="true"/>
                </div>
                <div class="form-group">
                    <label for="address2">Billing Address2</label>
                    <input type="text" id="address2" class="form-control" name="address2" placeholder="Billing Address 2" value="{{$userDetails->billing_address_2}}"/>
                </div>
                <div class="row">
                 <div class="form-group col-md-4">
                     <label for="billing_locality">City</label>
                    <input type="text" id="billing_locality" class="form-control" placeholder="City" name="city" value="{{$userDetails->city}}" required="" aria-required="true"/>
                </div>
                <div class="form-group col-md-4">
                    <label for="billing_region">State</label>
                    <input type="text" id="billing_region" class="form-control" name="state" placeholder="State" value="{{$userDetails->state}}" required="" aria-required="true"/>
                </div>
                <div class="form-group col-md-4">
                    <label for="billing_postal_code">Zip</label>
                    <input type="text" id="billing_postal_code" class="form-control" name="zip" placeholder="Postal Code" value="{{$userDetails->zip}}"  required="" aria-required="true"/>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <label>
                          <input type="checkbox" <?=isset($_REQUEST['accept_terms']) ? 'checked' : ''?> name="accept_terms" value="1"> I have read and agree to the <a href="{{ route('pub.terms-and-conditions.index')}}" target="_blank">Terms and Conditions</a>.
                        </label>
                    </div>
                    <p>{!! get_application_name() !!} has a 30 day refund policy. If your not happy for any reason please <a href="https://www.render.properties/contact" target="_blank">contact us</a> for a full refund within  30 days of signing up for a paid membership.</p>
                </div>
                </div>
                
            </div>
            </div>
           <div class="col-md-6">@include('partials.registration.package-selected') </div>
           <div class="clearfix"></div>
           <div class="col-md-12">
           <div class="card-form package-infobox">
           <div class="box-title-box">
            <h1 class="box-title line-left family-mont">Payment Details</h1>
             <p>Please enter your payment details</p>              
           </div>
           <div class="row"> 
                 <div class="col-md-5"> <div class="card-wrapper"></div></div>
                 <div class="col-md-7">
                    <div class="form-group">
                      <div class="radio fancy_radio">
                        <label><input name="namehere" type="radio"><span>Credit Card</span></label>
                      </div>
                      <div class="pull-right">
                          <img src="img/credit-cards.png" class="img-responsive center-block" style="width: 50%;float: right;margin-top: -45px;" />
                      </div>
                    </div>
                    <div class="clearfix"></div><br>
                    <div class="row">
                      <div class="col-md-6">
                      <div class="form-group">
                         <input required type="text" class="form-control form-control-lg card-number" name="number" id="card-number" maxlength="19" placeholder="Card Number" autocomplete="off">
                      </div>
                      </div>
                      <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                    <input type="text" class="form-control card-expiry form-control-lg date-formatter" name="expiry" id="date-format" placeholder="MM/YYYY" required autocomplete="off">
					   </div>
                      </div>
                      <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="form-group">
                        <input required type="text" class="form-control card-cvc form-control-lg" name="cvc" id="card-cvc" maxlength="16" placeholder="CVC" autocomplete="off">
                        </div>
                      </div>
                    </div><!------  ROW--->
                 <div class="form-group ">
                    <input required type="text" class="form-control card-name form-control-lg" name="name" id="card-name" placeholder="Card Holder Name" autocomplete="off">
                    </div>

                    <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-success btn-min-width" id="doPaymentButton">Continue</button>
                    </div>
                </div><!------  Col-md-6---->
          </div><!------ ROW--->
      </div>
  </div>  <!----- Col-md-12--->
</form>
@else
<div class="row">
<div class="col-md-6">
<div class="form-group text-center">
      <h3>No Package Available. </h3>
      </div>
      </div>
      </div>
      @endif
        </div>
    </div>
    </section>
@endsection

@push('scripts-footer')
  <script>
   
    /*********State Package Option ****************************/  
     
    var stateCounter = 0;
    $('#vendor_register').on('click', '#addmorBtn', function() 
    {
    $('#additionalStateFields').append('<tr id="row'+stateCounter+'"><td ><div class="odd gradeX" >'+'<input type="text" id="add_additionalState' + stateCounter + '" name="additional_state[' + stateCounter + ']' + '" placeholder="Enter Additional State" class="form-control required" />'+'</div> </td><td>'+
            '<button type="button" name="remove" id="'+stateCounter+'" class="btn btn-warning btn_removestate"><i class="fa fa-close"></i></button></td></tr>');
        var initialCount = 799+599;
        var addiStateAmount = 599;
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
          var initialAmount = 799;
          var itrDeduction = 599;
          var stateAmount = $('#current_state').val();
          var stateAddDeduction = parseInt(stateAmount)-parseInt(itrDeduction);
          $('#current_state').val(stateAddDeduction);
          $('#totalStatePrice').html('$'+stateAddDeduction);
      }
    }); 
  /********************End State Package Option**************/
    /*******************City Package Option*******************/
     var itr = 0;
    $('#vendor_register').on('click', '#addMoreCity', function() 
    {
         $('#totalPrice').empty();
        $('#additionalFields').append('<tr id="row'+itr+'"><td ><div class="odd gradeX">'+'<input type="text" id="add_additionalCity' + itr + '" name="additional_city[' + itr + ']' + '" placeholder="Enter Additional City" class="form-control required" />'+'</div> </td><td>'+
            '<button type="button" name="remove" id="'+itr+'" class="btn btn-warning btn_remove"><i class="fa fa-close"></i></button></td></tr>');
         var firstItr = 99+79;
         var addPrice = 79;
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
         var initalVal = 99;
         var deductionAmount = 79;
          var currAmnt = $('#current_city').val();
          var AddDeductionAmount =   parseInt(currAmnt)-parseInt(deductionAmount);
          $('#current_city').val(AddDeductionAmount);
          $('#totalPrice').html('$'+AddDeductionAmount);
     }
    }); 
    /**********************End City Package Option**************/
    </script>
      <style>.banner{margin-bottom:0}.footer{margin-top:0}</style>
    @endpush
