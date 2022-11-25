//validation gia sosto tracking number
function validate_box_form(){
	var tracking_number = document.box_search_form.tracking_number.value;

	if(tracking_number != ''){
		$.ajax({
			type: "POST",
			url: "../php/get_box_path.php",
			data: {tracking_number:tracking_number},
			success: function(data){
				console.log(data);
				var message = data;
				message = message.replace(/\s+/g, '');
				var str_valid = "valid_tracking_number";
				var str_fail = "not_a_box";

				if(message == str_valid){
					document.getElementById("tracking_number").value = "";
					error3.style.visibility = 'hidden';
					window.location = "../html/show_box_path.html";
				}
				else if(message == str_fail){
					document.getElementById('error3').innerHTML = "Λαθος αριθμος αποστολης";
				}
			}
		})
	}
	else if(tracking_number == ''){
		document.getElementById('error3').innerHTML = "Συμπληρωσε αριθμο αποστολης";
	}
	
	return false;
}

