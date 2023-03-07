<div
    class="banner {{ isset($banner_class) ? $banner_class : '' }}"
    @if (isset($background))
        style="background-image: url('{{ $background }}');"
    @endif
>
    <div class="container">
        <div class="row">
            {{ $slot }}
        </div>
    </div>
</div>