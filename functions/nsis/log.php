<?php
session_start();
include '../connection.php';
$return = new \stdClass();
   
if($_POST['type'] == 'in'){
	$email = $_POST['email'];
	$password = md5($_POST['password']);

	$sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
	$query = mysqli_query($con,$sql);

	if(mysqli_num_rows($query)>0){
		$row = mysqli_fetch_array($query);
		mysqli_query($con,"UPDATE user SET lastlogin = '$currenttime' WHERE id = $row[id]");
		$_SESSION['userId'] = $row['id'];
		$return->status = 1;
		$activity = "LOGIN";
		addAuditTrail($row['id'],$activity); 
	}else{
		$return->status = 0;
	}
	echo json_encode($return);
}

if($_POST['type'] == 'out'){
	
	session_unset();
	if(!isset($_SESSION['userId'])){
		$return->status = 1;
	}else{
		$return->status = 0;
	}
	echo json_encode($return); 
}

?>