@inject('states', 'App\Http\Utilities\Geo\USStates')
@extends('admin.layouts.main')
@section('content')
<section class="content-header">
    <h1>Property Leads</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Leads</li>
        <li class="active">Property</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="box">
                <div class="box-header">
                    <div class="col-md-12">
                        <h4>All Leads</h4>
                    </div>
                </div>
                <div class="box-body">
                    <form class="lead-form" id="filter-lead-form" action="{{ route('admin.leads.filter') }}" method="post">
                        <!-- Search types -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Search By</label>
                                <select class="form-control" name="search_type" id="lead_search_type">
                                    <option value="all">All</option>
                                    <option value="name">Name</option>
                                    <option value="email">Email</option>
                                    <option value="phone_number">Phone Number</option>
                                    <option value="state">State</option>
                                    <option value="city">City</option>
                                    <option value="form_type">Form Type</option>
                                </select>
                            </div>
                        </div>

                        <!-- Search Value -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Value</label>
                                <input class="form-control" type="text" name="search_value" id="search_value_input" />    

                                <!-- New select dropdown for filtering by "sell" and "buy" -->
                                <select name="search_form_type" class="form-control" id="search_form_type">
                                    <option value="" selected>Select Form Type</option>
                                    <option value="sell">Sell</option>
                                    <option value="buy">Buy</option>
                                </select>

                                <select id="search_state" class="form-control" name="search_state" >
                                    <option value="">Choose a state</option>
                                    @foreach($states::all() as $abbr => $stateName)
                                        <option value="{{ $abbr }}" {{ collect(old('state'))->contains($abbr) ? 'selected' : '' }}>{{ $stateName }}</option>
                                    @endforeach
                                </select>
                                
                                <p class="text-red lead-field-error"></p>
                            </div>
                        </div>

                        <!-- Apply Filter -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div class="form-input">
                                    <input type="hidden" name="filter_type" value="property" />
                                    <button type="button" id="filter_leads" name="filter_leads" class="btn btn-success">Filter</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="view-lead-box lead_data_content"></div>
            </div>
        </div>
    </div>
</section>
@endsection