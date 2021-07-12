<?php 
session_start();
error_reporting(E_ALL);
include '../connection.php';
$return = new \stdClass();

$part = $_POST['part'];

if($part == 'project_creation'){
	$file = $_FILES['file_input'];
	$pqa = $_FILES['pqa_test'];
	$product_name = $_POST['productName'];
	
	$file_type = explode('/',$file['type'])[1];
	$pqa_type = explode('/',$pqa['type'])[1];
	
	if($file_type == 'zip'){
		$file_zip = new ZipArchive;
		$file_open = $file_zip->open($file['tmp_name']);
		if($file_open === TRUE){
			mkdir("../../extracted_file/".$product_name."");
			$file_zip->extractTo('../../extracted_file/'.$product_name.'');
			$file_zip->close();
		} else {
			echo 'File Extraction Failed (Code:'.$file_open.')';
		}
	}
	
	if($file_type == 'tar'){
		$file_tar = new PharData($file['tmp_name']);
		
	}
	

}

?>