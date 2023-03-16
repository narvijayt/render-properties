@extends('admin.layouts.main')
@section('content')
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
            <form  id="vendorPayment" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
          <div class="col-md-6">
                 @include('partials.registration.package-selected')
                 <div class="row">
                 	<div class="col-md-6 form-group{{ $errors->has('package_price') ? ' has-error' : '' }}">
		<input id="packagePrice" type="text" class="form-control" name="package_price" placeholder="Enter Final Package Price" value="" required>
			<span class="help-block">
		@if ($errors->has('package_price'))
			<strong>{{ $errors->first('package_price') }}</strong>
		@endif
		</span>
	</div>
	</div>
	 <div class="form-group">
         <button type="submit" class="btn btn-lg btn-success btn-min-width" id="doPaymentButton">Proceed To Make Payment</button>
		</div>
            </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
   
    /*********State Package Option ****************************/  
     
    var stateCounter = 0;
    $('#vendorPayment').on('click', '#addmorBtn', function() 
    {
    $('#additionalStateFields').append('<tr id="row'+stateCounter+'"><td ><div class="odd gradeX" >'+'<input type="text" id="add_additionalState' + stateCounter + '" name="additional_state[' + stateCounter + ']' + '" placeholder="Enter Additional State" class="form-control" pattern="^[A-Za-z -]+$" required/>'+'</div> </td><td>'+
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
    $('#vendorPayment').on('click', '#addMoreCity', function() 
    {
         $('#totalPrice').empty();
        $('#additionalFields').append('<tr id="row'+itr+'"><td ><div class="odd gradeX">'+'<input type="text" id="add_additionalCity' + itr + '" name="additional_city[' + itr + ']' + '" placeholder="Enter Additional City" class="form-control" pattern="^[A-Za-z -]+$" required/>'+'</div> </td><td>'+
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
    </script>
@endsection