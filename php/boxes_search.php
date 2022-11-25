<?php
	include('db.php'); 
	include('func.php');
	error_reporting(0);
	
	$output = array();
	$query = "SELECT * FROM box ";
	if(isset($_POST["search"]["value"]))
	{
		$query .= 'WHERE box_id LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'AND ( name_sender LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR name_receiver LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR starting_store_id LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR final_store_id LIKE "%'.$_POST["search"]["value"].'%") ';
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY box_id ASC ';
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
		$sub_array[] = $row["box_id"];
		$sub_array[] = $row["tracking_number"];
		$sub_array[] = $row["name_sender"];
		$sub_array[] = $row["name_receiver"];
		$sub_array[] = $row["route_receiver"];
		$sub_array[] = $row["starting_store_id"];
		$sub_array[] = $row["final_store_id"];
		$sub_array[] = $row["delivery_type"];
		$sub_array[] = $row["cost"];
		$sub_array[] = $row["delivered"];
		$sub_array[] = '<button type="button" data-toggle="modal" data-target="#boxModal2" name="more_info" id="'.$row["box_id"].'" class="btn btn-warning btn-xs more_info">Περισσοτερα</button>';
		$sub_array[] = '<button type="button" name="delete_box" id="'.$row["box_id"].'" class="btn btn-danger btn-xs delete_box">Διαγραφη</button>';
		$data[] = $sub_array;
	}
	$output = array(
		"draw"				=>	intval($_POST["draw"]),
		"recordsTotal"		=> 	$filtered_rows,
		"recordsFiltered"	=>	get_total_all_records_boxes(),
		"data"				=>	$data
	);
	echo json_encode($output);
?>
