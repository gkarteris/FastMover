<?php
	include('db.php');
	include('func.php');
	error_reporting(0);

	if(isset($_POST["emp_id"]))
	{
		$output = array();
		$statement = $conn->prepare(
			"SELECT * FROM employee 
			WHERE emp_id = '".$_POST["emp_id"]."' 
		");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output["name"] = $row["name"];
			$output["surname"] = $row["surname"];
			$output["gender"] = $row["gender"];
			$output["age"] = $row["age"];
			$output["working_store"] = $row["working_store"];
			$output["username"] = $row["username"];
			$output["password"] = $row["password"];		
		}
		echo json_encode($output);
	}
?>