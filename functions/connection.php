<?php
$servername = "localhost";
$username = "iprimeuser";
$password = "abntothemoon";
$database = "broadcom"; 
$con = mysqli_connect($servername, $username, $password, $database);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
date_default_timezone_set("Asia/Kuala_Lumpur");
$currenttime = date("Y-m-d H:i:s");
include 'php_function.php';
?> 