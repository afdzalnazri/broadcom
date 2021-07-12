<?php
session_start();
include '../connection.php';
$return = new \stdClass();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
	$email = $_POST['email'];
	
	$sql = "SELECT * FROM user WHERE email = '$email'";
	$query = mysqli_query($con,$sql);

	if(mysqli_num_rows($query)>0){
		$row = mysqli_fetch_array($query);
		$password = rand(111111,999999);
		$passwordMd5 = md5($password);
		mysqli_query($con,"UPDATE user SET password = '$passwordMd5' WHERE email = '$email'");
		//$_SESSION['userId'] = $row['id'];
		$return->status = 1;
		$activity = "CHANGE PASSWORD";
		addAuditTrail($row['id'],$activity); 
		
		

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

$mail = new PHPMailer(true);
$mail->SMTPDebug = 0;                 //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'broadcombuild@gmail.com';                     //SMTP username
$mail->Password   = 'uruonicpnuompybp';                          //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
$mail->Port       = 587;
$mail->setFrom('broadcombuild@gmail.com', 'Broadcom Build');
$mail->isHTML(true);  


	$email = $_POST['email'];
		$msg = '
		This is your new password: <br><br>
		<b>'.$password.'</b><br>
		Thank you.
	';
	
	$mail->addAddress($email, $email);
	$mail->Subject = "Password Reset";
	$mail->Body = $msg;
	
	if($mail->send()){
		//echo 1;
	}



	}else{
		$return->status = 0;
	}
	echo json_encode($return);


/*
if($_POST['type'] == 'out'){
	
	session_unset();
	if(!isset($_SESSION['userId'])){
		$return->status = 1;
	}else{
		$return->status = 0;
	}
	echo json_encode($return); 
}*/

?>