<?php
	error_reporting(0);
	
	$final_path = array();
	$str = file_get_contents('../JSON/completed_box_path.json');
	$current_paths_to_hubs = json_decode($str, true);

	$conn = mysqli_connect("127.0.0.1","root","","our_site_db");
	if(!$conn){
		die(mysqli_connect_error());
	};
	mysqli_set_charset($conn, "utf8");


	foreach ($current_paths_to_hubs as $key => $value) {
		$result = $conn->query("SELECT * FROM transit_hub WHERE transit_id = $current_paths_to_hubs[$key]")  or die($conn->error());
		$row = $result->fetch_assoc();
		$final_path[] = $row;
	}

	$fp = fopen('../JSON/completed_box_path.json', 'w');
	$rv_from_fwrite = fwrite($fp, json_encode($final_path));
	if(!$rv_from_fwrite){
		die(mysqli_error());
	}
	fclose($fp);
?>