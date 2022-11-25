<?php
	include('db.php');
	include('func.php');
	error_reporting(0);

	if(isset($_POST["store_id"]))
	{
		$output = array();
		$statement = $conn->prepare("SELECT * FROM store 
			WHERE store_id = '".$_POST["store_id"]."' 
		");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output["city"] = $row["city"];
			$output["route"] = $row["route"];
			$output["route_number"] = $row["route_number"];
			$output["TK"] = $row["TK"];
			$output["phone_number"] = $row["phone_number"];
			$output["geo_x"] = $row["geo_x"];
			$output["geo_y"] = $row["geo_y"];
			$output["hub_id"] = $row["hub_id"];		
		}
		echo json_encode($output);
	}
?>