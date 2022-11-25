<?php
	setlocale(LC_TIME, 'el_GR.UTF-8');
	date_default_timezone_set('Europe/Athens');
	session_start();
	error_reporting(0);

	$scanned_QR = $_COOKIE["myCode"];
	$eid = $_SESSION['empid'];
	$hubid = $_SESSION['hubid'];
	$hub_check_scan = 'hub_check_'.$hubid;
	$correct_hub = 'no';

	$day = date("w");
    $greekDays = array( "Κυριακή", "Δευτέρα", "Τρίτη", "Τετάρτη", "Πέμπτη", "Παρασκευή", "Σάββατο" ); 
	$greekMonths = array('Ιανουαρίου','Φεβρουαρίου','Μαρτίου','Απριλίου','Μαΐου','Ιουνίου','Ιουλίου','Αυγούστου','Σεπτεμβρίου','Οκτωβρίου','Νοεμβρίου','Δεκεμβρίου');
	$date = strftime (" %A - %d %b. %Y --> %H:%M:%S");

	$conn = mysqli_connect("127.0.0.1","root","","our_site_db");
	if(!$conn){
		die(mysqli_connect_error());
	};
	mysqli_set_charset($conn, "utf8");

	$result = $conn->query("UPDATE box SET $hub_check_scan = '$date' WHERE '$scanned_QR' = tracking_number");

	$result = $conn->query("SELECT box_id FROM box WHERE '$scanned_QR' = tracking_number") or die($conn->error());
	$row = $result->fetch_assoc();
	$box_scanned = $row['box_id'];

	$result = $conn->query("SELECT * FROM box_history_transportation WHERE box_id = '$box_scanned'");
	$row = mysqli_fetch_row($result);
	for($i = 1; $i <sizeof($row); $i++){
		if($row[$i] == $hubid){
			$correct_hub = 'yes';
			break;
		}
	}
	
	$result = $conn->query("SELECT hub_id FROM store INNER JOIN box ON store.store_id = box.final_store_id") or die($conn->error());
	$row = $result->fetch_assoc();
    if($hubid == $row['hub_id'])
	$result=$conn->query("UPDATE box SET delivered = 'yes' WHERE '$scanned_QR' = tracking_number");

	$result = $conn->query(" SELECT * FROM box_hub_check_transportation WHERE box_id = '$box_scanned' ") or die($conn->error());
	$row = mysqli_fetch_row($result);
	
	for($i = 1; $i <sizeof($row); $i++){
		if($row[$i] == $hubid){
			//already scaned QR
			break;
		}
		else if($row[$i] == NULL){
			$column = 'cur_check_'.$i;
			$result2 = $conn->query(" UPDATE box_hub_check_transportation SET $column = '$hubid' WHERE box_id = '$box_scanned' ") or die($conn->error());
			break;
		}
	}

	if($correct_hub == "yes"){
		echo "ok";
	}
	else if($correct_hub == "no"){
		echo "mistake";
	}
?>
