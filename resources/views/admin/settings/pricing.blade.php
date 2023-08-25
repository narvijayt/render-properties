@extends('admin.layouts.main')
@section('content')
    <section class="content-header">
        <h1>Registration Plans</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li class="active">Registration Plans</li>
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
                        <h3 class="box-title">Lender Registration Price</h3>
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

                <div class="box mt-5">
                    <div class="box-header">
                        <h3 class="box-title">Vendor Registration Plans</h3>
                        <a href="{{ route('settings.vendorPackage.create') }}" class="btn btn-sm btn-success pull-right">Create New Package</a>
                    </div>
                    <div class="box-body">
                        <table id="packages" class="table table-bordered table-striped py-2">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Base Price ($)</th>
                                    <th>Add-On Price ($)</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!is_null($vendorPackages))
                                    @foreach($vendorPackages as $index=>$package)
                                        <tr>
                                            <td>{{ ($index+1) }}</td>
                                            <td>{{ $package->title }}</td>
                                            <td>{{ ucfirst($package->packageType) }}</td>
                                            <td>{{ $package->basePrice }}</td>
                                            <td>{{ $package->addOnPrice }}</td>
                                            <td>{{ $package->status == 0 ? 'Inactive' : 'Active' }}</td>
                                            <td>
                                                <a href="{{ route('settings.vendorPackage.edit', [packageId => $package->id]) }}" class="btn btn-sm btn-primary"> <i class="fa fa-pencil-square-o"></i> </a>
                                            </td>
                                        </tr>   
                                    @endforeach
                                @endif
                            </tbody>
                        </table>                        
                    </div>

                    <div class="page-div">
                        @if(isset($vendorPackages) && !empty($vendorPackages))
                            {{ $vendorPackages->appends($_GET)->links() }}
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

