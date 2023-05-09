// var app_url = 'https://www.realbrokerconnections.com/';
// var app_url = 'https://render.properties/';
var app_url = window.location.protocol+"//"+ location.hostname+"/";
console.log(app_url);
var profileForm = new Vue({
	el: '#profile-sales',
	data: {
		sales: [{
			year: '',
			month: '',
			total_sales: ''
		}]
	},
	methods: {
		addEntry: function () {
			this.sales.push({
				year: '',
				month: '',
				total_sales: ''
			})
		}
	}

});


    function showElementLoader(element)
    {
		$('<div class="loader-outer form-loader loaderInner"><div class="loader">Please wait...<div class="loader-inner"></div></div></div>').insertBefore(element);
	}

	function hideElementLoader() 
	{
		$('.loaderInner').remove();
	}
/* register form validation */
$(document).ready(function() {
    $(function() {
        $("#reg-form").validate({
            ignore:'',
            rules: {
                first_name: {
                    required: true,
                    noSpace: true,
                    lettersonly: true
                },
                last_name: {
                    required: true,
                    noSpace: true,
                    lettersonly: true
                },
                user_type: {
                    required: true,
                },
                username: {
                    required: true,
                    minlength: 4,
                    noSpace: true
                },
                email: {
                    required: true,
					email: true
                },
                phone_number: {
                    required: true,
                },
                password: {
                    required: true,
					minlength: 8
                },
                password_confirmation: {
                    required: true,
					equalTo: "#password"
                },
               /* city: {
                    required: true,
                },*/
                state: {
                    required: true,
                },
				zip: {
                    required: true,
                    // number: true
                },
                receive_email: {
                    required: true
                },
                license: {
                    required: true
                },
                postal_code_service: {
                    required: true,
                    number: true
                },
                provide_content:{
                    required: true
                },
                agree:{
                     required: true
                },
                rbc_free_marketing:{
                     required: true
                },
                open_to_lender_relations:{
                     required: true
                },
                co_market_yes:{
                     required: true
                },
                contact_me_for_match:{
                     required: true
                },
                enable_emails:{
                     required: true
                },
                how_long_realtor:{
                     required: true
                },
                accept_terms:{
                    required: true
                },
            },
            messages: {
                first_name: {
                    reqired: "Please enter your firstname",
                    noSpace: "Do not add space in firstname.",
                },
                last_name: {
                    required: "Please enter your lastname",
                    noSpace: "Do not add space in lastname.",
                },
                username: {
                    minlength: "Username must be atleast 4 characters long.",
                    noSpace: "Do not add space in username."
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 characters long"
                },
                email: "Please enter a valid email address",
                phone_number: "Please enter a valid phone number",
                rbc_free_marketing: "Please answer this  question",
                open_to_lender_relations: "To contact with Lenders, you must opt in for new lender relationships.",
                co_market: "Please answer this question",
                contact_me_for_match: "Please answer this question",
                enable_emails: "To receive the free marketing and training that Render offers you must opt in to being contacted by loan officers and vendors.",
                how_long_realtor: "This field is required to enter",
                accept_terms: {
                    required: "Please accept the Terms and Condition to continue the registration",
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                var type = $(element).attr("type");
                if (type === "radio") {
                    error.insertAfter($(element).closest("div.input-radio-group"));
                }else if (type === "checkbox") {
                    error.insertAfter($(element).closest("label"));
                }else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                 var $captcha = $('#recaptcha' );
                  response = grecaptcha.getResponse();
              if (response.length === 0) {
                $( '.msg-error').text( "reCAPTCHA is mandatory" );
                if( !$captcha.hasClass( "error" ) ){
                  $captcha.addClass( "error" );
                }
                
              } else {
                $( '.msg-error' ).empty();
                $captcha.removeClass( "error" );
                form.submit();
              }
                //form.submit();
            }
        });

    });

    /* check username contain no space */
    jQuery.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "Do not add space in field.");

    /* only allow letters */
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please");
});

 $( '#reg-btn' ).click(function(e){
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



/* check duplicate username  */
$('#username').on('blur', function() {
    var uname = $(this).val();
    if(uname !== '') {
        if (uname.length > 1) {
            $.ajax({
                type: 'POST',
                url: app_url + 'check-username',
                data: {username: uname},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data === 'exist') {
                        $('#uname-error').show();
                        $('#uname-error').text('This username already exists in our database.');
                        $('button#reg-btn').prop('disabled', true);
                    } else {
                        $('#uname-error').hide();
                        $('button#reg-btn').prop('disabled', false);
                    }
                }
            });
        } else {
            $('#uname-error').hide();
        }
    } else {
        $('#uname-error').hide();
        $('button#reg-btn').prop('disabled', false);
    }
});

/* check duplicate licnese  */
$('#license').on('blur', function() {
    var license = $(this).val();
    if(license !== '') {
        if (license.length > 1) {
            $.ajax({
                type: 'POST',
                url: app_url + 'check-license',
                data: {license: license},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data === 'exist') {
                        $('#license_error').show();
                        $('#license_error').text('Sorry, this license has already exist.');
                        $('button#reg-btn').prop('disabled', true);
                    } else {
                        $('#license_error').hide();
                        $('button#reg-btn').prop('disabled', false);
                    }
                }
            });
        } else {
            $('#license_error').hide();
        }
    } else {
        $('#license_error').hide();
        $('button#reg-btn').prop('disabled', false);
    }
});

/* check duplicate email  */
$('#email').on('blur', function() {
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
                        $('#email_error').show();
                        $('#email_error').text('This email already exists in our database.');
                        $('button#reg-btn').prop('disabled', true);
                    } else {
                        $('#email_error').hide();
                        $('button#reg-btn').prop('disabled', false);
                    }
                }
            });
        } else {
            $('#email_error').hide();
        }
    } else {
        $('#email_error').hide();
        $('button#reg-btn').prop('disabled', false);
    }
});

/* check duplicate phone number  */
$('#phone_number').on('blur', function() {
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
                        $('#phone-error').show();
                        $('#phone-error').text('This phone number already exists in our database');
                        $('button#reg-btn').prop('disabled', true);
                    } else {
                        $('#phone-error').hide();
                        $('button#reg-btn').prop('disabled', false);
                    }
                }
            });
        } else {
            $('#phone-error').hide();
        }
    } else {
        $('button#reg-btn').prop('disabled', false);
        $('#phone-error').hide();
    }
});

/* check duplicate zip  */
$('#postal_code_service_btn').on('click', function() {
   var zip = $("#postal_code_service").val();
     $('.notify-success').empty();
    if(zip === '') {
         toastr.options.timeOut = 3000;
            toastr.error('zip value empty.');
            return false;
    }
    
    if(zip !== '') {
        var zip = $("#postal_code_service").val();
        if(!$("#user_type--realtor").is(":checked") && !$("#user_type--lender").is(":checked")) {
            toastr.options.timeOut = 3000;
            toastr.error('Please select REGISTER AS type Realtor or Lender');
            return false;
        }
    
        if($("#user_type--realtor").is(":checked") || $("#user_type--lender").is(":checked")) {
           var type = $("input[name='user_type']:checked").val();
        }
        
        if (zip.length > 1) {
            $.ajax({
                type: 'POST',
                url: app_url + 'check-zip',
                data: {zip: zip, user_type: type},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function (xhr) {
                    $('#loading-imgs').show();
                },
                success: function (data) {
                    $('#loading-imgs').hide();
                    if (data !== '') {
                        $('#postal-error').show();
                        $('.suggested-zip').show();

                        if(data !== 'exist') {
                            $('.suggested-zip').html('<h4>Other Near by available postal codes:</h4>'+data);
                        }

                        $('#postal-error').text('Sorry, this postal code already assigned to someone.');
                        $(".notify-box").removeClass('hidden');
                        $('#notify-txt').text('We will notify you when '+ zip +' this postal code is available. Please click on notify button.');
                        $('button#reg-btn').prop('disabled', true);
                        $('.notify-success').hide();
                    } else {
                        $('.suggested-zip').hide();
                        $(".notify-box").addClass('hidden');
                         $('.notify-success').show();
                        $('.notify-success').text('This zip code is available.');
                        $('#postal-error').hide();
                        $('button#reg-btn').prop('disabled', false);
                    }
                }
            });
        } else {
            $(".notify-box").addClass('hidden');
            $('#postal-error').hide();
            $('#postal-error').text('');
            $('.suggested-zip').hide();
        }
    } else {
        $(".notify-box").addClass('hidden');
        $('#postal-error').hide();
        $('#postal-error').text('');
        $('.suggested-zip').hide();
        $('button#reg-btn').prop('disabled', false);
    }
});

$(".suggested-zip").on("click", ".notify-txt" ,function(){
 var zip = $(this).text();
 $('#postal_code_service').val(zip);
 $('#postal-error').text('');
 $('.notify-box').addClass('hidden');
});


/* notify */
$(document).on('click', '#notify-btn', function() {
   var email = $('#email').val();
   var zip = $('#postal_code_service').val();
   if(zip !== '' && email !== '') {
       toastr.options.timeOut = 3000;

        $.ajax({
            type: 'POST',
            url: app_url + 'notify-me',
            data: {zip: zip, email: email},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                if(data === 'success') {
                    $(".notify-box").addClass('hidden');
                    $('#postal_code_service').val('');
                    $('#postal-error').hide();
                    toastr.success('Your data has been saved. We will notify you soon.');
                }

                if(data === 'exist') {
                    $(".notify-box").addClass('hidden');
                    $('#postal_code_service').val('');
                    $('#postal-error').hide();
                    $('button#reg-btn').prop('disabled', false);
                    toastr.error('Email already notified');
                }
            }
        });
   } else {
       toastr.error('Email is not empty');
       $(".notify-box").addClass('hidden');
       $('#postal_code_service').val('');
       $('#postal-error').hide();
       $('button#reg-btn').prop('disabled', false);
   }
});

/* billing form validation */
$(document).ready(function() {
    $(function() {
        $("#payment-form").validate({
            rules: {
                first_name: {
                    required: true,
                    noSpace: true,
                    lettersonly: true
                },
                last_name: {
                    required: true,
                    noSpace: true,
                    lettersonly: true
                },
                email: {
                    required: true,
                    email: true
                },
                amount: {
                    required: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

    });
});

/* change text of submit btn */
$(document).on('click', '#user_type--realtor', function() {
    $('#reg-form').attr('action', app_url+'register');
    $('#reg-btn').text('Register');
});

$(document).on('click', '#user_type--lender', function() {
    $('#reg-form').attr('action', app_url+'billing-information');
    $('#reg-btn').text('Next');
});

/* register form validation */
$(document).ready(function() {
    $(function() {
        $("#consumer-form").validate({
            rules: {
                first_name: {
                    required: true,
                    noSpace: true,
                    lettersonly: true
                },
                last_name: {
                    required: true,
                    noSpace: true,
                    lettersonly: true
                },
                username: {
                    required: true,
                    minlength: 4,
                    noSpace: true
                },
                email: {
                    required: true,
                    email: true
                },
                phone_number: {
                    required: true,
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
                city: {
                    required: true,
                },
                state: {
                    required: true,
                },
                zip: {
                    required: true,
                    number: true
                }
            },
            messages: {
                first_name: {
                    reqired: "Please enter your firstname",
                    noSpace: "Do not add space in firstname.",
                },
                last_name: {
                    required: "Please enter your lastname",
                    noSpace: "Do not add space in lastname.",
                },
                username: {
                    minlength: "Username must be atleast 4 characters long.",
                    noSpace: "Do not add space in username."
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 8 characters long"
                },
                email: "Please enter a valid email address",
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

    });

    /* check username contain no space */
    jQuery.validator.addMethod("noSpace", function(value, element) {
        return value.indexOf(" ") < 0 && value != "";
    }, "Do not add space in field.");

    /* only allow letters */
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please");
});


jQuery('#state').on('change', function(){
    var state = $(this).find("option:selected").val();
    if(state !=""){
    jQuery('#another-city').html('<input type="hidden" name="anotherCity" placeholder="Add another city"  class="form-control" />');
     $.ajax({
            type: 'POST',
            url: app_url + 'get-city',
            data: {state: state},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            beforeSend: function(res) {
                showElementLoader($('#city'));
              //$('#city').html('<option selected="selected">Please wait...</option>');  
            },
            success: function (data) {
                $('#city').html(data);
                hideElementLoader();
            }
        });
    }else{
        $('#city').children().remove();
        $('#city').append('<option value="">Select City</option>');
    }
});

jQuery('#city').on('change', function(){
     var selectedpageid = this.value;
      if(selectedpageid !="")
      {
          $('#city > option').attr('selected',false);
          var index = $(this).prop('selectedIndex');
          $('#city > option').eq(index).attr('selected','selected');
      }else{
           $('#city > option').attr('selected',false);
           
      }
    var city = $(this).find("option:selected").val();
    if(city === 'Other') {
        jQuery('#another-city').html('<input type="text" name="anotherCity" placeholder="Add another city"  class="form-control" required />');
    } else {
        jQuery('#another-city').html('<input type="hidden" name="anotherCity" placeholder="Add another city"  class="form-control" />');
    }
    
});

jQuery( document ).ready(function() {
   var selectedState = $('#state').find("option:selected").val();
    if(selectedState !="")
   {
       jQuery('#another-city').html('<input type="hidden" name="anotherCity" placeholder="Add another city"  class="form-control" />');
             $.ajax({
                    type: 'POST',
                    url: app_url + 'get-previouscity',
                    data: {state: selectedState},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    beforeSend: function(res) 
                    {
                        showElementLoader($('#city'));
                    },
                    success: function (data) 
                    {
                        $('#city').html(data);
                        hideElementLoader();
                    }
                });
   }else{
    $('#city').children().remove();
    $('#city').append('<option value="">Select City</option>');
   }
   
});
