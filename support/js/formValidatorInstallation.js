$(document).ready(function() {
    
    toggleSmtpFields();
    $("#USESMTP").change(function () {
        toggleSmtpFields();
    });
    
    toggleRecaptchaFields();
    $("#USERECAPTCHA").change(function () {
        toggleRecaptchaFields();
    });
    
    var installFrm = $('#installationForm');
    
    installFrm.bootstrapValidator({
        fields: {
            EMAIL: {
                validators: {
                    notEmpty: {
                        message: 'Email to is required'
                    }
                }
            },
            SUBJECT: {
                validators: {
                    notEmpty: {
                        message: 'Email subject is required'
                    }
                }
            }
        }
    })
    .on('success.form.bv', function(e) {
 
            e.preventDefault();
        
            var request = $.ajax({
                type: installFrm.attr('method'),
                url: installFrm.attr('action'),
                data: installFrm.serialize()
            });

            $('#installationForm').hide();
            $('#status').html("Installing form, please wait...");

            request.done(function(e) {
                if(e[0] + e[1] == "OK") {
                    $('#status').html(e);
                } else {
                    $('#status').html("Sorry, there was a problem installing your form.<br>Error: " + e + "<br />PLEASE INSTALL MANUALLY");
                    $('#contactForm').show();
                }
            });

            request.fail(function() {
                $('#status').html("Sorry, there was a problem installing your form.");
                $('#installationForm').show();
            });
            
        });

});

function toggleSmtpFields() {
    if ($("#USESMTP").val() == "yes") {
        $("#smtp_options").show();
    } else {
        $("#smtp_options").hide();
    }
}

function toggleRecaptchaFields() {
    if ($("#USERECAPTCHA").val() == "yes") {
        $("#recaptcha_options").show();
    } else {
        $("#recaptcha_options").hide();
    }
}