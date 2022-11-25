<?php
	include('db.php');
	include('func.php');
	error_reporting(0);

	if(isset($_POST["operation"]))
	{
		if($_POST["operation"] == "Add")
		{
			$statement = $conn->prepare("
				INSERT INTO employee (name, surname, gender, age, working_store, working_hub, username, password, work_type) 
				VALUES (:name, :surname, :gender, :age, :working_store, NULL, :username, :password, 'cashier')
			");
			$result = $statement->execute(
				array(
					':name'			=>	$_POST["name"],
					':surname'		=>	$_POST["surname"],
					':gender'		=>	$_POST["gender"],
					':age'			=>	$_POST["age"],
					':working_store'=>	$_POST["working_store"],
					':username'		=>	$_POST["username"],
					':password'		=>	$_POST["password"]
				)
			);
			if(!empty($result))
			{
				echo 'Τα δεδομένα καταχωρήθηκαν επιτυχώς';
			}
			else
			{
				echo 'Παρουσιάστηκε κάποιο σφάλμα, προσπάθησε ξανά';
			}
		}
		
		if($_POST["operation"] == "Edit")
		{
			$statement = $conn->prepare(
				"UPDATE employee 
				SET name = :name, surname = :surname, 
				gender = :gender, age = :age, 
				working_store = :working_store, working_hub = NULL, 
				username = :username, password= :password, 
				work_type = 'cashier'
				WHERE emp_id = :emp_id
			");
			$result = $statement->execute(
				array(
					':name'			=>	$_POST["name"],
					':surname'		=>	$_POST["surname"],
					':gender'		=>	$_POST["gender"],
					':age'			=>	$_POST["age"],
					':working_store'=>	$_POST["working_store"],
					':username'		=>	$_POST["username"],
					':password'		=>	$_POST["password"],
					':emp_id'		=>	$_POST["emp_id"]
				)
			);

			if(!empty($result))
			{
				echo 'Τα δεδομένα αναβαθμίστηκαν επιτυχώς';
			}
			else
			{
				echo 'Παρουσιάστηκε κάποιο σφάλμα, προσπάθησε ξανά';
			}
		}
	}
?>