{{ $slot }}

@foreach($matches as $match)
{{ $match->first_name }}: [{{ route('pub.user.show', $match->username) }}]({{ route('pub.user.show', $match) }})

@endforeach