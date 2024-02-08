/* contact form */
$(document).ready(function() {
    $(document).on("click", ".disbaled-contact-link", function(e){
      alert("Request a Match with the user to access contact details.");
    });

    $(document).on("click", ".send-sms-link", function(e){
      var isMobile = false; //initiate as false
      // device detection
      if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
          || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
          isMobile = true;
      }
      if(isMobile== false){
        e.preventDefault();
        alert("Send SMS only works on mobile/ipad");
      }
    });

    $(document).on("click", ".otp-login-btn", function(){
      var emailPhone = $("input[id='email']").val();
      if(emailPhone == ''){
        $(".otp-error-response").removeClass('d-none').html('<span class="help-block alert alert-danger">You have to enter Email or Phone number to login with OTP.</span>');
        $("input[name='loginWithOTP']").val(0);
      }else{
        $(".otp-error-response").addClass('d-none').html('');
        $("input[name='loginWithOTP']").val(1);
        $('form')[0].submit();
      }
    });

    // initializeCreditCardJsForForm('vendor_register');
    $(function() {
        $("#contact-form").validate({
            rules: {
                name: {
                    required: true,
                },
                phone: {
                    number: true
                },
                email: {
                    required: true,
                    email: true
                },
                subject: {
                    required: true
                },
                message: {
                    required: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
        
        
         $("#vendor_register").validate({
            rules: {
               state_name:{
                  required:true 
                },
                city_name:{
                    required:true
                },
                number:{
                    required:true
                },
                expiry:{
                    required:true
                },
                cvc:{
                    required:true
                },
                name:{
                    required:true
                },
                "additional_city[]":{
                     required:true
                },
                "additional_state[]":{
                     required:true
                },
                first_name:{
                     required:true
                },
                last_name:{
                   required:true 
                },
                email:{
                    required:true
                },
                firm_name:{
                     required:true
                },
                address:{
                     required:true
                },
                address2:{
                     required:true
                },
                city:{
                    required:true
                },
                state:{
                  required:true   
                },
                zip:{
                    required:true 
                },
                accept_terms:{
                    required:true 
                }
            },
            messages: {
                state_name:{
                     required: "Please enter state name for selected Package",
                },
                city_name:{
                    required: "Please enter city name for selected Package",
                },
                number:{
                    required: "Please enter credit card no.",
                },
                 expiry:{
                    required: "Please enter expiry.",
                },
                cvc:{
                     required: "Please enter cvc.",
                },
                 name:{
                     required: "Please enter card holder name.",
                },
                 "additional_city[]":{
                     required: "Please enter additional city name.",
                },
                 "additional_state[]":{
                     required: "Please enter additional state name.",
                },
                 first_name:{
                     required: "Please enter first name.",
                 },
                 last_name:{
                     required: "Please enter last name.",
                 },
                 email:{
                     required: "Please enter email address.",
                 },
                 firm_name:{
                     required: "Please enter firm name.", 
                 },
                 address:{
                      required: "Please enter billing address1.", 
                 },
                 address2:{
                     required: "Please enter billing address2.", 
                 },
                  city:{
                    required: "Please enter city name.",
                },
                state:{
                     required: "Please enter state name.",
                },
                zip:{
                    required: "Please enter zipcode.",
                },
                accept_terms:{
                    required: "Please accept our Terms and Conditions to contiue.",
                }
            },
            submitHandler: function(form) {
                $("button#doPaymentButton").attr("disabled", true);
                // form.submit();
                handleSubscrSubmit();
                // const vendorForm = document.querySelector("#vendor_register");

                // // Attach an event handler to subscription form
                // vendorForm.addEventListener("submit", handleSubscrSubmit);
            }
        });
        
        $('#vendor_registers').bootstrapValidator({
        message:'This value is not valid',
        feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        first_name: {
          validators: {
            notEmpty: {
              message: 'Please enter first name'
            },
            regexp: {
              regexp: /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/,
              message: 'Please enter letters only'
            },
          }
        },
        last_name: {
          validators: {
            notEmpty: {
              message: 'Please enter last name'
            },
            regexp: {
              regexp: /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/,
              message: 'Please enter letters only'
            },
          }
        },
        billing_address_1:{
         validators: {
            notEmpty: {
                message: 'Please enter address'
            }
        }    
        },
        state:{
        validators: {
            notEmpty: {
                message: 'Please select city'
            }
        }    
        },
        city:{
        validators: {
            notEmpty: {
              message: 'Please enter city'
            },
            regexp: {
              regexp: /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/,
              message: 'Please enter letters only'
            },
          }   
        },
        zip:{
           validators: {
            notEmpty: {
              message: 'Please enter zipcode'
            },
            regexp: {
              regexp: /^\d{5}$/,
              message: 'The US zipcode must contain 5 digits'
            },
          }   
        },
    other_description:{
      validators: {
            notEmpty: {
                message: 'Please enter other industry description.'
            }
        }
        },
      company_name: {
        validators: {
            notEmpty: {
                message: 'Please enter company name'
            }
        }
      },
    father_name: {
          validators: {
            notEmpty: {
              message: 'Please enter father name'
            },
            regexp: {
              regexp: /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/,
              message: 'Please enter letters only'
            },
          }
        },
          "select_category[]":{
            validators: {
            notEmpty: {
                message: 'Please select at least 1 industry you are in'
            }
        }  
          },
      vendor_coverage_units:{
          validators: {
            notEmpty: {
                message: 'Please enter your area of coverage'
            }
        }
      },
      services:{
         validators: {
            notEmpty: {
                message: 'Please select enter services you offer'
            }
        } 
      },
    phone_no: {
      validators: {
        notEmpty: {
            message: 'Please Enter your phone number'
        },
         regexp: {
              regexp: /^\d{10}$/,
              message: 'Phone Number must be 10 digits'
            }
       
           }
         },
 email: {
        validators: {
            notEmpty: {
                message: 'Please enter your email address'
            },
            regexp: {
              regexp: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
              message: 'Please enter a valid email address'
            }
        }
    },
password: {
  validators: {
      notEmpty: {
        message: 'The password is required'
      },
  callback:{
      message: 'The password is not strong',
      callback: function(value, password, $field){
      if (value.length < 5) {
      return {
         valid: false,
        message: 'Password must be more than 5 characters long'
       };
      }
      // The password doesn't contain any uppercase character
      if (value === value.toLowerCase()) {
      return {
        valid: false,
        message: 'Password must contain at least one upper case character'
      }
      }
      // The password doesn't contain any uppercase character
      if (value === value.toUpperCase()) {
      return {
        valid: false,
        message: 'Password must contain at least one lower case character'
      }
      }
      // The password doesn't contain any digit
      if (value.search(/[0-9]/) < 0) {
      return {
        valid: false,
        message: 'Password must contain at least one digit'
      }
      }
      if(value.search(/[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/) < 0) {
      return {
        valid: false,
        message: 'Password must contain atleast one special character'
      }
      }
      return true;
      }
    }
    }
    },
 cpassword: {
        validators: {
            identical: {
                field: 'password',
                message: 'Password do not match'
            },
            notEmpty: {
                message: 'Please confirm your password'
            }
        }
    }
  },
}).find('[name="select_category[]"]').on('change', function() {
                    // Revalidate the bio field
                    $('#vendor_registers').bootstrapValidator('revalidateField', 'select_category[]');
                });
 
 
 $( "#vendor_registers, .contact-submit-btn").on("submit",function( event ) {
  if($('#recaptcha' ).length){
    var $captcha = $('#recaptcha' );
    response = grecaptcha.getResponse();
    if (response.length === 0) {
      $( '.msg-error').text( "The captcha-response field is required." );
      if( !$captcha.hasClass( "error" ) ){
        $captcha.addClass( "error" );
      }
      e.preventDefault();
    } else {
      $( '.msg-error' ).empty();
      $captcha.removeClass( "error" );
    }
  }
});

                
$( '#registerVendor' ).on("click",function(event){
  if($('#recaptcha' ).length){
    var $captcha = $('#recaptcha' );
    response = grecaptcha.getResponse();
    if (response.length === 0) {
      $( '.msg-error').text( "The captcha-response field is required." );
      if( !$captcha.hasClass( "error" ) ){
        $captcha.addClass( "error" );
      }
      e.preventDefault();
    } else {
      $( '.msg-error' ).empty();
      $captcha.removeClass( "error" );
    }
  }
});


$('#updateUserProfile').bootstrapValidator({
        message:'This value is not valid',
        feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        first_name: {
          validators: {
            notEmpty: {
              message: 'Please enter first name'
            },
            regexp: {
              regexp: /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/,
              message: 'Please enter letters only'
            },
          }
        },
        last_name: {
          validators: {
            notEmpty: {
              message: 'Please enter last name'
            },
            regexp: {
              regexp: /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/,
              message: 'Please enter letters only'
            },
          }
        },
      firm_name: {
        validators: {
            notEmpty: {
                message: 'Please enter company name'
            }
        }
      },

     father_name: {
          validators: {
            notEmpty: {
              message: 'Please enter father name'
            },
            regexp: {
              regexp: /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/,
              message: 'Please enter letters only'
            },
          }
        },
          "selectcategory[]":{
            validators: {
            notEmpty: {
                message: 'Please select at least 1 industry you are in'
            }
        }  
          },
      vendor_coverage_units:{
          validators: {
            notEmpty: {
                message: 'Please enter your area of coverage'
            }
        }
      },
      other_description:{
         validators: {
            notEmpty: {
                message: 'Please enter other industry description.'
            }
        } 
      },
      other_description_optional:{
        validators: {
            notEmpty: {
                message: 'Please enter other industry  description.'
            }
        }    
      },
      services:{
         validators: {
            notEmpty: {
                message: 'Please select enter services you offer'
            }
        } 
      },
       state:{
             validators: {
            notEmpty: {
                message: 'Please select state.'
            }
        } 
         },
         license:{
              validators: {
            notEmpty: {
                message: 'Please enter license.'
            }
        }   
         },
         specialties:{
             validators: {
            notEmpty: {
                message: 'Please enter specialties.'
            }
        }      
        },
         zip:{
                 validators: {
            notEmpty: {
                message: 'Please enter zipcode.'
            }
        }  
         },
    phone_number: {
      validators: {
        notEmpty: {
            message: 'Please Enter your phone number'
        },
         regexp: {
              regexp: /^\d{10}$/,
              message: 'Phone Number must be 10 digits'
            }
       
           }
         },
         phone_ext:{
           validators: {
        notEmpty: {
            message: 'Please Enter your phone number'
        }
        }  
         },
    email: {
        validators: {
            notEmpty: {
                message: 'Please enter your email address'
            },
            regexp: {
              regexp: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
              message: 'Please enter a valid email address'
            }
        }
    }
},
  }).find('[name="select_category[]"]').on('change', function() {
                    // Revalidate the bio field
                    $('#updateUserProfile').bootstrapValidator('revalidateField', 'select_category[]');
                });

        
         jQuery.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "Do not add space in field.");

    /* only allow letters */
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please");
        
       

        
        
        

    });
});

jQuery( document ).ready(function() {
     var selectedOption = $('#editProfileState').find("option:selected").val();
     var prevCity = $('#previous_city').val();
      if(selectedOption !="")
      {
          jQuery('#another-city').html('<input type="hidden" name="anotherCity" placeholder="Add another city"  class="form-control" />');
             $.ajax({
                    type: 'POST',
                    url: app_url + 'get-previouscity',
                    data: {state: selectedOption,city:prevCity},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    beforeSend: function(res) 
                    {   
                        if(prevCity !="")
                        {
                            showElementLoader($('#editProfilecity'));
                        }
                    },
                    success: function (data) 
                    {
                         $('#editProfilecity').html(data);
                         $("#editProfilecity option[value="+prevCity+"]").prop("selected", true);
                         hideElementLoader();
                    }
                }); 
          
      }else{
           $('#editProfilecity').children().remove();
           $('#editProfilecity').append('<option value="">Select City</option>');
      }
      
     jQuery('#editProfileState').on('change', function(){
        var state = $(this).find("option:selected").val();
          if(state !="")
          {
            jQuery('#another-city').html('<input type="hidden" name="anotherCity" placeholder="Add another city"  class="form-control" />');
             $.ajax({
                    type: 'POST',
                    url: app_url + 'get-city',
                    data: {state: state},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    beforeSend: function(res) 
                    {
                        showElementLoader($('#editProfilecity'));
                    },
                    success: function (data) 
                    {
                    $('#editProfilecity').html(data);
                        hideElementLoader();
                    }
                    
                });
        }else{
            $('#editProfilecity').children().remove();
            $('#editProfilecity').append('<option value="">Select City</option>');
        }
    });
});







    function initializeCreditCardJsForForm(fromId) {
        new Card({
            form: document.querySelector('#'+ fromId),
            container: '.card-wrapper'
        });
    }


/* check duplicate email  */
$('#emailadd').on('blur', function() {
    var email = $(this).val();
    if(email !== '') {
        if (email.length > 1) {
            $.ajax({
                type: 'POST',
                url: app_url + 'check-email',
                data: {email: email},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data === 'exist') {
                        $('#email_vendor_error').show();
                        $('#email_vendor_error').text('This email already exists in our database.');
                        $('button#vendor_register').prop('disabled', true);
                    } else {
                        $('#email_vendor_error').hide();
                        $('button#vendor_register').prop('disabled', false);
                    }
                }
            });
        } else {
            $('#email_vendor_error').hide();
        }
    } else {
        $('#email_vendor_error').hide();
        $('button#vendor_register').prop('disabled', false);
    }
});



$('#phone_vendor_no').on('blur', function() {
    var phone = $(this).val();
    if(phone !== '') {
        if (phone.length > 1) {
            $.ajax({
                type: 'POST',
                url: app_url + 'check-phone',
                data: {phone: phone},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data === 'exist') {
                        $('#phone-vendor-error').show();
                        $('#phone-vendor-error').text('This phone number already exists in our database');
                        $('button#vendor_register').prop('disabled', true);
                    } else {
                        $('#phone-vendor-error').hide();
                        $('button#vendor_register').prop('disabled', false);
                    }
                }
            });
        } else {
            $('#phone-vendor-error').hide();
        }
    } else {
        $('button#vendor_register').prop('disabled', false);
        $('#phone-vendor-error').hide();
    }
});





