@component('mail::message')
# {{ $user->first_name }} we are sorry to see you go!

If you change you're mind you can renew your subscription by visiting your profile.
Any matches that you have will remain in place for the next 30 days until they are
removed.

@component('mail::button', ['url' => route('pub.profile.index')])
View My Profile
@endcomponent

Thanks,<br>
Team {!! get_application_name() !!}
@endcomponent
