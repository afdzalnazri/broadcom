<?php 
session_start();
include '../connection.php';

$action = $_POST['action'];
$table = $_POST['table'];
$userid = $_SESSION['userId'];
$id = $_POST['id_value'];
$return = new \stdClass();


?>