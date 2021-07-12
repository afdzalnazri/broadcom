
if($action == 'editmasterFile'){

	//write into folder - rewrite the file 
	$scriptname = $_POST['scriptname'];
	$scripttext = $_POST['scripttext'];
	$fileID = $_POST['fileID']; 
	
	
$sql = "SELECT * FROM masterVersionFileList WHERE id = '$_POST[fileID]'";
$sql_query = mysqli_query($con,$sql);
$rowMasterFile = mysqli_fetch_array($sql_query);


  
$fileDirectoryName = $rowMasterFile['fileDirectoryName'];
$versionNumber = $rowMasterFile['versionNumber'];
	
	if(file_put_contents($fileDirectoryName,$scripttext)){
			$versionNumber++;
			
			$crc = crc32($fileDirectoryName);
			
		mysqli_query($con,"UPDATE masterVersionFileList SET versionNumber = '$versionNumber', crc='$crc' WHERE id = $fileID");
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
		addAuditTrail($userid,$activity); 
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
	
	
	//uprev the database 
	
}