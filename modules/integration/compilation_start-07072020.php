  <!--<script type="text/javascript"> 
							  
							 
		
							   
							  
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
  //form.CKS8.value = strResult;
  return strResult;
}

       function readTextFile(file) {
		  // alert(file);
   var checksumFinalCal = calc_cksum8(file);
   //alert(checksumFinalCal);
   
 if (window.XMLHttpRequest){
     xmlhttp = new XMLHttpRequest();
 }

else{
     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 }

 var PageToSendTo = "writeToFile.php?";
 var MyVariable = checksumFinalCal;
 var VariablePlaceholder = "chcSum8=";
 var UrlToSend = PageToSendTo + VariablePlaceholder + MyVariable;
//alert(UrlToSend);
 xmlhttp.open("GET", UrlToSend, false);
 xmlhttp.send();				  
            }
        
    
    //rawFile.send(null); //Sends the request to the server Used for GET requests with param null

<?php 
$fileName = "project_build/logitech/loigc_01/Working Folder/support/M1100G_fru_A2.bin";
?>
//readTextFile(<?php //echo "'project_build/logitech/loigc_01/Working Folder/support/M1100G_fru_A2.bin'"; ?>); //<= Call function ===== don't need "file:///..." just the path   
readTextFile(<?php //echo "'".getHexFromBinFile($fileName)."'"; ?>); //<= Call function ===== don't need "file:///..." just the path   
//readTextFile(<?php //echo "'project_build/logitech/loigc_01/Working Folder/support/N1100FZ_fru_A0.bin'"; ?>); //<= Call function ===== don't need "file:///..." just the path   
//readTextFile(<?php //echo "'project_build/logitech/loigc_01/Working Folder/support/Wilshire_J3D14_FRU_X00_3.bin'"; ?>); //<= Call function ===== don't need "file:///..." just the path   

    </script> 
-->	
	<?php
$table = 'buildConfig';
$col = mysqli_query($con,"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'");
while($rowcol = mysqli_fetch_array($col)){
	$columns[] = $rowcol['COLUMN_NAME']; 
}

$column =
				[
				[
						'db_column'=>'buildConfigName',
						'title_column'=>'Build Config',
						'fk'=>[],
						'display'=>[
							'type'=>'text',
							'property'=>
								[
									'page'=>'',
									'param'=>'',
									'text'=>'',
									'target'=>'',
									'class'=>'',
									'function'=>[]
								],
							'format'=>''
						],
						'width'=>'10%'
					],
					[
						'db_column'=>'projectName',
						'title_column'=>'Product Name',
						'fk'=>[],
						'display'=>[
							'type'=>'text',
							'property'=>
								[
									'page'=>'',
									'param'=>'',
									'text'=>'',
									'target'=>'',
									'class'=>'',
									'function'=>[]
								],
							'format'=>''
						],
						'width'=>'10%'
					],
					[
						'db_column'=>'created',
						'title_column'=>'Date Created',
						'fk'=>[],
						'display'=>[
							'type'=>'text',
							'property'=>
								[
									'page'=>'',
									'param'=>'',
									'text'=>'',
									'target'=>'',
									'class'=>'',
									'function'=>[]
								],
							'format'=>'date'
						],
						'width'=>'10%'
					],
					[
						'db_column'=>'userId',
						'title_column'=>'Created By',
						'fk'=>[
							'fk_table'=>'user',
							'fk_id_column'=>'id',
							'fk_db_column'=>'userId',
							'fk_display_column'=>'name'
						],
						'display'=>[
							'type'=>'text',
							'property'=>
								[
									'page'=>'',
									'param'=>'',
									'text'=>'',
									'target'=>'',
									'class'=>'',
									'function'=>[]
								],
							'format'=>''
						],
						'width'=>'10%'
					],
										
															[
						'db_column'=>'id',
						'title_column'=>'',
						'fk'=>[],
						'display'=>[
							'type'=>'button',
							'property'=>
								[
									'page'=>'?page=compilation-start',
									'param'=>'id',
									'text'=>'Create Compilattion',
									'target'=>'',
									'class'=>'btn btn-primary',
									'function'=>[]
								],
							'format'=>''
						],
						'width'=>'5%'
					],
					
				];
				//$where = [];
				
			if($_GET["prodName"]!="")
					{
				$where = [
					[
					 'condition'=>'',
					 'column'=>'projectId',
					 'operator'=>'=',
					 'value'=>''.$_GET["prodName"].''
					]
				
				];
				$condition_filter = 'AND';
					}else{
						$condition_filter = '';
					}
				
				$order = 
				[
					'column'=>'created',
					'order'=>'ASC'
				];
				
				$filter = [
					[
						'db_column'=>'projectId',
						'input_name'=>'option_product', 
						'operator'=>'=',
						'condition'=>$condition_filter,
						'fk'=>[]
					],				
				];
$cat_read->table = $table;
$cat_read->column = $column;
$cat_read->where = $where;
$cat_read->filter = $filter;
$cat_read->order = $order;

?>
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
				<li class="breadcrumb-item">Compilation</li>
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
			
						

						<div class="row form-info-row">
							<div class="col-md-12">
							<?php 
							
							$col = mysqli_query($con,"SELECT * FROM buildConfig where md5(id) = '$_GET[id]'");
							while($rowcol = mysqli_fetch_array($col)){
								$buildConfigName = $rowcol['buildConfigName']; 
								$projectName = $rowcol['projectName']; 
								
								$familyId = $rowcol['familyId']; 
								$projectId = $rowcol['projectId']; 
								
							}
							
							$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '3'");
							while($rowcol = mysqli_fetch_array($col)){
								$paramId = $rowcol['paramId']; 
								
								
							}
							
							
							
							$col = mysqli_query($con,"SELECT * FROM masterFamily where id = '$familyId'");
							while($rowcol = mysqli_fetch_array($col)){
								$familyName = $rowcol['familyName']; 
							}
							
							$col = mysqli_query($con,"SELECT * FROM project where id = '$projectId'");
							while($rowcol = mysqli_fetch_array($col)){
								$productName = $rowcol['productName']; 
							}
							
							//do the untar here
							echo "project_build/$familyName/$productName/$buildConfigName/bc/";
							echo "<br><br>";
							$fileNameSearch = scandir("project_build/$familyName/$productName/$buildConfigName/bc/");
							//echo "project_build/$familyName/$productName/$buildConfigName/bc/";
							
							//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
							foreach($fileNameSearch as $fileNameS)
							{
								
								
								
								if(strpos($fileNameS, ".gz") !== false)
								{
									
									echo $toExtract = "project_build/$familyName/$productName/$buildConfigName/bc/".$fileNameS;
									$p = new PharData($toExtract);
									$p->decompress('tar'); // creates /path/to/my.tar
									
									echo "<br><br>EXTRACTION SUCCESS...<br><br>";
									echo $fileNameS = str_replace("gz","tar",$fileNameS);
									// unarchive from the tar
									$phar = new PharData("project_build/$familyName/$productName/$buildConfigName/bc/".$fileNameS);
									$phar->extractTo("project_build/$familyName/$productName/$buildConfigName/bc/aa");
									
									//unlink("project_build/$projectName/$buildConfigName/Working Folder/support/".$fileNameS);
									
									
								}
							}
							
								$fileNameSearch = scandir("project_build/$familyName/$productName/$buildConfigName/bc/aa/");
								echo $folderName = $fileNameSearch[3]."-".$fileNameSearch[2];
								
							echo "<br><br>";
							echo $folderName = str_replace(".tar.gz","",$folderName);
							exit();
							rename("project_build/$familyName/$productName/$buildConfigName/bc/aa/","project_build/$familyName/$productName/$buildConfigName/bc/".$folderName."/");
							echo "<br><br>FOLDER CREATED...<br><br>";
							
							//copy("modules/input/files_master_file_versioning/extracted/Master File Versioning/Setup.sh","project_build/$familyName/$productName/$buildConfigName/bc/".$folderName."/Setup.sh");
							echo "<br><br>Setup.sh NOT copied to working folder...<br><br>";
							//unlink ("project_build/$projectName/$buildConfigName/Working Folder/support/".$folderName."/install.sh");
							mkdir("project_build/$familyName/$productName/$buildConfigName/bc/".$folderName."/".$folderName);
							
						
//echo $tarfile = $folderName.".tar";
echo $tarfile= "project_build/$familyName/$productName/$buildConfigName/bc/".$folderName.".tar";
//$p = new \PharData($tarfile);

//$tarfile = "2.5.0.0-RC1.tar";
$pd = new \PharData($tarfile);
$pd->buildFromDirectory("project_build/$familyName/$productName/$buildConfigName/bc/".$folderName."/");
$pd->compress(\Phar::GZ);

//$p1 = $p->compress(Phar::GZ); // copies to /path/to/my.tar.gz
//$p2 = $p->compress(Phar::BZ2); // copies to /path/to/my.tar.bz2
//$p3 = $p2->compress(Phar::NONE); // exception: /path/to/my.tar already exists
//$p->buildFromDirectory($tarfile);
//$pd = new \PharData($tarfile);
//$pd->buildFromDirectory($tarfile);
//$pd->compress(\Phar::GZ);
				echo "<br><br>FOLDER COMPRESSED TO TAR FILE ...<br><br>";
				
				
							if(copy($folderName.".tar.gz","project_build/$projectName/$buildConfigName/Working Folder/".$folderName.".tar.gz"))
							{
								echo "<h1>".$folderName.".tar.gz COPIED</h1><br>";
								unlink ($folderName.".tar.gz");
								unlink ($folderName.".tar");
								echo "<br><br>FOLDER COMPRESSED TO TAR FILE ...<br><br>";
							}else
							{
								echo "<h1>NOT COPIED</h1><br>";
							}
							echo "<h1>CHECK </h1>".$file_name; 
							//exit();
							
							
						exit();	
							
							
							
							
							////////end of untar
							
							
							//get the buildconfig name
							
							
							
							
							function fileHasString($stringToCheck, $filePathToCheck)
							{
								$myfileCheck = fopen($filePathToCheck, "r") or die("Unable to open file!");
								$i=0;
								while (($lineToCheck = fgets($myfileCheck)) !== false) {
								
																		
									
									if(strpos($lineToCheck, $stringToCheck) !== false)
									{
										return true;
									}
									
								
								}
								
								return false;
							}
							
							
							if($paramId!='')
							{
							//this is for FCTPRG.sh
							$filePath = "project_build/$projectName/$buildConfigName/Working Folder/support/FCTPRG.sh";
							unlink("project_build/$projectName/$buildConfigName/Working Folder/support/FCTPRG_new.sh");
							
								if(!fileHasString("revdev_file=REVDEV$(printf \"%02d\" \$card_num).txt\r\n", $filePath))
								
								{
								$myfile = fopen($filePath, "r") or die("Unable to open file!");
								$i=0;
								while (($line = fgets($myfile)) !== false) {
									$i++;
																		
									
									if(strpos($line, "#sets the card specific MACID file") !== false)
									{
										$line = $line."revdev_file=REVDEV$(printf \"%02d\" \$card_num).txt\r\n";
									}
									
									$newFile = file_put_contents("project_build/$projectName/$buildConfigName/Working Folder/support/FCTPRG_new.sh", $line , FILE_APPEND);
								}
								unlink($filePath);
								
								//rename new file 
								rename("project_build/$projectName/$buildConfigName/Working Folder/support/FCTPRG_new.sh",$filePath);
								
								//echo fread($myfile,filesize($filePath));
								fclose($myfile);

								}else
								{
									echo "<h3>THIS FILE HAS revdev_file=REVDEV$(printf \"%02d\" \$card_num).txt\r\n</h3>";
								}
								
								
							}else
							{
								echo "<h3>No 2D Label selected for this build</h3>";
							}

							//to include MPC programming
							
							//this is for FCTPRG.sh
							
							$filePath = "project_build/$projectName/$buildConfigName/Working Folder/support/FCTPRG.sh";
							unlink("project_build/$projectName/$buildConfigName/Working Folder/support/FCTPRG_new.sh");
							$firstMfgLoad = false;
							//if(!fileHasString("-devnrev \$revdev_file", $filePath))
								if(true)
								
								{
									
								$myfile = fopen($filePath, "r") or die("Unable to open file!");
								$i=0;
								while (($line = fgets($myfile)) !== false) {
									$i++;
										
										
							$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
							foreach($fileNameSearch as $fileNameS)
							{
								if(strpos($fileNameS, "mpf") !== false)
								{
									$macFileName = $fileNameS;
								}
							}
	
										 
									$newLine = "-mac_prof ".$macFileName;
										echo $line;
										
										if(substr($line, 0, 17) == "echo ./mfgload.sh")
											
											{
												
												$line = "echo ./mfgload.sh -sysop -none -no_swap -noreset -noidcheck -gen1 -fnvm \$firmware_file -fmac \$mac_file ".$newLine." -sn4 -devnrev \$revdev_file \$sn_file -vpd -log \$output_file\r\n";
												//echo "SINI";
										
											}
											
											if(substr($line, 0, 12) == "./mfgload.sh")
											
											{
												
												$line = "./mfgload.sh  -sysop -none -no_swap -noreset -noidcheck -gen1 -fnvm \$firmware_file -fmac \$mac_file ".$newLine." -sn4 -devnrev \$revdev_file \$sn_file -vpd -log \$output_file \r\n";
												//echo "SANA";
										
											}
										
										
										
										
									
										//if(strpos($line, "./mfgload.sh -sysop -none -no_swap -noreset -noidcheck -gen1 -fnvm") !== false){
										
									//	$line = "AFDZAL NAZRI \r\n";
										
									//}
									
								
									
									
								
									
									
									
									$newFile = file_put_contents("project_build/$projectName/$buildConfigName/Working Folder/support/FCTPRG_new.sh", $line , FILE_APPEND);
								}
								unlink($filePath);
								
								//rename new file 
								rename("project_build/$projectName/$buildConfigName/Working Folder/support/FCTPRG_new.sh",$filePath);
								
								//echo fread($myfile,filesize($filePath));
								fclose($myfile);
								}else
								{
									echo "<h3>THIS FILE HAS BEEN INCLUDE WITH THE MAC ADDRESS</h3>";
								}
							
							
							
							//
							
							//creation of STRESPRG.sh
							unlink("project_build/$projectName/$buildConfigName/Working Folder/support/STRESPRG.sh");
							if(copy("project_build/$projectName/$buildConfigName/Working Folder/support/FCTPRG.sh","project_build/$projectName/$buildConfigName/Working Folder/support/STRESPRG.sh"))
							{
								echo "DUDE";
							}else
							{
								echo "rara";
							}
								

								
							//R2.5: CFGCHK.TXT.IN - START
							
							//read bc.sh line by line
							//if GOT TEST_N1100FX N1100FX is user input
							
								//get the whole line
								//get string inside "" into array
								//write this into CFGCHK.TXT.IN
								unlink ("project_build/$projectName/$buildConfigName/Working Folder/support/CFGCHK-TEMP.TXT.IN");
								
								$filePathToCheck = "project_build/$projectName/$buildConfigName/ALBERT/bc.sh";
								$lineToCheck = "TEST_N1100FX";
								$myfileCheck = fopen($filePathToCheck, "r") or die("Unable to open file!");
								$i=0;
								while (($lineToCheck = fgets($myfileCheck)) !== false) {
								//echo $lineToCheck; 
																
$mystring = $lineToCheck;
$findme   = "TEST_N1100FX";
$pos = strpos($mystring, $findme);
 

if ($pos === false) {
    //echo "NO FOUND";
} else {
	
	
	
$findmeSecond   = "@";
$posSecond = strpos($mystring, $findmeSecond);


if ($posSecond === false) {
    //echo "NO FOUND";
	$PCIE = $lineToCheck;
} else {
	
}
	
    
}
														
							
								}
								//echo $PCIE;	
							
								
echo $PCIEArray = explode('"',$PCIE);

print("<pre>".print_r($PCIEArray,true)."</pre>");	
echo $PCIEArray[1];//PCIE=
echo $PCIEArray[3];//PCIE=
echo $PCIEArray[5];//PCIE=
echo $PCIEArray[7];//PCIE=

$pcie1 = $PCIEArray[1]."\r\n";
$pcie2 = $PCIEArray[3]."\r\n";
$pcie3 = $PCIEArray[5]."\r\n";
$pcie4 = $PCIEArray[7]."\r\n";

$mfgload2Text = $PCIEArray[13]."\r\n";

$pcie1 = str_replace(" = "," : PCIE=",$pcie1);
$pcie2 = str_replace(" = "," : PCIE=",$pcie2);
$pcie3 = str_replace(" = "," : PCIE=",$pcie3);
$pcie4 = str_replace(" = "," : PCIE=",$pcie4);


								//TEST_N1100FX
			//unlink ("project_build/$projectName/$buildConfigName/Working Folder/support/CFGCHK.TXT.IN");					
			
			//
$file = fopen("project_build/$projectName/$buildConfigName/Working Folder/support/CFGCHK.TXT.IN","r");
$myfile = fopen("project_build/$projectName/$buildConfigName/Working Folder/support/CFGCHK-TEMP.TXT.IN", "a") or die("Unable to open file!");
fwrite($myfile, "#2 usage:  <DEV> :  PCIE=<PCIE_SETTING>  <FW_NAME1>=<version_string>  <FW_NAME2>=<version_string>  pciecrc=<CRC32_value> BOARD=<board_name>\r\n#                 DEV :   dev1 | dev2  | dev3 | ....\r\n");  

while(! feof($file))
  {
$content = fgets($file);
  
  $posContent = strpos($content, "PCIE=");


if ($posContent === false) {
    //echo "NO FOUND";
	fwrite($myfile, $content);  
} else {
	
}

  } 
fclose($myfile); 
fclose($file);
			
			
$myfile = fopen("project_build/$projectName/$buildConfigName/Working Folder/support/CFGCHK-TEMP.TXT.IN", "a") or die("Unable to open file!");
fwrite($myfile, $pcie1);  
fwrite($myfile, $pcie2);  
fwrite($myfile, $pcie3);  
fwrite($myfile, $pcie4);  
fclose($myfile); 

	unlink("project_build/$projectName/$buildConfigName/Working Folder/support/CFGCHK.TXT.IN");
	
	rename("project_build/$projectName/$buildConfigName/Working Folder/support/CFGCHK-TEMP.TXT.IN", "project_build/$projectName/$buildConfigName/Working Folder/support/CFGCHK.TXT.IN");
								
  echo "<br><br><br><br><br><br>";
//echo "<h1>SUCCESFULLY WRITE TO CFGCHK.SH</h1>";  

/////////R 2.6
//1.check the configuration (2D checksum) either selected or not and task_xxx.ini file
//2.do replace, insert, remove or do nothing

//step 1



$selectedParam = false;
$foundInFile = false;
 
$foundInFileAPPGenerateRevDev = false;

$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '3'");
							while($rowcol = mysqli_fetch_array($col)){
								$paramId = $rowcol['value']; 
							}
if($paramId!=""){$selectedParam = true;echo "<br><h1>param selected</h1>";}else {$selectedParam = false;echo "<br><h1>param NOT selected</h1>";}

//do checking on the task_xxx.ini file

$file = fopen("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini","r");

while(!feof($file))
  {
  $line = fgets($file);
  
  
  $posContent = strpos($line, "RevDevLabel1=MyRevDevLabel");


if ($posContent === false) {
    //echo "NO FOUND";
	 
} else {
	$foundInFile = true;
}

  }
  
  
  if($selectedParam==true && $foundInFile==true){ replaceINI("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName);}
  if($selectedParam==true && $foundInFile==false){ insertINI("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName);}
  if($selectedParam==false && $foundInFile==true){ removeINI("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName);}
  if($selectedParam==false && $foundInFile==false){  } // do nothing

fclose($file);

if($selectedParam==true && $foundInFile==true){
unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
}

if($selectedParam==true && $foundInFile==false){
unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
}

if($selectedParam==false && $foundInFile==true){
unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
}

if($selectedParam==false && $foundInFile==false){  } // do nothing




//002=APP::GenerateRevDev START 


  $file = fopen("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini","r");

  //checking APP::GenerateRevDev
while(!feof($file))
  {

  $line = fgets($file);

  
  $posContentRev = strpos($line, "GenerateRevDev");


if ($posContentRev === false) {
	
	
    //echo "NO FOUND";

	
} else {

	$foundInFileAPPGenerateRevDev = true;
}

  }

	
	
  if($selectedParam==true && $foundInFileAPPGenerateRevDev==true){ replace002INI("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName);}
  if($selectedParam==true && $foundInFileAPPGenerateRevDev==false){ insert002INI("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName);}
  if($selectedParam==false && $foundInFileAPPGenerateRevDev==true){ remove002INI("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName);}
  if($selectedParam==false && $foundInFileAPPGenerateRevDev==false){  } // do nothing


fclose($file);

if($selectedParam==true && $foundInFileAPPGenerateRevDev==true){
unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
}


if($selectedParam==true && $foundInFileAPPGenerateRevDev==false){
unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
}

if($selectedParam==false && $foundInFileAPPGenerateRevDev==true){
unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
}

//check    for 002-APPGenerateRevDev END

//check for 009=APP::ProgramVerifyFRU START

$foundInFileAPPVerifyFRU = false;

  $file = fopen("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini","r");

  //checking APP::ProgramVerifyFRU
while(!feof($file))
  {

  $line = fgets($file);

  
  $posContentRev = strpos($line, "APP::ProgramVerifyFRU");


if ($posContentRev === false) {
	
	
    //echo "NO FOUND";

	
} else {

	$foundInFileAPPVerifyFRU = true;
}

  }
  
$binFileFound = false;
$fileNameSearchBin = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
	
	foreach($fileNameSearchBin as $fileNameSBin)
	{
		if(strpos($fileNameSBin, ".bin") !== false)
		{
			$binFileFound = true;
			echo "Jumpa FILE";
			//FOUND
		} 
	}
	
  if($binFileFound==true && $foundInFileAPPVerifyFRU==true){ replace009INI("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName);}
  if($binFileFound==true && $foundInFileAPPVerifyFRU==false){ insert009INI("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName);}
  if($binFileFound==false && $foundInFileAPPVerifyFRU==true){ remove009INI("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName);}
  if($binFileFound==false && $foundInFileAPPVerifyFRU==false){  } // do nothing
			

fclose($file);

if($binFileFound==true && $foundInFileAPPVerifyFRU==true){
unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
}


if($binFileFound==true && $foundInFileAPPVerifyFRU==false){
unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
}

if($binFileFound==false && $foundInFileAPPVerifyFRU==true){
unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");	
}		
		//check for 009=APP::ProgramVerifyFRU END	

//check for 008=008=APP::FruUnlock START			


$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '37'");
							while($rowcol = mysqli_fetch_array($col)){
								$paramId = $rowcol['value']; 
							}
if($paramId!=""){$selectedParam = true;}else {$selectedParam = false;}

$foundInFileAPPFruUnlock = false;

  $file = fopen("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini","r");

  //checking APP::ProgramVerifyFRU
while(!feof($file))
  {

  $line = fgets($file);

  
  $posContentRev = strpos($line, "APP::FruUnlock");


if ($posContentRev === false) {
	
	
    //echo "NO FOUND";

	
} else {

	$foundInFileAPPFruUnlock = true;
}

  }

 
////////----///////////////


if($binFileFound)
{
	echo "<br><h1>BIN FOUND</h1>";
  if($selectedParam==true && $foundInFileAPPFruUnlock == true){ echo "<br><br><h1>IGNORE APPFruUnlock</h1>"; }
 if($selectedParam==false && $foundInFileAPPFruUnlock == true){ 


		echo "<br><br><h1>HANDLE APPFruUnlock</h1>";

remove008INIA("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName); 
 

unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

 }
 
  if($selectedParam==true && $foundInFileAPPFruUnlock == false){ 


		echo "<br><br><h1>INSERT ALL 008,009,010</h1>";

insert008INI("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName); 
 

unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

 }
 
 
}else
	
{
	echo "<br><h1>BIN NOT FOUND</h1>";
	if($selectedParam==true && $foundInFileAPPFruUnlock == true){

		echo "<br><br><h1>HANDLE APPFruUnlock</h1>";

remove008INI("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName); 
 

unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

	}
	
	if($selectedParam==false && $foundInFileAPPFruUnlock == true){

		echo "<br><br><h1>HANDLE APPFruUnlock</h1>";

remove008INI("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName); 
 

unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

	}
	
	
	if($selectedParam==false && $foundInFileAPPFruUnlock == false){

		echo "<br><br><h1>Remove 008, 009, 010</h1>";

remove008INI("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName); 
 

unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

	}
	
}


 
////////----///////////////




//check for 008=008=APP::FruUnlock END			


//008=APP::FruUnlock
//009=APP::ProgramVerifyFRU
//010=APP::FruLock

//check on the last line
fclose($file);

$file = "project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini";
$data = file($file);
$lastline = $data[count($data)-1];

 if(strpos($lastline, "ProgramVerifyFRU") !== false){
			  
				  $lastline = "";
				  echo "NO LAST LINE";
			  }else
			  {
				   $lastline = ";insert by system\r\n008=APP::ProgramVerifyFRU\r\n";
			echo "LAST LINE";
			  }

$fp = fopen($file, 'a');//opens file in append mode  
fwrite($fp, $lastline);  
fclose($fp);  


//now need to count the item in [ProductionTasks]
				//exit();						
							
							//R2.5: CFGCHK.TXT.IN - END

//count the number using php_ini
$arrayFile = parse_ini_file($file,true);
 

echo $countProdTask = count($arrayFile['ProductionTasks']);
//$arrayFile['ProductionTasks']['Num_Task'] = $countProdTask-1;
$taskQty = $countProdTask-1;
print("<pre>".print_r($arrayFile,true)."</pre>");

writeNumbers("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName, $taskQty); 

unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

removeTaskNumProd($file, $paramId, $projectName, $buildConfigName);

unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");



removeUnWanted($file, $paramId, $projectName, $buildConfigName);

unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

writeNumbersProd("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini", $paramId, $projectName, $buildConfigName, $taskQty); 

unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
 

removeUnWantedNum($file, $paramId, $projectName, $buildConfigName);

unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

rewriteProductionTasks($file, $paramId, $projectName, $buildConfigName);

unlink("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
rename("project_build/$projectName/$buildConfigName/Working Folder/test.ini","project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

/////////////// R2.4 starts ////////////////
unlink("project_build/$projectName/$buildConfigName/Working Folder/support/QA.sh");
copy("project_build/$projectName/$buildConfigName/Working Folder/support/FCTTEST.sh","project_build/$projectName/$buildConfigName/Working Folder/support/QA.sh");

replaceQA1("project_build/$projectName/$buildConfigName/Working Folder/support/QA.sh", $paramId, $projectName, $buildConfigName);
unlink("project_build/$projectName/$buildConfigName/Working Folder/QA.sh");
rename("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","project_build/$projectName/$buildConfigName/Working Folder/support/QA.sh");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");


replaceQA2("project_build/$projectName/$buildConfigName/Working Folder/support/QA.sh", $paramId, $projectName, $buildConfigName);
unlink("project_build/$projectName/$buildConfigName/Working Folder/QA.sh");
rename("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","project_build/$projectName/$buildConfigName/Working Folder/support/QA.sh");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

insertQA("project_build/$projectName/$buildConfigName/Working Folder/support/QA.sh", $paramId, $projectName, $buildConfigName);
unlink("project_build/$projectName/$buildConfigName/Working Folder/QA.sh");
rename("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","project_build/$projectName/$buildConfigName/Working Folder/support/QA.sh");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

insertQAif("project_build/$projectName/$buildConfigName/Working Folder/support/QA.sh", $paramId, $projectName, $buildConfigName);
unlink("project_build/$projectName/$buildConfigName/Working Folder/QA.sh");
rename("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","project_build/$projectName/$buildConfigName/Working Folder/support/QA.sh");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

replacemfgload("project_build/$projectName/$buildConfigName/Working Folder/support/QA.sh", $paramId, $projectName, $buildConfigName, $mfgload2Text);
unlink("project_build/$projectName/$buildConfigName/Working Folder/QA.sh");
rename("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","project_build/$projectName/$buildConfigName/Working Folder/support/QA.sh");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");



$foundInFileGrep = false;


$file = fopen("project_build/$projectName/$buildConfigName/Working Folder/support/FCTTEST.sh","r");

while(!feof($file))
  { 
  $line = fgets($file);
  
  
  $posContent = strpos($line, "insmod");


if ($posContent === false) {
    //echo "NO FOUND";
	$foundInFileGrep = true;
	echo "foundInFileGrep";
	
	 
} else {
	$foundInFileGrep = true;
	echo "foundInFileGrep";
}

  }
  
  
  $test3Text = $PCIEArray[15]."\r\n";
  
  
  //if insmod not there, put the long one,
  
  
replaceforins("project_build/$projectName/$buildConfigName/Working Folder/support/FCTTEST.sh", $paramId, $projectName, $buildConfigName, $mfgload2Text);
unlink("project_build/$projectName/$buildConfigName/Working Folder/FCTTEST.sh");
rename("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","project_build/$projectName/$buildConfigName/Working Folder/support/FCTTEST.sh");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");


insertAfterLine("project_build/$projectName/$buildConfigName/Working Folder/support/FCTTEST.sh", $paramId, $projectName, $buildConfigName);


replacemfgloadSecond("project_build/$projectName/$buildConfigName/Working Folder/support/FCTTEST.sh", $paramId, $projectName, $buildConfigName, $test3Text);
unlink("project_build/$projectName/$buildConfigName/Working Folder/FCTTEST.sh");
rename("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","project_build/$projectName/$buildConfigName/Working Folder/support/FCTTEST.sh");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

unlink("project_build/$projectName/$buildConfigName/Working Folder/support/STRESTST.sh");
copy("project_build/$projectName/$buildConfigName/Working Folder/support/FCTTEST.sh","project_build/$projectName/$buildConfigName/Working Folder/support/STRESTST.sh");

replaceStres("project_build/$projectName/$buildConfigName/Working Folder/support/STRESTST.sh", $paramId, $projectName, $buildConfigName);
unlink("project_build/$projectName/$buildConfigName/Working Folder/STRESTST.sh");
rename("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","project_build/$projectName/$buildConfigName/Working Folder/support/STRESTST.sh");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

replaceStresFirst("project_build/$projectName/$buildConfigName/Working Folder/support/STRESTST.sh", $paramId, $projectName, $buildConfigName, $test3Text);
unlink("project_build/$projectName/$buildConfigName/Working Folder/STRESTST.sh");
rename("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","project_build/$projectName/$buildConfigName/Working Folder/support/STRESTST.sh");
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");

unlink("project_build/$projectName/$buildConfigName/Working Folder/STRESTST_WORK.sh");

/////////////// R2.4 end ////////////////

/////////////// R2.7 start ////////////////

projectCodeWrite($projectName, $buildConfigName);

if($binFileFound)
{

projectCodeWriteSecond($projectName, $buildConfigName);

							
}


//DO THE CHECKING FOR ALL 

?>

<form action="index.php?page=compilation-start&id=<?php echo $_GET["id"] ?>" method="GET">
<table class="table table-bordered" style="width: 50%">
                <tr>
                  <th style="width: 50px">FIELD</th>
                  <th style="width: 200px">PROCEED IF VERSION NOT MATCH</th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">MBA</th>
                  <th style="width: 200px"><input type="checkbox" id="mba" name="mba" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">APE FIRMWARE</th>
                  <th style="width: 200px"><input type="checkbox" id="ape_firmware" name="ape_firmware" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">CCM</th>
                  <th style="width: 200px"><input type="checkbox" id="ccm" name="ccm" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">CFWP</th>
                  <th style="width: 200px"><input type="checkbox" id="cfwp" name="cfwp" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">CFW</th>
                  <th style="width: 200px"><input type="checkbox" id="cfw" name="cfw" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">ISCSI BOOT</th>
                  <th style="width: 200px"><input type="checkbox" id="iscsi_boot" name="iscsi_boot" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">BFW</th>
                  <th style="width: 200px"><input type="checkbox" id="BFW" name="BFW" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">PCIE</th>
                  <th style="width: 200px"><input type="checkbox" id="pcie" name="pcie" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">PCFG00</th>
                  <th style="width: 200px"><input type="checkbox" id="pcfg00" name="pcfg00" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">PCFG01</th>
                  <th style="width: 200px"><input type="checkbox" id="pcfg01" name="pcfg01" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">SCFG</th>
                  <th style="width: 200px"><input type="checkbox" id="scfg" name="scfg" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">CFW CHECKSUM</th>
                  <th style="width: 200px"><input type="checkbox" id="cfwchksum" name="cfwchksum" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">CFWP CHECKSUM</th>
                  <th style="width: 200px"><input type="checkbox" id="cfwpchksum" name="cfwpchksum" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">CFWP CHECKSUM</th>
                  <th style="width: 200px"><input type="checkbox" id="cfwpchksum" name="cfwpchksum" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">AFW CHECKSUM</th>
                  <th style="width: 200px"><input type="checkbox" id="afwchksum" name="afwchksum" value="1"></th>
                </tr>
				
				
				<tr>                  
                  <th style="width: 50px">CCM CHECKSUM</th>
                  <th style="width: 200px"><input type="checkbox" id="ccmchksum" name="ccmchksum" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">BFWCH CHECKSUM</th>
                  <th style="width: 200px"><input type="checkbox" id="bfwchksum" name="bfwchksum" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">TSCF CHECKSUM</th>
                  <th style="width: 200px"><input type="checkbox" id="tscfchksum" name="tscfchksum" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">IBOOT CHECKSUM</th>
                  <th style="width: 200px"><input type="checkbox" id="ibootchksum" name="ibootchksum" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">IBCFG00 CHECKSUM</th>
                  <th style="width: 200px"><input type="checkbox" id="ibcfg00" name="ibcfg00" value="1"></th>
                </tr>
				
				<tr>                  
                  <th style="width: 50px">IBCFG01 CHECKSUM</th>
                  <th style="width: 200px"><input type="checkbox" id="ibcfg01" name="ibcfg01" value="1"></th>
                </tr>
		
		
				
				
</table>
<input type="hidden" name="page" id="page" value="compilation-start">
<input type="hidden" name="id" id="id" value="<?php echo $_GET["id"] ?>">

<input class="btn btn-block btn-success btn-sm" type="submit" value="PROCEED">
</form><br>
<a href="javascript:history.go(-1)"><button type="button" class="btn btn-block btn-warning btn-sm">CANCEL</button></a>
<br><br><br>



	
<?php



projectCodeWriteMba($projectName, $buildConfigName);

projectCodeWrite_ape_firmware($projectName, $buildConfigName);

projectCodeWriteCCM($projectName, $buildConfigName);

projectCodeWriteCFWP($projectName, $buildConfigName);

projectCodeWriteCFW($projectName, $buildConfigName);
 

//iscsi_boot=214.0.152.
projectCodeWriteIScsi($projectName, $buildConfigName);


//bfw=214.0.194.0
//projectCodeWriteBFW($projectName, $buildConfigName);
projectCodeWriteVersion($projectName, $buildConfigName, "BFW");
//projectCodeWriteVersion($projectName, $buildConfigName, "PCIE");
projectCodeWritePCIE($projectName, $buildConfigName);

projectCodeWritePgfg00($projectName, $buildConfigName);
projectCodeWritePgfg01($projectName, $buildConfigName);

projectCodeWriteVersion($projectName, $buildConfigName, "SCFG");
projectCodeWriteVersion($projectName, $buildConfigName, "AFW");
projectCodeWriteVersion($projectName, $buildConfigName, "BFW");

projectCodeWriteTSCF($projectName, $buildConfigName);
projectCodeWriteIBoot($projectName, $buildConfigName);

projectCodeWriteIbcfg00($projectName, $buildConfigName);
projectCodeWriteIbcfg01($projectName, $buildConfigName);

templateSize($projectName, $buildConfigName);

brcmFBCheckSum($projectName, $buildConfigName);
brcmFBCheckSumLineTwo($projectName, $buildConfigName);
brcmFBCheckSumLineThree($projectName, $buildConfigName);
OEMRecordHeader($projectName, $buildConfigName);
OEMRecordHeaderCheckSum($projectName, $buildConfigName);
OEMStartCheckSum($projectName, $buildConfigName);
compressToTar($projectName, $buildConfigName);



/////////////// R2.7 end ////////////////
							?>
							
	<?
	
	//sleep(3);
	
	?>
	<br><br>
	

	
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



							
