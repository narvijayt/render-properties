@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper">
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
                <div class="col-md-9">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Add Vendor Package</h3>
                        </div>
                        
                        <form name="vendor-package-form" id="vendor-package-form" method="post" action="{{ route('settings.vendorPackage.store') }}" >
                            <div class="box-body">
                                <div class="form-group d-block w-100 mb-1">
                                    <label class="col-md-3">Package Title</label>
                                    <div class="form-input col-md-9">
                                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') ? old('title') : $package->title }}" />
                                        @if ($errors->has('title'))
                                            <div class="invalid-feedback" role="alert"> 
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </div> 
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group d-block w-100 mb-1">
                                    <label class="col-md-3">Type</label>
                                    <div class="form-input col-md-9">
                                        <select class="form-control" id="packageType" disabled>
                                            <option value=""> Select Package Type </option>
                                            @foreach($packageTypes as $index=>$value)
                                                <option value="{{ $value }}" {{ $value == $package->packageType ? "selected" : "" }}> {{ ucfirst($value) }} </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('packageType'))
                                            <div class="invalid-feedback" role="alert"> 
                                                <strong>{{ $errors->first('packageType') }}</strong>
                                            </div> 
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group d-block w-100 mb-1">
                                    <label class="col-md-3">Base Price ($)</label>
                                    <div class="form-input col-md-9">
                                        <input type="text" class="form-control" id="basePrice" placeholder="99.00" value="{{ $package->basePrice }}" disabled />
                                        @if ($errors->has('basePrice'))
                                            <div class="invalid-feedback" role="alert"> 
                                                <strong>{{ $errors->first('basePrice') }}</strong>
                                            </div> 
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group d-block w-100 mb-1">
                                    <label class="col-md-3">Each Additional Unit ($)</label>
                                    <div class="form-input col-md-9">
                                        <input type="text" class="form-control" id="addOnPrice" placeholder="79.00" value="{{ $package->addOnPrice }}" disabled />
                                        @if ($errors->has('addOnPrice'))
                                            <div class="invalid-feedback" role="alert"> 
                                                <strong>{{ $errors->first('addOnPrice') }}</strong>
                                            </div> 
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group d-block w-100 mb-1">
                                    <label class="col-md-3">Status</label>
                                    <div class="form-input col-md-9">
                                        <select class="form-control" name="status" id="status">
                                            <option value=""> Select Status </option>
                                            @php $selectedStatus = old('status') ? old('status') : $package->status;  @endphp
                                            @foreach(['0' => 'inactive', '1' => 'active'] as $index=>$value)
                                                <option value="{{ $index }}" {{ $index == $selectedStatus ? "selected" : "" }}> {{ ucfirst($value) }} </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('status'))
                                            <div class="invalid-feedback" role="alert"> 
                                                <strong>{{ $errors->first('status') }}</strong>
                                            </div> 
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <div class="form-input text-right pull-right">
                                    <button type="submit" class="btn btn-success" name="savePricing" id="savePricing">Save</button>
                                    <input type="hidden" name="packageId" value="{{ $package->id }}" />
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection

