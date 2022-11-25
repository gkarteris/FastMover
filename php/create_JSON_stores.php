<?php
	error_reporting(0);

	$conn = mysqli_connect("127.0.0.1","root","","our_site_db");
	if(!$conn){
		die(mysqli_connect_error());
	};
	mysqli_set_charset($conn, "utf8");

	$result = $conn->query("SELECT * FROM store");
	$cities = array();
	$cities = $result->fetch_all(MYSQLI_ASSOC);

	$fp = fopen('../JSON/stores_records.json', 'w');
	$rv_from_fwrite = fwrite($fp, json_encode($cities));
	if(!$rv_from_fwrite){
		die(mysqli_error());
	}
	fclose($fp);
?>