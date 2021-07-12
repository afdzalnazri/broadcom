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

window.onload = function() {
//board checksum

<?php

global $con;

 $sql = "SELECT * from masterchecksum";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {
			
         $checksumID = $row["checksumID"]; 
		 $checksumname = $row["checksumname"]; 
		 $starthex = $row["starthex"]; 
		 $endhex = $row["endhex"]; 
		 $checksumaddress = $row["checksumaddress"]; 
			
echo "

try{
hex = document.getElementById('".$checksumname."').value; 

".$checksumname."bin = document.getElementById('".$checksumname."bin').value;

var ".$checksumname."FinalCal = calc_cksum8(hex);  
document.getElementById('".$checksumname."cal').value = ".$checksumname."FinalCal;


if(".$checksumname."FinalCal==".$checksumname."bin){
document.getElementById('".$checksumname."note').innerHTML = \"<font size='6'>BOARD CHECKSUM : OK</font>\";	

}else
{
document.getElementById('".$checksumname."note').innerHTML = \"<font size='6'>BOARD CHECKSUM : FAULT</font>\";	

}

}catch(err)
{
	
}

";

echo "


";
		}
		
?>

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
	


//call function to make compare with andy and anrew file
global $con;

//echo "<br><br><br>";
//echo getHexFromBinFile($target_file_bin); 

//$hexes = explode(" ", getHexFromBinFile($target_file_bin));
	
	//echo '<pre>';
        //print_r ($hexes);
      //  echo  '</pre>';
	
//echo "<br><br><br>";
  
  
  /*
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
*/

  global $con;


	

//foreach ($_POST['LocStart'] as $LocStart) {
	//echo $LocStart;
	//foreach ($_POST['LocEnd'] as $LocEnd) {
		//echo $LocEnd;
		
		foreach ($_POST['checkboxCheckSum'] as $checkboxCheckSum) {
	  
	
	  
	  $sql = "SELECT * from masterchecksum";
	$col = mysqli_query($con,$sql);

	  while ($row = mysqli_fetch_array($col))
			{			
		
			 $checksumID = $row["checksumID"];  
			 $checksumname = $row["checksumname"];  
			 $starthex = $row["starthex"]; 
			 $endhex = $row["endhex"]; 
			 $checksumaddress = $row["checksumaddress"]; 
			 
			 
			 if($checkboxCheckSum == $checksumname."_box")			 
			{
				echo "<br><br><h1>$checksumname</h1>";
				 
			 checksumExtraUpload($target_file_bin, $starthex, $endhex, $checksumname);
			 
			}
			
			}
		} 
		
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
	echo "<br><br>";
	
	
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
				

   global $con;


	

//foreach ($_POST['LocStart'] as $LocStart) {
	//echo $LocStart;
	//foreach ($_POST['LocEnd'] as $LocEnd) {
		//echo $LocEnd;
		
		foreach ($_POST['checkboxCheckSum'] as $checkboxCheckSum) {
	  
	
	  
	  $sql = "SELECT * from masterchecksum";
	$col = mysqli_query($con,$sql);

	  while ($row = mysqli_fetch_array($col))
			{			
		
			 $checksumID = $row["checksumID"];  
			 $checksumname = $row["checksumname"];  
			 $starthex = $row["starthex"]; 
			 $endhex = $row["endhex"]; 
			 $checksumaddress = $row["checksumaddress"]; 
			 
			 
			 if($checkboxCheckSum == $checksumname."_box")			 
			{
				echo "<br><br><h1>$checksumname</h1>";
			 checksumExtra($target_file_fru, $target_file_bin, $starthex, $endhex, $checksumname);
			 
			}
			
			}
		} 
		
		
		
//}
//}

	


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
	
	


<h2>OPTION 1 : SELECT FAMILY, PROJECT AND BUILD</h2>
<br><br>
 <form action="index.php?page=checksum_extra" method="post" >
  
  <input type="hidden"  name="ids" id="id" value="<?php echo $_GET["id"]; ?>">
  <input type="hidden"  name="pages" id="page" value="compare_file_cfg">
 
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
  <!--
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
	-->
	<br><br>
				<div class="row">
					<div class="col-md-4">
						<b>Select Specific Address</b><br> 
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-2"><b>Checksum</b></div>
					<div class="col-md-2"><b></b></div> 
					<!-- <div class="col-md-2"><b>Start Address (Hex)</b></div>
					<div class="col-md-2"><b>End Address (Hex)</b></div>
					<div class="col-md-2"><b>Checksum Location Address (Hex)</b></div>
					-->
				</div>
				<?php
				
				
global $con;

 $sql = "SELECT * from masterchecksum";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {
			
         $checksumID = $row["checksumID"]; 
		 $checksumname = $row["checksumname"]; 
		 $starthex = $row["starthex"]; 
		 $endhex = $row["endhex"]; 
		 $checksumaddress = $row["checksumaddress"]; 
		 echo "<div class='row'>\r\n";
		echo "<div class='col-md-2'><b>".$checksumname."</b></div>\r\n";
		echo "<div class='col-md-2'><input type='checkbox' name='checkboxCheckSum[]' value='".$checksumname."_box'  id='".$checksumname."' checked></div>\r\n";
		//echo "<div class='col-md-2'><b><input type='text' name='LocStart[]'></b></div>\r\n";
		//echo "<div class='col-md-2'><b><input type='text' name='LocEnd[]'></b></div>\r\n"; 
		//echo "<div class='col-md-2'><b><input type='text' name='checksumLoc[]'></b></div>\r\n"; 
		 echo "</div>\r\n\r\n";
		 
		}
				?> 




	<br><br>
  <input type="submit" value="Get Checksum" name="submit">
</form>

<form onsubmit="return false" class="filter-form" id="filter_vars">  
				 
				</form>
				

<br><br>
<h2>OPTION 2 : UPLOAD FILES</h2>
<br><br>

	
<form action="index.php?page=checksum_extra" method="post" enctype="multipart/form-data">
  
  <input type="hidden"  name="id" id="id" value="<?php echo $_GET["id"]; ?>">
  <input type="hidden"  name="page" id="page" value="compare_file_cfg">
  Select BIN  File: <input type="file" name="binFile" id="binFile"><br><br>
  
  
	<br><br>
				<div class="row">
					<div class="col-md-4">
						<b>Select Specific Address</b><br> 
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-2"><b>Checksum</b></div>
					<div class="col-md-2"><b></b></div>  
					<!-- <div class="col-md-2"><b>Start Address (Hex)</b></div>
					<div class="col-md-2"><b>End Address (Hex)</b></div>-->
				</div>
				
				<?php
				
				
global $con;

 $sql = "SELECT * from masterchecksum";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {
			
         $checksumID = $row["checksumID"]; 
		 $checksumname = $row["checksumname"]; 
		 $starthex = $row["starthex"]; 
		 $endhex = $row["endhex"]; 
		 $checksumaddress = $row["checksumaddress"]; 
		 echo "<div class='row'>\r\n";
		echo "<div class='col-md-2'><b>".$checksumname."</b></div>\r\n";
		//echo "<div class='col-md-2'><input type='checkbox' name='1'  name='".$checksumname."cb'  id='".$checksumname."cb' value='1' checked></div>\r\n";
		echo "<div class='col-md-2'><input type='checkbox' name='checkboxCheckSum[]' value='".$checksumname."_box'  id='".$checksumname."' checked></div>\r\n";
		//echo "<div class='col-md-2'><b><input type='text' name='".$checksumname."LocStart'></b></div>\r\n";
		//echo "<div class='col-md-2'><b><input type='text' name='".$checksumname."LocEnd'></b></div>\r\n";
		 echo "</div>\r\n\r\n";
		 
		}
				?> 
				
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



							
