function forget_password() {
    
}

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
            password: {
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
            data.bv.disableSubmitButtons(false);
        }
    });

});
