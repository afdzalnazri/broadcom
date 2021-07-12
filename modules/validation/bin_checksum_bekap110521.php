  	 <script type="text/javascript"> 
							  
							  
							  function calc_cksum8(N) {

 // convert input value to upper case
  strN = new String(N);
  strN = strN.toUpperCase();

  strHex = new String("0123456789ABCDEF");
  result = 0;
  fctr = 16;

  for (i=0; i<strN.length; i++) {
    if (strN.charAt(i) == " ") continue;

    v = strHex.indexOf(strN.charAt(i));
    if (v < 0) {
       result = -1;
       break; 
    } 
    result += v * fctr;

    if (fctr == 16) fctr = 1;
    else            fctr = 16;
  }

  if (result < 0) {
     strResult = new String("Non-hex character");
  }
  else if (fctr == 1) {
     strResult = new String("Odd number of characters");
  }
  else {
     // Calculate 2's complement
     result = (~(result & 0xff) + 1) & 0xFF;
     // Convert result to string
     //strResult = new String(result.toString());
     strResult = strHex.charAt(Math.floor(result/16)) + strHex.charAt(result%16);
  }
	return strResult;			
}

 
//hex="00";   
//hex="01 0C 19 D5 30 C7 C8 42 72 6F 61 64 63 6F 6D DB 42 52 43 4D 20 31 30 30 47 20 31 50 20 35 37 35 30 34 20 4F 43 50 20 4D 65 7A 7A D2 4E 31 31 30 30 46 5A 31 39 32 31 30 30 30 31 59 43 51 D1 42 43 4D 39 35 37 35 30 34 2D 4E 31 31 30 30 46 5A CA 31 30 2F 31 35 2F 32 30 31 39 C1 00 00 00";
//hex = document.getElementById("checksumone").value;
//alert(hex);



window.onload = function() {
//board checksum
try{
hex = document.getElementById("checksumone").value;
checksumonebin = document.getElementById("checksumonebin").value;
var checksumFinalCal = calc_cksum8(hex); 
document.getElementById("checksumonecal").value = checksumFinalCal;

if(checksumFinalCal==checksumonebin){
document.getElementById("checksumonenote").innerHTML = "<font size='6'>BOARD CHECKSUM : OK</font>";
}else
{
document.getElementById("checksumonenote").innerHTML = "<font size='6'>BOARD CHECKSUM : FAULT</font>";	
}
}catch(err)
{
	
}

///product checksum
try{
hex = document.getElementById("checksumoneprod").value;
checksumonebin = document.getElementById("checksumonebinprod").value;
var checksumFinalCal = calc_cksum8(hex); 
document.getElementById("checksumonecalprod").value = checksumFinalCal;

if(checksumFinalCal==checksumonebin){
document.getElementById("checksumonenoteprod").innerHTML = "<font size='6'>PRODUCT CHECKSUM : OK</font>";
}else
{
document.getElementById("checksumonenoteprod").innerHTML = "<font size='6'>PRODUCT CHECKSUM : FAULT</font>";	
}
}catch(err)
{
	
}

///OEM Record checksum
try{
hex = document.getElementById("checksumonerecord").value;
checksumonebin = document.getElementById("checksumonebinrecord").value;
var checksumFinalCal = calc_cksum8(hex); 
document.getElementById("checksumonecalrecord").value = checksumFinalCal;

if(checksumFinalCal==checksumonebin){
document.getElementById("checksumonenoterecord").innerHTML = "<font size='6'>OEM RECORD CHECKSUM : OK</font>";
}else
{
document.getElementById("checksumonenoterecord").innerHTML = "<font size='6'>OEM RECORD CHECKSUM : FAULT</font>";	
}
}catch(err)
{
	
}
///OEM Header checksum
try
{
hex = document.getElementById("checksumoneheader").value;
checksumonebin = document.getElementById("checksumonebinheader").value;
var checksumFinalCal = calc_cksum8(hex); 
document.getElementById("checksumonecalheader").value = checksumFinalCal;

if(checksumFinalCal==checksumonebin){
document.getElementById("checksumonenoteheader").innerHTML = "<font size='6'>OEM HEADER CHECKSUM : OK</font>";
}else
{
document.getElementById("checksumonenoteheader").innerHTML = "<font size='6'>OEM HEADER CHECKSUM : FAULT</font>";	
}
}catch(err)
{
	
}

};

 


 </script> 
 
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
				<li class="breadcrumb-item">BIN File Validation</li>
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

if($_POST["submit"]=="Upload BIN") {
  
  
  
 $files = glob('uploads/*.bin'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file)) {
	 // echo $file;
	//  echo "DELET FILES";
    unlink($file); // delete file
  }
}

 $files = glob('uploads/*.txt'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file)) {
	 // echo $file;
	//  echo "DELET FILES";
    unlink($file); // delete file
  }
}

	$target_dir = "uploads/";
	
$target_file_bin = $target_dir . basename($_FILES["binFile"]["name"]);  
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file_bin,PATHINFO_EXTENSION));

// Check file size
if ($_FILES["binFile"]["size"] > 30000000) { 
  echo "<strong>Sorry, your file is too large.</strong><br><br>";
  $uploadOk = 0;
}

// Allow certain file formats 
if($imageFileType != "bin") {
  echo "<strong>Sorry, only BIN files are allowed.</strong><br><br>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<strong>Sorry, your file was not uploaded.</strong><br><br>";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["binFile"]["tmp_name"], $target_file_bin)) {
    echo "<br>The BIN file ". htmlspecialchars( basename( $_FILES["binFile"]["name"])). " has been uploaded.";
	

  } else {
    echo "<strong>Sorry, there was an error uploading your file.</strong><br><br>";
  }
}
	

	$target_dir = "uploads/";
	
$target_file_fru = $target_dir . basename($_FILES["fruFile"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file_fru,PATHINFO_EXTENSION));

// Check file size
if ($_FILES["fruFile"]["size"] > 30000000) { 
  echo "<strong>Sorry, your file is too large.</strong><br><br>";
  $uploadOk = 0;
}

// Allow certain file formats 
if($imageFileType != "txt") {
  echo "<strong>Sorry, only TXT files are allowed.</strong><br><br>";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<strong>Sorry, your file was not uploaded.</strong><br><br>";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fruFile"]["tmp_name"], $target_file_fru)) {
    echo "<br><br>The FRU file ". htmlspecialchars( basename( $_FILES["fruFile"]["name"])). " has been uploaded.";
	

  } else {
    echo "<strong>Sorry, there was an error uploading your file.</strong>";
  }
}

//call function to make compare with andy and anrew file
global $con;

//echo "<br><br><br>";
//echo getHexFromBinFile($target_file_bin); 

//$hexes = explode(" ", getHexFromBinFile($target_file_bin));
	
	//echo '<pre>';
        //print_r ($hexes);
      //  echo  '</pre>';
	
//echo "<br><br><br>";
  
  
  
if($_POST["checksumselect"]=="checkAllCheckSum")
{
	boardChecksum($target_file_fru, $target_file_bin);
	productChecksum($target_file_fru, $target_file_bin);
	oemRecordChecksum($target_file_fru, $target_file_bin);
	oemHeaderChecksum($target_file_fru, $target_file_bin);
} 

	
if($_POST["checksumselect"]=="boardCheckSum"){boardChecksum($target_file_fru, $target_file_bin);}
if($_POST["checksumselect"]=="productCheckSum"){productChecksum($target_file_fru, $target_file_bin);}
if($_POST["checksumselect"]=="oemRecordCheckSum"){oemRecordChecksum($target_file_fru, $target_file_bin);}
if($_POST["checksumselect"]=="oemHeaderCheckSum"){oemHeaderChecksum($target_file_fru, $target_file_bin);}

}


if($_POST["submit"]=="Get Checksum") {
  
  //echo "PROCESS PROJECT SELECTION HERE";
//echo $_POST["submit"];
  $project = $_POST["option_product"];
  $buildID = $_POST["option_build"];  
  
  	$col = mysqli_query($con,"SELECT * FROM buildConfig where id = '$buildID'");
							while($rowcol = mysqli_fetch_array($col)){
								$buildConfigName = $rowcol['buildConfigName']; 
								$projectName = $rowcol['projectName']; 
							}
							
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	foreach($fileNameSearch as $fileNameS)
	{
		if(strpos($fileNameS, "_fru_") !== false)
		{
	
			 $txtFruFile = $fileNameS;
			
			
		}
	}
	echo "<br><br>"; 
	echo "project_build/".$projectName."/".$buildConfigName."/".$projectName."-M0_999 Test Logs/log/evram/";
	echo "<br><br>";
	$fileNameSearch = scandir("project_build/".$projectName."/".$buildConfigName."/".$projectName."-M0_999 Test Logs/log/evram/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	foreach($fileNameSearch as $fileNameS)
	{
		if(strpos($fileNameS, "_verify_") !== false)
		{
	
			 echo $txtBinFile = $fileNameS;
			
			
		}
	}
	
	
	$col = mysqli_query($con,"SELECT * FROM buildConfigParam where id = '$buildID' and paramId = 3");
							while($rowcol = mysqli_fetch_array($col)){
								$valueParamB = $rowcol['value']; 
							}
							
							$col = mysqli_query($con,"SELECT * FROM buildConfigParam where id = '$buildID' and paramId = 3");
							while($rowcol = mysqli_fetch_array($col)){
								$valueParamB = $rowcol['value']; 
							}
	
	echo $target_file_fru = "project_build/".$projectName."/".$buildConfigName."/Working Folder/support/".$txtFruFile;
	echo "<br><br>";
	echo $target_file_bin = "project_build/".$projectName."/".$buildConfigName."/".$projectName."-M0_".$valueParamB." Test Logs/log/evram/".$txtBinFile;
   
	echo "<br><br>";
	
	///999 is the running number, not valueParamB
	//M0 is already in the file name
  
  if(!file_exists($target_file_fru)){echo "ERROR : FRU FILE NOT EXIST. ";exit();}
  if(!file_exists($target_file_bin)){echo "ERROR : BIN FILE NOT EXIST. ";exit();}
  
  
  //$target_file_fru = "project_build/logitech/loigc_01/Working Folder/support/N1100FZ_fru_A0.txt";
  //$target_file_bin = "project_build/logitech/loigc_01/logitech-M0_999 Test Logs/log/evram/a.bin";

//echo $target_file_fru;
//echo $target_file_bin;
  
if(file_exists($target_file_fru) && file_exists($target_file_bin))
{


if($_POST["checksumselect"]=="checkAllCheckSum")
{
	boardChecksum($target_file_fru, $target_file_bin);
	productChecksum($target_file_fru, $target_file_bin);
	oemRecordChecksum($target_file_fru, $target_file_bin);
	oemHeaderChecksum($target_file_fru, $target_file_bin);
} 

	
if($_POST["checksumselect"]=="boardCheckSum"){boardChecksum($target_file_fru, $target_file_bin);}
if($_POST["checksumselect"]=="productCheckSum"){productChecksum($target_file_fru, $target_file_bin);}
if($_POST["checksumselect"]=="oemRecordCheckSum"){oemRecordChecksum($target_file_fru, $target_file_bin);}
if($_POST["checksumselect"]=="oemHeaderCheckSum"){oemHeaderChecksum($target_file_fru, $target_file_bin);}



}else{
	
	if(!file_exists($target_file_fru))
	{
		echo "<br><br><h2>FRU file not found</h2>";
	}
	
	if(!file_exists($target_file_bin))
	{
		echo "<br><br><h2>BIN file not found</h2><br>";
	}
	
}

}

	?>
	
	<h2>SELECT CUSTOMER</h2>
	
	<div class="row">
					<div class="col-md-4">
						
						<select id="option_family" name="option_family" onchange='filterOption(this.value,"project","family","productName","productName","option_product");read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control">
							<option value="">Select customer</option>
							<option value="GENERIC">GENERIC</option>
							<option value="DELL">DELL</option>
							<option value="LENOVO">LENOVO</option>
							<option value="HPE">HPE</option>
							
							
							
						</select> 
					</div>
	</div>
					
<br><br>


<h2>OPTION 1 : SELECT FAMILY, PROJECT AND BUILD</h2>
<br><br>
 <form action="index.php?page=bin_checksum" method="post" >
  
  <input type="hidden"  name="id" id="id" value="<?php echo $_GET["id"]; ?>">
  <input type="hidden"  name="page" id="page" value="compare_file_cfg">
 
 <div class="row">
					<div class="col-md-4">
						<b>Family</b><br> 
						<select id="option_family" name="option_family" onchange='filterOption(this.value,"project","family","productName","productName","option_product");read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control">
							<option value="">Select an option</option>
							<?php echo optionMaster('masterFamily','familyName','id',''); ?>
						</select> 
					</div>
					<div class="col-md-4">
						<b>Project</b><br>									
						<select id="option_product" name="option_product" onchange='filterOption(this.value,"buildConfig","projectName","buildConfigName","id","option_build");read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control" disabled>
							<option value="#">Select an option</option>
						</select>
					</div>
					<div class="col-md-4">
						<b>Build</b><br>
						<select id="option_build" name="option_build" onchange='read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control" disabled>
							<option value="#">Select an option</option>
						</select>
					</div>
					<!--<div class="col-md-2"><button style="width:100%" class="btn btn-success" onclick='read("filter_vars",<?php echo json_encode($read_dt);?>,1);$("#reset").attr("hidden",false);'>Search</button></div>-->
				</div>
				
  <br><br>
  
  <div class="row">
					<div class="col-md-4">
						<b>Select Checksum to calculate</b><br> 
						<select id="checksumselect" name="checksumselect" class="form-control">
							<option value="checkAllCheckSum">Check All Checksum</option>
							<option value="boardCheckSum">Board Checksum</option>
							<option value="productCheckSum">Product Checksum</option>
							<option value="oemRecordCheckSum">OEM Record Checksum</option>
							<option value="oemHeaderCheckSum">OEM Header Checksum</option>
						</select> 
					</div>
	</div>
	<br><br>
  <input type="submit" value="Get Checksum" name="submit">
</form>

<form onsubmit="return false" class="filter-form" id="filter_vars">  
				 
				</form>
				

<br><br>
<h2>OPTION 2 : UPLOAD FILES</h2>
<br><br>

	
<form action="index.php?page=bin_checksum" method="post" enctype="multipart/form-data">
  
  <input type="hidden"  name="id" id="id" value="<?php echo $_GET["id"]; ?>">
  <input type="hidden"  name="page" id="page" value="compare_file_cfg">
  Select BIN  File: <input type="file" name="binFile" id="binFile"><br><br>
  Select FRU Text: <input type="file" name="fruFile" id="fruFile"><br><br>
  
   <div class="row">
					<div class="col-md-4">
						<b>Select Checksum to calculate</b><br> 
						<select id="checksumselect" name="checksumselect" class="form-control">
							<option value="checkAllCheckSum">Check All Checksum</option>
							<option value="boardCheckSum">Board Checksum</option>
							<option value="productCheckSum">Product Checksum</option>
							<option value="oemRecordCheckSum">OEM Record Checksum</option>
							<option value="oemHeaderCheckSum">OEM Header Checksum</option>
						</select> 
					</div>
	</div>
	
  <input type="submit" value="Upload BIN" name="submit">
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



							
