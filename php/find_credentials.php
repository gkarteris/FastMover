<?php	
	session_start();

	if(!isset($_SESSION['uname'])){
		echo 'you_shall_not_pass';
	}
	else if(isset($_SESSION['uname'])){
		echo 'ok';
	}
?>