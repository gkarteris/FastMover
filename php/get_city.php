<?php
	error_reporting(0);

	$conn = mysqli_connect("127.0.0.1","root","","our_site_db");
	if(!$conn){
		die(mysqli_connect_error());
	};
	mysqli_set_charset($conn, "utf8");

	$result = $conn->query("SELECT store_id, city, route, route_number FROM store ORDER BY city ASC") or die($conn->error());
	$city = array();
	$city = $result->fetch_all(MYSQLI_ASSOC);

	$fp = fopen('../JSON/city_list.json', 'w');
	$rv_from_fwrite = fwrite($fp, json_encode($city));
	if(!$rv_from_fwrite){
		die(mysqli_error());
	}
	fclose($fp);
?>