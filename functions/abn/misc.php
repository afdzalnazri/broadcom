<?php 
session_start();
include '../connection.php';

$action = $_POST['action'];
$userid = $_SESSION['userId'];

$return = new \stdClass();

if($action == 'display_master_file'){
	$id = $_POST['scriptname'];
	
	$project = "SELECT * FROM masterVersionFileList WHERE id = '$id'";
	$crcNumber = mysqli_query($con,$project);
	$rowCRC = mysqli_fetch_array($crcNumber);

	$fileDirectoryName = $rowCRC['fileDirectoryName'];
	$crc = $rowCRC['crc'];
	$revision = $rowCRC['versionNumber'];
	$createdTime = $rowCRC['createdTime'];
	$modifiedDate = $rowCRC['updateTime'];
	
	
	if($createdTime!=""){
	$createdTime = date("d-M-Y h:i:s", strtotime($createdTime));  
    }else
	{
		$createdTime = "";
	}
	
	if($modifiedDate!="" ){
	$modifiedDate = date("d-M-Y h:i:s", strtotime($modifiedDate));  
    }else
	{
		$modifiedDate = "---";
	}
	
	if($rowCRC['updateTime']=="0000-00-00 00:00:00"){$modifiedDate = "NEVER UPDATE";}
	
	$data = file_get_contents($fileDirectoryName);
	$return->data = $data;
	$return->createdDate = $createdTime;
	$return->modifiedDate = $modifiedDate;
	$return->revision = $revision;
	echo json_encode($return);
}

?>