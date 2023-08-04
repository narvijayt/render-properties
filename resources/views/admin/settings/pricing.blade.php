@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>Lender Registration Price</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li class="active">Price</li>
        </ol>
    </section>

    @if (Session::has('message'))
        <p class="alert alert-success">
            {{ Session::get('message') }}
        </p>
    @endif

    @if (Session::has('error'))
        <p class="alert alert-danger">
            {{ Session::get('error') }}
        </p>
    @endif

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manage Pricing</h3>
                    </div>
                    
                    <form name="pricing-form" id="pricing-form" method="post" action="{{ route('settings.storepricing') }}">
                        <div class="box-body">

                            <div class="form-group d-block w-100 mb-1">
                                <label class="col-md-3">Regular Price ($)</label>
                                <div class="form-input col-md-9">
                                    <input type="text" class="form-control" name="regular_price" id="regular_price" placeholder="59.00" value="{{ old('regular_price') ? old('regular_price') : $pricing->regular_price }}" />
                                    @if ($errors->has('regular_price'))
                                        <div class="invalid-feedback" role="alert"> 
                                            <strong>{{ $errors->first('regular_price') }}</strong>
                                        </div> 
                                    @endif
                                </div>
                            </div>
                            <div class="form-group d-block w-100 mb-1">
                                <label class="col-md-12">Want to add Discount?</label>
                            </div>
                            <div class="form-group d-block w-100 mb-1">
                                <label class="col-md-3">Sale Price ($)</label>
                                <div class="form-input col-md-9">
                                    <input type="text" class="form-control" name="sale_price" id="sale_price" placeholder="40.00" value="{{ old('sale_price') ? old('sale_price') : $pricing->sale_price }}" />
                                </div>
                            </div>
                            <div class="form-group d-block w-100 mb-1">
                                <label class="col-md-3">Sale Period (In Months: 1 or 2)</label>
                                <div class="form-input col-md-9">
                                    <input type="number" class="form-control" name="sale_period" id="sale_period" placeholder="1" value="{{ old('sale_period') ? old('sale_period') : $pricing->sale_period }}" />
                                </div>
                            </div>
                        
                        </div>

                        <div class="box-footer">
                            <div class="form-input text-right pull-right">
                                <button type="submit" class="btn btn-success" name="savePricing" id="savePricing">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

