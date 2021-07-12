  	
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $title; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item">Compare File</li>
              <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
		
              <div class="card-body table-responsive">

				<div class="row row-form">
				
					<div class="col-md-12">
			
						
<br><br><br>


<?php 
						/*	
							$col = mysqli_query($con,"SELECT * FROM buildConfig where md5(id) = '$_GET[id]'");
							while($rowcol = mysqli_fetch_array($col)){
								$buildConfigName = $rowcol['buildConfigName']; 
								$projectName = $rowcol['projectName']; 
								
							}
*/
//compressToTar($projectName, $buildConfigName);



/////////////// R2.7 end ////////////////
						echo "<h7>Logic sequence <br>";
						echo "1) Upload file NVRAMLOG00.log - if found the existing file, overwrite, else put in <br> <br>";
				echo "2) Compare Andy and albert first - just show the keywords value only. Throw exception if not matched <br> <br> <br>";
						echo "3) Compare Andy with NVRAM .log- line by line and the keywords value  <br></h7>";
	
	//sleep(3);
	
	$target_dir = "uploads/";
	
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image

if($_POST["submit"]=="Upload Log") {
  

// Check file size
if ($_FILES["fileToUpload"]["size"] > 30000000) { 
  echo "<strong>Sorry, your file is too large.</strong>";
  $uploadOk = 0;
}

// Allow certain file formats 
if($imageFileType != "zip") {
  echo "<strong>Sorry, only ZIP files are allowed.</strong>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<strong>Sorry, your file was not uploaded.</strong>";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
	
	$zip = new ZipArchive;
if ($zip->open($target_file) === TRUE) {
	
	
	$col = mysqli_query($con,"SELECT * FROM buildConfig where md5(id) = '$_POST[id]'");
							while($rowcol = mysqli_fetch_array($col)){
								$buildConfigName = $rowcol['buildConfigName']; 
								$projectName = $rowcol['projectName']; 
								
							}  
		echo "<br><br><br>";
		//project_build/logitech/loigc_01/logs/
		
		//999 is user input - PART_REV
	//<project name>-M0_ is hardcoded  TEST Logs 
	
	
	$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(id) = '$_POST[id]' and paramId ='8'");
							while($rowcol = mysqli_fetch_array($col)){
								$partRev = $rowcol['value']; 
								
								
							}  
							
							
		echo $folder_name = $projectName."-M0_".$partRev." Test Logs";
		
	echo $target_dir_project = "project_build/".$projectName."/".$buildConfigName."/".$folder_name."/";					
	echo "<br><br><br>";
    $zip->extractTo($target_dir_project); //extract to build folder . the extracted file should be replaced
	//unlink the log folder   
	
	
	
    $zip->close();
    echo '<br><br>Extraction ZIP file DONE</br></br>';
} else {
    echo 'ZIP FILE FAILED EXTRACTION';
}

  } else {
    echo "<strong>Sorry, there was an error uploading your file.</strong>";
  }
}

//call function to make compare with andy and anrew file
echo "dadass"; 
echo "SELECT * FROM buildConfig where md5(id) = '$_POST[id]'";
$col = mysqli_query($con,"SELECT * FROM buildConfig where md5(id) = '$_POST[id]'");
							while($rowcol = mysqli_fetch_array($col)){
								echo $buildConfigName = $rowcol['buildConfigName']; 
								$projectName = $rowcol['projectName']; 
								
							} 

    
//compareAndyAlbert($projectName, $buildConfigName); disabled this to proceed with other function
//compareAndyLog($projectName, $buildConfigName, $target_dir_project);disabled this to proceed with other function

compareAndyAlbertCFG($projectName, $buildConfigName);


	$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(id) = '$_POST[id]' and paramId ='8'");
							while($rowcol = mysqli_fetch_array($col)){
								$partRev = $rowcol['value']; 
								
								
							}  
							
							
		echo $folder_name = $projectName."-M0_".$partRev." Test Logs";
		
	echo $target_dir_project = "project_build/".$projectName."/".$buildConfigName."/".$folder_name."/";					
	
	
compareAndyLogCFG($projectName, $buildConfigName, $target_dir_project);


}
	?>
	<br><br> 
	
<form action="index.php?page=compare_file" method="post" enctype="multipart/form-data">
  Select log file:    
  <input type="hidden"  name="id" id="id" value="<?php echo $_GET["id"]; ?>">
  <input type="hidden"  name="page" id="page" value="compare_file">
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Log" name="submit">
</form>
<br><br><br><br> 
<form target="_blank" action="fa/index.php" method="post" enctype="multipart/form-data">
  Select file:
  <input type="hidden"  name="id" id="id" value="<?php echo $_GET["id"]; ?>">
  <input type="hidden"  name="page" id="page" value="compare_file">
  <input type="file" name="fileA" id="fileA">
  <input type="file" name="fileB" id="fileB">
  <input type="submit" value="Upload File" name="submit">
</form>

	
	<br><br>
	
	
							
							</div>
						</div>
					</div>
				</div>

              </div>
	 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



							
