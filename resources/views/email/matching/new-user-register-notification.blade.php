@component('mail::message')
<p>Dear {{ ucfirst($member->first_name) }},</p>

<p>We're excited to inform you that a new {{ $usertype }} has recently registered in your area! This presents a great opportunity for you to expand your network and connect with more home buyers and sellers who need your services. </p>

<p>To match with this new member and start connecting, simply click on the link below:</p>

@component('mail::button', ['url' =>  route('pub.user.show', ['user_id' => $user->user_id]) ])
View Details
@endcomponent

<p>Don't miss out on this chance to grow your business and reach more clients. We look forward to seeing the successful connections you make!</p>

Best regards,<br>
{{ $member->first_name.' '.$member->last_name }},<br>
{{ $memberType }},<br>
@if(!empty($member->phone_number))
    Phone: {{ $member->phone_number }},<br>
@endif