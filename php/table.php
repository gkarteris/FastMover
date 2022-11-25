<?php
    error_reporting(0);
    session_start();
    $conn = mysqli_connect("127.0.0.1","root","","our_site_db");
    if(!$conn){
        die(mysqli_connect_error());
    };
    mysqli_set_charset($conn, "utf8");
    $output = '';

    $starting_store_id = $_SESSION['st_store'];
    $final_store_id = $_SESSION['fn_store'];
    $cost = $_SESSION['cost'];
    $time = $_SESSION['time'];
    $delivery_type = $_SESSION['del_type'];


    $result = $conn->query("SELECT city, route, route_number FROM store WHERE store_id = '$starting_store_id' ") or die($conn->error());
    $starting_store_row = $result->fetch_assoc();

    $result = $conn->query("SELECT city, route, route_number FROM store WHERE store_id = '$final_store_id' ") or die($conn->error());
    $final_store_row = $result->fetch_assoc();

    if($starting_store_row['city'] == '' || $final_store_row['city'] == '' || $cost == '' || $time == '' || $delivery_type == ''){
        $output .= '
        <div class="table-responsive">
        <table id="cost" class="table table-striped table-bordered table-hover" cellspacing="0"">
        <tr>
            <th width="5%" style="text-align:center">Αφετηρία</th>
            <td width="5%" style="text-align:center">Δεν είναι διαθέσιμο</td>
        </tr>
        <tr>
            <th width="5%" style="text-align:center">Προορισμός</th>
            <td width="5%" style="text-align:center">Δεν είναι διαθέσιμο</td>
        </tr>
        <tr>
            <th width="5%" style="text-align:center">Τύπος Αποστολής</th>
            <td width="5%" style="text-align:center">Δεν είναι διαθέσιμο</td>
        </tr>
        <tr>
            <th width="5%" style="text-align:center"΄>Κόστος (€)</th>
            <td width="5%" style="text-align:center">Δεν είναι διαθέσιμο</td>
        </tr>
        <tr>
            <th width="5%" style="text-align:center"΄>Χρόνος (μέρες)</th>
            <td width="5%" style="text-align:center">Δεν είναι διαθέσιμο</td>
        </tr>';
    }
    else{
        $output .= '
        <div class="table-responsive">
        <table id="cost" class="table table-striped table-bordered table-hover" cellspacing="0"">
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
            if($delivery_type == "regular"){
                $output .= '<td width="5%" style="text-align:center">κανονική</td>';
            }
            else if($delivery_type == "express"){
                $output .= '<td width="5%" style="text-align:center">γρήγορη</td>';
            }
            $output .= '
        </tr>
        <tr>
            <th width="5%" style="text-align:center"΄>Κόστος (€)</th>
            <td width="5%" style="text-align:center">'.$cost.'</td>
        </tr>
        <tr>
            <th width="5%" style="text-align:center"΄>Χρόνος (μέρες)</th>
            <td width="5%" style="text-align:center">'.$time.'</td>
        </tr>';
    }

    echo $output;
?>