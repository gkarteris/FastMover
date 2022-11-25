function validate_form(){
	var user = document.login_form.user.value;
	var pass = document.login_form.pass.value;

	// elegxoyme an ta credentianls toy login einai sosta kai an nai kanoyme analogo redirect
	if(user != '' && pass != ''){
		$.ajax({
			type: "POST",
			url: "../php/process.php",
			data: {user:user , pass:pass},
			success: function(data){
				var message = data;
				message = message.replace(/\s+/g, ''); // diagrafi olwn twn kenwn

				var str_hub = "hubber";
				var str_admin = "admin";
				var str_cashier = "cashier";
				var str_fail = "failed";

				if(message == str_hub){
					window.location = "../html/hubber.html";
				}
				else if(message == str_admin){
					window.location = "../html/admin.html";
				}
				else if(message == str_cashier){
					window.location = "../html/cashier.html";
				}
				else if(message == str_fail){
					document.getElementById('error2').innerHTML = "Λάθος κωδικός ή όνομα χρήστη"; // message prompt
				}
			}
		})
	}
	else if(user == '' || pass == ''){
		if(user == ''){
			document.getElementById('error1').innerHTML = "Βάλε όνομα"; //message prompt
		}

		if(pass == ''){
			document.getElementById('error2').innerHTML = "Βάλε κωδικό"; //message prompt
		}	
	}
	return false;
}
