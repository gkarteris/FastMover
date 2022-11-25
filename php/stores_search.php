<?php
	include('db.php'); 
	include('func.php');
	error_reporting(0);
	
	$query = '';
	$output = array();
	$query .= "SELECT * FROM store ";
	if(isset($_POST["search"]["value"]))
	{
		$query .= 'WHERE city LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR route LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR route_number LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR TK LIKE "%'.$_POST["search"]["value"].'%" ';
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY store_id ASC ';
	}
	if($_POST["length"] != -1)
	{
		$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	}

	$statement = $conn->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();

	$data = array();
	$filtered_rows = $statement->rowCount();
	foreach($result as $row)
	{
		$sub_array = array();
		$sub_array[] = $row["store_id"];
		$sub_array[] = $row["city"];
		$sub_array[] = $row["route"];
		$sub_array[] = $row["route_number"];
		$sub_array[] = $row["TK"];
		$sub_array[] = $row["phone_number"];
		$sub_array[] = $row["geo_x"];
		$sub_array[] = $row["geo_y"];
		$sub_array[] = $row["hub_id"];
		$sub_array[] = '<button type="button" name="update_store" id="'.$row["store_id"].'" class="btn btn-warning btn-xs update_store">Ενημερωση</button>';
		$sub_array[] = '<button type="button" name="delete_store" id="'.$row["store_id"].'" class="btn btn-danger btn-xs delete_store">Διαγραφη</button>';
		$data[] = $sub_array;
	}
	$output = array(
		"draw"				=>	intval($_POST["draw"]),
		"recordsTotal"		=> 	$filtered_rows,
		"recordsFiltered"	=>	get_total_all_records_stores(),
		"data"				=>	$data
	);
	echo json_encode($output);
?>
