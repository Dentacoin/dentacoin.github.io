$(document).ready(function() {
    
    var frm = $('#contactForm');
    
    frm.bootstrapValidator({
        fields: {
            Name: {
                validators: {
                    notEmpty: {
                        message: 'Your name is required'
                    }
                }
            },
            Email: {
                validators: {
                    notEmpty: {
                        message: 'Your email is required'
                    },
                    emailAddress: {
                        message: 'Your email is not valid'
                    }
                }
            },
            Message: {
                validators: {
                    notEmpty: {
                        message: 'Your message is required'
                    }
                }
            }
        }
    })
    .on('success.form.bv', function(e) {
 
            e.preventDefault();
        
            var request = $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize()
            });

            $('#contactForm').hide();
            $('#status').html("Sending form, please wait...");

            request.done(function(e) {
                if(e[0] + e[1] == "OK") {
                    $('#status').html("Thank you, we've received your message.");
                } else {
                    $('#status').html("Sorry, there was a problem sending your message.<br>Error: " + e);
                    $('#contactForm').show();
                }
            });

            request.fail(function() {
                $('#status').html("Failure, sorry there was a problem sending your message.");
                $('#contactForm').show();
            });
            
        });
    
});