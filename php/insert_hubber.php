<?php
	include('db.php');
	error_reporting(0);

	if(isset($_POST["operation_hubber"]))
	{
		$timi = $_POST["operation_hubber"];
		if(empty($timi)){
			echo 'einai adeia re sy ';
		} 
		echo 'if clause POST[operation]--> ';
		if($_POST["operation_hubber"] == "Add_hubber")
		{
			echo 'ADD--> ';
			$statement = $conn->prepare("
				INSERT INTO employee (name, surname, gender, age, working_store, working_hub, username, password, work_type) 
				VALUES (:name, :surname, :gender, :age, NULL, :working_hub, :username, :password, 'hub')
			");
			$result = $statement->execute(
				array(
					':name'			=>	$_POST["name_hubber"],
					':surname'		=>	$_POST["surname_hubber"],
					':gender'		=>	$_POST["gender_hubber"],
					':age'			=>	$_POST["age_hubber"],
					':working_hub'	=>	$_POST["working_hub_hubber"],
					':username'		=>	$_POST["username_hubber"],
					':password'		=>	$_POST["password_hubber"]
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
		if($_POST["operation_hubber"] == "Edit_hubber")
		{
			echo 'EDIT--> ';
			$statement = $conn->prepare(
				"UPDATE employee 
				SET name = :name, surname = :surname, 
				gender = :gender, age = :age, 
				working_store = NULL, working_hub = :working_hub, 
				username = :username, password= :password, 
				work_type = 'hub'
				WHERE emp_id = :emp_id
			");
			$result = $statement->execute(
				array(
					':name'			=>	$_POST["name_hubber"],
					':surname'		=>	$_POST["surname_hubber"],
					':gender'		=>	$_POST["gender_hubber"],
					':age'			=>	$_POST["age_hubber"],
					':working_hub'	=>	$_POST["working_hub_hubber"],
					':username'		=>	$_POST["username_hubber"],
					':password'		=>	$_POST["password_hubber"],
					':emp_id'		=>	$_POST["emp_id_hubber"]
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
		// echo 'END ';
	}
?>