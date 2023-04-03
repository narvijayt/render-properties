@php
/** @var $user \App\User */
@endphp
@component('mail::message')
#User Plan Upgrade Details

### Details:
@if($user[0]->first_name !="") Name: {{ $user[0]->first_name }} {{ $user[0]->last_name }} <br> @endif
@if($user[0]->email !="" ) Email: {{ $user[0]->email }} <br> @endif
@if($user[0]->phone_number !="") Phone: {{ $user[0]->phone_number }} <br> @endif
@if($user[0]->website !="")  Website: {{ $user[0]->website }} <br> @endif
@if($user[0]->user_type !="")  User Type: {{ $user[0]->user_type}} <br> @endif
@if($user[0]->firm_name !="")  Company: {{ $user[0]->firm_name }} <br> @endif
@if($user[0]->vendor_details[0]->vendor_coverage_area !="")  Coverage Area: {{$user[0]->vendor_details[0]->vendor_coverage_area}} <br> @endif
@if($user[0]->vendor_details[0]->vendor_service !="")  Vendor Service: {{$user[0]->vendor_details[0]->vendor_service}} <br> @endif
@if($user[0]->vendor_details[0]->package_selected_state !="")  Package State: {{$user[0]->vendor_details[0]->package_selected_state}} <br>@endif
@if($user[0]->vendor_details[0]->package_selected_city !="")  Package City: {{$user[0]->vendor_details[0]->package_selected_city}} <br> @endif
@if($user[0]->vendor_details[0]->additional_city !="")  Additional City: {{implode(',',json_decode($user[0]->vendor_details[0]->additional_city))}} <br> @endif
@if($user[0]->vendor_details[0]->additional_state !="") Additional State: {{implode(',',json_decode($user[0]->vendor_details[0]->additional_state))}} <br> @endif
@if($user[0]->vendor_details[0]->payable_amount !="")  Paid Amount: <b>${{$user[0]->vendor_details[0]->payable_amount}}</b> <br> @endif
@if($user[0]->vendor_details[0]->payment_status !="")  Payment Status: {{$user[0]->vendor_details[0]->payment_status}}@else Pending @endif
<br>

    Thanks,
    Team {!! get_application_name() !!}
    @endcomponent