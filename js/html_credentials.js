$.ajax({
	url: "../php/find_credentials.php",
	success: function(data){
		var message = data;
		message = message.replace(/\s+/g, '');

		//elegxos gia redirect sta admin.html, cashier.html, hubber.html
		var str_fail = "you_shall_not_pass";
		var str_pass = "ok";

		if(message == str_fail){
			window.location = "../html/index.html";
		}
		else if(message == str_pass){
			document.body.style.display = "block";
		}
	}
})