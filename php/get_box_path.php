<?php
	error_reporting(0);
	session_start();

	$tracking_number = $_POST['tracking_number'];

	$conn = mysqli_connect("127.0.0.1","root","","our_site_db");
	if(!$conn){
		die(mysqli_connect_error());
	};
	mysqli_set_charset($conn, "utf8");

	$result = $conn->query("SELECT * FROM box WHERE tracking_number = '$tracking_number'") or die($conn->error());
	$row = $result->fetch_assoc();
	$box_id = $row['box_id'];
	$_SESSION['boxid'] = $box_id;

    if(mysqli_num_rows($result) > 0){
		echo "valid_tracking_number";
	}
	else{
		unset($_SESSION['boxid']);
		echo "not_a_box";
	}

	$result = $conn->query("SELECT * FROM box_history_transportation WHERE box_id = '$box_id'") or die($conn->error());
	$row = mysqli_fetch_row($result);
	$final_path = array();
	for($i = 1; $i <sizeof($row); $i++){
		if($row[$i] != NULL){
			$final_path[] = $row[$i];
		}
		else{
			break;
		}
	}

	$fp = fopen('../JSON/final_box_path.json', 'w');
    fwrite($fp, json_encode($final_path));
    fclose($fp);
    include 'convert_to_long_lat.php';	//enimeronei to json me tis pliris plirofories tou kathe hub id pou exei mesa to json

    $result = $conn->query(" SELECT * FROM box_hub_check_transportation WHERE box_id = '$box_id'") or die($conn->error());
	$row = mysqli_fetch_row($result);
	$current_path = array();
	for($i = 1; $i <sizeof($row); $i++){
		if($row[$i] != NULL){
			$current_path[] = $row[$i];
		}
		else{
			break;
		}
	}

	$fp = fopen('../JSON/completed_box_path.json', 'w');
    fwrite($fp, json_encode($current_path));
    fclose($fp);
    include 'convert_to_long_lat_2.php';	//enimeronei to json me tis pliris plirofories tou kathe hub id pou exei mesa to json
?>