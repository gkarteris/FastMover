<?php
	include('db.php');
	error_reporting(0);

	if(isset($_POST["operation_store"]))
	{
		$timi = $_POST["operation_store"];
		if(empty($timi)){
			echo 'einai adeia re sy ';
		}
		echo 'if clause POST[operation]--> ';
		if($_POST["operation_store"] == "Add_store")
		{
			echo 'ADD--> ';
			$statement = $conn->prepare("
				INSERT INTO store (city, route, route_number, TK, phone_number, geo_x, geo_y, hub_id) 
				VALUES (:city, :route, :route_number, :TK, :phone_number, :geo_x, :geo_y, :hub_id)
			");
			$result = $statement->execute(
				array(
					':city'			=>	$_POST["city"],
					':route'		=>	$_POST["route"],
					':route_number'	=>	$_POST["route_number"],
					':TK'			=>	$_POST["TK"],
					':phone_number'	=>	$_POST["phone_number"],
					':geo_x'		=>	$_POST["geo_x"],
					':geo_y'		=>	$_POST["geo_y"],
					':hub_id'		=>	$_POST["hub_id"]
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
		if($_POST["operation_store"] == "Edit_store")
		{
			echo 'EDIT--> ';
			$statement = $conn->prepare(
				"UPDATE store 
				SET city = :city, route = :route, 
				route_number = :route_number, TK = :TK, 
				phone_number = :phone_number, geo_x = :geo_x, 
				geo_y = :geo_y, hub_id = :hub_id 
				WHERE store_id = :store_id
			");
			
			$result = $statement->execute(
				array(
					':city'			=>	$_POST["city"],
					':route'		=>	$_POST["route"],
					':route_number'	=>	$_POST["route_number"],
					':TK'			=>	$_POST["TK"],
					':phone_number'	=>	$_POST["phone_number"],
					':geo_x'		=>	$_POST["geo_x"],
					':geo_y'		=>	$_POST["geo_y"],
					':hub_id'		=>	$_POST["hub_id"],
					':store_id' 	=>  $_POST["store_id"]
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