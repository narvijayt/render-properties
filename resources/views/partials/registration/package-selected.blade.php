<div class="packageSel package-infobox">
     <div class="box-title-box">
	    <h1 class="box-title line-left family-mont">ORDER DETAILS</h1>
         <p>Below are your order details.</p>
	 </div>
    <div class="text-center selected-box">
	<h3 class="family-mont">Your Order Summary</h3>
    @if($selectedPackage == 'united-states')
		<table class="table">
		  <thead>
		     <tr><th>Description</th><th>Amount</th></tr>
		    </thead>
			<tbody style="text-align:left;">
		     <tr><td>UNITED STATES <small>(FOR ONE MONTH*)</small>
		     <input type="hidden" name="selected_us" value="11">
			      </td><td>$8995 MO</u></td></tr>
			<tbody id="additionalStateFields"></tbody>
			<tr><td><strong>OWN THE U.S. IN YOUR INDUSTRY!!!</strong></td></tr>	  
		 </tbody>
		 <tfoot style="text-align:left;">
		     <tr><th>Total</th><th id="totalStatePrice">$8995</th></tr>
		    </tfoot>
		  </table>
	  @endif
     @if($selectedPackage == 'pick-a-state')
		 <table class="table">
		  <thead>
		     <tr><th>Description</th><th>Amount</th></tr>
		    </thead>
			<tbody style="text-align:left;">
		     <tr><td>PICK A STATE  <small>(FOR ONE STATE*)</small>
			          <div class="form-group defaultState">
						<input id="stateName" type="text" class="form-control {{ $errors->has('state_name') ? ' has-error' : '' }}" name="state_name" value="" placeholder="Enter State Name" value="" pattern="^[A-Za-z -]+$">
						</div> 
			      </td><td>$799 <u>MO</u></td></tr>
			<tbody id="additionalStateFields"></tbody>
			<tr><td>Add More Additional State for <strong>$599</strong> <u>MO</u> <small>EACH ADDITIONAL*</small></td><td><button type="button" class="btn btn-success" id="addmorBtn"><i class="fa fa-plus"></i></button></td></tr>	  
		 </tbody>
		 <tfoot style="text-align:left;">
		     <tr><th>Total</th><th id="totalStatePrice">$799</th></tr>
		    </tfoot>
		  </table>
		    <input type="hidden" id="current_state" name="curr_state" value="">
		@endif
      @if($selectedPackage == 'pick-a-city')
	 <table class="table">
		  <thead>
		     <tr><th>Description</th><th>Amount</th></tr>
		    </thead>
			<tbody style="text-align:left;">
		     <tr><td>PICK A CITY  <small>(FOR ONE CITY*)</small>
			          <div class="form-group defaultCity">
						<input id="cityName" type="text" class="form-control {{ $errors->has('city_name') ? ' has-error' : '' }}" name="city_name" value="" placeholder="Enter City Name" value="" pattern="^[A-Za-z -]+$">
						</div> 
			      </td><td>$99 <u>MO</u></td></tr>
			<tbody id="additionalFields"></tbody>
			<tr><td>Add More Additional City for <strong>$79</strong> <u>MO</u> <small>EACH ADDITIONAL*</small></td><td><button type="button" class="btn btn-success" id="addMoreCity"><i class="fa fa-plus"></i></button></td></tr>	  
		 </tbody>
		 <tfoot style="text-align:left;">
		     <tr><th>Total</th><th id="totalPrice">$99</th></tr>
		    </tfoot>
		  </table>
		  <input type="hidden" id="current_city" name="curr_city" value="">
	 @endif
		 </div>
	<div class="cancel-order text-center">
    <!---<button type="submit" class="btn btn-info-outline" id='reg-btn'>Cancel Order</button>-->
       </div>
 </div>
 