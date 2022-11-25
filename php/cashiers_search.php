<?php
	include('db.php'); 
	include('func.php');
	error_reporting(0);
	
	$output = array();
	$query = "SELECT emp_id,name,surname,gender,age,working_store,username,password,work_type FROM employee WHERE work_type = 'cashier' ";
	if(isset($_POST["search"]["value"]))
	{
		$query .= 'AND (name LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR surname LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR gender LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR emp_id LIKE "%'.$_POST["search"]["value"].'%" ';
		$query .= 'OR working_store LIKE "%'.$_POST["search"]["value"].'%") ';
	}
	if(isset($_POST["order"]))
	{
		$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	}
	else
	{
		$query .= 'ORDER BY emp_id ASC ';
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
		$sub_array[] = $row["emp_id"];
		$sub_array[] = $row["name"];
		$sub_array[] = $row["surname"];
		$sub_array[] = $row["gender"];
		$sub_array[] = $row["age"];
		$sub_array[] = $row["working_store"];
		$sub_array[] = $row["username"];
		$sub_array[] = $row["password"];
		$sub_array[] = $row["work_type"];
		$sub_array[] = '<button type="button" name="update_cashier" id="'.$row["emp_id"].'" class="btn btn-warning btn-xs update_cashier">Ενημερωση</button>';
		$sub_array[] = '<button type="button" name="delete_cashier" id="'.$row["emp_id"].'" class="btn btn-danger btn-xs delete_cashier">Διαγραφη</button>';
		$data[] = $sub_array;
	}
	$output = array(
		"draw"				=>	intval($_POST["draw"]),
		"recordsTotal"		=> 	$filtered_rows,
		"recordsFiltered"	=>	get_total_all_records_cashier(),
		"data"				=>	$data
	);
	echo json_encode($output);	
?>
