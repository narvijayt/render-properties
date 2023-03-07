/* contact form */
$(document).ready(function() {
    initializeCreditCardJsForForm('vendor_register');
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
                }
            },
            submitHandler: function(form) {
                $("button#doPaymentButton").attr("disabled", true);
                form.submit();
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
 
 
 $( "#vendor_registers" ).submit(function( event ) {
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
});

                
$( '#registerVendor' ).click(function(event){
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





