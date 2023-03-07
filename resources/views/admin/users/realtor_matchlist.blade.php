@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1> All Matches</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Matches</a></li>
            <li class="active">All Matches</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Matches</h3>
                        <a href="{{ url('cpldashrbcs/add-matches') }}"><button type="button" class="btn btn-secondary" style="float:right;"><i class="fa fa-plus" aria-hidden="true"></i> Add Matches</button></a>
                    </div>
                    <div class="box-body">
                    <div id="dlt-msg" class="alert alert-success" style="display:none;"></div>
                        <table id="realor_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Lender Name (Email)</th>
                                <th>Status</th>
                                <th>Relator Name (Email)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($listrealtormatch) && !empty($listrealtormatch))
                            @php $i = 1; @endphp
                            @foreach($listrealtormatch as $user)
                            <tr class="row_<?= $user->user_id; ?>">
                                <td>{{$i++}}</td>
                                <td>
                                @if($user->matchrelatordata->user_type == 'broker') <a class="relatortn " data-toggle="modal" data-target="#viewrelator" data-firstname="{{ucfirst($user->matchrelatordata->first_name)}}"
                                data-last="{{ucfirst($user->matchrelatordata->last_name)}}" data-emailreal="{{$user->matchrelatordata->email}}" data-realphone="{{$user->matchrelatordata->phone_number}}"  data-city="{{$user->matchrelatordata->city}}" data-state="{{$user->matchrelatordata->state}}">{{ucfirst($user->matchrelatordata->first_name).' '.ucfirst($user->matchrelatordata->last_name)}}  (Email:  {{$user->matchrelatordata->email}}   Zipcode :  {{$user->matchrelatordata->zip}})</a>@endif</a>
                                @if($user->matchuserbeoker->user_type == 'broker')<a class="lenderbtnview" data-toggle="modal" data-target="#viewlender" data-firstnamelender="{{ucfirst($user->matchuserbeoker->first_name)}}"
                                data-lastlender="{{ucfirst($user->matchuserbeoker->last_name)}}" data-emaillender="{{$user->matchuserbeoker->email}}" data-lenderphone="{{$user->matchuserbeoker->phone_number}}" data-lendercity="{{$user->matchuserbeoker->city}}" data-lenderstate="{{$user->matchuserbeoker->state}}">{{ucfirst($user->matchuserbeoker->first_name).' '.ucfirst($user->matchuserbeoker->last_name)}}  (Email: {{$user->matchuserbeoker->email}}  -  Zipcode :{{$user->matchuserbeoker->zip}})</a>@endif</td>
                                <td class="matchlogdata">
                                <?php if($user->match_log_broker->match_action == 'initial'){ ?><span class="pending" style="color:red;"><?php echo "Pending";?></span><?php }
                                if($user->match_log_broker->match_action == 'accept'){?><span class="accepted" style="color:green;"><?php echo "Accepted";}?></td> 
                                <td>
                                @if($user->matchrelatordata->user_type == 'realtor')<a class="relatortn " data-toggle="modal" data-target="#viewrelator" data-firstname="{{ucfirst($user->matchrelatordata->first_name)}}"
                                data-last="{{ucfirst($user->matchrelatordata->last_name)}}" data-emailreal="{{$user->matchrelatordata->email}}" data-realphone="{{$user->matchrelatordata->phone_number}}"  data-city="{{$user->matchrelatordata->city}}" data-state="{{$user->matchrelatordata->state}}">{{ucfirst($user->matchrelatordata->first_name).' '.ucfirst($user->matchrelatordata->last_name)}}  (Email: {{$user->matchrelatordata->email}}  -  Zipcode : {{$user->matchrelatordata->zip}})</a>@endif
                                @if($user->matchuserbeoker->user_type == 'realtor')<a class="lenderbtnview" data-toggle="modal" data-target="#viewlender" data-firstnamelender="{{ucfirst($user->matchuserbeoker->first_name)}}"
                                data-lastlender="{{ucfirst($user->matchuserbeoker->last_name)}}" data-emaillender="{{$user->matchuserbeoker->email}}" data-lenderphone="{{$user->matchuserbeoker->phone_number}}" data-lendercity="{{$user->matchuserbeoker->city}}" data-lenderstate="{{$user->matchuserbeoker->state}}">{{ucfirst($user->matchuserbeoker->first_name).' '.ucfirst($user->matchuserbeoker->last_name)}}  (Email: {{$user->matchuserbeoker->email}}  - Zipcode : {{$user->matchuserbeoker->zip}})</a>@endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>No Records Found.</tr>
                            @endif
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div id="viewrelator" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background-color:green;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align:center;background-color:green;color:white;">REALTOR DETAILS</h4>
                </div>
                <div class="modal-body realtrpopup" style="background-color: #ece2cf;font-size: 17px;padding: 43px;">
                    First Name: <span class="realfirst"></span><br>
                    Last Name: <span class="reallastname"></span><br>
                    Email Address: <span class="realemail"></span><br>
                    Phone No: <span class="realphone"></span><br>
                    City: <span class="realcity"></span><br>
                    State: <span class="realstate"></span><br>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="viewlender" class="modal fade lenderviewpoup" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="text-align:center;background-color:#00c0ef;color:white;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align:center;background-color:#00c0ef;color:white;">LENDER DETAILS</h4>
                </div>
                <div class="modal-body lenderpopup" style="background-color:#e4e0e2;font-size: 17px;padding: 43px;">
                    First Name: <span class="lenderfirst"></span><br>
                    Last Name: <span class="lenderlast"></span><br>
                    Email Address: <span class="lenderemail"></span><br>
                    Phone No: <span class="lenderphoneno"></span><br>
                    City: <span class="lendercity"></span><br>
                    State: <span class="lenderstate"></span><br>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
    $(document).ready(function () {
        $(".relatortn").click(function(){
            $('.realtrpopup .realfirst').empty();
            $('.realtrpopup .reallastname').empty();
            $('.realtrpopup .realemail').empty();
            $('.realtrpopup .realphone').empty();
            $('.realtrpopup .realcity').empty();
            $('.realtrpopup .realstate').empty();
            var username = jQuery(this).attr("data-firstname");
            var lastname = jQuery(this).attr("data-last");
            var emailadd = jQuery(this).attr("data-emailreal");
            var phoneno = jQuery(this).attr("data-realphone");
            var realCity = jQuery(this).attr("data-city");
            var realState = jQuery(this).attr("data-state");
            $('.realtrpopup .realfirst').html(username);
            $('.realtrpopup .reallastname').html(lastname);
            $('.realtrpopup .realemail').html(emailadd);
            $('.realtrpopup .realphone').html(phoneno);
            $('.realtrpopup .realcity').html(realCity);
            $('.realtrpopup .realstate').html(realState);
        });
        $(".lenderbtnview").click(function(){
            $('.lenderpopup .lenderfirst').empty();
            $('.lenderpopup .lenderlast').empty();
            $('.lenderpopup .lenderemail').empty();
            $('.lenderpopup .lenderphoneno').empty();
            $('.lenderpopup .lendercity').empty();
            $('.lenderpopup .lenderstate').empty();
            var lenderfirstname = jQuery(this).attr("data-firstnamelender");
            var lenderlastname = jQuery(this).attr("data-lastlender");
            var lenderemailaddress = jQuery(this).attr("data-emaillender");
            var lenderphoneno = jQuery(this).attr("data-lenderphone");
            var lenderCity = jQuery(this).attr("data-lendercity");
            var lenderState = jQuery(this).attr("data-lenderstate");
            $('.lenderpopup .lenderfirst').html(lenderfirstname);
            $('.lenderpopup .lenderlast').html(lenderlastname);
            $('.lenderpopup .lenderemail').html(lenderemailaddress);
            $('.lenderpopup .lenderphoneno').html(lenderphoneno);
            $('.lenderpopup .lendercity').html(lenderCity);
            $('.lenderpopup .lenderstate').html(lenderState);
        });
    });
    </script>
@endsection