<?php
	error_reporting(0);

    $conn = mysqli_connect("127.0.0.1","root","","our_site_db");
    if(!$conn){
        die(mysqli_connect_error());
    };
    mysqli_set_charset($conn, "utf8");


   if(isset($_POST['latitude']) && isset($_POST['longitude'])) {
   		$timi_x = $_POST['latitude'];
		$timi_y = $_POST['longitude'];

        $result = $conn->query("SELECT * FROM store") or die($conn->error());
        $stores = array();
        $stores = $result->fetch_all(MYSQLI_ASSOC);

        // parakatw kanw euclidean distance gia na vrw tin pio kodini
        // apostasi metaksu twn stores

        $euclidean_dist = 1000;
        $min = $euclidean_dist;
        $pos_min = -1;

        foreach ($stores as $key => $value){
            $euclidean_dist = pow(pow($stores[$key]['geo_x'] - $timi_x,2) + pow($stores[$key]['geo_y'] - $timi_y,2),0.5);
            if($euclidean_dist < $min ){
                $min = $euclidean_dist;
                $pos_min = $key;
            }
        }
   }

   $output = array();
   $output['store_id'] = $stores[$pos_min]['store_id'];
   $output['city'] = $stores[$pos_min]['city'];
   $output['route'] = $stores[$pos_min]['route'];
   $output['route_number'] = $stores[$pos_min]['route_number'];

	$fp = fopen('../JSON/filter_zip_code.json', 'w');
	$rv_from_fwrite = fwrite($fp, json_encode($output));
	if(!$rv_from_fwrite){
		die(mysqli_error());
	}
	fclose($fp);
?>