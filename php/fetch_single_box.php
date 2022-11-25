<?php
	include('db.php');
	include('func.php');
	error_reporting(0);

	if(isset($_POST["box_id"]))
	{ 
		$output = array();
		$statement = $conn->prepare(
			"SELECT * FROM box 
			WHERE box_id = '".$_POST["box_id"]."' 
		");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output["name_sender"] = $row["name_sender"];
			$output["name_receiver"] = $row["name_receiver"];
			$output["route_receiver"] = $row["route_receiver"];	
		}
		$statement = $conn->prepare(
			"SELECT * FROM store 
			WHERE store_id = '".$row["starting_store_id"]."' 
		");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $start_row)
		{
			$output["start_city"] = $start_row["city"].', '.$start_row["route"].' '.$start_row["route_number"];	
		}
		$statement = $conn->prepare(
			"SELECT * FROM store 
			WHERE store_id = '".$row["final_store_id"]."' 
		");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $final_row)
		{
			$output["final_city"] = $final_row["city"].', '.$final_row["route"].' '.$final_row["route_number"];	
		}
		echo json_encode($output);
	}
?>