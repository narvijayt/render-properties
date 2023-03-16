@extends('pub.profile.layouts.profile')

@section('title', 'Manage Matches')

@section('page_content')

    <div>
        {{--You are currently using {{ $usedMatchesCount }} of {{ $purchasedMatchesCount }} available matches.--}}
        {{--@can('purchase-additional-matches', \App\User::class)--}}
            {{--<a href="{{ route('pub.profile.payment.purchase-matches-show') }}" class="btn btn-warning btn-sm pull-right">Purchase More</a>--}}
        {{--@endcan--}}
    </div>
    <div class="row">
        <div class="col-md-12">

            @if ($activeMatches->count() !== 0)
                <h3>Existing Matches</h3>
                <?php /** @var \App\Match $match */ ?>
                <ul class="list-unstyled">
                @foreach($activeMatches as $match)
                    @include('pub.profile.partials.matches.result', [
                        'user' => $user,
                        'match' => $match,
                    ])
                @endforeach
                </ul>
            @endif

            @if($pendingMatches !== 0)
                <h3>Pending Matches</h3>
                <ul class="list-unstyled">
                    @foreach($pendingMatches as $match)
                        @include('pub.profile.partials.matches.result', [
                            'user' => $user,
                            'match' => $match
                        ])
                    @endforeach
                </ul>
            @endif

            @if($renewableMatches !== 0)
                <h3>Renewable Matches</h3>
                <ul class="list-unstyled">
                    @foreach($renewableMatches as $match)
                        @include('pub.profile.partials.matches.result', [
                            'user' => $user,
                            'match' => $match
                        ])
                    @endforeach
                </ul>
            @endif

        </div>
    </div>


    <div class="modal" tabindex="-1" role="dialog" id="confirm-submit-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cls-cross"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Confirm</h4>
                </div>
                <div class="modal-body">
                    <p id="confirm-submit-modal-message">Are you sure?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close" id="cls">Close</button>
                    <button type="button" class="btn btn-primary" id="confirm-submit-modal-accept" aria-label="Yes">Yes</button>
    				<div id="loading-imgs" style="display: none; position: absolute; z-index: 9; top: 60%; left: 50%; transform: translate(-50%, -50%);">
    					<img src="{{asset('img/profile-loader.gif')}}" />
    				</div>
    				
                    <form method="post" id="confirm-modal-match-form" action="">
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@push('scripts-footer')
    <script>
        
        function confirmMatch(id, type) {
            $('#confirm-submit-modal').show();
            if(type==='remove') {
                $('#confirm-submit-modal-message').text('Are you sure want to remove this match?')
            } else if(type==='renew') {
                $('#confirm-submit-modal-message').text('Are you sure you wish to renew the match with this user?')
            } else if(type==='confirm_renew') {
                $('#confirm-submit-modal-message').text('Are you sure you wish to accept the match renewal with this user?')
            } else if(type==='reject_match') {
                $('#confirm-submit-modal-message').text('Are you sure you wish to reject the match with this user?')
            } else if(type==='reject_renew_match') {
                $('#confirm-submit-modal-message').text('Are you sure you wish to reject the match renewal with this user?')
            }
            
            // $("#confirm-submit-modal #actionType").val(type);
            // $("#confirm-submit-modal #userId").val(id);
            var app_url = window.location.protocol+ "//"+ location.hostname;
            if(type==='accept') {
                var url = app_url+'matches/'+id+'/confirm-match';
            } else if(type==='remove') {
                var url = app_url+'matches/'+id+'/remove-match';
            } else if(type==='renew') {
                var url = app_url+'matches/'+id+'/request-renew-match';
            } else if(type==='confirm_renew') {
                var url = app_url+'matches/'+id+'/confirm-renew-match';
            } else if(type==='reject_match') {
                var url = app_url+'matches/'+id+'/reject-match';
            } else if(type==='reject_renew_match') {
                var url = app_url+'matches/'+id+'/reject-renew-match';
            }
            
            $("#confirm-modal-match-form").attr("action", url);
        }
        
        jQuery(document).ready(function($){
            
            $("#confirm-submit-modal-accept").on('click', function() {
                
                /*console.log("Type = ", type);
                console.log("ID = ", id);
                var type = $("#confirm-submit-modal #actionType").val();
                var id = $("#confirm-submit-modal #userId").val();
                var app_url = 'https://www.render.properties/matches';
                
                if(type==='accept') {
                    $("#confirm-match-form").submit();
                    // var url = app_url+'/'+id+'/confirm-match';
                } else if(type==='remove') {
                    var url = app_url+'/'+id+'/remove-match';
                } else if(type==='renew') {
                    var url = app_url+'/'+id+'/request-renew-match';
                } else if(type==='confirm_renew') {
                    var url = app_url+'/'+id+'/confirm-renew-match';
                } else if(type==='reject_match') {
                    var url = app_url+'/'+id+'/reject-match';
                } else if(type==='reject_renew_match') {
                    var url = app_url+'/'+id+'/reject-renew-match';
                }
                
                $("#confirm-modal-match-form").attr("action", url);*/
                
                $("#confirm-modal-match-form").submit();
                /*
                $.ajax({
                    type: 'POST',
                    url: url,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    // headers: { 'X-CSRF-Token': "{{ csrf_token() }}", 'Accept' : 'application/json'},
					beforeSend: function() {
						$("#loading-imgs").show();
					},	
                    success: function (data) {
                        console.log(data);
                        
						$("#loading-imgs").hide();
                        $('#confirm-submit-modal').hide();
                        window.location.reload();
                        
                    }
                });
                */
            });
            
    
            $(document).on('click', '#cls',function(){
                $('#confirm-submit-modal').hide();
            });
    
            $(document).on('click', '#cls-cross',function(){
                $('#confirm-submit-modal').hide();
            });
        
        });
    </script>
@endpush
