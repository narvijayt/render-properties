@php $states = app('App\Http\Utilities\Geo\USStates'); @endphp
@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>Users List</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Vendors</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All Vendors</h3>
                    </div>
                    	<div id="dlt-msg" class="alert alert-success" style="display:none;"></div>
                   <div class="box-body">
                   
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                     <th>Company</th>
                                   <th>Registered</th>
                                    <th>Package</th>
                                     <th>State</th>
                                    <th>City</th>
                                    <th>Payment Status</th>
                                    <th>Paid Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($users) && !empty($users))
                                    @php $i = 1; @endphp
                                     @foreach($users as $user)
                                     <tr class="row_<?= $user['user_id']; ?>">
                                            <td>{{$i++}}</td>
                                            <td><img src="{{$user->avatarUrl()}}" width="100%" alt="{{ $user->full_name() }}"/></td>
                                            @if(count($user->vendor_details) > 0 )
                                           <td><a class="vendordetail" data-toggle="modal" data-target="#viewvendor" data-firstname="{{ucfirst($user->first_name)}}"
                                            data-last="{{ucfirst($user->last_name)}}" data-emailreal="{{$user->email}}" data-realphone="{{$user->phone_number}}"  
                                            data-city="{{$user->vendor_details[0]->package_selected_city}}" data-state="{{$user->vendor_details[0]->package_selected_state}}" 
                                            data-package-price="{{$user->vendor_details[0]->payable_amount}}" data-package-additional-city="@if($user->vendor_details[0]->additional_city !="") {{implode(',',json_decode($users[0]->vendor_details[0]->additional_city))}} @endif"
                                            data-additional-state="@if($user->vendor_details[0]->additional_state !=""){{implode(',',json_decode($users[0]->vendor_details[0]->additional_state))}} @endif" 
                                            data-additional-paymentstatus="{{$user->vendor_details[0]->payment_status}}" data-vendorcoverage="{{$user->vendor_details[0]->vendor_coverage_area}}"
                                            data-vendor-services="{{$user->vendor_details[0]->vendor_service}}" data-package-id="{{$user->braintree_id}}"></a></td>
                                            @else
                                            
                                            <td>{{ucfirst($user['first_name'])}}</td>
                                            @endif
                                            <td>{{$user['email']}}</td>
                                            <td>{{str_replace('-', '', $user['phone_number'])}}</td>
										    <td>{{ucwords(substr($user['firm_name'], 0, 50))}}</td>
                                            <td>{{date('d M, Y',strtotime($user['created_at']))}}</td>
                                            <td>@if($user->braintree_id == '7')	<span class="success">For One City</span> @endif 
                                            @if($user->braintree_id == '8')<span class="success">For Each Additional City</span> @endif 
                                            @if($user->braintree_id == '9')<span class="success">For One state</span>@endif
                                            @if($user->braintree_id == '10')<span class="success">For Each Additional State </span>@endif
                                            @if($user->braintree_id == '11')<span class="success">United States</span>@endif
                                            @if($user->braintree_id == '13')<span class="success">Cash</span>@endif
                                            @if($user->braintree_id == '') <span class="error">N/A</span>@endif
                                            </td>
                                            
                                            <td>
                                                @if($user->state !="") {{$user->state}}@else<span class="error">N/A</span> @endif
                                       </td>
                                        <td>
                                             @if($user->city !="") {{$user->city}}@else<span class="error">N/A</span> @endif
                                       </td> 
                                            <td>
                                                @if($user->vendor_details->isEmpty())
                                               <span class="error">Pending </span> 
                                                @endif
                                            @foreach($user->vendor_details as $vendordet)
                                            @if($vendordet->payment_status !="" && $vendordet->payment_status !="Pending")<span class="success">{{$vendordet->payment_status}}</span>@else<span class="error">Pending </span> @endif
                                          @endforeach
                                     </td>
                                     <td>
                                         @if($user->vendor_details->isEmpty())
                                               <span class="error">Not Paid </span> 
                                                @endif
                                         @foreach($user->vendor_details as $vendordet)
                                            @if($vendordet->payable_amount !="")<span class="success">@if($vendordet->payable_amount == 'Cash') {{$vendordet->payable_amount}} @else $ {{$vendordet->payable_amount}} </span>@endif @else<span class="error">Not Paid</span> @endif
                                          @endforeach</td>
                                            <td>
                                                @if($user['active'] == 1)
                                                    <span class="success">Active</span>
                                                @else
                                                    <span class="error">Inactive</span>
                                                @endif
                                            </td>
                                            <td>   <a href="javascript:void(0)" class="delete-icon" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteUser(<?= $user['user_id'] ?>)">
                                                    <i class="fa fa-trash-o"></i></a>
                                                    <a href="{{url('cpldashrbcs/edit-vendor',[$user['user_id']])}}" class="edit-icon" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fa fa-edit"></i></a>
                                                  </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>No Records Found.</tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="page-div">
                        @if(isset($users) && !empty($users))
                            {{ $users->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <div id="viewvendor" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color:green;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align:center;background-color:green;color:white;">VENDOR DETAIL</h4>
      </div>
      <div class="modal-body realtrpopup" style="background-color: #ece2cf;font-size: 17px;padding: 43px;">
        <strong>First Name:</strong> <span class="realfirst"></span><br>
        <strong>Last Name:</strong> <span class="reallastname"></span><br>
        <strong>Email Address:</strong> <span class="realemail"></span><br>
        <strong>Phone No:</strong> <span class="realphone"></span><br>
        <strong>Coverage Area:</strong> <span class="coverage"></span><br>
        <strong>Vendor Services:</strong> <span class="vendService"></span>
        <div class="packageSel"><strong>Package:</strong> <span class="packName"></span><br></div>
        <div class="packageCity"><strong>Selected Package City:</strong> <span class="realcity"></span><br></div>
        <div class="additionalCity"><strong>Additional City: </strong> <span class="addCity"></span><br></div>
        <div class="packageState"><strong>Selected Package State: </strong> <span class="realstate"></span><br></div>
        <div class="additionalState"><strong>Additional State: </strong> <span class="addState"></span><br></div>
        <div class="packageAmount"><strong>Package Price: </strong><span class="pricePackage"></span><br></div>
        <div class="paymentStatus"><strong>Payment Status: </strong><span class="statusPay"></span><br></div>
      </div>
    </div>

  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
        $(document).ready(function () {
        $(".vendordetail").click(function(){
                $('.realtrpopup .realfirst').empty();
                $('.realtrpopup .reallastname').empty();
                $('.realtrpopup .realemail').empty();
                $('.realtrpopup .realphone').empty();
                $('.realtrpopup .realcity').empty();
                $('.realtrpopup .realstate').empty();
                var username = jQuery(this).attr("data-firstname");
                var lastname = jQuery(this).attr("data-last");
                var emailadd = jQuery(this).attr("data-emailreal");
                var phoneno = jQuery(this).attr("data-realphone");
                var realCity = jQuery(this).attr("data-city");
                var realState = jQuery(this).attr("data-state");
                var packagePrice = jQuery(this).attr("data-package-price");
                var additionalCities = jQuery(this).attr("data-package-additional-city");
                var additionalStates = jQuery(this).attr("data-additional-state");
                var paymentStatus = jQuery(this).attr("data-additional-paymentstatus");
                var vendorCoverage = jQuery(this).attr("data-vendorcoverage");
                var vendorSerice = jQuery(this).attr("data-vendor-services");
                var packageName = jQuery(this).attr("data-package-id");
                $('.realtrpopup .realfirst').html(username);
                $('.realtrpopup .reallastname').html(lastname);
                $('.realtrpopup .realemail').html(emailadd);
                $('.realtrpopup .realphone').html(phoneno);
                $('.realtrpopup .coverage').html(vendorCoverage);
                $('.realtrpopup .vendService').html(vendorSerice);
                if(realCity ==""){
                    $('.packageCity').css('display','none');
                }else{
                    $('.packageCity').css('display','block');
                    $('.realtrpopup .realcity').html(realCity);
                }
                if(realState ==""){
                    $('.packageState').css('display','none');
                }else{
                    $('.packageState').css('display','block');
                    $('.realtrpopup .realstate').html(realState);
                }
                if(packagePrice ==""){
                    $('.packageAmount').css('display','none');
                }else{
                    $('.packageAmount').css('display','block');
                    $('.realtrpopup .pricePackage').html('$'+packagePrice);
                }
                 if(additionalCities ==""){
                    $('.additionalCity').css('display','none');
                }else{
                    $('.additionalCity').css('display','block');
                    $('.realtrpopup .addCity').html(additionalCities);
                }
                if(additionalStates == ""){
                    $('.additionalState').css('display','none'); 
                }else{
                    $('.additionalState').css('display','block');
                    $('.realtrpopup .addState').html(additionalStates);
                }
                if(paymentStatus ==""){
                    $('.realtrpopup .statusPay').html('<span class="error">Pending</span>');
                }else{
                    $('.realtrpopup .statusPay').html(paymentStatus);
                }
                if(packageName !=""){
                    $('.packageSel').css('display','block');
                    if(packageName == '7'){
                        $('.realtrpopup .packName').html('<span class="success">For One City<span>');
                    }
                    if(packageName == '8'){
                       $('.realtrpopup .packName').html('<span class="success">For Each Additional City</span>'); 
                    }
                    if(packageName == '9'){
                        $('.realtrpopup .packName').html('<span class="success">For One state</span>');
                    }
                    if(packageName == '10'){
                        $('.realtrpopup .packName').html('<span class="success">For Each Additional State</span>');
                    }
                     if(packageName == '11'){
                        $('.realtrpopup .packName').html('<span class="success">United States</span>');
                    }
                }else{
                     $('.realtrpopup .packName').html('<span class="error">N/A</span>');
                }
             });
        });
       
        </script>
@endsection

