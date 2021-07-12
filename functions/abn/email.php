<?php 
session_start();
include '../connection.php';

$action = $_POST['action'];
$userid = $_SESSION['userId'];

$return = new \stdClass();
/*
if($action == 'user_creation'){
	$email = $_POST['email'];
	$password = '0123';
	mysqli_query($con,"UPDATE user SET password = '$password',lastlogin = '$currenttime' WHERE email = '$email'");
	$msg = '
		You are now registered in Build Config system. Your password as below:<br>
		<b>'.$password.'</b><br>
		Thank you.
	';
	if(mail($email,"User Registration",$msg)){
		echo 1;
	}
}
8?
?>