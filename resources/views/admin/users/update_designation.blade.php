@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Edit User</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Edit User</a></li>
                
            </ol>
        </section>
        
        <section class="content">
            <div class="row">
                <div class="col-md-10">
                     @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
             @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                         @endif
                   <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit User</h3>
                        </div>
                        <form id="add-page-form" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" value="{{$user->user_id}}">
                            <div class="box-body">
                                <div class="form-group {{ $errors->has('user_name') ? ' has-error' : '' }}">
                                    <label for="page">Select User</label>
                        <input type="text" name="user_name" value="{{$user->first_name}} {{$user->last_name}}" class="form-control" disabled required>
                                    <span id="pages-error"></span>
                                </div>
                                @if ($errors->has('user_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                                @endif
                            
                             
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" value="{{$user->email}}" readonly/>
                                </div>
                                <div class="form-group">
                                    <label for="email">Mobile Number</label>
                                    <input type="tel" class="form-control" name="phone_number" id="phone_number" value="{{$user->phone_number}}" />
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="active">
                                        <option value="1" @if($user->active == 1) selected @endif>Active</option>
                                        <option value="0" @if($user->active == 0) selected @endif>Inactive</option>
                                    </select>
                                </div>
                                
                                @if($user->user_type == 'broker')
                                    <div class="form-group">
                                        <label for="status">Payment Status</label>
                                        <select class="form-control" id="payment_status" name="payment_status">
                                            <option value="1" @if($user->payment_status == 1) selected @endif>Paid</option>
                                            <option value="0" @if($user->payment_status == 0) selected @endif>Unpaid</option>
                                        </select>
                                    </div>
                                @endif
                           
                                <div class="form-group {{ $errors->has('designation') ? ' has-error' : '' }}">
                                    <label for="page">Designation</label></br>
                                    <input type="hidden" name="designation" value="" />
                                   <input type="checkbox" name="designation" value="Gold Standard Broker" <?php if($user->designation !="" && $user->designation !="null") echo "checked";?>> <label>Gold Standard Broker</label>
                                    
                                    <span id="pages-error"></span>
                                </div>
                            
                                @if ($errors->has('designation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('designation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Update User</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

