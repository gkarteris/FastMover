function validate_QR(){
	// console.log('mpika');
	$.ajax({
		type: "POST",
		url: "../php/box_scan.php",
		//data: {user:user , pass:pass},
		success: function(data){

			var message = data;
			console.log(message);
			message = message.replace(/\s+/g, '');

			var str_mistake = "mistake";
			var str_ok = "ok";

			if(message == str_mistake){
				$('.QR_error').show();
		        $('.QR_error').delay(3000).fadeOut( "slow", function() {
		            // Animation complete.
		            $('#QR_btn').prop("disabled", false);
		        });
			}
			else if(message == str_ok){
				$('.QR_correct').show();
		        $('.QR_correct').delay(2000).fadeOut( "slow", function() {
		            // Animation complete.
		            $('#QR_btn').prop("disabled", false);
		        });
			}
		}
	})
}


$(document).ready(function () {
    $('#QR_btn').click(function() {
        validate_QR();
        $('#QR_btn').prop("disabled", true);                     
    });
    $(document).on('click', '.close', function () {
        $(this).parent().hide();
    });
});