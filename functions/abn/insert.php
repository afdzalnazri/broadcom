<?php 
session_start();
include '../connection.php';

$action = $_POST['action'];
$table = $_POST['table'];
$userid = $_SESSION['userId'];


$return = new \stdClass();


/* Master File Versioning EDIT */

if($action == 'editmasterFile'){

	//write into folder - rewrite the file 
	$scriptname = $_POST['scriptname'];
	$scripttext = $_POST['scripttext'];
	$fileID = $_POST['fileID']; 
	
	
$sql = "SELECT * FROM masterVersionFileList WHERE id = '$_POST[fileID]'";
$sql_query = mysqli_query($con,$sql);
$rowMasterFile = mysqli_fetch_array($sql_query);

unlink("filelist.txt");
file_put_contents("filelist.txt", "$sql \n", FILE_APPEND);
  
$fileDirectoryName = $rowMasterFile['fileDirectoryName'];
$versionNumber = $rowMasterFile['versionNumber'];
	
	if(file_put_contents($fileDirectoryName,$scripttext)){
			$versionNumber++;
			
			$crc = crc32($fileDirectoryName);
			
		mysqli_query($con,"UPDATE masterVersionFileList SET versionNumber = '$versionNumber', crc='$crc', updateTime = NOW() WHERE id = $fileID");
		$return->status = 1;
		$return->message = '<div class="row">
							<div class="col-md-12"> 
								<center>
								<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
								<p><b>Master File saved</b></p>
								</center>
							</div>
						</div>';
		//$return->status_document = '';
		addAuditTrail($userid,"Change Master File - File name : Up rev to : $versionNumber"); 
	}else{
	$return->message = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="red"><i class="fa fa-times-circle"></i></font><br><br>
								<p><b>Unsuccessful Editing</b></p>
								</center>
							</div>
						</div>';
	$return->status = 0;
	}
	echo json_encode($return);
	
	//uprev the database 
	
}

/* Master File Versioning */
if($action == 'master_file_versioning'){
$ids = rand(10000000,99999999); 
$scriptfile = $_FILES['scriptFileName'];
$scriptfile_type = explode('/',$scriptfile['type'])[1];
$scriptfile_name = $scriptfile["name"];
unlink("fileversion1.txt");
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
	
	// 1) extract the file here
	
	//$target_file
	extractZipFile($target_file, "../../modules/input/files_master_file_versioning/extracted/");
	$i=0;
	foreach(glob("../../modules/input/files_master_file_versioning/extracted/Master File Versioning".'/*.*') as $file) {
    $i++;
	$versionNumber="";
	$crc = crc32(file_get_contents($file));
	 
	//check in the db, if has the same CRC by select from the database where CRC == $crc
	
	$project = "SELECT * FROM masterVersionFileList WHERE fileDirectoryName = '$file'";
	$crcNumber = mysqli_query($con,$project);
	$rowCRC = mysqli_fetch_array($crcNumber);

	$crcDB = $rowCRC['crc'];
	file_put_contents("fileversion1.txt", "FILE CRC ".$crc."\r\nDB CRC ".$crcDB."\r\n ".$file."\r\n\r\n\r\n", FILE_APPEND);
	$versionNumber = $rowCRC['versionNumber'];
	$fileDirectoryName = $rowCRC['fileDirectoryName'];
	
	
  
	if(($file == $fileDirectoryName))
	{
	 
		if(($crc != $crcDB))
		{
				
	
	$versionNumber++;
	//make update
		$query = "UPDATE masterVersionFileList SET fileDirectoryName = '$file', versionNumber = '$versionNumber', crc= '$crc'  WHERE fileDirectoryName = '$file'";
		
		}else
		{
			

			$query = "$crc $crcDB";
		}
	}else{
	 
	$query = "INSERT INTO masterVersionFileList (fileDirectoryName, crc) VALUES ('$file', '$crc')";
	
	}
	
	
	
    mysqli_query($con,$query);
	
}

	// put the file name, CRC number, version number in database 
	
	// 
	
	//
	
	
	
	
	
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


?>