@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')

            @isset($user)
This email was sent to: {{ $user->email }}
Unsubscribe: {{ route('unsubscribe.index', ['uid' => $user->uid, 'type' => $email_type]) }}
Email Preferences: {{ route('pub.profile.settings.index') }}
            @endisset

Render | 1024 Spyglass Lane, Waxhaw, NC 28173 | © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
