@extends('admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Add Designation</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Add Designation</a></li>
                
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
                            <h3 class="box-title">Add Designation</h3>
                        </div>
                        <form id="add-page-form" method="post">
                            {{csrf_field()}}
                            
                            <div class="box-body">
                                <div class="form-group {{ $errors->has('selected_user') ? ' has-error' : '' }}">
                                    <label for="page">Select User</label>
                               <input type="hidden" name="selected_user" value="" id="selectedUserId" required>
                               <input type="text" name="user_name" value="" id="autocompletes" class="form-control" required>
                               <div id="userList">
                                 </div>
                                    <span id="pages-error"></span>
                                </div>
                                @if ($errors->has('selected_user'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('selected_user') }}</strong>
                                    </span>
                                @endif
                            </div>
                             <div class="box-body">
                                <div class="form-group {{ $errors->has('designation') ? ' has-error' : '' }}">
                                    <label for="page">Designation</label><br>
                                   <input type="hidden" name="designation" value="null" />
                                   <input type="checkbox" name="designation" value="Gold Standard Broker"/> <label>Gold Standard Broker</label>
                                   <span id="pages-error"></span>
                                </div>
                                @if ($errors->has('designation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('designation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Add Designation</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <script>
$(document).ready(function(){

 $('#autocompletes').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete.fetch') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
             $('#userList').fadeIn();  
           $('#userList').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){
        if($(this).val() != 0){
        $('#userList').fadeOut();  
        $('#autocompletes').val($(this).text());  
        $('#selectedUserId').val($(this).val());
        $('#userList').fadeOut();  
        }else{
            $('#recordNotFound').css('color','red');
            $('#autocompletes').val('');
        }
          
    });  

});
</script>
 
    
@endsection

