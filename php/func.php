<?php
	error_reporting(0);

	function get_total_all_records_cashier(){
		include('../php/db.php');
		$statement = $conn->prepare("SELECT emp_id,name,surname,gender,age,working_store,username,password,work_type FROM employee WHERE work_type = 'cashier'");
		$statement->execute();
		$result = $statement->fetchAll();
		return $statement->rowCount();
	}

	function get_total_all_records_hubber(){
		include('../php/db.php');
		$statement = $conn->prepare("SELECT emp_id,name,surname,gender,age,working_hub,username,password,work_type FROM employee WHERE work_type = 'hub'");
		$statement->execute();
		$result = $statement->fetchAll();
		return $statement->rowCount();
	}

	function get_total_all_records_stores(){
		include('../php/db.php');
		$statement = $conn->prepare("SELECT * FROM store");
		$statement->execute();
		$result = $statement->fetchAll();
		return $statement->rowCount();
	}

	function get_total_all_records_boxes(){
		include('../php/db.php');
		$statement = $conn->prepare("SELECT * FROM box");
		$statement->execute();
		$result = $statement->fetchAll();
		return $statement->rowCount();
	}
?>