<div class="packageSel package-infobox">
    <div class="box-title-box">
        <h1 class="box-title line-left family-mont">ORDER DETAILS</h1>
        <p>Below are your order details.</p>
    </div>
    <div class="text-center selected-box">
        <h3 class="family-mont">Your Order Summary</h3>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody style="text-align:left;">
                <tr>
                    <td>
						{{ $vendorPackage->packageType == "usa" ? "United States" : "Pick a ".$vendorPackage->packageType }} 
						<small>({{ $vendorPackage->packageType == "usa" ? "FOR ONE MONTH" : "For One ".$vendorPackage->packageType }}*)</small>
                        <input type="hidden" name="packageId" value="{{ $vendorPackage->id }}">

						@if($userDetails->packageId != $vendorPackage->id)
                        	<input type="hidden" name="oldPackageId" value="{{ $userDetails->packageId }}">
						@endif
						
						@if($vendorPackage->packageType != "usa")
							@if(!is_null($vendorDetails) && ($userDetails->packageId == $vendorPackage->id))
								@php
									$selectedItem = 'package_selected_'.$vendorPackage->packageType;
								@endphp
								<div class="form-group default{{ ucfirst($vendorPackage->packageType)}}">
									<input id="{{ $vendorPackage->packageType }}Name" type="text" class="form-control {{ $errors->has($vendorPackage->packageType.'_name') ? ' has-error' : '' }}" name="{{$vendorPackage->packageType}}_name" value="{{ $vendorDetails->$selectedItem }}" placeholder="Enter {{ ucfirst($vendorPackage->packageType)}} Name"  pattern="^[A-Za-z -]+$">
								</div>	
							@else
								<div class="form-group default{{ ucfirst($vendorPackage->packageType)}}">
									<input id="{{ $vendorPackage->packageType }}Name" type="text" class="form-control {{ $errors->has($vendorPackage->packageType.'_name') ? ' has-error' : '' }}" name="{{$vendorPackage->packageType}}_name" value="" placeholder="Enter {{ ucfirst($vendorPackage->packageType)}} Name" pattern="^[A-Za-z -]+$">
								</div>
							@endif
						@endif
                    </td>
                    <td>${{ (get_decimal_value($vendorPackage->basePrice) > 0) ? $vendorPackage->basePrice : floor($vendorPackage->basePrice)  }} MO</u></td>
                </tr>
            <tbody id="additionalItemsField">
			@if($vendorPackage->packageType != "usa")
				@if(!is_null($vendorDetails) && ($userDetails->packageId == $vendorPackage->id))
					@php 
						$additionalItemsLabel = 'additional_'.$vendorPackage->packageType;
						$additionalItems = json_decode($vendorDetails->$additionalItemsLabel);
					@endphp
					@if(!empty($additionalItems))
						@foreach($additionalItems as $index=>$item)
							<tr id="row">
								<td>
									<div class="odd gradeX">
										<input type="text" id="add_additional{{$vendorPackage->packageType}}" name="additional_{{$vendorPackage->packageType}}[]" placeholder="Enter Additional {{ ucfirst($vendorPackage->packageType)}}" value="{{ $item }}" class="form-control required" />
									</div>
								</td>
								<td>
									<button type="button" name="remove" class="btn btn-warning removeAdditionalItem">
										<i class="fa fa-close"></i>
									</button>
								</td>
							</tr>
						@endforeach
					@endif
				@endif
			@endif
			</tbody>
				<tr>
					@if($vendorPackage->packageType == "usa")
						<td><strong>OWN THE U.S. IN YOUR INDUSTRY!!!</strong></td>
					@else
						<td>Add More Additional {{ ucfirst($vendorPackage->packageType) }} for <strong>${{ (get_decimal_value($vendorPackage->addOnPrice) > 0) ? $vendorPackage->addOnPrice : floor($vendorPackage->addOnPrice)  }}</strong> <u>MO</u> <small>EACH ADDITIONAL*</small></td>
						<td><button type="button" class="btn btn-success" id="addAdditionalItem" data-type="{{$vendorPackage->packageType}}" data-baseprice="{{$vendorPackage->basePrice}}" data-addonprice="{{$vendorPackage->addOnPrice}}"><i class="fa fa-plus"></i></button>
						</td>
					@endif
				</tr>
            </tbody>
            <tfoot style="text-align:left;">
                <tr>
                    <th>Total</th>
                    <th id="totalPrice">${{ (get_decimal_value($vendorPackage->basePrice) > 0) ? $vendorPackage->basePrice : floor($vendorPackage->basePrice) }}</th>
                </tr>
            </tfoot>
        </table>
        
        {{--
			<table class="table">
				<thead>
					<tr>
						<th>Description</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody style="text-align:left;">
					<tr>
						<td>PICK A STATE <small>(FOR ONE STATE*)</small>
							<div class="form-group defaultState">
								<input id="stateName" type="text"
									class="form-control {{ $errors->has('state_name') ? ' has-error' : '' }}"
									name="state_name" value="" placeholder="Enter State Name" value=""
									pattern="^[A-Za-z -]+$">
							</div>
						</td>
						<td>$799 <u>MO</u></td>
					</tr>
				<tbody id="additionalStateFields"></tbody>
					<tr>
						<td>Add More Additional State for <strong>$599</strong> <u>MO</u> <small>EACH ADDITIONAL*</small></td>
						<td><button type="button" class="btn btn-success" id="addmorBtn"><i class="fa fa-plus"></i></button>
						</td>
					</tr>
				</tbody>
				<tfoot style="text-align:left;">
					<tr>
						<th>Total</th>
						<th id="totalStatePrice">$799</th>
					</tr>
				</tfoot>
			</table>
			<input type="hidden" id="current_state" name="curr_state" value="">
			

			@if($selectedPackage == 'pick-a-city')
			<table class="table">
				<thead>
					<tr>
						<th>Description</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody style="text-align:left;">
					<tr>
						<td>PICK A CITY <small>(FOR ONE CITY*)</small>
							<div class="form-group defaultCity">
								<input id="cityName" type="text"
									class="form-control {{ $errors->has('city_name') ? ' has-error' : '' }}"
									name="city_name" value="" placeholder="Enter City Name" value=""
									pattern="^[A-Za-z -]+$">
							</div>
						</td>
						<td>$99 <u>MO</u></td>
					</tr>
				<tbody id="additionalFields"></tbody>
				<tr>
					<td>Add More Additional City for <strong>$79</strong> <u>MO</u> <small>EACH ADDITIONAL*</small></td>
					<td><button type="button" class="btn btn-success" id="addMoreCity"><i class="fa fa-plus"></i></button>
					</td>
				</tr>
				</tbody>
				<tfoot style="text-align:left;">
					<tr>
						<th>Total</th>
						<th id="totalPrice">$99</th>
					</tr>
				</tfoot>
			</table>
			<input type="hidden" id="current_city" name="curr_city" value="">
			@endif

		--}}
    </div>
    <div class="cancel-order text-center">
        <!---<button type="submit" class="btn btn-info-outline" id='reg-btn'>Cancel Order</button>-->
    </div>
</div>