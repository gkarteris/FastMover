<?php
    error_reporting(0);

    function dijkstra_algorithm($starting_node, $final_node, $type_of_shipment){

        $_time_array = array();     //set the time weight array
        $_money_array = array();    //set the money weight array

        $conn = mysqli_connect("127.0.0.1","root","","our_site_db");
        if(!$conn){
            die(mysqli_connect_error());
        };
        mysqli_set_charset($conn, "utf8");

        $result = $conn->query("SELECT * FROM hub_connections") or die($conn->error());
        for($a = 1; $a <= mysqli_num_rows($result); $a++){
            $row=mysqli_fetch_row($result);
            //print_r($row);
            $_time_array[$row[1]][$row[2]] = $row[3];
            $_time_array[$row[2]][$row[1]] = $row[3];
            $_money_array[$row[1]][$row[2]] = $row[4];
            $_money_array[$row[2]][$row[1]] = $row[4];
        }

    //$_time_array[$row[1]][$row[2]] = $row[3];

        $matrix_paths = array();
        $end = 0;
        $j = 0;

        if($starting_node == $final_node) {
            return array(1, 0, 0);
        }
        else if($type_of_shipment == "express") {
            $position_min_money = 0;

            do {
                //initialize the array for storing
                $trace_array = array(); //the nearest path with its parent and weight
                $Q = array();   //the left nodes without the nearest path
                foreach (array_keys($_time_array) as $val) $Q[$val] = 99999;    //kai kala to apeiro
                $Q[$starting_node] = 0;

                //start calculating
                while (!empty($Q)) {
                    $min = array_search(min($Q), $Q);   //position of min inside Q array
                    if ($min == $final_node) break; //an den eimai sto teleutaio node
                    foreach ($_time_array[$min] as $key => $val) {
                        if (!empty($Q[$key]) && $Q[$min] + $val < $Q[$key]) {
                            $Q[$key] = $Q[$min] + $val;
                            $trace_array[$key] = array($min, $Q[$key]);
                        }
                    }
                    unset($Q[$min]);
                }

                //list the path
                $path = array();
                $pos = $final_node;

                //No way found
                if (!array_key_exists($final_node, $trace_array)) {
                    echo "Found no way.";
                    return;
                }

                while ($pos != $starting_node) {
                    $path[] = $pos;
                    $pos = $trace_array[$pos][0];
                }
                $path[] = $starting_node;
                $path = array_reverse($path);

                $i = 0;
                $money_count = 0;
                while ($i < count($path)) {
                    $matrix_paths[$j][] = $path[$i];
                    if ($i + 1 < count($path))
                        $money_count += $_money_array[$path[$i]][$path[$i + 1]];
                    $i++;
                }
                $matrix_paths[$j]['time'] = $trace_array[$final_node][1];
                $matrix_paths[$j]['money'] = $money_count;

                $current_time = $matrix_paths[$j]['time'];
                $current_money = $matrix_paths[$j]['money'];

                if ($j > 0) {
                    if ($current_time > $matrix_paths[0]['time']) { //elegxei an vrikame veltisto xrono
                        $end = 1;
                        unset($matrix_paths[$j]);
                    } else if ($current_time == $matrix_paths[0]['time']) {
                        for ($i = 0; $i < $j; $i++) {
                            if ($current_money > $matrix_paths[$i]['money']) {
                                unset($matrix_paths[$i]);
                            } else if ($current_money < $matrix_paths[$i]['money']) {
                                $position_min_money = $j;
                            }
                        }
                    }
                }

                if (count($path) >= 2) {
                    unset($_time_array[$path[0]][$path[1]]);
                    unset($_time_array[$path[1]][$path[0]]);
                    unset($_money_array[$path[0]][$path[1]]);
                    unset($_money_array[$path[1]][$path[0]]);
                }

                $j++;
                print_r($trace_array);
            } while ($end != 1 && !empty($_time_array[$starting_node]) && !empty($_time_array[$final_node])); //tha ginei 1 otan ikanopoiithoun oles oi sunthikes elegxou

            // echo 'Delivery Type: '.$type_of_shipment;
            for($b = 0; $b <= count($matrix_paths[$position_min_money]) - 3; $b++){
                $final_path[0][$b] = $matrix_paths[$position_min_money][$b];
            }
            // echo '<br />Path is: '.implode('->', $final_path[0]);

            return array($matrix_paths[$position_min_money]['time'], $matrix_paths[$position_min_money]['money'], $final_path[0]);
        }
        else if($type_of_shipment = "regular"){
            $position_min_time = 0;

            do {
                //initialize the array for storing
                $trace_array = array(); //the nearest path with its parent and weight
                $Q = array();   //the left nodes without the nearest path
                foreach (array_keys($_money_array) as $val) $Q[$val] = 99999;   //kai kala to apeiro
                $Q[$starting_node] = 0;

                //start calculating
                while (!empty($Q)) {
                    $min = array_search(min($Q), $Q);   //position of min inside Q array
                    if ($min == $final_node) break; //an den eimai sto teleutaio node
                    foreach ($_money_array[$min] as $key => $val) {
                        if (!empty($Q[$key]) && $Q[$min] + $val < $Q[$key]) {
                            $Q[$key] = $Q[$min] + $val;
                            $trace_array[$key] = array($min, $Q[$key]);
                        }
                    }
                    unset($Q[$min]);
                }

                //list the path
                $path = array();
                $pos = $final_node;

                //No way found
                if (!array_key_exists($final_node, $trace_array)) {
                    echo "Found no way.";
                    return;
                }

                while ($pos != $starting_node) {
                    $path[] = $pos;
                    $pos = $trace_array[$pos][0];
                }
                $path[] = $starting_node;
                $path = array_reverse($path);

                $i = 0;
                $time_count = 0;
                while ($i < count($path)) {
                    $matrix_paths[$j][] = $path[$i];
                    if ($i + 1 < count($path))
                        $time_count += $_time_array[$path[$i]][$path[$i + 1]];
                    $i++;
                }
                $matrix_paths[$j]['time'] = $time_count;
                $matrix_paths[$j]['money'] = $trace_array[$final_node][1];

                $current_time = $matrix_paths[$j]['time'];
                $current_money = $matrix_paths[$j]['money'];

                if ($j > 0) {
                    if ($current_money > $matrix_paths[0]['money']) { //elegxei an vrikame veltisto xrono
                        $end = 1;
                        unset($matrix_paths[$j]);
                    }
                    else if ($current_money == $matrix_paths[0]['money']) {
                        for ($i = 0; $i < $j; $i++) {
                            if ($current_time > $matrix_paths[$i]['time']) {
                                unset($matrix_paths[$i]);
                            } else if ($current_time < $matrix_paths[$i]['time']) {
                                $position_min_time = $j;
                            }
                        }
                    }
                }

                if (count($path) >= 2) {
                    unset($_time_array[$path[0]][$path[1]]);
                    unset($_time_array[$path[1]][$path[0]]);
                    unset($_money_array[$path[0]][$path[1]]);
                    unset($_money_array[$path[1]][$path[0]]);
                }

                $j++;
            } while ($end != 1 && !empty($_money_array[$starting_node]) && !empty($_money_array[$final_node])); //tha ginei 1 otan ikanopoiithoun oles oi sunthikes elegxou

            // echo 'Delivery Type: '.$type_of_shipment;
            for($b = 0; $b <= count($matrix_paths[$position_min_time]) - 3; $b++){
                $final_path[0][$b] = $matrix_paths[$position_min_time][$b];
            }
            // echo '<br />Path is: '.implode('->', $final_path[0]);

            return array($matrix_paths[$position_min_time]['time'], $matrix_paths[$position_min_time]['money'], $final_path[0]);
        }
    }
?>