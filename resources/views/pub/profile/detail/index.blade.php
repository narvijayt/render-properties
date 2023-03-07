@extends('pub.profile.layouts.profile')
@section('title',$user->first_name .' Profile | Edit Profile')
@section('meta')
    {{ meta('description', config('seo.description')) }}
    {{ meta('keywords', config('seo.keyword')) }}
@endsection

@section('page_content')
    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('pub.profile.detail.update') }}" method="post" id="updateUserProfile">
                <h4 class="margin-top-none">User Information</h4>
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                 @include('pub.profile.partials.forms.user-info')
                <h4>Details</h4>
                @include('pub.profile.partials.forms.user-detail')
                <button type="submit" id="submitUpdateProfileUser"class="btn btn-primary">Update</button>
            </form>
         </div>
        <div class="col-md-4 profile-img-box">
            <img class="img-responsive" src="{{ $user->avatarUrl() }}" alt="{{ $user->full_name() }}'s profile photo" onclick="openImageModal()"/>

                       <form action="" method="POST" id="user-profile-avatar-upload-form1" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="avatar" class="hidden" id="user-profile-avatar-file1">
                <button type="button" class="btn btn-primary btn-block margin-top-1em" id="user-profile-avatar-upload1">Change Photo</button>
                <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                    @if($errors->has('avatar'))
                        <span class="help-block">
                            <strong>The image failed to upload:</strong><br />
                            {{ $errors->first('avatar') }}
                        </span>
                    @endif
                </div>
             <small class="text-info">
                    <strong>For Best Results:</strong><br />
                    Max File Size: 1MB <br />
                    Allowed File Types: .jpg, .jpeg, .png <br />
                    Preferred Dimensions: 1000px x 1000px <br />
                </small>
            </form>

        </div>
    </div>
    <div id="image_crop_modal" class="modal " role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        X
                    </button>
                    <h4 class="modal-title">Profile Photo</h4>
                </div>
                <div class="modal-body">
                    <div class="crop-img"></div>
                </div>
                <div id="loading-imgs" style="display: none; position: absolute;
				z-index: 9;top: 50%;left: 50%;transform: translate(-50%,-50%);">
                    <img src="{{asset('img/profile-loader.gif')}}" >
                </div>
                <div class="modal-footer">
                    <div class="rotate-btn">
                        <button class="vanilla-rotate-left" data-rotate="-90">
                            <span class="rotate-left-text">
                                <i class="fa fa-undo" aria-hidden="true"></i>
                                Rotate Left
                            </span>
                        </button>
                        <button class="vanilla-rotate-right" data-rotate="90">
                            <span class="rotate-left-text">
                                 <i class="fa fa-repeat"></i>
                                Rotate Right
                            </span>
                        </button>
                    </div>
                    <div class="save-btn">
                        <button type="button" class="btn btn-default cancel-crop" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-secondary image-crop-save">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function () {
          var t=$("#user-profile-avatar-upload-form1");
          var e=$("#user-profile-avatar-file1");
          $("#user-profile-avatar-upload1").on("click",function(){
              e.trigger("click");
          });

          var $uploadCrop;

          $uploadCrop = $('.crop-img').croppie({
              viewport: {
                  width: 350,
                  height: 350,
                  type: 'circle'
              },
              boundary: {
                  width: 400,
                  height: 400
              },
              enableExif: true,
              enableResize: true,
              enableOrientation: true,
              mouseWheelZoom: 'ctrl',
              enableZoom: true,
              showZoomer: true,

          });

          e.on("change",function(){
              $("#image_crop_modal").modal('show');
              readURL(this);
          });

          function readURL(input) {
              if (input.files && input.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function (e) {
                      $uploadCrop.croppie('bind', {
                          url: e.target.result,
                          zoom: 1
                      }).then(function(){
                          console.log('jQuery bind complete');
                      });
                      
                      $uploadCrop.setZoom(5.5)
                  }
                  reader.readAsDataURL(input.files[0]);
              }
          }

        $(document).on('click', '.image-crop-save', function(){
            $uploadCrop.croppie('result', {
                type: 'base64',
                size: 'viewport',
            }).then(function (resp) {
                 $.ajax({
                    url: "{{url('profile/avatar')}}",
                    type: "POST",
                    data:{"avatar": resp},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                     beforeSend: function (xhr) {
                        $('#loading-imgs').show();
                    },
                    success:function(data)
                    {
                       $('#loading-imgs').hide();
                       if(data === 'success') {
                          location.reload();
                       } else {
                            $('.img-msg').html('Unable to update avatar').show().delay(5000);
                       }
                    }
                })
            });

        });

        /* rotate*/
        $('.vanilla-rotate-left').on('click', function(ev) {
            $uploadCrop.croppie('rotate', parseInt($(this).data('rotate')));
        });

        $('.vanilla-rotate-right').on('click', function(ev) {
            $uploadCrop.croppie('rotate', parseInt($(this).data('rotate')));
        });
    });
    </script>
    @if(auth()->user()->user_type =='vendor')
    <script>
     function uploadBannerImage() {
          $('#file').click();
      }
      $('#file').change(function() {
          if ($(this).val() != '') {
              uploadBannerImg(this);
          }
      });
    function uploadBannerImg(img) {
          var form_data = new FormData();
          form_data.append('file', img.files[0]);
          form_data.append('_token', '{{csrf_token()}}');
          $('#loading').css('display', 'block');
          
          $.ajax({
              url: "{{url('advertisement/banner')}}",
              data: form_data,
              type: 'POST',
              contentType: false,
              processData: false,
              success: function(data) {
                  if (data.fail) {
                      $('#preview_image').attr('src', '{{URL::to('/public/attach - 1. png ')}}');
                          alert(data.errors['file']);
                  } else {
                      var ext = data.split('.').pop();
                     if(ext == 'pdf'){
                          $('#preview_image').css('display', 'block');
                          $('#preview_image').attr('src', '{{URL::to('/banner/')}}/' + 'preview_pdf.png');
                     }else{
                      $('#file_name').val(data);
                      $('#preview_image').css('display', 'block');
                      $('#preview_image').attr('src', '{{URL::to('/banner/')}}/' + data);
                  }
                  $('#loading').css('display', 'none');
              }
              },
              error: function(xhr, status, error) {
                  alert(xhr.responseText);
                  $('#preview_image').attr('src', '{{URL::to('/public/attach - 1.png')}}');
              }
          });
      }
     $('#profileMultisel').on('change',function() {
           var selected = $(this).find("option:selected"); 
       var arrSelected = [];
        selected.each((idx, val) => {
            arrSelected.push(val.value);
        });
        if ($.inArray('19', arrSelected) >= 0)
        {
            var description = $('#desc_first').val();
           if (typeof description === "undefined"){
                $('#OtherDescription').css('display','block');
                $('#otherIndustryDesc').css('display','block');
            }else{
                $('#OtherDescription').css('display','none');
                $('#otherIndustryDesc').val(''); 
                $('#otherIndustryDesc').css('display','none');
                $('#firstDesc').css('display','block');
            }
        }else{
           $('#OtherDescription').css('display','none');
           $('#otherIndustryDesc').val('');
           $('#otherIndustryDesc').css('display','none');
           $('#firstDesc').css('display','none');
        }
      });
       $('#desc_first').keypress(function() {
        var txtVal = this.value;
        $('#desc_first').val(txtVal);
        });
      </script>
	@endif
@endsection