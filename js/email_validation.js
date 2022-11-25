
// elegxei an exeis valei swsto pattern email
function validateEmail(email) {
    var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return pattern.test(email);
}

function check_email() {
    x = document.getElementById("email_sub");
    var email_sub = "";
    email_sub = x.elements[0].value;
    if(validateEmail(email_sub) == true){
        $('.alert-autocloseable-success').show();
        $('.alert-autocloseable-success').delay(1500).fadeOut( "slow", function() {
            // Animation complete.
            $('#button_subscribe').prop("disabled", false);
            document.getElementById('email_sub').reset(); // ta dedomena tis formas svinodai
        });
    }
    else{
        $('.alert-normal-danger').show();
        $('.alert-normal-danger').delay(1500).fadeOut( "slow", function() {
            // Animation complete.
            $('#button_subscribe').prop("disabled", false);
            document.getElementById('email_sub').reset(); // ta dedomena tis formas svinodai
        });
    }
}

$(document).ready(function () {
    $('#button_subscribe').click(function() {
        check_email();
        $('#button_subscribe').prop("disabled", true);                     
    });
});