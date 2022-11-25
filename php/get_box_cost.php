<?php
	include('db.php');
	include "algorithm_dijkstra.php";
	error_reporting(0);

	session_start();
	mb_internal_encoding("UTF-8");

	$starting_store_id = $_POST['starting_store_id'];
	$final_store_id = $_POST['final_store_id'];
	$delivery_type = $_POST['delivery_type'];

	$statement = $conn->prepare("SELECT hub_id FROM store WHERE store_id = '$starting_store_id'");
	$statement->execute();
	$row = $statement->fetch();
	$starting_hub = $row['hub_id'];

	$statement = $conn->prepare("SELECT hub_id FROM store WHERE store_id = '$final_store_id'");
	$statement->execute();
	$row = $statement->fetch();
	$final_hub = $row['hub_id'];

	list($time, $cost, $final_path) = dijkstra_algorithm($starting_hub, $final_hub, $delivery_type);

	$cost+=2;
	$_SESSION['cost'] = $cost;
	$_SESSION['time'] = $time;
	$_SESSION['del_type'] = $delivery_type;
	$_SESSION['st_store'] = $starting_store_id;
	$_SESSION['fn_store'] = $final_store_id;
?>