<div class="container">
    <div class="row">
        {{--
        <div class="col-md-3">
            <div class="container" style="padding:0px;">
                <div class=row>
                    <div class="col-md-3" style="white-space: nowrap; padding-left: 0px;">
                        <img src="{{ $review->reviewer->avatarUrl() }}" class="img-responsive"/>
                    </div>
                </div>
            </div>
        </div>
        --}}
        
        <div class="col-md-12 social-review-row">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left">
                        @component('pub.components.ratings', ['rating' => $review->rating, 'class' => 'small']) @endcomponent
                    </div>
                
                    <span style="padding-left:15px;"></span>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    {{ $review->reviewDate}} - {{ $review->reviewer }}
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">{{ $review->reviewSummary}}</div>
            </div>
            
            @if(!empty($review->revieweeFullName))
                <div class="row">
                    <div class="col-md-12">
                        Review for Former Member: {{ $review->revieweeFullName }}
                    </div>
                </div>
            @endif
            
            
            
            <div class="row mt-1">
                <div class="col-md-12" style="font-size: 16px;">
                    {{$review->description}}
                </div>
            </div>
            
        </div>
        
    </div>
    <hr>
</div>