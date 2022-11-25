<?php
    error_reporting(0);
    session_start();

    $conn = mysqli_connect("127.0.0.1","root","","our_site_db");
    if(!$conn){
        die(mysqli_connect_error());
    };
    mysqli_set_charset($conn, "utf8");
    $output = '';
    $box_id = $_SESSION['boxid'];

    $result = $conn->query("SELECT * FROM box WHERE box_id = '$box_id'") or die($conn->error());
    $row = $result->fetch_assoc();

    $result = $conn->query("SELECT city, route, route_number FROM store WHERE store_id = '".$row['starting_store_id']."' ") or die($conn->error());
    $starting_store_row = $result->fetch_assoc();

    $result = $conn->query("SELECT city, route, route_number FROM store WHERE store_id = '".$row['final_store_id']."' ") or die($conn->error());
    $final_store_row = $result->fetch_assoc();

    if(mysqli_num_rows($result) > 0)
    {
    	$output .= '
        <div class="table-responsive">
        <table id="hub_list" class="table table-striped table-bordered table-hover" cellspacing="0"">
        <tr>
        <th width="5%" style="text-align:center">Tracking Number</th>
        <td width="5%" style="text-align:center">'.$row['tracking_number'].'</td>
        </tr>
        <tr>
        <th width="5%" style="text-align:center">Όνομα Αποστολέα</th>
        <td width="5%" style="text-align:center">'.$row['name_sender'].'</td>
        </tr>
        <tr>
        <th width="5%" style="text-align:center">Όνομα Παραλήπτη</th>
        <td width="5%" style="text-align:center">'.$row['name_receiver'].'</td>
        </tr>
        <tr>
        <th width="5%" style="text-align:center">Διεύθυνση Παραλήπτη</th>
        <td width="5%" style="text-align:center">'.$row['route_receiver'].'</td>
        </tr>
        <tr>
        <th width="5%" style="text-align:center">Αφετηρία</th>
        <td width="5%" style="text-align:center">'.$starting_store_row['city'].' ('.$starting_store_row['route'].' '.$starting_store_row['route_number'].')</td>
        </tr>
        <tr>
        <th width="5%" style="text-align:center">Προορισμός</th>
        <td width="5%" style="text-align:center">'.$final_store_row['city'].' ('.$final_store_row['route'].' '.$final_store_row['route_number'].')</td>
        </tr>
        <tr>
        <th width="5%" style="text-align:center">Τύπος Αποστολής</th>
        ';
        if($row['delivery_type'] == "regular"){
            $output .= '<td width="5%" style="text-align:center">κανονική</td>';
        }
        else if($row['delivery_type'] == "express"){
            $output .= '<td width="5%" style="text-align:center">γρήγορη</td>';
        }
        $output .= '
        </tr>
        <tr>
        <th width="5%" style="text-align:center"΄>Κόστος (€)</th>
        <td width="5%" style="text-align:center">'.$row['cost'].'</td>
        </tr>
        <tr>
        <th width="5%" style="text-align:center">Κατάσταση</th>
        ';
        if($row['delivered'] == "yes"){
            $output .= '<td width="5%" style="text-align:center">παραδόθηκε</td>';
        }
        else if($row['delivered'] == "no"){
            $output .= '<td width="5%" style="text-align:center">δεν παραδόθηκε</td>';
        }
   
        echo $output;
    }
    else
    {
        echo "fail";
    }
    unset($_SESSION['boxid']);
?>