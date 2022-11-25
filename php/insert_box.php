<?php
	include('db.php');
	include('func.php');
	include "../QR/phpqrcode/qrlib.php";
	include "algorithm_dijkstra.php";
	error_reporting(0);

	session_start();
	setlocale(LC_TIME, 'el_GR.UTF-8');
	date_default_timezone_set('Europe/Athens');
	mb_internal_encoding("UTF-8");

	$starting_store_id = $_SESSION['storeid'];
	$name_sender = $_POST['name_sender'];
	$name_receiver = $_POST['name_receiver'];
	$route_receiver = $_POST['route_receiver'];
	$final_store_id = $_POST['destination_store'];
	$delivery_type = $_POST['delivery_type'];
	$new_date = date_create();

	$day = date("w");
    $greekDays = array( "Κυριακή", "Δευτέρα", "Τρίτη", "Τετάρτη", "Πέμπτη", "Παρασκευή", "Σάββατο" ); 
	$greekMonths = array('Ιανουαρίου','Φεβρουαρίου','Μαρτίου','Απριλίου','Μαΐου','Ιουνίου','Ιουλίου','Αυγούστου','Σεπτεμβρίου','Οκτωβρίου','Νοεμβρίου','Δεκεμβρίου');
	$date = strftime ("%Y-%m-%d %H:%M:%S");

	function transliterateString($txt){
    $transliterationTable = array(
    	// upper case
    	'Α' => 'A', 'Ά' => 'A', 'Β' => 'V', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Έ' => 'E', 'Ζ' => 'Z', 'Η' => 'I', 'Ή' => 'I', 'Θ' => 'TH', 'Ι' => 'I', 'Ί' => 'I', 'Ϊ' => 'I', 'ΐ' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => 'X', 'Ο' => 'O', 'Ό' => 'O', 'Π' => 'P', 'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Ύ' => 'Y', 'Ϋ' => 'Y', 'ΰ' => 'Y', 'Φ' => 'F', 'Χ' => 'CH', 'Ψ' => 'PS', 'Ω' => 'O', 'Ώ' => 'O',
	    // lower case
	    'α' => 'A', 'ά' => 'A', 'β' => 'V', 'γ' => 'G', 'δ' => 'D', 'ε' => 'E', 'έ' => 'E', 'ζ' => 'Z', 'η' => 'I', 'ή' => 'I', 'θ' => 'TH', 'ι' => 'I', 'ί' => 'I', 'ϊ' => 'I', 'κ' => 'K', 'λ' => 'L', 'μ' => 'M', 'ν' => 'N', 'ξ' => 'X', 'ο' => 'O', 'ό' => 'O', 'π' => 'P', 'ρ' => 'R', 'σ' => 'S', 'ς' => 'S', 'τ' => 'T', 'υ' => 'Y', 'ύ' => 'Y', 'ϋ' => 'Y', 'φ' => 'F', 'χ' => 'CH', 'ψ' => 'PS', 'ω' => 'O', 'ώ' => 'O');
	    return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
	}

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

	if(isset($_POST["operation"]))
	{
		if($_POST["operation"] == "Add")
		{
			$statement = $conn->prepare("
				INSERT INTO box (box_id, tracking_number, name_sender, name_receiver, route_receiver, starting_store_id, final_store_id, delivery_type, cost, delivered, hub_check_1, hub_check_2, hub_check_3, hub_check_4, hub_check_5, hub_check_6, hub_check_7, hub_check_8, hub_check_9) 
				VALUES (DEFAULT,NULL, :name_sender, :name_receiver, :route_receiver, :starting_store_id, :final_store_id, :delivery_type, :cost, 'no', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)
			");
			$result = $statement->execute(
				array(
					':name_sender'			=>	$name_sender,
					':name_receiver'		=>	$name_receiver,
					':route_receiver'		=>	$route_receiver,
					':starting_store_id'	=>	$starting_store_id,
					':final_store_id'		=>	$final_store_id,
					':delivery_type'		=>	$delivery_type,
					':cost'					=>	$cost,
				)
			);
			if(!empty($result)){
				$last_id = $conn->lastInsertId();

				$statement = $conn->prepare("SELECT city FROM store INNER JOIN box ON box.starting_store_id = store.store_id WHERE box.box_id = '$last_id'");
				$statement->execute();
				$row = $statement->fetch();
				$city = transliterateString($row['city']);
				$start_city = mb_substr($city, 0, 2);

				$statement = $conn->prepare("SELECT city FROM store INNER JOIN box ON box.final_store_id = store.store_id WHERE box.box_id = '$last_id'");
				$statement->execute();
				$row = $statement->fetch();
				$city = transliterateString($row['city']);
				$final_city = mb_substr($city, 0, 2);

				$tracking_number = $start_city.date_timestamp_get($new_date).$final_city;
				$statement = $conn->prepare("UPDATE box SET tracking_number = '$tracking_number' WHERE box.box_id = '$last_id'");
				$res = $statement->execute();

				if(!empty($res)){
					echo 'Το δέμα καταχωρήθηκε';
				}
				else{
					echo 'Παρουσιάστηκε κάποιο σφάλμα, προσπάθησε ξανά';
				}

				QRcode::png($tracking_number, '../QR/qr_codes/'.$last_id.'.png', 'L', 4, 2);

				$statement = $conn->prepare("INSERT INTO box_history_transportation (box_id) values ('$last_id')");
				$statement->execute();

				$statement = $conn->prepare("INSERT INTO box_hub_check_transportation (box_id) values ('$last_id')");
				$statement->execute();

			    foreach ($final_path as $key => $value) {
					$x = 'dest_'.($key+1);
					$statement = $conn->prepare("UPDATE box_history_transportation SET $x = '$value' WHERE box_history_transportation.box_id = '$last_id'");
					$statement->execute();
				}
			}
			else
			{
				echo 'Παρουσιάστηκε κάποιο σφάλμα, προσπάθησε ξανά';
			}
		}
	}
?>