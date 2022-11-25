<?php
	include('db.php');
	include('func.php');
	error_reporting(0);

	if(isset($_POST["emp_id"]))
	{
		
		$statement = $conn->prepare(
			"DELETE FROM employee WHERE emp_id = :emp_id"
		);
		$result = $statement->execute(
			array(
				':emp_id'	=>	$_POST["emp_id"]
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