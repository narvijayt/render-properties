{{--

Accepts 2 arguments:
    int $rating The rating that should be displayed as an integer eg. 3.5
    string $class large|normal|small|tiny

 --}}
<div class="ratings">
    <div class="ratings__icons">
        @for($i = 1; $i <= $rating; $i++)
            <span class="ratings__icon--{{ isset($class) ? $class : 'normal' }}">
                @include('partials.svg.full-house-ratings')
            </span>
        @endfor
        @if($rating - floor($rating) != 0)
            <span class="fa ratings__icon--{{ isset($class) ? $class : 'normal' }}">
                @include('partials.svg.half-ratings')
            </span>
        @endif
        @for($i = ceil($rating); $i < 5; $i++)
            <span class="fa ratings__icon--{{ isset($class) ? $class : 'normal' }}">
                @include('partials.svg.gray-house-ratings')
            </span>
        @endfor
    </div>

    {{ $slot }}
</div>