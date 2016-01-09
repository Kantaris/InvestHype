jQuery(document).ready(function () {
    if ($("#msg_alert").html()!=''){
        showAlert($("#msg_alert").html());
    }

    $('form').bootstrapValidator({
        feedbackIcons: {
            valid: 'has-success',
            invalid: 'has-error',
//                        validating: ''
        },
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: 'Enter the username'
                    },
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Enter the password'
                    },
                }
            },
            password1: {
                validators: {
                    notEmpty: {
                        message: 'Enter the password'
                    },
                }
            },
            password2: {
                validators: {
                    notEmpty: {
                        message: 'Enter the password'
                    },
                }
            },
            email:{
                validators:{
                    notEmpty: {
                        message: 'Enter the email address'
                    },
                    emailAddress: {
                        message: 'Enter the valid email'
                    },
                }
            },
        }
    })
    .on('success.field.bv', function(e, data) {
        if (data.bv.isValid()) {
//            if ($("#subscribe").hasClass('fa-square-o')){
//                update_subscribe($("#email").val(), '0');
//                remove_subscribe();
//            } else {
//                update_subscribe($("#email").val(), '1');
//            }
    
            data.bv.disableSubmitButtons(false);
        }
    });
    
//    $("div.subscribe").click(function(e){
//       e.preventDefault();
//       if ($("#subscribe").hasClass('fa-square-o')) {
//           $("#subscribe").removeClass('fa-square-o').addClass('fa-check-square-o');
//       } else {
//           $("#subscribe").removeClass('fa-check-square-o').addClass('fa-square-o');
//       }
//    });

});
