@php $states = app('App\Http\Utilities\Geo\USStates'); @endphp
@extends('admin.layouts.main')
@section('content')
<section class="content-header">
    <h1>Users List</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Vendors</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <div class="col-md-10">
                        <h3 class="box-title">Vendors</h3>
                    </div>
                    <div class="col-md-2 text-right">
                        <h4>Total: {{ $users->total() }}</h4>
                    </div>
                </div>
                <div id="dlt-msg" class="alert alert-success" style="display:none;"></div>
                <div class="box-body px-2">
                    <form name="broker-form" action="{{ route('admin.vendors') }}" method="get">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>By Name/Email</label>
                                <div class="form-input">
                                    <input type="text" name="search" class="form-control" value="{{ isset($_REQUEST['search']) ? $_REQUEST['search'] : '' }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Payment Status</label>
                                <div class="form-input">
                                    <select class="form-control" name="payment_status">
                                        <option value="all">All</option>
                                        <option value="online_paid" {{ (isset($_REQUEST['payment_status']) && $_REQUEST['payment_status'] == "online_paid" ) ? "selected" : "" }}>Online Payment</option>
                                        <option value="manual_paid" {{ (isset($_REQUEST['payment_status']) && $_REQUEST['payment_status'] == "manual_paid" ) ? "selected" : "" }}>Manual Payment</option>
                                        <option value="unpaid" {{ (isset($_REQUEST['payment_status']) && $_REQUEST['payment_status'] == "unpaid" ) ? "selected" : "" }}>Unpaid</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp;</label>
                            <div class="form-input">
                                <button type="submit" id="filter" class="btn btn-success">Filter</button>
                            </div>
                        </div>
                    </form>
                    <table id="realor_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Registered</th>
                                <th>Billing</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($users) && !empty($users))
                            @php $i = 1; @endphp
                            @foreach($users as $user)
                            <tr class="row_<?= $user['user_id']; ?>">
                                <td>{{$i++}}</td>
                                <td>{{ucfirst($user['first_name'])}}</td>
                                <td>{{$user['email']}}</td>
                                <td>{{str_replace('-', '', $user['phone_number'])}}</td>
                                <td>{{date('d M, Y',strtotime($user['created_at']))}}</td>
                                <td>
                                    @if($user->payment_status == 0)
                                        <span class="error">Unpaid </span>
                                    @elseif($user->payment_status == 1)
                                        <span class="success">Paid {{ ($user->vendorPackage) ? '('.ucfirst($user->vendorPackage->packageType).' Plan)': ''}}</span>
                                    @endif
                                </td>
                                <td> <a href="javascript:void(0)" class="delete-icon" data-toggle="tooltip"
                                        data-placement="top" title="Delete"
                                        onclick="deleteUser(<?= $user['user_id'] ?>)">
                                        <i class="fa fa-trash-o"></i></a>
                                    <a href="{{url('cpldashrbcs/edit-vendor',[$user['user_id']])}}" class="edit-icon"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>No Records Found.</tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="page-div">
                        @if(isset($users) && !empty($users))
                            {{ $users->appends($_GET)->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="viewvendor" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color:green;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="text-align:center;background-color:green;color:white;">VENDOR DETAIL</h4>
            </div>
            <div class="modal-body realtrpopup" style="background-color: #ece2cf;font-size: 17px;padding: 43px;">
                <strong>First Name:</strong> <span class="realfirst"></span><br>
                <strong>Last Name:</strong> <span class="reallastname"></span><br>
                <strong>Email Address:</strong> <span class="realemail"></span><br>
                <strong>Phone No:</strong> <span class="realphone"></span><br>
                <strong>Coverage Area:</strong> <span class="coverage"></span><br>
                <strong>Vendor Services:</strong> <span class="vendService"></span>
                <div class="packageSel"><strong>Package:</strong> <span class="packName"></span><br></div>
                <div class="packageCity"><strong>Selected Package City:</strong> <span class="realcity"></span><br>
                </div>
                <div class="additionalCity"><strong>Additional City: </strong> <span class="addCity"></span><br></div>
                <div class="packageState"><strong>Selected Package State: </strong> <span class="realstate"></span><br>
                </div>
                <div class="additionalState"><strong>Additional State: </strong> <span class="addState"></span><br>
                </div>
                <div class="packageAmount"><strong>Package Price: </strong><span class="pricePackage"></span><br></div>
                <div class="paymentStatus"><strong>Payment Status: </strong><span class="statusPay"></span><br></div>
            </div>
        </div>

    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $(".vendordetail").click(function() {
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
        var packagePrice = jQuery(this).attr("data-package-price");
        var additionalCities = jQuery(this).attr("data-package-additional-city");
        var additionalStates = jQuery(this).attr("data-additional-state");
        var paymentStatus = jQuery(this).attr("data-additional-paymentstatus");
        var vendorCoverage = jQuery(this).attr("data-vendorcoverage");
        var vendorSerice = jQuery(this).attr("data-vendor-services");
        var packageName = jQuery(this).attr("data-package-id");
        $('.realtrpopup .realfirst').html(username);
        $('.realtrpopup .reallastname').html(lastname);
        $('.realtrpopup .realemail').html(emailadd);
        $('.realtrpopup .realphone').html(phoneno);
        $('.realtrpopup .coverage').html(vendorCoverage);
        $('.realtrpopup .vendService').html(vendorSerice);
        if (realCity == "") {
            $('.packageCity').css('display', 'none');
        } else {
            $('.packageCity').css('display', 'block');
            $('.realtrpopup .realcity').html(realCity);
        }
        if (realState == "") {
            $('.packageState').css('display', 'none');
        } else {
            $('.packageState').css('display', 'block');
            $('.realtrpopup .realstate').html(realState);
        }
        if (packagePrice == "") {
            $('.packageAmount').css('display', 'none');
        } else {
            $('.packageAmount').css('display', 'block');
            $('.realtrpopup .pricePackage').html('$' + packagePrice);
        }
        if (additionalCities == "") {
            $('.additionalCity').css('display', 'none');
        } else {
            $('.additionalCity').css('display', 'block');
            $('.realtrpopup .addCity').html(additionalCities);
        }
        if (additionalStates == "") {
            $('.additionalState').css('display', 'none');
        } else {
            $('.additionalState').css('display', 'block');
            $('.realtrpopup .addState').html(additionalStates);
        }
        if (paymentStatus == "") {
            $('.realtrpopup .statusPay').html('<span class="error">Pending</span>');
        } else {
            $('.realtrpopup .statusPay').html(paymentStatus);
        }
        if (packageName != "") {
            $('.packageSel').css('display', 'block');
            if (packageName == '7') {
                $('.realtrpopup .packName').html('<span class="success">For One City<span>');
            }
            if (packageName == '8') {
                $('.realtrpopup .packName').html(
                    '<span class="success">For Each Additional City</span>');
            }
            if (packageName == '9') {
                $('.realtrpopup .packName').html('<span class="success">For One state</span>');
            }
            if (packageName == '10') {
                $('.realtrpopup .packName').html(
                    '<span class="success">For Each Additional State</span>');
            }
            if (packageName == '11') {
                $('.realtrpopup .packName').html('<span class="success">United States</span>');
            }
        } else {
            $('.realtrpopup .packName').html('<span class="error">N/A</span>');
        }
    });
});
</script>
@endsection