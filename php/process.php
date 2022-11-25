<?php
	error_reporting(0);
	session_start();
	$username = $_POST['user'];
	$password = $_POST['pass'];

	$conn = mysqli_connect("127.0.0.1","root","","our_site_db");
	if(!$conn){
		die(mysqli_connect_error());
	};
	mysqli_set_charset($conn, "utf8");

	$result = $conn->query("SELECT * FROM employee WHERE username = '$username' AND password = '$password'") or die($conn->error());
	$row = $result->fetch_assoc();
	$_SESSION['uname'] = $row['username'];
	$_SESSION['empid'] = $row['emp_id'];
	$_SESSION['storeid'] = $row['working_store'];
	$_SESSION['hubid'] = $row['working_hub'];

	if($row['username'] == $username && $row['password'] == $password){
		if($row['work_type'] == "admin")
			echo "admin";
		else if($row['work_type'] == "cashier")
			echo "cashier";
		else if($row['work_type'] == "hub")
			echo "hubber";
	}
	else{
		echo "failed";
	}
?> 