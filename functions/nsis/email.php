<?php 
session_start();
include '../connection.php';

$action = $_POST['action'];
$userid = $_SESSION['userId'];

$return = new \stdClass();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

if($action == 'user_creation'){
	$email = $_POST['email'];
	$password = '0123';
	mysqli_query($con,"UPDATE user SET password = '$password',lastlogin = '$currenttime' WHERE email = '$email'");
	$msg = '
		You are now registered in Build Config system. Your password as below:<br>
		<b>'.$password.'</b><br>
		Thank you.
	';
	
	$mail->addAddress($email, $email);
	$mail->Subject = "User Registration";
	$mail->Body = $msg;
	
	if($mail->send()){
		echo 1;
	}
}

?>