  	
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
				<li class="breadcrumb-item">Compare File TRC</li>
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
	


// Check if image file is a actual image or fake image

if($_POST["submit"]=="Upload TRC") {
  
  
  
 $files = glob('uploads/*.trc'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file)) {
	  echo $file;
	//  echo "DELET FILES";
    unlink($file); // delete file
  }
}

	$target_dir = "uploads/";
	
$target_file = $target_dir . basename($_FILES["fileToUploadA"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check file size
if ($_FILES["fileToUploadA"]["size"] > 30000000) { 
  echo "<strong>Sorry, your file is too large.</strong>";
  $uploadOk = 0;
}

// Allow certain file formats 
if($imageFileType != "trc") {
  echo "<strong>Sorry, only TRC files are allowed.</strong>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<strong>Sorry, your file was not uploaded.</strong>";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUploadA"]["tmp_name"], $target_file)) {
    echo "The file <A> ". htmlspecialchars( basename( $_FILES["fileToUploadA"]["name"])). " has been uploaded.";
	

  } else {
    echo "<strong>Sorry, there was an error uploading your file.</strong>";
  }
}
	

	$target_dir = "uploads/";
	
$target_file = $target_dir . basename($_FILES["fileToUploadB"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check file size
if ($_FILES["fileToUploadB"]["size"] > 30000000) { 
  echo "<strong>Sorry, your file is too large.</strong>";
  $uploadOk = 0;
}

// Allow certain file formats 
if($imageFileType != "trc") {
  echo "<strong>Sorry, only TRC files are allowed.</strong>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<strong>Sorry, your file was not uploaded.</strong>";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUploadB"]["tmp_name"], $target_file)) {
    echo "<br><br>The file (B) ". htmlspecialchars( basename( $_FILES["fileToUploadB"]["name"])). " has been uploaded.";
	

  } else {
    echo "<strong>Sorry, there was an error uploading your file.</strong>";
  }
}

//call function to make compare with andy and anrew file
global $con;
//echo "SELECT * FROM buildConfig where md5(id) = '$_POST[id]'";
$col = mysqli_query($con,"SELECT * FROM buildConfig where md5(id) = '$_POST[id]'");
							while($rowcol = mysqli_fetch_array($col)){
								echo $buildConfigName = $rowcol['buildConfigName']; 
								$projectName = $rowcol['projectName']; 
								
							} 

 compareTRCile();
 compareFileVersioning();
 
 compareFileChecksum();
 compareProdName();
 compareTemp();
  
}
	?>
	
<form action="index.php?page=compare_file_cfg" method="post" enctype="multipart/form-data">
  
  <input type="hidden"  name="id" id="id" value="<?php echo $_GET["id"]; ?>">
  <input type="hidden"  name="page" id="page" value="compare_file_cfg">
  Select TRC file A: <input type="file" name="fileToUploadA" id="fileToUploadA"><br><br>
  Select TRC file B: <input type="file" name="fileToUploadB" id="fileToUploadB"><br><br>
  <input type="submit" value="Upload TRC" name="submit">
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



							
