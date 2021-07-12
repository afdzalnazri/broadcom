<?php
include '../connection.php';
$project = $_GET["project"];
$family = $_GET["family"];
$bc = $_GET["bc"];
$sql1 = "SELECT * FROM buildConfig WHERE buildConfigName = '$bc'";
	$query = mysqli_query($con,$sql1);
	$row = mysqli_fetch_array($query);
	//echo $sql;
	$buildConfigName = $row['buildConfigName'];
	$projectName = $row['projectName'];

	
	if($projectName!='')
	{
		$sql2 = "SELECT * FROM project WHERE productName = '$projectName'";
	$query = mysqli_query($con,$sql2);
	$row = mysqli_fetch_array($query);
	//echo $sql;
	$familyDB = $row['family'];

	
	}
	
	///make the checking here
	
	if($familyDB!='')
	{
		$sql3 = "SELECT * FROM masterFamily WHERE id = '$familyDB'";
	$query = mysqli_query($con,$sql3);
	$row = mysqli_fetch_array($query);
	//echo $sql;
	$familyNameDB = $row['familyName'];
	
	}
	
	if($familyNameDB == $family)
	{
	echo "DUPLICATE FOUND";	
	}else
	{
		echo $projectName;;
	}
	exit();
?>