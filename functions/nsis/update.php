<?php 
session_start();
include '../connection.php';

$action = $_POST['action'];
$table = $_POST['table'];
$userid = $_SESSION['userId'];
$id = $_POST['id_value'];
$return = new \stdClass();

if($action == 'project_update'){
$ids = rand(10000000,99999999);


$fileinput = $_FILES['fileName'];
$pqa = $_FILES['pqaTestLogFile'];

$fileinput_type = explode('/',$fileinput['type'])[1];
$pqa_type = explode('/',$pqa['type'])[1];

$pqafilename = $pqa['name'];
$fileinputname = $fileinput['name'];
	
$col = mysqli_query($con,"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'");
while($rowcol = mysqli_fetch_array($col)){
	$columns[] = $rowcol['COLUMN_NAME'];
	$colname = $rowcol['COLUMN_NAME'];
	if(isset($_POST[$colname]) && $_POST[$colname] != ''){
		$data[$colname] = $_POST[$rowcol['COLUMN_NAME']]; 
	}
}

//$new_data['<master table>_<master column to insert>_<column name in original table>_<column to be returned>']
if($_POST['newFamily'] != ''){$new_data['masterFamily_familyName_family_id'] = $_POST['newFamily'];}
if($_POST['newProductNumber'] != ''){$new_data['masterProduct_productNumber_productNumber_id'] = $_POST['newProductNumber'];}
if($_POST['newCustomer'] != ''){$new_data['masterCustomer_customerName_customer_id'] = $_POST['newCustomer'];}
if($_POST['newFormFactor'] != ''){$new_data['masterFormFactor_formFactorName_formFactor_id'] = $_POST['newFormFactor'];}
if($_POST['new_brcmMinIsoFw'] != ''){$new_data['masterIsoFw_isoFwVer_brcmMinIsoFw_isoFwVer'] = $_POST['new_brcmMinIsoFw'];}
if($_POST['new_brcmMinDstVer'] != ''){$new_data['masterDstVer_dstVer_brcmMinDstVer_dstVer'] = $_POST['new_brcmMinDstVer'];}
if($_POST['new_brcmDstWinCtrl'] != ''){$new_data['masterDstWinCtrl_dstWinCtrl_brcmDstWinCtrl_dstWinCtrl'] = $_POST['new_brcmDstWinCtrl'];}

$project_data = addReturn($data,$new_data);

$product_number = $_POST['productNumber'];


//--------------------------------- FILE ----------------------------------//

//Files Input//
/*if($fileinput_type == 'zip'){

	$zip = new ZipArchive;
	$file_open = $zip->open($fileinput['tmp_name']);
	$folder_name = $product_number;
	$folder_path = "../../modules/input/files_project/fileinput/".$folder_name;

	//mkdir($folder_path);
	//$zip->extractTo($folder_path);
	//$zip->close();
}else if($fileinput_type == 'tar'){

}else{
	$target_file_dir = "../../modules/input/files_project/fileinput/";
	$target_file_file = $target_file_dir . basename($fileinputname);
	move_uploaded_file($fileinput["tmp_name"], $target_file_file);
	$arr_column[] = 'fileName';
	$arr_values[] = '"'.$fileinputname.'"';
}

//PQA Input//
if($pqa_type == 'zip'){

	$zip = new ZipArchive;
	$file_open = $zip->open($pqa['tmp_name']);
	$folder_name = $product_number;
	$folder_path = "../../modules/input/files_project/pqa/".$folder_name;

	//mkdir($folder_path);
	//$zip->extractTo($folder_path);
	//$zip->close();
}else if($pqa_type == 'tar'){

}else{
	$target_pqa_dir = "../../modules/input/files_project/pqa/";
	$target_pqa_file = $target_pqa_dir . basename($pqafilename);
	move_uploaded_file($pqa["tmp_name"], $target_pqa_file);
	$arr_column[] = 'pqaTestLogFile';
	$arr_values[] = '"'.$pqafilename.'"';	
}*/

//-----------------------------------------------------------------------------------------//
foreach($project_data as $column => $value){
	$arr_update[] = ''.$column.' = "'.$value.'"';
}

$update = implode(',',$arr_update);

$query = "UPDATE $table SET $update WHERE id = $id";
$sql = mysqli_query($con,$query);

$inserted = mysqli_query($con,"SELECT * FROM $table WHERE id = $id");
$rowins = mysqli_fetch_array($inserted);

$activity = 'UPDATE PROJECT - '.$rowins['productName'];

if($query){
	$return->status_data = 1;
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
								<p><b>Successful Project Update</b></p>
								</center>
							</div>
						</div>';
	$return->status_document = '';
	addAuditTrail($userid,$activity);
}else{
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="red"><i class="fa fa-times-circle"></i></font><br><br>
								<p><b>Unsuccessful Project Update</b></p>
								</center>
							</div>
						</div>';
	$return->status_data = 0;
}

echo json_encode($return);
}

?>