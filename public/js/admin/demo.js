const domainURL = document.location.origin;
/**
 * AdminLTE Demo Menu
 * ------------------
 * You should not use this file in production.
 * This file is for demo purposes only.
 */
  $(document).ready(function() {
     $('#registerVendor').bootstrapValidator({
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

      company_name: {
        validators: {
            notEmpty: {
                message: 'Please enter company name'
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
        short_description:{
          validators: {
            notEmpty: {
                message: 'Please enter bio'
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
        }/*,
         regexp: {
              regexp: /^\d{10}$/,
              message: 'Phone Number must be 10 digits'
            }*/
       
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

});
     
 });
  $("#vendorPayment").validate({
            rules: {
               state_name:{
                  required:true 
                },
                city_name:{
                    required:true
                },
                package_price:{
                    required:true
                },
                "additional_city[]":{
                     required:true
                },
                
                "additional_state[]":{
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
                package_price:{
                    required: "Please enter Package Price.",
                },
                 "additional_city[]":{
                     required: "Please enter additional city name.",
                },
                
                 "additional_state[]":{
                     required: "Please enter additional state name.",
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
        
        $("#packagePrice").on("keyup", function(){
            var valid = /^\d{0,4}(\.\d{0,2})?$/.test(this.value),
                val = this.value;
            
            if(!valid){
                console.log("Invalid input!");
                this.value = val.substring(0, val.length - 1);
            }
        });  
        
        
$(function () {
    'use strict'

    /**
     * Get access to plugins
     */

    $('[data-toggle="control-sidebar"]').controlSidebar()
    $('[data-toggle="push-menu"]').pushMenu()
    var $pushMenu = $('[data-toggle="push-menu"]').data('lte.pushmenu')
    var $controlSidebar = $('[data-toggle="control-sidebar"]').data('lte.controlsidebar')
    var $layout = $('body').data('lte.layout')
    $(window).on('load', function() {
        // Reinitialize variables on load
        $pushMenu = $('[data-toggle="push-menu"]').data('lte.pushmenu')
        $controlSidebar = $('[data-toggle="control-sidebar"]').data('lte.controlsidebar')
        $layout = $('body').data('lte.layout')
    })

    /**
     * List of all the available skins
     *
     * @type Array
     */
    var mySkins = [
        'skin-blue',
        'skin-black',
        'skin-red',
        'skin-yellow',
        'skin-purple',
        'skin-green',
        'skin-blue-light',
        'skin-black-light',
        'skin-red-light',
        'skin-yellow-light',
        'skin-purple-light',
        'skin-green-light'
    ]

    /**
     * Get a prestored setting
     *
     * @param String name Name of of the setting
     * @returns String The value of the setting | null
     */
    function get(name) {
        if (typeof (Storage) !== 'undefined') {
            return localStorage.getItem(name)
        } else {
            window.alert('Please use a modern browser to properly view this template!')
        }
    }

    /**
     * Store a new settings in the browser
     *
     * @param String name Name of the setting
     * @param String val Value of the setting
     * @returns void
     */
    function store(name, val) {
        if (typeof (Storage) !== 'undefined') {
            localStorage.setItem(name, val)
        } else {
            window.alert('Please use a modern browser to properly view this template!')
        }
    }

    /**
     * Toggles layout classes
     *
     * @param String cls the layout class to toggle
     * @returns void
     */
    function changeLayout(cls) {
        $('body').toggleClass(cls)
        $layout.fixSidebar()
        if ($('body').hasClass('fixed') && cls == 'fixed') {
            $pushMenu.expandOnHover()
            $layout.activate()
        }
        $controlSidebar.fix()
    }

    /**
     * Replaces the old skin with the new skin
     * @param String cls the new skin class
     * @returns Boolean false to prevent link's default action
     */
    function changeSkin(cls) {
        $.each(mySkins, function (i) {
            $('body').removeClass(mySkins[i])
        })

        $('body').addClass(cls)
        store('skin', cls)
        return false
    }

    /**
     * Retrieve default settings and apply them to the template
     *
     * @returns void
     */
    function setup() {
        var tmp = get('skin')
        if (tmp && $.inArray(tmp, mySkins))
            changeSkin(tmp)

        // Add the change skin listener
        $('[data-skin]').on('click', function (e) {
            if ($(this).hasClass('knob'))
                return
            e.preventDefault()
            changeSkin($(this).data('skin'))
        })

        // Add the layout manager
        $('[data-layout]').on('click', function () {
            changeLayout($(this).data('layout'))
        })

        $('[data-controlsidebar]').on('click', function () {
            changeLayout($(this).data('controlsidebar'))
            var slide = !$controlSidebar.options.slide

            $controlSidebar.options.slide = slide
            if (!slide)
                $('.control-sidebar').removeClass('control-sidebar-open')
        })

        $('[data-sidebarskin="toggle"]').on('click', function () {
            var $sidebar = $('.control-sidebar')
            if ($sidebar.hasClass('control-sidebar-dark')) {
                $sidebar.removeClass('control-sidebar-dark')
                $sidebar.addClass('control-sidebar-light')
            } else {
                $sidebar.removeClass('control-sidebar-light')
                $sidebar.addClass('control-sidebar-dark')
            }
        })

        $('[data-enable="expandOnHover"]').on('click', function () {
            $(this).attr('disabled', true)
            $pushMenu.expandOnHover()
            if (!$('body').hasClass('sidebar-collapse'))
                $('[data-layout="sidebar-collapse"]').click()
        })

        //  Reset options
        if ($('body').hasClass('fixed')) {
            $('[data-layout="fixed"]').attr('checked', 'checked')
        }
        if ($('body').hasClass('layout-boxed')) {
            $('[data-layout="layout-boxed"]').attr('checked', 'checked')
        }
        if ($('body').hasClass('sidebar-collapse')) {
            $('[data-layout="sidebar-collapse"]').attr('checked', 'checked')
        }

    }

    // Create the new tab
    var $tabPane = $('<div />', {
        'id': 'control-sidebar-theme-demo-options-tab',
        'class': 'tab-pane active'
    })

    // Create the tab button
    var $tabButton = $('<li />', {'class': 'active'})
        .html('<a href=\'#control-sidebar-theme-demo-options-tab\' data-toggle=\'tab\'>'
            + '<i class="fa fa-wrench"></i>'
            + '</a>')

    // Add the tab button to the right sidebar tabs
    $('[href="#control-sidebar-home-tab"]')
        .parent()
        .before($tabButton)

    // Create the menu
    var $demoSettings = $('<div />')

    // Layout options
    $demoSettings.append(
        '<h4 class="control-sidebar-heading">'
        + 'Layout Options'
        + '</h4>'
        // Fixed layout
        + '<div class="form-group">'
        + '<label class="control-sidebar-subheading">'
        + '<input type="checkbox"data-layout="fixed"class="pull-right"/> '
        + 'Fixed layout'
        + '</label>'
        + '<p>Activate the fixed layout. You can\'t use fixed and boxed layouts together</p>'
        + '</div>'
        // Boxed layout
        + '<div class="form-group">'
        + '<label class="control-sidebar-subheading">'
        + '<input type="checkbox"data-layout="layout-boxed" class="pull-right"/> '
        + 'Boxed Layout'
        + '</label>'
        + '<p>Activate the boxed layout</p>'
        + '</div>'
        // Sidebar Toggle
        + '<div class="form-group">'
        + '<label class="control-sidebar-subheading">'
        + '<input type="checkbox"data-layout="sidebar-collapse"class="pull-right"/> '
        + 'Toggle Sidebar'
        + '</label>'
        + '<p>Toggle the left sidebar\'s state (open or collapse)</p>'
        + '</div>'
        // Sidebar mini expand on hover toggle
        + '<div class="form-group">'
        + '<label class="control-sidebar-subheading">'
        + '<input type="checkbox"data-enable="expandOnHover"class="pull-right"/> '
        + 'Sidebar Expand on Hover'
        + '</label>'
        + '<p>Let the sidebar mini expand on hover</p>'
        + '</div>'
        // Control Sidebar Toggle
        + '<div class="form-group">'
        + '<label class="control-sidebar-subheading">'
        + '<input type="checkbox"data-controlsidebar="control-sidebar-open"class="pull-right"/> '
        + 'Toggle Right Sidebar Slide'
        + '</label>'
        + '<p>Toggle between slide over content and push content effects</p>'
        + '</div>'
        // Control Sidebar Skin Toggle
        + '<div class="form-group">'
        + '<label class="control-sidebar-subheading">'
        + '<input type="checkbox"data-sidebarskin="toggle"class="pull-right"/> '
        + 'Toggle Right Sidebar Skin'
        + '</label>'
        + '<p>Toggle between dark and light skins for the right sidebar</p>'
        + '</div>'
    )
    var $skinsList = $('<ul />', {'class': 'list-unstyled clearfix'})

    // Dark sidebar skins
    var $skinBlue =
        $('<li />', {style: 'float:left; width: 33.33333%; padding: 5px;'})
            .append('<a href="javascript:void(0)" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin">Blue</p>')
    $skinsList.append($skinBlue)
    var $skinBlack =
        $('<li />', {style: 'float:left; width: 33.33333%; padding: 5px;'})
            .append('<a href="javascript:void(0)" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin">Black</p>')
    $skinsList.append($skinBlack)
    var $skinPurple =
        $('<li />', {style: 'float:left; width: 33.33333%; padding: 5px;'})
            .append('<a href="javascript:void(0)" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin">Purple</p>')
    $skinsList.append($skinPurple)
    var $skinGreen =
        $('<li />', {style: 'float:left; width: 33.33333%; padding: 5px;'})
            .append('<a href="javascript:void(0)" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin">Green</p>')
    $skinsList.append($skinGreen)
    var $skinRed =
        $('<li />', {style: 'float:left; width: 33.33333%; padding: 5px;'})
            .append('<a href="javascript:void(0)" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin">Red</p>')
    $skinsList.append($skinRed)
    var $skinYellow =
        $('<li />', {style: 'float:left; width: 33.33333%; padding: 5px;'})
            .append('<a href="javascript:void(0)" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin">Yellow</p>')
    $skinsList.append($skinYellow)

    // Light sidebar skins
    var $skinBlueLight =
        $('<li />', {style: 'float:left; width: 33.33333%; padding: 5px;'})
            .append('<a href="javascript:void(0)" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin" style="font-size: 12px">Blue Light</p>')
    $skinsList.append($skinBlueLight)
    var $skinBlackLight =
        $('<li />', {style: 'float:left; width: 33.33333%; padding: 5px;'})
            .append('<a href="javascript:void(0)" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin" style="font-size: 12px">Black Light</p>')
    $skinsList.append($skinBlackLight)
    var $skinPurpleLight =
        $('<li />', {style: 'float:left; width: 33.33333%; padding: 5px;'})
            .append('<a href="javascript:void(0)" data-skin="skin-purple-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin" style="font-size: 12px">Purple Light</p>')
    $skinsList.append($skinPurpleLight)
    var $skinGreenLight =
        $('<li />', {style: 'float:left; width: 33.33333%; padding: 5px;'})
            .append('<a href="javascript:void(0)" data-skin="skin-green-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin" style="font-size: 12px">Green Light</p>')
    $skinsList.append($skinGreenLight)
    var $skinRedLight =
        $('<li />', {style: 'float:left; width: 33.33333%; padding: 5px;'})
            .append('<a href="javascript:void(0)" data-skin="skin-red-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin" style="font-size: 12px">Red Light</p>')
    $skinsList.append($skinRedLight)
    var $skinYellowLight =
        $('<li />', {style: 'float:left; width: 33.33333%; padding: 5px;'})
            .append('<a href="javascript:void(0)" data-skin="skin-yellow-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">'
                + '<div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>'
                + '<div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>'
                + '</a>'
                + '<p class="text-center no-margin" style="font-size: 12px">Yellow Light</p>')
    $skinsList.append($skinYellowLight)

    $demoSettings.append('<h4 class="control-sidebar-heading">Skins</h4>')
    $demoSettings.append($skinsList)

    $tabPane.append($demoSettings)
    $('#control-sidebar-home-tab').after($tabPane)

    setup()

    $('[data-toggle="tooltip"]').tooltip()
})

$(function () {
    $('#example1').DataTable({
        'paging': false,
        'info' : false
    });

    $('#realor_table').DataTable({
        'paging': false,
        'info' : false,
        'searching': false
    });

    $('#leads_listing_table').DataTable();

    /* add page form */
    $(function() {
        $("#add-page-form").validate({
            rules: {
                title: {
                    required: true
                }
            },
            messages: {
                title: {
                    required: "Title required"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

    });

});

// var app_url = 'https://www.realbrokerconnections.com/cpldashrbcs/';
// var app_url = 'https://render.properties/cpldashrbcs/';
var app_url = window.location.protocol+ "//"+ location.hostname+"/cpldashrbcs/";

$(document).ready(function(){
    tinymce.init({
        selector: "#editor1",
        theme: "modern",
        height: "300px",
        extended_valid_elements: 'span',
        branding: false,
        forced_root_block: "",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools",
            "image code"
        ],
        toolbar: "insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code | print preview media fullpage | forecolor backcolor emoticons",
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        image_advtab: true,
     //   advlist_bullet_styles: 'default',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };
            input.click();
        }
    });

    tinymce.init({
        selector: "#editor2",
        theme: "modern",
        height: "300px",
        extended_valid_elements: 'span',
        branding: false,
        forced_root_block: "",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools",
            "image code"
        ],
        toolbar: "insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code | print preview media fullpage | forecolor backcolor emoticons",
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        image_advtab: true,
     //   advlist_bullet_styles: 'default',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };
            input.click();
        }
    });

    tinymce.init({
        selector: "#editor3",
        theme: "modern",
        height: "300px",
        extended_valid_elements: 'span',
        branding: false,
        forced_root_block: "",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools",
            "image code"
        ],
        toolbar: "insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code | print preview media fullpage | forecolor backcolor emoticons",
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        image_advtab: true,
       // advlist_bullet_styles: 'default',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };
            input.click();
        }
    });
    
    
    tinymce.init({
        selector: "#editor4",
        theme: "modern",
        height: "300px",
        extended_valid_elements: 'span',
        branding: false,
        forced_root_block: "",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools",
            "image code"
        ],
        toolbar: "insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code | print preview media fullpage | forecolor backcolor emoticons",
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        image_advtab: true,
       // advlist_bullet_styles: 'default',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };
            input.click();
        }
    });


    tinymce.init({
        selector: "#editor5",
        theme: "modern",
        height: "300px",
        extended_valid_elements: 'span',
        branding: false,
        forced_root_block: "",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools",
            "image code"
        ],
        toolbar: "insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code | print preview media fullpage | forecolor backcolor emoticons",
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        image_advtab: true,
       // advlist_bullet_styles: 'default',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };
            input.click();
        }
    });


    tinymce.init({
        selector: "#editor6, #editor7, #editor8, #editor9, #editor10, #editor11",
        theme: "modern",
        height: "300px",
        extended_valid_elements: 'span',
        branding: false,
        forced_root_block: "",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools",
            "image code"
        ],
        toolbar: "insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code | print preview media fullpage | forecolor backcolor emoticons",
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        image_advtab: true,
       // advlist_bullet_styles: 'default',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };
            input.click();
        }
    });

    
    
    
});

/* check unique page title */
$('#page').on('blur', function() {
    var page = $(this).val();
    if(page !== '') {
        if (page.length > 1) {
            $.ajax({
                type: 'POST',
                url: app_url+'pages/check-page',
                data: {page: page},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data === 'exist') {
                        $('#pages-error').show();
                        $('#pages-error').text('Sorry, this page title has already exist.');
                    } else {
                        $('#pages-error').hide();
                    }
                }
            });
        } else {
            $('#pages-error').hide();
        }
    } else {
        $('#pages-error').hide();
    }
});

/* testimonials section */
$(document).ready(function(){
    $(function() {
        $("#add-testimonial-form").validate({
            rules: {
                name: {
                    required: true
                },
                description: {
                    required: true
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

    });

    /* image upload */
    tinymce.init({
        selector: "#text-image",
        theme: "modern",
        height: "250px",
        extended_valid_elements: 'span',
        branding: false,
        forced_root_block: "",
        plugins: [
            "imagetools",
            "image"
        ],
        toolbar: "image | fullpage",
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        image_advtab: true,
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };
            input.click();
        }
    });

    /* description */
    tinymce.init({
        selector: "#text-description",
        theme: "modern",
        height: "300px",
      //  extended_valid_elements: 'span',
        branding: false,
        //forced_root_block: "",
        plugins: [
            "advlist autolink lists link charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern",
            "code"
        ],
        toolbar: "insertfile undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | code | print preview fullpage | forecolor backcolor emoticons",
        style_formats: []
      //  advlist_bullet_styles: 'default',
    });
});

/* delete testimonial */
function deleteTestimonial(id) {
    if(confirm("Are you sure you want to delete this?")){
        $.ajax({
            type: 'POST',
            url: app_url+'pages/delete-testimonial',
            data: {id: id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                if(data === 'success') {
                    $('.row_'+id).remove();
                    $("#dlt-msg").text('Record successfully deleted.').show().delay(5000).fadeOut();
                }
            }
        });
    } else {
        return false;
    }
}


function deleteUser(id) {
    if(confirm("Are you sure you want to delete this user?")){
        $.ajax({
            type: 'POST',
            url: app_url + 'users/delete-user',
            data: {id: id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                if(data === 'success') {
                    $('.row_'+id).remove();
                    $("#dlt-msg").text('Record successfully deleted.').show().delay(5000).fadeOut();
                }
            }
        });
    } else {
        return false;
    }
}






// Div Counter (Realtor Register Page)
let numberOfDivs = document.querySelectorAll('.section-box').length + 1;

// Create tiny MCE textarea 
function initTinyMCE(selector) {
    tinymce.init({
        selector: selector,
        theme: "modern",
        height: "300px",
        extended_valid_elements: 'span',
        branding: false,
        forced_root_block: "",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools",
            "image code"
        ],
        toolbar: "insertfile undo redo | styleselect | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code | print preview media fullpage | forecolor backcolor emoticons",
        image_title: true,
        automatic_uploads: true,
        file_picker_types: 'image',
        image_advtab: true,
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };
            input.click();
        }
    });
}

// Add New Sections
$("#addSubSections").click(function(){
    $(".addNewSections").append(`
        <div class="section-box form-group">
            <h4>Section 1 (Sub Section ${numberOfDivs++})</h4>
            <textarea class="tinyTextArea" name="section1[]" rows="10" cols="80"></textarea>
            <a class='btn btn-danger ms-1 remove_section_field'>Remove</a>
        </div>        
        <div class="clearfix"></div>
    `);

    // Call this to apply tiny mce textArea on this class when adding a new section
    initTinyMCE(".tinyTextArea");
});

// Remove Section Field
$('.addNewSections').on("click", ".remove_section_field", function(e){ 
    e.preventDefault(); 
    $(this).parent('.section-box').remove();
});

// First Call on while page load to apply tiny mce textArea on this class
initTinyMCE(".tinyTextArea");


// $(document).ready(function() {
//     $('#leads-listing-table').DataTable({
//         dom: 'Bfrtip', // Define the position of the buttons
//         buttons: [
//             'copy', 'excel', 'pdf', 'colvis'
//         ],
//         "paging": true, // Enable pagination
//         "searching": true, // Enable search functionality
//         "ordering": true, // Enable column sorting
//         "info": true, // Show info about the table
//         "autoWidth": false // Disable auto width calculation
//     });
// });

// new DataTable('#leads-listing-table');

// $(document).ready(function () {
//     // Function to toggle input visibility based on selected search type
//     function toggleInputFields(searchType) {
//         // Clear previous input and error message
//         $("#search_value_input").val("");
//         $(".lead-field-error").html("");
//         $('#search_form_type, #search_state, #search_value_input').hide();

//         if (searchType === 'form_type') {
//             $('#search_form_type').show();
//         } else if (searchType === 'state') {
//             $('#search_state').show();
//         } else {
//             $('#search_value_input').show();
//         }
//     }

//     // Initialize the form state based on the selected search type
//     toggleInputFields($('#lead_search_type').val());

//     $('#lead_search_type').change(function () {
//         toggleInputFields($(this).val());
//     });

//     function getLeadContent() {
//         let form = $("#filter-lead-form");
//         let formData = new FormData(form[0]);
//         let searchType = formData.get("search_type");

//         // Clear error message before validation
//         $(".lead-field-error").html("");

//         // Form validation logic
//         let isValid = true;
//         if (searchType === 'all' || searchType === 'name' || searchType === 'email' || searchType === 'phone_number' || searchType === 'city') {
//             if (!formData.get("search_value")) {
//                 $(".lead-field-error").html("Please enter a value");
//                 isValid = false;
//             }
//         } else if (searchType === 'state' && !formData.get("search_state")) {
//             $(".lead-field-error").html("Please select a state");
//             isValid = false;
//         } else if (searchType === 'form_type' && !formData.get("search_form_type")) {
//             $(".lead-field-error").html("Please select a form type");
//             isValid = false;
//         }

//         // If validation fails, do not proceed with AJAX request
//         if (!isValid) {
//             return;
//         }

//         // AJAX request to filter leads
//         $.ajax({
//             url: form.attr("action"),
//             method: "POST",
//             data: formData,
//             processData: false,
//             contentType: false,
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             success: function (response) {
//                 $('.lead_data_content').html(response.content);
//                 console.log("Leads filtered successfully", response);
//             },
//             error: function (error) {
//                 console.error("Error filtering leads", error);
//                 if (error.responseJSON && error.responseJSON.message) {
//                     alert(error.responseJSON.message);
//                 }
//             }
//         });
//     }

//     // Bind click event to the filter button
//     $("#filter_leads").click(getLeadContent);

//     // Initial content load on page load
//     getLeadContent();
// });




$(document).ready(function () {
    // Hide or show the select field based on the initial dropdown state
    $('#search_form_type').hide();
    $('#search_state').hide();
    $('#search_value_input').show();

    // Function to toggle input fields based on selected search type
    function toggleInputFields(searchType) {
        $("#search_value_input").val(""); // Clear input value
        $(".lead-field-error").html(""); // Clear error message
        
        $('#search_form_type, #search_state, #search_value_input').hide(); // Hide all fields initially

        if (searchType === 'form_type') {
            $('#search_form_type').show();
        } else if (searchType === 'state') {
            $('#search_state').show();
        } else {
            $('#search_value_input').show();
        }
    }

    // Initialize the form state based on the selected search type
    $('#lead_search_type').change(function () {
        toggleInputFields($(this).val());
    });

    // Trigger change event on page load to set the correct initial state
    $('#lead_search_type').trigger('change');

    // Function to handle form validation and lead content retrieval
    function getLeadContent() {
        let form = $("#filter-lead-form");
        let formData = new FormData(form[0]);
    
        let searchType = formData.get("search_type");
        let searchValue = formData.get("search_value");
        let formTypeValue = formData.get("search_form_type");
        let stateValue = formData.get("search_state");
    
        // Clear any previous error messages
        $(".lead-field-error").html("");
    
        // Form validation logic
        if (searchType !== "all" && searchType !== "form_type" && searchType !== "state") {
            if (!searchValue) {
                $(".lead-field-error").html("Please enter a value");
                return;
            }
        } else if (searchType === "state") {
            if (!stateValue) {
                $(".lead-field-error").html("Please select a state");
                return;
            }
        } else if (searchType === "form_type") {
            if (!formTypeValue) {
                $(".lead-field-error").html("Please select a form type");
                return;
            }
        }
    
        // Show loader and hide table quickly
        console.log('Hiding table and showing loader');
        $('.admin_lead_table').hide(); // Hide the table quickly
        $('#loader-2').show(); // Show the loader
    
        // Send AJAX request to filter leads
        $.ajax({
            url: form.attr("action"),
            method: "POST",
            data: formData,
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Set contentType to false since we're sending FormData
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token for Laravel
            },
            success: function (response) {
                console.log("Leads filtered successfully", response); // Debugging
                $('.lead_data_content').html(response.content); // Update content with response
            },
            error: function (error) {
                console.error("Error filtering leads", error); // Debugging
            },
            complete: function () {
                $('.admin_lead_table').hide();
                // Start a timeout to ensure loader is visible for at least 1 second
                let loaderTimeout = setTimeout(() => {
                    $('#loader-2').hide(); // Hide loader after 1 second
                    $('.admin_lead_table').fadeIn(); // Show table with fade-in effect
                }, 800); // 1000ms = 1 second
            }
        });
    }

    // Event handler to hide error messages when a valid input is made
    $('#search_state, #search_form_type, #search_value_input').change(function () {
        if ($(this).val() !== "") {
            $(".lead-field-error").html(""); // Clear error message when valid input is provided
        }
    });

    // Bind click event to filter button
    $("#filter_leads").click(getLeadContent);

    // Initial content load on page load
    getLeadContent();
});