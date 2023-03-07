<div class="row">
   <div class="col-md-8 Biographical-information">
         @if($user->user_id == '1822')
      <img src="{{asset('img/EnvoyLogo.jpg')}}" class="premiumuser-logo">
        @endif
        <h2 class="bio-title line-left">Biographical information</h2>
        <ul class="list-unstyled">
            <li>
                @if($user->bio !="")
                 {{ $user->bio }}
                @else
                   N/A
                @endif
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="col-md-4">
        @if($user->video_url !="")
            <iframe src="{{$user->video_url}}" width="100%" height="210" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
        @endif
        <div class="user-map-Location">
            <h4>Map Location</h4>
            @include('pub.partials.google-map', [
            'markers' => [
            [
            'lat' => $user->latitude,
            'lng' => $user->longitude
            ]
            ]
            ])
        </div>
    </div>
</div>

