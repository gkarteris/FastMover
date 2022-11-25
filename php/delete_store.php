<?php
	include('db.php');
	include('func.php');
	error_reporting(0);

	if(isset($_POST["store_id"]))
	{
		
		$statement = $conn->prepare(
			"DELETE FROM store WHERE store_id = :store_id"
		);
		$result = $statement->execute(
			array(
				':store_id'	=>	$_POST["store_id"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Η καταχώρηση διαγράφηκε επιτυχώς';
		}
		else
		{
			echo 'Κάτι πηγε στραβα';
		}
	}
?>