function validateEmail(email) {
    var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return pattern.test(email);
}

function validate_contact_form(){

	x = document.getElementById("contact_form");
    f_name = x.elements[0].value;
    l_name = x.elements[1].value;
    email = x.elements[2].value;
    subject = x.elements[3].value;
    message = x.elements[4].value;

  	

    if(f_name == '' || l_name == '' || email == '' || subject == '' || message == ''){
    	$('#error4').show();
		document.getElementById('error4').innerHTML = "Όλα τα πεδία είναι υποχρεωτικά";
	}
	else if(f_name != '' && l_name != '' && email != '' && subject != '' && message != ''){
		$('#error4').hide();

    	if(validateEmail(email) == true){
    						/* a tropos */
			document.getElementById('contact_form').reset();

			 				/* b tropos */
			// document.getElementById("firstname").value = "";
			// document.getElementById("lastname").value = "";
			// document.getElementById("email").value = "";
			// document.getElementById("subject").value = "";
			// document.getElementById("message").value = "";
			$('.alert-autocloseable-success-send-email').show();
	        $('.alert-autocloseable-success-send-email').delay(1500).fadeOut( "slow", function() {
	            // Animation complete.
	            $('#btn_send_message').prop("disabled", false);
	        });
	    }
	    else{
	    	$('#error4').show();
			document.getElementById('error4').innerHTML = "Μη έγκυρο email";
	    }
	}	
	return false;
}