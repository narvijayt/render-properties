@extends('admin.layouts.main')
@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
    <section class="content-header">
        <h1>Add Manual Matches</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Matches</a></li>
            <li class="active">Add Matches</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Add Manual Matches</h3>
                    </div>
                    <div class="box-body">
                        <form id="add_matches" method="post">
                            <label for="selectrelator">Search Lender</label>
                            <div class="form-group">
                                <input list="answers" id="answer" class="form-control" placeholder="Enter Lender To Search" >
                                    <datalist id="answers">
                                        @foreach($selectalllender as $lenderdata)
                                            <option data-value="{{$lenderdata->user_id}}">{{$lenderdata->first_name}} {{$lenderdata->last_name}} ({{$lenderdata->email}})</option>
                                        @endforeach
                                    </datalist>
                                    <input type="hidden" name="lenderlist" id="answer-hidden">
                                    <small id="relatedbroker" class="form-text text-muted"></small>
                                    <small id="sucessrealtor" class="form-text text-muted"></small>
                                    <small id="pendingstatus"></small>
                            </div>
                            <label for="selectrelator">Select/ Search Realtor</label>
                                <div class="form-group">
                                    <select theme="google" width="400"  class="form-control" placeholder="Search Relator" data-search="true" name="addrelator" id="selectrealtor" disabled="disabled">
                                        @foreach($relator as $listallrealtor) 
                                            <option value="{{$listallrealtor->user_id}}">{{$listallrealtor->first_name}}  {{$listallrealtor->last_name}} ({{$listallrealtor->email}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" id="selected_reltordata" name="relatorId">
                                <input type="submit" class="btn btn-primary" disabled="disabled" id="addMatch" value="Add Match" name="AddMatches">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
    document.querySelector('input[list]').addEventListener('input', function(e) {
        jQuery("#relatedbroker").empty();
        jQuery("#pendingstatus").empty();
        jQuery("#sucessrealtor").empty();
        var input = e.target,
        list = input.getAttribute('list'),
        options = document.querySelectorAll('#' + list + ' option'),
        hiddenInput = document.getElementById(input.getAttribute('id') + '-hidden'),
        label = input.value;
        hiddenInput.value = label;
        for(var i = 0; i < options.length; i++) {
            var option = options[i];
            if(option.innerText === label) {
                hiddenInput.value = option.getAttribute('data-value');
                var lenderid =   hiddenInput.value;
                    jQuery.ajaxSetup({
                        headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    jQuery.ajax({
                        url:"{{ route('checkconnection.lender') }}",
                        method:"GET",
                        dataType: 'json',
                        data:{lenderid:lenderid},
                        success:function(data)
                        {
                        if(data !="")
                        {
                            var jsonparse = JSON.stringify(data);
                            var stringifyData = JSON.parse(jsonparse);
                                for (var i = 0; i < stringifyData.length; i++) {
                                var logstatus = stringifyData[i]['match_log_broker']['match_action'];
                                if(logstatus == 'initial'){
                                    jQuery('#pendingstatus').append("Pending match found with");
                                    jQuery("#pendingstatus").append(" ");
                                    jQuery('#pendingstatus').css('color','red');
                                    var RealtorFirstNameinitial = stringifyData[i]['matchrelatordata']['first_name'];
                                    jQuery('#pendingstatus').append(RealtorFirstNameinitial );
                                    jQuery("#pendingstatus").append(" ");
                                    var RealtorLastNameinitial = stringifyData[i]['matchrelatordata']['last_name'];
                                    jQuery('#pendingstatus').append(RealtorLastNameinitial );
                                    jQuery("#pendingstatus").append("</br>");
                                }
                                if(logstatus == 'accept'){
                                    jQuery('#relatedbroker').append("Match found with ");
                                    jQuery("#relatedbroker").append(" ");
                                    var RealtorFirstName = stringifyData[i]['matchrelatordata']['first_name'];
                                    jQuery('#relatedbroker').append(RealtorFirstName );
                                    jQuery("#relatedbroker").append(" ");
                                    var RealtorLastName = stringifyData[i]['matchrelatordata']['last_name'];
                                    jQuery('#relatedbroker').append(RealtorLastName );
                                    jQuery("#relatedbroker").append(" ");
                                    jQuery("#relatedbroker").append("</br>");
                                }
                                }
                                jQuery('#selectrealtor').removeAttr("disabled");
                        }else{
                            jQuery('#sucessrealtor').text("This Lender is not matched with anyone.");
                            jQuery('#sucessrealtor').css('color','green');
                            jQuery('#selectrealtor').removeAttr("disabled");
                        }
                        },
                        error: function (xhr, status, error) 
                        {
                        }
                    });
                break;
            }
        }
    });
    document.getElementById("add_matches").addEventListener('submit', function(e) {
        var value = document.getElementById('answer-hidden').value;
    });
</script>
<script>
    var k = jQuery.noConflict();
    k(document).ready(function(){
        k("#selectrealtor").change(function(){
            var previouVaal = k(this).val();
            var getrelatorid = k('#selectrealtor').val();
            k("#selectrealtor option[value=" + getrelatorid + "]").attr('selected','selected');
            jQuery('#addMatch').removeAttr("disabled");
        });
    });
   </script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="{{ asset('js/admin/selectstyle.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('js/admin/selectstyle.css')}}">
    <script>
    jQuery(document).ready(function($) {
        $('select').selectstyle({
            width  : 1000,
            height : 300,
            theme  : 'light',
                onchange : function(val){
                }
        });
    });
    </script>
@endsection