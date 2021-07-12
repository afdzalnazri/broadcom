<?php 
session_start();
include '../connection.php';

$action = $_POST['action'];
$table = $_POST['table'];
$userid = $_SESSION['userId'];

$return = new \stdClass();

if($action == 'project_creation'){
	
	//check the $_POST['newProductNumber'] - shoul dbe no duplication
	
$productName = $_POST['productName'];

$sqlSearch = mysqli_query($con,"SELECT * FROM project WHERE productName = '$productName'");
$rowSearch = mysqli_fetch_array($sqlSearch);

$productNameDB = $rowSearch['productName'];

if($productNameDB!="")
{
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="red"><i class="fa fa-times-circle"></i></font><br><br>
								<p><b>Duplicated product name</b></p>
								</center>
							</div>
						</div>';
	$return->status = 'duplicate_prod';

	echo json_encode($return);
	exit(); 
}	



	
	
	
	
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
if($_POST['new_brcmMinIsoFw'] != ''){$new_data['masterIsoFw_isoFwVer_brcmMinIsoFw_id'] = $_POST['new_brcmMinIsoFw'];}
if($_POST['new_brcmMinDstVer'] != ''){$new_data['masterDstVer_dstVer_brcmMinDstVer_id'] = $_POST['new_brcmMinDstVer'];}
if($_POST['new_brcmDstWinCtrl'] != ''){$new_data['masterDstWinCtrl_dstWinCtrl_brcmDstWinCtrl_id'] = $_POST['new_brcmDstWinCtrl'];}

$project_data = addReturn($data,$new_data);

$arr_column[] = 'ids';
$arr_values[] = $ids;

$arr_column[] = 'userId';
$arr_values[] = $userid;



$product_number = $_POST['productNumber'];


//--------------------------------- FILE ----------------------------------//

/*Files Input*/
if($fileinput_type == 'zip'){

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
}

//-----------------------------------------------------------------------------------------//
foreach($project_data as $column => $value){
	$arr_column[] = $column;
	$arr_values[] = "'".$value."'";
	//*SELECT*//
	$arr_select[] = $column ."='".$value."'";
}


$str_check = implode(' AND ',$arr_select);
$columns = implode(',',$arr_column);
$values = implode(',',$arr_values);

$query_check = "SELECT * FROM $table WHERE $str_check";
$sql_check = mysqli_query($con,$query_check);
if(mysqli_num_rows($sql_check)>0){
	$return->status = 'duplicate';
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="yellow"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></font><br><br>
								<p><b>Duplicate project information</b></p>
								</center>
							</div>
						</div>';
	echo json_encode($return);
	exit();
}

$query = "INSERT INTO $table($columns) VALUES ($values)";
$sql = mysqli_query($con,$query);

$inserted = mysqli_query($con,"SELECT * FROM $table WHERE ids = $ids");
$rowins = mysqli_fetch_array($inserted);

$activity = 'CREATE PROJECT - '.$rowins['productName'];

if($query){
	$return->status = 1;
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
								<p><b>Successful Project Creation</b></p>
								</center>
							</div>
						</div>';
	//$return->status_document = '';
	addAuditTrail($userid,$activity);
}else{
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="red"><i class="fa fa-times-circle"></i></font><br><br>
								<p><b>Unsuccessful Project Creation</b></p>
								</center>
							</div>
						</div>';
	$return->status = 0;
}

echo json_encode($return);
}

//--CREATE Build Config
if($action == 'build_config_creation'){
$ids = rand(10000000,99999999);
$table = $_POST['table'];

// Information for table 'buildConfig'
$buildConfigName = mysqli_real_escape_string($con,$_POST['buildConfigName']);
$familyId = $_POST['familyId'];
$projectId = $_POST['projectId'];


// Check if buildConfigName already exists
$sql_check_bc = mysqli_query($con,"SELECT * FROM buildConfig WHERE buildConfigName = '$buildConfigName'");
if(mysqli_num_rows($sql_check_bc) > 0){
	$return->status = 'duplicate';
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></font><br><br>
								<p><b>Duplicated Build Config Name</b></p>
								</center>
							</div>
						</div>';
	echo json_encode($return);
	exit();
}

// Folders for Reference File & Product File
$productFile = $_FILES['productFile'];
$referenceFile = $_FILES['referenceFile'];

$productFileName = $productFile['name'];
$referenceFileName = $referenceFile['name'];

$referenceFileType = explode('/',$referenceFile['type'])[1];
$productFileType = explode('/',$productFile['type'])[1];

$referenceFolder = "";
$productFolder = "";
$folder_path_reference = "";
$folder_path_products = "";

// Product File
if(sizeof($productFile)>0){
	$productFolder = "products_".$ids;
	$folder_path_products = "../../modules/input/files_build_config/".$productFolder;
	mkdir($folder_path_products);
	if($productFileType == "zip"){
		$zip = new ZipArchive;
		$file_open = $zip->open($productFile['tmp_name']);
	}else if($productFileType == "tar"){
	
	}else{
		$target_product_file = $folder_path_products . '/' . basename($productFileName);
		move_uploaded_file($productFile["tmp_name"], $target_product_file);
		extractZipFile($target_product_file, $folder_path_products . '/');
	}
}

// Reference File
if(sizeof($referenceFile)>0){
	$referenceFolder = "reference_".$ids;
	$folder_path_reference = "../../modules/input/files_build_config/".$referenceFolder;
	mkdir($folder_path_reference);
	if($referenceFileType == "zip"){
		$zip = new ZipArchive;
		$file_open = $zip->open($referenceFile['tmp_name']);	
	}else if($referenceFileType == "tar"){}
	else{
		$target_reference_file = $folder_path_reference . '/' .basename($referenceFileName);
		move_uploaded_file($referenceFile["tmp_name"], $target_reference_file);
		extractZipFile($target_reference_file, $folder_path_reference . '/');
	}
}


//--------------------------------------------- AFDZAL -----------------------------------------------------------//

$sqlFamily = mysqli_query($con,"SELECT * FROM masterfamily WHERE id = '$familyId'");
$rowFamily = mysqli_fetch_array($sqlFamily);

$familyName = $rowFamily['familyName'];


$sqlProject = mysqli_query($con,"SELECT * FROM project WHERE id = '$projectId'");
$rowProject = mysqli_fetch_array($sqlProject);

$product_name = $rowProject['productName'];



mkdir("../../project_build/".$familyName."/".$product_name);	
	mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName);
	mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/ANDY");
	mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/ALBERT");
	mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/bc");	
	mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder");
	mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support");
	
copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/CFGCHK.TXT.IN","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/CFGCHK.TXT.IN");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/FCTPRG.sh","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/FCTPRG.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/FCTTEST.sh","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/FCTTEST.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/GET_CRID.TCL","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/GET_CRID.TCL");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/LOG.sh","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/LOG.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/NVMFILL.sh","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/NVMFILL.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/NVMFILL.TCL","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/NVMFILL.TCL");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/NVRAM.TCL","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/NVRAM.TCL");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/NVRAMCFG.TCL","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/NVRAMCFG.TCL");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/NVRAMLOG.TCL","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/NVRAMLOG.TCL");;
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/ProjectCode_MMDDYY.upd","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/ProjectCode_MMDDYY.upd");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/QA.sh","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/QA.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/READMAC.sh","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/READMAC.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/READMAC.TCL","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/READMAC.TCL");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/Setup.sh","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/Setup.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/STRESPRG.sh","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/STRESPRG.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/STRESTST.sh","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/STRESTST.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/TaskState_xxx.ini","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/TaskState_xxx.ini");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/TaskState_xxx.ini","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/TaskState_xxx.ini");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/LOG.sh","../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/LOG.sh");
	
	extractZipFile($folder_path_reference."/Reference Files/andy.zip", "../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/ANDY/");
	
	extractZipFile($folder_path_reference."/Reference Files/albert.zip", "../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/ALBERT/");
	
	if(extractZipFile($target_product_file, "../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/bc/"))
	{
		file_put_contents("unzip_bc.txt", "EXTRACTED", FILE_APPEND);
		
		  if(mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/bc/".$buildConfigName."/bnxtmt/")){
		  file_put_contents("createfolder.txt", "../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/bc/".$buildConfigName."/bnxtmt/", FILE_APPEND);
		  }
	}else
	{
		file_put_contents("unzip_bc.txt", "NO EXTRACTED", FILE_APPEND);
	}
	
$path = "../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/ALBERT/";
unlink("albert.txt");
//file_put_contents("albert.txt", $path, FILE_APPEND);
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
$files = array(); 
foreach ($rii as $file) {
    if ($file->isDir()){ 
        continue;
    }
    $files[] = $file->getPathname(); 
}
//print("<pre>".print_r($files,true)."</pre>");
//echo "<br><br><br>";
foreach($files as $file) {   
   if (strpos($file, 'bc.sh') !== false) {copy($file, $path."bc.sh");}
   if (strpos($file, 'cfg') !== false) {
	   $myFile = pathinfo($file); 
	   copy($file, $path."".$myFile['basename']);
   }
   if (strpos($file, 'vpd.log') !== false) {
	   $myFile = pathinfo($file); 
	   copy($file, $path."".$myFile['basename']);} 
}
	
	//mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName);
	
	$folder_path_reference = "../../modules/input/files_build_config/reference_".$ids;
    $folder_path_products = "../../modules/input/files_build_config/products_".$ids;

	$folderScanned = scandir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/bc/", 1);
	
	


		$files = scandir($folder_path_products);
		
		foreach($files as $file) 
		{ 
		//echo $file."< br>";
		$files_1 = scandir($folder_path_products."/".$file);		
		 
		
		 
	
	
		if (strpos($file, 'BCM') !== false) { 
   	//mkdir("../../project_build".$product_name."/".$buildConfigName."/Working Folder/bc/".$file);
		  mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/bc/".$buildConfigName);
		  mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/bc/".$file."/bnxtmt/");
		  
		  $gZIPFolder = "../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/bc/".$file."";
		  $gZIPDest = "../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/bc/".$file."/bnxtmt/";
		 
	custom_copy($folder_path_products."/".$file, "../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/"); 
}
		}
		unlink("GZIP.txt");
		//../../project_build/ABN-001/q1/bc/BCM_14856_102620200836
		file_put_contents("GZIP.txt", "gZIPFolder ".$gZIPFolder."\r\n\r\n", FILE_APPEND);
		$filesGZip = scandir($gZIPFolder);
		
		foreach($filesGZip as $Gzfile) 
		{ 
		
			if (strpos($Gzfile, 'gz') !== false) { 
			
			
			if(extractGzipFile($gZIPFolder."/".$Gzfile, $gZIPDest."/a.tar.gzip")){
			
			
		$out_file_name = str_replace('.gz', '.tar.gz', $Gzfile);
		if(copy($gZIPFolder."/".$out_file_name, $gZIPFolder."/bnxtmt/".$out_file_name))
		{
			file_put_contents("GZIP.txt", "COPIED\r\n\r\n", FILE_APPEND);
			unlink($gZIPFolder."/".$out_file_name);
			
		}else
		{
			file_put_contents("GZIP.txt", "NOT COPIED".$out_file_name."\r\n\r\n", FILE_APPEND);
		}
		
		copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/Setup.sh",$gZIPFolder."/bnxtmt/Setup.sh");
		
			}else{
		file_put_contents("GZIP.txt",$Gzfile, FILE_APPEND);			
			}
			}
		}
		
		
		
		$filesZip = scandir($gZIPFolder);
		 
		foreach($filesZip as $fileZip) 
		{ 
		if (strpos($fileZip, 'zip') !== false) { 
			unlink("GZIP.txt");
			if(extractZipFile($gZIPFolder."/".$fileZip, $gZIPFolder)){
				file_put_contents("GZIP.txt",$Gzfile, FILE_APPEND);	
			}

		}
		}
		
	//////////////
	
	$files = scandir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/");
		 
		foreach($files as $file) 
		{ 
		if (strpos($file, 'zip') !== false) { 
			
			if(extractZipFile("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/".$file, "../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/")){
				
				//make copy 
				$filename = str_replace(".zip","",$file);
				
				custom_copy($folder_path_products."/".$filename, "../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/"); 
				unlink("GZIP.txt");
				file_put_contents("GZIP.txt",$folder_path_products."/".$filename, FILE_APPEND);	
				
				
				}
			}
			
			}
		
		
	//////////////
	
	//echo "SELECT * FROM buildConfigParam where bcId = '$ids' ORDER BY paramId ASC LIMIT 1";
	//exit();

	$sqlParam = mysqli_query($con,"SELECT * FROM buildConfigParam where bcId = '$ids' ORDER BY paramId ASC LIMIT 1");
	$rowParam = mysqli_fetch_array($sqlParam);
	$REV = $rowParam['value'];
	
	if($REV=="") {$REV="001A";}  
	
     if(mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/".$product_name."-M0_".$REV))
	 {			unlink("GZIP.txt"); 
				file_put_contents("GZIP.txt","CREATED - "."../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/".$buildConfigName."-M0-006", FILE_APPEND);	
				mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/".$product_name."-M0_".$REV." Test Logs");
				mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/".$product_name."-M0_".$REV." Test Logs/FCT");
				mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/".$product_name."-M0_".$REV." Test Logs/OBA"); 
				}
				
		 

		
//for andy folder
custom_copy($folder_path_products."/".$file, "../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/"); 

	//mkdir("../../project_build/".$product_name);	
	//mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName);
	//mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/ANDY");
	
	//mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/bc"); 
	//mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/ALBERT");  
	//mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder");	
	//mkdir("../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support");
	
	/*
	$files = scandir($folder_path_products);
		
		foreach($files as $file) 
		{ 
		
			if (strpos($file, 'img') !== false) { 
			
			copy($folder_path_products."/".$file, "../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/".$file);
			
			}
		}
	*/
	
	
$path = "../../project_build/".$familyName."/".$product_name."/".$buildConfigName."/Working Folder/support/";

//file_put_contents("albert.txt", $path, FILE_APPEND);
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
$files = array(); 
foreach ($rii as $file) {
    if ($file->isDir()){ 
        continue;
    }
    $files[] = $file->getPathname(); 
}
//print("<pre>".print_r($files,true)."</pre>");
//echo "<br><br><br>";
foreach($files as $file) {   
   
   if (strpos($file, '.bin') !== false) {
	   $myFile = pathinfo($file); 
	   copy($file, $path."".$myFile['basename']);
   }
   if (strpos($file, '.txt') !== false) {
	   $myFile = pathinfo($file); 
	   copy($file, $path."".$myFile['basename']);} 
}
	


//----------------------------------------------------------------------------------------------------------------//

// Add data to table 'buildConfig'
$query_add_buildConfig = "INSERT INTO buildConfig(ids,userId,familyId,projectId,buildConfigName,referenceFolder,productFolder,productFile,referenceFile) VALUES ('$ids','$userid','$familyId','$projectId','$buildConfigName','$referenceFolder','$productFolder','$productFileName','$referenceFileName')";
$sql_add_buidConfig = mysqli_query($con,$query_add_buildConfig);

if($sql_add_buidConfig){

// Information for new Build Config Params
$newbcParams = $_POST['newConfigEntry'];
if(sizeof($newbcParams)>0){
	foreach($newbcParams as $key => $newbcParam){
		if($newbcParam != ""){
		$idsBcParam = rand(10000000,99999999);
		$newbcParamValue = mysqli_real_escape_string($con,$_POST['newConfigEntryVal'][$key]);
		//-- Add to masterConfigParam
		$add_masterConfigParam = mysqli_query($con,"INSERT INTO masterConfigParam(ids,configName) VALUES ('$idsBcParam','$newbcParam')");
		//-- Add to buildConfigParam
		$add_buildConfigParam = mysqli_query($con,"INSERT INTO buildConfigParam(bcId,paramId,value) VALUES ('$ids','$idsBcParam','$newbcParamValue')");
		}
	}
}
	
// Information for table 'buildConfigParam'
$bcParams = $_POST['configParamId'];
if(sizeof($bcParams)>0){
foreach($bcParams as $key => $bcParam){
	if($bcParam != ""){
		$bcParamValue = $_POST['configParamValue'.$bcParam];
		$sql_bcParam = mysqli_query($con,"INSERT INTO buildConfigParam(bcId,paramId,value) VALUES ('$ids','$bcParam','$bcParamValue')");
	}
}
}

$return->status = 1;
$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
								<p><b>Successful Build Config Creation</b></p>
								</center>
							</div>
						</div>';
						
			addAuditTrail($userid,"Create Build ".$buildConfigName);			
	
}else{
	$return->status = 0;
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="red"><i class="fa fa-times-circle"></i></font><br><br>
								<p><b>Unsuccessful Build Config Creation</b></p>
								</center>
							</div>
						</div>';
}


echo json_encode($return);
}

//-- UPDATE Build Config
if($action == 'build_config_update'){
/*Update BC
1. Update Build Config Name, Family ID, Project ID
2. Build Config Param:
	a. Remove all existing BC Parameters
	b. Add new (using creation function)
	c. Add new extracted files to folder
*/

$id = $_POST['id'];
$table = $_POST['table'];

$bc = mysqli_query($con,"SELECT * FROM buildConfig WHERE id = '$id'");
$row = mysqli_fetch_array($bc);
$ids = $row['ids'];

// Information for table 'buildConfig'
$buildConfigName = mysqli_real_escape_string($con,$_POST['buildConfigName']);
$familyId = $_POST['familyId'];
$projectId = $_POST['projectId'];

// Check if buildConfigName already exists
$sql_check_bc = mysqli_query($con,"SELECT * FROM buildConfig WHERE buildConfigName = '$buildConfigName' AND id != '$id'");
if(mysqli_num_rows($sql_check_bc) > 0){
	$return->status = 'duplicate';
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="yellow"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></font><br><br>
								<p><b>Duplicated Build Config Name</b></p>
								</center>
							</div>
						</div>';
	echo json_encode($return);
	exit();
}

// Folders for Reference File & Product File
$productFile = $_FILES['productFile'];
$referenceFile = $_FILES['referenceFile'];

$productFileName = $productFile['name'];
$referenceFileName = $referenceFile['name'];

$referenceFileType = explode('/',$referenceFile['type'])[1];
$productFileType = explode('/',$productFile['type'])[1];

$productFolder = "products_".$ids;
$referenceFolder = "reference_".$ids;

$folder_path_products = "../../modules/input/files_build_config/".$productFolder;
$folder_path_reference = "../../modules/input/files_build_config/".$referenceFolder;

// Product File
if(sizeof($productFile)>0){
	if($productFileType == "zip"){
		$zip = new ZipArchive;
		$file_open = $zip->open($productFile['tmp_name']);
	}else if($productFileType == "tar"){
	
	}else{
		$target_product_file = $folder_path_products . '/' . basename($productFileName);
		move_uploaded_file($productFile["tmp_name"], $target_product_file);
		extractZipFile($target_product_file, $folder_path_products . '/');
	}
}

// Reference File
if(sizeof($referenceFile)>0){
	if($referenceFileType == "zip"){
		$zip = new ZipArchive;
		$file_open = $zip->open($referenceFile['tmp_name']);	
	}else if($referenceFileType == "tar"){}
	else{
		$target_reference_file = $folder_path_reference . '/' .basename($referenceFileName);
		move_uploaded_file($referenceFile["tmp_name"], $target_reference_file);
		extractZipFile($target_reference_file, $folder_path_reference . '/');
	}
}


//--------------------------------------------- AFDZAL -----------------------------------------------------------//





//----------------------------------------------------------------------------------------------------------------//

$sql_update_bc = "UPDATE buildConfig SET buildConfigName = '$buildConfigName',familyId = '$familyId', projectId = '$projectId' WHERE id = '$id'";
$update_bc = mysqli_query($con,$sql_update_bc);

if($update_bc){
// Delete Build Config Param
$delete_bcParam = mysqli_query($con,"DELETE FROM buildConfigParam WHERE bcId = '$ids'");
// Information for new Build Config Params
$newbcParams = $_POST['newConfigEntry'];
if(sizeof($newbcParams)>0){
	foreach($newbcParams as $key => $newbcParam){
		if($newbcParam != ""){
		$idsBcParam = rand(10000000,99999999);
		$newbcParamValue = mysqli_real_escape_string($con,$_POST['newConfigEntryVal'][$key]);
		//-- Add to masterConfigParam
		$add_masterConfigParam = mysqli_query($con,"INSERT INTO masterConfigParam(ids,configName) VALUES ('$idsBcParam','$newbcParam')");
		//-- Add to buildConfigParam
		$add_buildConfigParam = mysqli_query($con,"INSERT INTO buildConfigParam(bcId,paramId,value) VALUES ('$ids','$idsBcParam','$newbcParamValue')");
		}
	}
}
	
// Information for table 'buildConfigParam'
$bcParams = $_POST['configParamId'];
if(sizeof($bcParams)>0){
foreach($bcParams as $key => $bcParam){
	if($bcParam != ""){
		$bcParamValue = $_POST['configParamValue'.$bcParam];
		$sql_bcParam = mysqli_query($con,"INSERT INTO buildConfigParam(bcId,paramId,value) VALUES ('$ids','$bcParam','$bcParamValue')");
	}
}
}

	$return->status = 1;
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
								<p><b>Successful Build Config Update</b></p>
								</center>
							</div>
						</div>';
						addAuditTrail($userid,"Update Build ".$buildConfigName);
	
}else{

	$return->status = 0;
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="red"><i class="fa fa-times-circle"></i></font><br><br>
								<p><b>Unsuccessful Build Config Update</b></p>
								</center>
							</div>
						</div>';
}

echo json_encode($return);

}

/* Master File Versioning */
if($action == 'master_file_versioning'){
$ids = rand(10000000,99999999); 
$scriptfile = $_FILES['scriptFileName'];
$scriptfile_type = explode('/',$scriptfile['type'])[1];
$scriptfile_name = $scriptfile["name"];

$col = mysqli_query($con,"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'");
while($rowcol = mysqli_fetch_array($col)){
	$columns[] = $rowcol['COLUMN_NAME'];
	$colname = $rowcol['COLUMN_NAME'];

	if(isset($_POST[$colname]) && $_POST[$colname] != ''){
		$data[$colname] = $_POST[$rowcol['COLUMN_NAME']]; 
	}
}

foreach($data as $column => $value){
	$arr_column[] = $column;
	$arr_values[] = "'".$value."'";
}

$arr_column[] = 'ids';
$arr_values[] = $ids;	

$project = "SELECT * FROM buildConfig INNER JOIN project ON buildConfig.projectId = project.id WHERE buildConfig.id = $_POST[bcId]";
$sql_project = mysqli_query($con,$project);
$rowproject = mysqli_fetch_array($sql_project);

$projectid = $rowproject['projectId'];
$projectname = $rowproject['projectName'];

if($projectid != ''){
$arr_column[] = 'projectId';
$arr_values[] = '"'.$projectid.'"';

$arr_column[] = 'projectName';
$arr_values[] = '"'.$projectname.'"';
}


$arr_column[] = 'uploadTime';
$arr_values[] = '"'.$currenttime.'"';

//--------------------------------- FILE ----------------------------------//

/*Script File*/
if($scriptfile_type == 'zip'){

	$zip = new ZipArchive;
	$file_open = $zip->open($scriptfile['tmp_name']);
	$folder_name = $projectname;
	$folder_path = "../../modules/input/files_build_config/reference/".$folder_name;

	//mkdir($folder_path);
	//$zip->extractTo($folder_path);
	//$zip->close();
}else if($scriptfile_type == 'tar'){

}else{
	$target_dir = "../../modules/input/files_master_file_versioning/";
	$target_file = $target_dir . basename($scriptfile_name);
	move_uploaded_file($scriptfile["tmp_name"], $target_file);
	$arr_column[] = 'scriptFileName';
	$arr_values[] = '"'.$scriptfile_name.'"';
}


$columns = implode(',',$arr_column);
$values = implode(',',$arr_values);

$query = "INSERT INTO $table($columns) VALUES ($values)";
$sql = mysqli_query($con,$query);

$inserted = mysqli_query($con,"SELECT * FROM $table WHERE ids = $ids");
$rowins = mysqli_fetch_array($inserted);

$activity = 'CREATE MASTER FILE VERSIONING - '.$projectname;

if($query){
	$return->status_data = 1;
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
								<p><b>Successful Upload File</b></p>
								</center>
							</div>
						</div>';
	//$return->status_document = '';
	addAuditTrail($userid,$activity);
}else{
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="red"><i class="fa fa-times-circle"></i></font><br><br>
								<p><b>Unsuccessful File Upload</b></p>
								</center>
							</div>
						</div>';
	$return->status_data = 0;
}

echo json_encode($return);
	
}

if($action == 'edit_bc_file'){
	$scriptname = $_POST['scriptname'];
	$scripttext = $_POST['scripttext'];
	$bcid = $_POST['bcid'];
	
	$sql = "SELECT * FROM buildConfig WHERE id = $bcid";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query);
	$record = mysqli_num_rows($query);
	
	//$newfile = $record.'_'.$scriptname;
	$newfile = $scriptname; 
	$newfilepath = '../../modules/input/files_build_config/'.$newfile;
	
	$activity = 'BC SCRIPT EDITING - '.$row['buildConfigName'];
	
	if(file_put_contents($newfilepath,$scripttext)){
		mysqli_query($con,"UPDATE buildConfig SET productFile = '$newfile' WHERE id = $bcid");
		$return->status = 1;
		$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
								<p><b>File saved</b></p>
								</center>
							</div>
						</div>';
		//$return->status_document = '';
		addAuditTrail($userid,$activity); 
	}else{
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="red"><i class="fa fa-times-circle"></i></font><br><br>
								<p><b>Unsuccessful BC Script Editing</b></p>
								</center>
							</div>
						</div>';
	$return->status = 0;
	}
	
	
	//make file extraction here COmment by Afdzal 
	
	
	echo json_encode($return);
	
}

if($action == 'build_config_last_value'){
	$value = $_POST['cb_value'];
	$last_val = "";
	
	$last_value = mysqli_query($con,"SELECT * FROM buildConfigParam WHERE paramId = '$value' ORDER BY created DESC LIMIT 1");
	if(mysqli_num_rows($last_value)>0){
		$rowlastvalue = mysqli_fetch_array($last_value);
		$last_val = $rowlastvalue['value'];
	}
	
	$return->value = $last_val;
	echo json_encode($return);
}

?>