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


/*Build Config Configuration*/
if($action == 'build_config_creation'){
	




$ids = rand(10000000,99999999);


///to check duplication 

$project = mysqli_query($con,"SELECT * FROM buildConfig WHERE buildConfigName = '$_POST[buildConfigName]' AND projectId = '$_POST[projectId]'");
$rowproject = mysqli_fetch_array($project);
$buildConfigNameDB = $rowproject['buildConfigName'];
$projectIdDB = $rowproject['projectId'];
/*
if($buildConfigNameDB!=""){
	//exit this BC creation 
	
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="red"><i class="fa fa-times-circle"></i></font><br><br>
								<p><b>aaa Build Config Name</b></p> 
								</center>
							</div>
						</div>'; 
	$return->status_data = 0;
	
	echo json_encode($return);
	exit();
}
*/

//end check duplication


$project = mysqli_query($con,"SELECT productName FROM project WHERE id = '$_POST[projectId]'");
$rowproject = mysqli_fetch_array($project);
$product_name = $rowproject['productName'];





$table = 'buildConfig';  
$col = mysqli_query($con,"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'");
while($rowcol = mysqli_fetch_array($col)){
	$data = $_POST[$rowcol['COLUMN_NAME']];
	if(isset($data)){
		$data_column[] = $rowcol['COLUMN_NAME'];
		$data_value[] = '"'.$data.'"';
	}
}


$reference_file = $_FILES['referenceFile'];
$product_file = $_FILES['productFile'];
$referencefile_type = explode('/',$referencefile['type'])[1];
$productfile_type = explode('/',$productfile['type'])[1];

$bcparamid = $_POST['configParamId'];
$newbcparamid = $_POST['newConfigEntry'];
$newbcparamval = $_POST['newConfigEntryVal'];
$buildConfigName = $_POST['buildConfigName'];

$isEditBC = $_POST['isEditBC'];
$idBC = $_POST['idBC'];




/////to handle MLF file////
if($_FILES['mlfFile']!='')
{
	//make the extraction
	$folder_path_mlf = "../../modules/input/files_build_config/mlf_".$ids;
	mkdir($folder_path_mlf);
	$mlf_file = $_FILES['mlfFile'];
	
	$target_mlf_file = $folder_path_mlf . '/' .basename($mlf_file["name"]);
	move_uploaded_file($mlf_file["tmp_name"], $target_mlf_file);
	if(extractZipFile($target_mlf_file, "../../project_build/".$product_name."/".$buildConfigName.""))
	{
		unlink("unzip.txt");
		file_put_contents("unzip.txt", "../../project_build".$product_name."/".$buildConfigName."", FILE_APPEND);
	}
	
	
	  
	$return->status_data = 1;
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
								<p><b>Successfully update MLF File</b></p>
								</center>
							</div>
						</div>';
						
						echo json_encode($return);
						
						exit();
	
}

///////////////////////


	//This to delete duplication in the database//
	$projectSql = mysqli_query($con,"SELECT buildConfigName FROM buildConfig WHERE buildConfigName = '$_POST[buildConfigName]'");
$rowprojectSql = mysqli_fetch_array($projectSql);
$buildConfigNameDB = $rowprojectSql['buildConfigName'];

if($buildConfigNameDB!=""){
	//delete here
	$query = mysqli_query($con,"DELETE FROM buildConfig where buildConfigName = '$buildConfigNameDB'");
}
/////end delete duplication in DB///


foreach($bcparamid as $index => $param_id){
	if($param_id != ''){
		$arr_param[$param_id] = $_POST['configParamValue'.$param_id];
	}
}

foreach($newbcparamid as $index => $new_param_id){
	if($new_param_id != ''){
		$ids = rand(10000000,99999999);
		$sql_newdata = "INSERT INTO masterConfigParam(ids,configName) VALUES ('$ids','$new_param_id')";
		$query_newdata = mysqli_query($con,$sql_newdata);
		$sql_select_newdata = "SELECT * FROM masterConfigParam WHERE ids = $ids";
		$query_select_newdata = mysqli_query($con,$sql_select_newdata);
		$rownewdata = mysqli_fetch_array($query_select_newdata);
		$arr_param[$rownewdata['id']] = $newbcparamval[$index];
	}
}


$folder_path_reference = "../../modules/input/files_build_config/reference_".$ids;
$folder_path_products = "../../modules/input/files_build_config/products_".$ids;

$data_column[] = 'ids';
$data_value[] = $ids;
$data_column[] = 'userId'; 
$data_value[] = $_SESSION['userId'];
$data_column[] = 'projectName';
$data_value[] = "'".$product_name."'";
$data_column[] = 'referenceFolder';
$data_value[] = "'reference_".$ids."'";
$data_column[] = 'productFolder';
$data_value[] = "'products_".$ids."'";

$str_column = implode(',',$data_column);
$str_value = implode(',',$data_value);

$query = mysqli_query($con,"INSERT INTO buildConfig($str_column) VALUES ($str_value)");

if($isEditBC=="true"){


	$query = mysqli_query($con,"DELETE FROM buildConfig where id = '$idBC'");	
	addAuditTrail($userid,"UPDATE Build Config : ".$product_name);   
	file_put_contents("insert.txt", "DELETE FROM buildConfig where id = '$idBC'", FILE_APPEND);



}else
{
	$activity = 'CREATE BUILD CONFIG - '.$buildConfigName;
	addAuditTrail($userid,$activity);
}

$select = mysqli_query($con,"SELECT * FROM buildConfig WHERE ids = $ids");
$row = mysqli_fetch_array($select);

foreach($arr_param as $param_id => $param_value){
	$insert_param = "INSERT INTO buildConfigParam(bcId,paramId,value) VALUES ('$row[id]','$param_id','$param_value')";
	mysqli_query($con,$insert_param);
}

mkdir($folder_path_reference);
mkdir($folder_path_products);


if($referencefile_type == 'zip'){

	$zip = new ZipArchive;
	$file_open = $zip->open($referencefile['tmp_name']);

	//$zip->extractTo($folder_path);
	//$zip->close();
}else if($referencefile_type == 'tar'){

}else{
	$target_reference_file = $folder_path_reference . '/' .basename($reference_file["name"]);
	move_uploaded_file($reference_file["tmp_name"], $target_reference_file);
	extractZipFile($target_reference_file, $folder_path_reference . '/');
}


if($productfile_type == 'zip'){

	$zip = new ZipArchive;
	$file_open = $zip->open($productfile['tmp_name']);

	//$zip->extractTo($folder_path);
	//$zip->close();
}else if($productfile_type == 'tar'){

}else{
	$target_product_file = $folder_path_products . '/' . basename($product_file["name"]);
	move_uploaded_file($product_file["tmp_name"], $target_product_file);
	extractZipFile($target_product_file, $folder_path_products . '/');
}


if($query){
	$return->status_data = 1;
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
								<p><b>Successful Build Config Creation</b></p>
								</center>
							</div>
						</div>';
	//$return->status_document = '';
	
}else{
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="red"><i class="fa fa-times-circle"></i></font><br><br>
								<p><b>Unsuccessful Build Config Creation</b></p>
								</center>
							</div>
						</div>';
	$return->status_data = 0;
}


//make file extraction here COmment by Afdzal 
	unlink("unzip.txt");
	
	if(extractZipFile($target_reference_file, $folder_path_reference."/")){
		
	file_put_contents("unzip.txt", "UNZIP FILE REFERENCE OK - \r\n".$target_reference_file, FILE_APPEND);
	}else {
	file_put_contents("unzip.txt", "UNZIP FILE REFERENCE NOT OK - \r\n".$target_reference_file, FILE_APPEND);	
	}
	if(extractZipFile($target_product_file, $folder_path_products."/"))
	{
	file_put_contents("unzip.txt", "UNZIP FILE PRODUCT OK - \r\n\r\n".$target_product_file, FILE_APPEND);
	}else{
	file_put_contents("unzip.txt", "UNZIP FILE PRODUCT NOT OK - \r\n\r\n".$target_product_file, FILE_APPEND);	
	}
	 
	
	//the file coppying here
	//make directory under project_build
	mkdir("../../project_build/".$product_name);	
	mkdir("../../project_build/".$product_name."/".$buildConfigName);
	mkdir("../../project_build/".$product_name."/".$buildConfigName."/ANDY");
	mkdir("../../project_build/".$product_name."/".$buildConfigName."/ALBERT");
	mkdir("../../project_build/".$product_name."/".$buildConfigName."/bc");	
	mkdir("../../project_build/".$product_name."/".$buildConfigName."/Working Folder");
	mkdir("../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support");
	
	
	
	
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/CFGCHK.TXT.IN","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/CFGCHK.TXT.IN");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/FCTPRG.sh","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/FCTPRG.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/FCTTEST.sh","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/FCTTEST.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/GET_CRID.TCL","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/GET_CRID.TCL");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/LOG.sh","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/LOG.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/NVMFILL.sh","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/NVMFILL.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/NVMFILL.TCL","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/NVMFILL.TCL");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/NVRAM.TCL","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/NVRAM.TCL");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/NVRAMCFG.TCL","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/NVRAMCFG.TCL");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/NVRAMLOG.TCL","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/NVRAMLOG.TCL");;
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/ProjectCode_MMDDYY.upd","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/ProjectCode_MMDDYY.upd");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/QA.sh","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/QA.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/READMAC.sh","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/READMAC.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/READMAC.TCL","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/READMAC.TCL");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/Setup.sh","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/Setup.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/STRESPRG.sh","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/STRESPRG.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/STRESTST.sh","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/STRESTST.sh");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/TaskState_xxx.ini","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/TaskState_xxx.ini");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/TaskState_xxx.ini","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/TaskState_xxx.ini");
	copy("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/LOG.sh","../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/LOG.sh");
	
	extractZipFile($folder_path_reference."/Reference Files/andy.zip", "../../project_build/".$product_name."/".$buildConfigName."/ANDY/");
	
	extractZipFile($folder_path_reference."/Reference Files/albert.zip", "../../project_build/".$product_name."/".$buildConfigName."/ALBERT/");
	
	if(extractZipFile($target_product_file, "../../project_build/".$product_name."/".$buildConfigName."/bc/"))
	{
		file_put_contents("unzip_bc.txt", "EXTRACTED", FILE_APPEND);
		
		  if(mkdir("../../project_build/".$product_name."/".$buildConfigName."/bc/".$buildConfigName."/bnxtmt/")){
		  file_put_contents("createfolder.txt", "../../project_build/".$product_name."/".$buildConfigName."/bc/".$buildConfigName."/bnxtmt/", FILE_APPEND);
		  }
	}else
	{
		file_put_contents("unzip_bc.txt", "NO EXTRACTED", FILE_APPEND);
	}
	
$path = "../../project_build/".$product_name."/".$buildConfigName."/ALBERT/";
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
	
	//mkdir("../../project_build/".$product_name."/".$buildConfigName);
	
	$folder_path_reference = "../../modules/input/files_build_config/reference_".$ids;
    $folder_path_products = "../../modules/input/files_build_config/products_".$ids;

	$folderScanned = scandir("../../project_build/".$product_name."/".$buildConfigName."/bc/", 1);
	
	


		$files = scandir($folder_path_products);
		
		foreach($files as $file) 
		{ 
		//echo $file."< br>";
		$files_1 = scandir($folder_path_products."/".$file);		
		 
		
		 
	
	
		if (strpos($file, 'BCM') !== false) { 
   	//mkdir("../../project_build".$product_name."/".$buildConfigName."/Working Folder/bc/".$file);
		  mkdir("../../project_build/".$product_name."/".$buildConfigName."/bc/".$buildConfigName);
		  mkdir("../../project_build/".$product_name."/".$buildConfigName."/bc/".$file."/bnxtmt/");
		  
		  $gZIPFolder = "../../project_build/".$product_name."/".$buildConfigName."/bc/".$file."";
		  $gZIPDest = "../../project_build/".$product_name."/".$buildConfigName."/bc/".$file."/bnxtmt/";
		 
	custom_copy($folder_path_products."/".$file, "../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/"); 
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
	
	$files = scandir("../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/");
		 
		foreach($files as $file) 
		{ 
		if (strpos($file, 'zip') !== false) { 
			
			if(extractZipFile("../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/".$file, "../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/")){
				
				//make copy 
				$filename = str_replace(".zip","",$file);
				
				custom_copy($folder_path_products."/".$filename, "../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/"); 
				unlink("GZIP.txt");
				file_put_contents("GZIP.txt",$folder_path_products."/".$filename, FILE_APPEND);	
				
				
				}
			}
			
			}
		
		
	//////////////
	
	$sqlParam = mysqli_query($con,"SELECT * FROM buildConfigParam where paramId = '8' ORDER BY paramId ASC LIMIT 1");
	$rowParam = mysqli_fetch_array($sqlParam);
	$REV = $rowParam['value'];
	
	
     if(mkdir("../../project_build/".$product_name."/".$buildConfigName."/".$product_name."-M0_".$REV))
	 {			unlink("GZIP.txt"); 
				file_put_contents("GZIP.txt","CREATED - "."../../project_build/".$product_name."/".$buildConfigName."/".$buildConfigName."-M0-006", FILE_APPEND);	
				mkdir("../../project_build/".$product_name."/".$buildConfigName."/".$product_name."-M0_".$REV." Test Logs");
				mkdir("../../project_build/".$product_name."/".$buildConfigName."/".$product_name."-M0_".$REV." Test Logs/FCT");
				mkdir("../../project_build/".$product_name."/".$buildConfigName."/".$product_name."-M0_".$REV." Test Logs/FCT/OBA"); 
				}
				
		 

		
//for andy folder
custom_copy($folder_path_products."/".$file, "../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/"); 

	//mkdir("../../project_build/".$product_name);	
	//mkdir("../../project_build/".$product_name."/".$buildConfigName);
	//mkdir("../../project_build/".$product_name."/".$buildConfigName."/ANDY");
	
	//mkdir("../../project_build/".$product_name."/".$buildConfigName."/bc"); 
	//mkdir("../../project_build/".$product_name."/".$buildConfigName."/ALBERT");  
	//mkdir("../../project_build/".$product_name."/".$buildConfigName."/Working Folder");	
	//mkdir("../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support");
	
	/*
	$files = scandir($folder_path_products);
		
		foreach($files as $file) 
		{ 
		
			if (strpos($file, 'img') !== false) { 
			
			copy($folder_path_products."/".$file, "../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/".$file);
			
			}
		}
	*/
	
	
$path = "../../project_build/".$product_name."/".$buildConfigName."/Working Folder/support/";

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
	
	
echo json_encode($return);


/*$referencefile = $_FILES['referenceFile'];
$productfile = $_FILES['productFile'];

$referencefile_type = explode('/',$referencefile['type'])[1];
$productfile_type = explode('/',$productfile['type'])[1];

$referencefilename = $referencefile['name'];
$productfilename = $productfile['name'];

$col = mysqli_query($con,"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'");
while($rowcol = mysqli_fetch_array($col)){
	$columns[] = $rowcol['COLUMN_NAME'];
	$colname = $rowcol['COLUMN_NAME'];
	if(isset($_POST[$colname]) && $_POST[$colname] != ''){
		$data[$colname] = $_POST[$rowcol['COLUMN_NAME']]; 
	}
}

$arr_column[] = 'ids';
$arr_values[] = $ids;

// Project //
$project = mysqli_query($con,"SELECT * FROM project WHERE id = $_POST[projectId]");
$rowproject = mysqli_fetch_array($project);

$arr_column[] = 'projectName';
$arr_values[] = '"'.$rowproject['productName'].'"';


$product_name = $rowproject['productName'];

//--------------------------------- FILE ----------------------------------//


//Reference File
if($referencefile_type == 'zip'){

	$zip = new ZipArchive;
	$file_open = $zip->open($referencefile['tmp_name']);
	$folder_name = $product_name;
	$folder_path = "../../modules/input/files_build_config/reference/".$folder_name;

	//mkdir($folder_path);
	//$zip->extractTo($folder_path);
	//$zip->close();
}else if($referencefile_type == 'tar'){

}else{
	$target_reference_dir = "../../modules/input/files_build_config/reference/";
	$target_reference_file = $target_reference_dir . basename($referencefilename);
	move_uploaded_file($referencefile["tmp_name"], $target_reference_file);
	$arr_column[] = 'referenceFile';
	$arr_values[] = '"'.$referencefilename.'"';
}

//Product File*
if($productfile_type == 'zip'){

	$zip = new ZipArchive;
	$file_open = $zip->open($productfile['tmp_name']);
	$folder_name = $product_name;
	$folder_path = "../../modules/input/files_build_config/product/".$folder_name;

	//mkdir($folder_path);
	//$zip->extractTo($folder_path);
	//$zip->close();
}else if($productfile_type == 'tar'){

}else{
	$target_product_dir = "../../modules/input/files_build_config/product/";
	$target_product_file = $target_product_dir . basename($productfilename);
	move_uploaded_file($productfile["tmp_name"], $target_product_file);
	$arr_column[] = 'productFile';
	$arr_values[] = '"'.$productfilename.'"';
}

//-----------------------------------------------------------------------------------------//
foreach($data as $column => $value){
	$arr_column[] = $column;
	$arr_values[] = "'".$value."'";
}

$columns = implode(',',$arr_column);
$values = implode(',',$arr_values);

$query = "INSERT INTO $table($columns) VALUES ($values)";
$sql = mysqli_query($con,$query);

$inserted = mysqli_query($con,"SELECT * FROM $table WHERE ids = $ids");
$rowins = mysqli_fetch_array($inserted);

$activity = 'CREATE BUILD CONFIG - '.$rowins['buildConfigName'];
if($query){
	$return->status_data = 1;
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
								<p><b>Successful Build Config Creation</b></p>
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
								<p><b>Unsuccessful Build Config Creation</b></p>
								</center>
							</div>
						</div>';
	$return->status_data = 0;
}

echo json_encode($return);*/
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

?>