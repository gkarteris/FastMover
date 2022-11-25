<?php
    error_reporting(0);

    $conn = mysqli_connect("127.0.0.1","root","","our_site_db");
    if(!$conn){
        die(mysqli_connect_error());
    };
    mysqli_set_charset($conn, "utf8");
    $output = '';
    $box_id = $_POST['box_id'];

    $result = $conn->query("SELECT * FROM box_history_transportation WHERE box_id = '$box_id'") or die($conn->error());
    $row = mysqli_fetch_row($result);
    if(mysqli_num_rows($result) > 0)
    {
        $output .= '
        <div class="table-responsive">
        <table id="hub_list" class="table table-striped table-bordered table-hover" cellspacing="0"">
        <tr>
        <th width="5%" style="text-align:center">Κέντρο Διανομής</th>
        <th width="5%" style="text-align:center">Ημερομηνία Άφιξης</th>
        </tr>
        ';
        for($i = 1; $i <sizeof($row); $i++){
            if($row[$i] != NULL){
                $result = $conn->query("SELECT transit_city FROM transit_hub WHERE transit_id = '$row[$i]'") or die($conn->error());
                $hub_city_row = $result->fetch_assoc();

                $hub_check = 'hub_check_'.$row[$i];
                $result = $conn->query("SELECT $hub_check FROM box WHERE box_id = '$box_id'") or die($conn->error());
                $hub_check_row = $result->fetch_assoc();
                if($hub_check_row[$hub_check] == NULL){
                	$output .= '
	                <tr>
	                <td width="5%" style="text-align:center">'.$hub_city_row['transit_city'].'</td>
	                <td width="5%" style="text-align:center">Αναμονή...</td>
	                </tr>
	                ';
                }
                else{
                	$output .= '
	                <tr>
	                <td width="5%" style="text-align:center">'.$hub_city_row['transit_city'].'</td>
	                <td width="5%" style="text-align:center">'.$hub_check_row[$hub_check].'</td>
	                </tr>
	                ';
                }    
            }
            else{
                break;
            }
        }
        echo $output;
    }
?>