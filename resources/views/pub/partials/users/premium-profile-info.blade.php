<div class="row">
<div class="col-md-8 Biographical-information">
    <h2 class="bio-title line-left">Biographical information</h2>
    <ul class="list-unstyled">
        <li>@if($user->bio !="") {{ $user->bio }} @else N/A @endif</li>
    </ul>
    <div class="clearfix"></div><br>
    @if($user->user_type == 'vendor')
        <h4 class="bio-title line-left">Experience</h4>
        <table class="table">
        <tr><th>Industry:</th>
        <td>@if(count($categoryName)>0){{implode(',', $categoryName)}}@endif</td>
        </tr> 
        <tr><th>Services Offered:</th>
        <td>@if($fetchOverallData[0]->vendor_details !="") {{$fetchOverallData[0]->vendor_details[0]->vendor_service}} @endif</td></tr> 
        <tr><th>Area Covered:</th>
        <td>@if($fetchOverallData[0]->vendor_details !="") {{$fetchOverallData[0]->vendor_details[0]->vendor_coverage_area}} @endif</td></tr> 
        </tr> 
        </table>
    @endif
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

