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
								
							}
							
							$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '3'");
							while($rowcol = mysqli_fetch_array($col)){
								$paramId = $rowcol['paramId']; 
								
								
							}
							/*
							//do the untar here
							
							$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
							//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
							foreach($fileNameSearch as $fileNameS)
							{
								
								
								if(strpos($fileNameS, ".gz") !== false)
								{
									
									$p = new PharData("project_build/$projectName/$buildConfigName/Working Folder/support/".$fileNameS);
									$p->decompress('/'); // creates /path/to/my.tar
									$fileNameS = str_replace("gz","",$fileNameS);
									// unarchive from the tar
									$phar = new PharData("project_build/$projectName/$buildConfigName/Working Folder/support/".$fileNameS);
									$phar->extractTo("project_build/$projectName/$buildConfigName/Working Folder/support/aaa");
									
									unlink("project_build/$projectName/$buildConfigName/Working Folder/support/".$fileNameS);
									
									
								}
							}
							
								$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/aaa/");
								$folderName = $fileNameSearch[2]."".$fileNameSearch[3];
						
							$folderName = str_replace(".tar.gz","",$folderName);
							rename("project_build/$projectName/$buildConfigName/Working Folder/support/aaa/","project_build/$projectName/$buildConfigName/Working Folder/support/".$folderName."/");
							copy("modules/input/files_master_file_versioning/extracted/Master File Versioning/Setup.sh","project_build/$projectName/$buildConfigName/Working Folder/support/".$folderName."/Setup.sh");
							
							//unlink ("project_build/$projectName/$buildConfigName/Working Folder/support/".$folderName."/install.sh");
							
							
						
echo $tarfile = $folderName.".tar";
$pd = new \PharData($tarfile);
$pd->buildFromDirectory("project_build/$projectName/$buildConfigName/Working Folder/support/".$folderName."/");
$pd->compress(\Phar::GZ);
							
							if(copy($folderName.".tar.gz","project_build/$projectName/$buildConfigName/Working Folder/".$folderName.".tar.gz"))
							{
								echo "<h1>".$folderName.".tar.gz COPIED</h1><br>";
								unlink ($folderName.".tar.gz");
								unlink ($folderName.".tar");
							}else
							{
								echo "<h1>NOT COPIED</h1><br>";
							}
							echo "<h1>CHECK </h1>".$file_name; 
							//exit();
							
							
							
							
							
							
							
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
								
								*/
								
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
$ini_array = parse_ini_file("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx.ini",true);

//[Num_Session] => 0

echo $ini_array['UUT_Status']['Label1']="PLine,EVRam,OBA,GSAM";
echo $ini_array['UUT_Status']['RevDevLabel1']="PLine,EVRam,OBA,GSAM";


print("<pre>".print_r($ini_array,true)."</pre>");

function array_to_ini($array,$out="")
{
    $t="";
    $q=false;
    foreach($array as $c=>$d)
    {
        if(is_array($d))$t.=array_to_ini($d,$c);
        else
        {
            if($c===intval($c))
            {
                if(!empty($out))
                {
                    $t.="\r\n".$out." = ".$d."";
                    if($q!=2)$q=true;
                }
                else $t.="\r\n".$d;
            }
            else
            {   
                $t.="\r\n".$c." = ".$d."";
                $q=2;
            }
        }
    }
    if($q!=true && !empty($out)) return "[".$out."]\r\n".$t;
    if(!empty($out)) return  $t;
    return trim($t);
}



function save_ini_file($array,$file)
{
    $a=array_to_ini($array);
    $ffl=fopen($file,"w");
    fwrite($ffl,$a);
    fclose($ffl);
}

//this is to write to INI file
save_ini_file($ini_array,"project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx_.ini");

unlink ("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx_1.ini");

$myfileAppend = fopen("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx_1.ini", "a") or die("Unable to open file!");
 


//read INI file 
$file = fopen("project_build/$projectName/$buildConfigName/Working Folder/TaskState_xxx_.ini","r");

while(! feof($file)) {
  $line = fgets($file);
  

if (strpos($line, "Num_Slot = 1") === false) {
    //echo "NO FOUND";
	$line = $line;
} else {
	$line = "[Test_System]
Num_Slot=2
;these should match the options in the controller list Ctrl provides\r\n";
}

if (strpos($line, "Test_Mode") === false) {
    //echo "NO FOUND";
	$line = $line;
} else {
	$line = $line."

[UUT_Status]
";
}





  fwrite($myfileAppend, $line); 
}

fclose($file);
fclose($myfileAppend); 

/*

//Serialize the array.
$serialized = serialize($ini_array);
 
//Save the serialized array to a text file.
file_put_contents('serialized.txt', $serialized);
 
//Retrieve the serialized string.
$fileContents = file_get_contents('serialized.txt');
 
//Unserialize the string back into an array.
$arrayUnserialized = unserialize($fileContents);
 
//End result.
var_dump($arrayUnserialized);
*/
				exit();						
							
							//R2.5: CFGCHK.TXT.IN - END
							
							
							
							?>
							
							
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



