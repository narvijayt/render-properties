@component('mail::message', [
    'user' => $user,
    'email_type' => config('mail.email_types.match_suggestions')
])
# {{ $user->first_name }}, here are some potential matches we found for you!
### {{ $subject }}

@component('mail::matches', [
    'matches' => $matches
])
Your Matches
@endcomponent
{{--@foreach($matches as $match)--}}
{{--<img src="{{ $match->avatarUrl() }}">--}}
{{--{{ $match->full_name() }}--}}

{{--@endforeach--}}
{{--@component('mail::button', ['url' => ''])--}}
{{--Button Text--}}
{{--@endcomponent--}}

Thank you,<br>
Team {!! get_application_name() !!}
@endcomponent
