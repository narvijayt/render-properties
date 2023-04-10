@php 
	$authUser = auth()->user();
	if($authUser->user_type == "broker"){
        $realtor = $user;
        $lendor = $authUser;
    }else{
        $realtor = $authUser;
        $lendor = $user;
    }
@endphp

@component('mail::message')
# Hello {{ ucfirst($user->first_name) }}, you have received a new match request from {{ ucfirst($authUser->first_name) }}

Click on the link below to view the details.

@component('mail::button', ['url' => route('view.automatch', ['brokerId' => $lendor->user_id, 'realtorId' => $realtor->user_id]) ])
View Match Request
@endcomponent

Thanks,<br>
Team {!! get_application_name() !!}
@endcomponent
