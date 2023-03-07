@component('mail::message', [
    'user' => $review->subject,
    'email_type' => config('mail.email_types.review_messages')
])
#Reason for Overriding:
{{$overrideMessage}}
@component('mail::panel')
#Review Details
#Person being reviewed: {{$review->subject->email}}
#Person who sent the review: {{$review->reviewer->email}}
#Below is the rejected review message:
{{$review->message}}
#Reasoning for rejecting:
{{$review->reject_message}}
@endcomponent
@endcomponent