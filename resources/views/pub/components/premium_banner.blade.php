<div class="banner {{ isset($banner_class) ? $banner_class : '' }}"
    @if (isset($findBanner))
        style="background-image: url('{{asset('banner')}}/{{ $findBanner[0]->banner_image }}');"
    @endif
>
<div class="container">
        <div class="row">
           {{ $slot }}
        </div>
    </div>
</div>