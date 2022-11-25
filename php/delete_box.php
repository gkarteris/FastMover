<?php
	include('db.php');
	include('func.php');
	error_reporting(0);

	if(isset($_POST["box_id"]))
	{
		
		$statement = $conn->prepare(
			"DELETE FROM box WHERE box_id = :box_id"
		);
		$result = $statement->execute(
			array(
				':box_id'	=>	$_POST["box_id"]
			)
		);
		if(file_exists('../QR/qr_codes/'.$_POST["box_id"].'.png'))
		{
	    	unlink('../QR/qr_codes/'.$_POST["box_id"].'.png');
		}

		if(!empty($result))
		{
			echo 'Το πακέτο διαγράφηκε επιτυχώς';
		}
		else
		{
			echo 'Κάτι πηγε στραβα';
		}
	}
?>