<?php

$pathToFile = '../../logfile.txt'; //this is to record log file for debugging purpose//afdzal

function replaceINI($file, $paramId, $projectName, $buildConfigName){ 
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  {
  echo $line = fgets($file);
   
			  
			  if(strpos($line, "RevDevLabel1=") !== false){
			   $line = "RevDevLabel1=MyRevDevLabel\r\n";
			
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}


function replace002INI($file, $paramId, $projectName, $buildConfigName){ 
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  {
  $line = fgets($file);
  
			  
			  if(strpos($line, "APP::GenerateRevDev") !== false){
			   $line = $line;
			
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}




function replaceQA1($file, $paramId, $projectName, $buildConfigName){  
unlink("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini");  
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  { 
  $line = fgets($file);
  
			  
			   if(strpos($line, "echo ./mfgload.sh -sysop -no_swap -none -T A1D3E1 -cfgchk CFGCHK.TXT.IN -log $output_file") !== false){
			   $line = "echo ./mfgload.sh -sysop -no_swap -none -T A1D3E1 -log $output_file\r\n";
			
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}



function replaceQA2($file, $paramId, $projectName, $buildConfigName){  
unlink("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini");  
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  { 
  $line = fgets($file);
  
			  
			   if(strpos($line, "./mfgload.sh -sysop -no_swap -none -T A1D3E1 -cfgchk CFGCHK.TXT.IN -log $output_file") !== false){
			   $line = "./mfgload.sh -sysop -no_swap -none -T A1D3E1 -log $output_file\r\n";
			
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}



function insertQA($file, $paramId, $projectName, $buildConfigName){  
unlink("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini");  
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  { 
  $line = fgets($file);
  
			  
			   if(strpos($line, "rm $output_file") !== false){
			   $line = "rm \$output_file\r\nfifi";
			
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}


function projectCodeWrite($projectName, $buildConfigName){  
global $con;
unlink("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd");  
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");
$file = fopen($file,"r");
echo "project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd";

//;


 $sql = "SELECT count(*) as projectCount FROM buildConfig where projectName = '$projectName'";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {
			
         $count = $row["projectCount"];
			
		}
	$count = str_pad($count, 3, "0", STR_PAD_LEFT);
fwrite($fileWrite,$projectName."_$count\r\n");
fwrite($fileWrite,"BROADCOM\r\n");

$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	foreach($fileNameSearch as $fileNameS)
	{
		
		
		if(strpos($fileNameS, ".img") !== false)
		{
			//file found
			fwrite($fileWrite,$fileNameS." ");
			$imgFile = $fileNameS;
		}
		
		if(strpos($fileNameS, "A0.bin") !== false)
		{
			//file found
			fwrite($fileWrite,$fileNameS."\r\n");
			$binFile = $fileNameS;
		}
		
		
	}
	
	fwrite($fileWrite,"NVRAM=".$imgFile."\r\n");
	fwrite($fileWrite,"FRU=".$binFile."\r\n");
	
	
	 $sql = "SELECT * from buildConfig where buildConfigName = '$buildConfigName'";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {
			
         $buildId = $row["id"];
			
		}
		
	
 $sql = "SELECT * FROM buildConfigParam where bcId = '$buildId' and paramId = '12'";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {			
         $value = $row["value"];			
		}
		
	fwrite($fileWrite,"Oem_name=".$value."\r\n");
	
	$sql = "SELECT * FROM buildConfigParam where bcId = '$buildId' and paramId = '9'";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {			
         $mac = $row["value"];			
		}
		
	fwrite($fileWrite,"Num_Of_Ieee_Address=".$mac."\r\n");
	
	$sql = "SELECT * FROM buildConfigParam where bcId = '$buildId' and paramId = '3'";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {			
         $value = $row["value"];			
		}
		
	fwrite($fileWrite,"RevDevLabel=1\r\n\r\n;first mac only\r\n");
	fwrite($fileWrite,"MAC_multiple=".$mac."\r\n");
	
	$sql = "SELECT * FROM project where productName = '$projectName'";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {	
			$brcmMinIsoFW = $row["brcmMinIsoFw"];
			$brcmMinIsoFWs = explode("=", $brcmMinIsoFW);			
			$brcmMinIsoFW = $brcmMinIsoFWs[1];
			
			$brcmMinDstVer = $row["brcmMinDstVer"];
			$brcmMinDstVers = explode("=", $brcmMinDstVer);			
			$brcmMinDstVer = $brcmMinDstVers[1];
			
			$brcmDstWinCtrl = $row["brcmDstWinCtrl"];		 
			$brcmDstWinCtrls = explode("=", $brcmDstWinCtrl);			
			$brcmDstWinCtrl = $brcmDstWinCtrls[1];
		}
	
	fwrite($fileWrite,"MinIsoFWVer=".$brcmMinIsoFW."\r\n");
	fwrite($fileWrite,";update software version to most recent release\r\n");	
	fwrite($fileWrite,"MinDST1Ver=".$brcmMinDstVer."\r\n");
	fwrite($fileWrite,"MinDSTWinCtrlVer=".$brcmDstWinCtrl."\r\n");
	fwrite($fileWrite,";------------------------------- MODEL PARAMS-----------------------------------\r\n");
	fwrite($fileWrite,";from verifyLabel\r\n\r\n");
	
	


fclose($fileWrite);




}

function projectCodeWriteMba($projectName, $buildConfigName){  
global $con;

$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "MBA") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-ANDY";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "MBA") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-ANDY";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "MBA") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAlbert = $lineOnes[1];
					echo "ALBERTo";
					echo $mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "MBA") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					echo "<br>";
					echo $mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "<br>";
					echo "ALBERTas";
					echo "<br>";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "<h3><br><br><br>THE MBA VALUE DOES MATCH</h3><br>";
					echo "WRITE";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"MBA=".$mbaVersionAlbert."");
					fwrite($fileWrite,"MBACHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3><br><br><br>THE MBA VALUE DOES NOT MATCH</h3><br>";
					if($_GET["mba"]=="1")
					{
					echo "<h3>PROCEED WITH MBA VALUE</h3><br>";
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"MBA=".$mbaVersionAlbert."");
					fwrite($fileWrite,"MBACHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					fwrite($fileWrite,"MBA=214.0.0.0");
					fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);

}


function projectCodeWrite_ape_firmware($projectName, $buildConfigName){
	
	 
global $con;

$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "APE_FIRMWARE") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-ANDY";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "APE_FIRMWARE") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-ANDY";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "APE_FIRMWARE") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAlbert = $lineOnes[1];
					echo "APE_FIRMWARE";
					echo $mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "APE_FIRMWARE") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					echo "<br>";
					echo $mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "<br>";
					echo "ALBERTas";
					echo "<br>";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "<h3><br><br><br>THE MBA VALUE DOES MATCH</h3><br>";
					echo "WRITE";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"MBA=".$mbaVersionAlbert."");
					fwrite($fileWrite,"MBACHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3><br><br><br>THE APE_FIRMWARE VALUE DOES NOT MATCH</h3><br>";
					if($_GET["ape_firmware"]=="1")
					{
					echo "<h3>PROCEED WITH APE_FIRMWARE VALUE</h3><br>";
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"APE_FIRMWARE=".$mbaVersionAlbert."");
					fwrite($fileWrite,"APE_FIRMWARECHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>APE_FIRMWARE VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"APE_FIRMWARE=214.0.0.0\r\n");
					//fwrite($fileWrite,"APE_FIRMWARECHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);


}


function projectCodeWriteCFWP($projectName, $buildConfigName){  
global $con;
echo "<br><br><br>";
echo "--------CFWP----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "CFWP") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "CFWP") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-CFWP";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "CFWP") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAlbert = $lineOnes[1];
					echo "CFWP";
					echo $mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "CFWP") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					$mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "CFWP";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "WRITE";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"CFWP=".$mbaVersionAlbert."");
					fwrite($fileWrite,"CFWPCHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3>THE CFWP VALUE DOES NOT MATCH</h3><br>";
					if($_GET["cfwp"]=="1")
					{
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"CFWP=".$mbaVersionAlbert."");
					fwrite($fileWrite,"CFWPCHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"MBA=214.0.0.0-\r\n");
					//fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);

}


function projectCodeWriteBFW($projectName, $buildConfigName){  
global $con;
echo "<br><br><br>";
echo "--------BFW----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "BFW") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "BFW") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-BFW";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "BFW") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAlbert = $lineOnes[1];
					echo "BFW";
					echo $mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "BFW") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					$mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "BFW";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "WRITE";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"BFW=".$mbaVersionAlbert."");
					fwrite($fileWrite,"BFWCHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3>THE BFW VALUE DOES NOT MATCH</h3><br>";
					if($_GET["bfw"]=="1")
					{
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"BFW=".$mbaVersionAlbert."");
					fwrite($fileWrite,"BFWCHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"MBA=214.0.0.0-\r\n");
					//fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);

}



function projectCodeWriteVersion($projectName, $buildConfigName, $versionType){  
global $con;
echo "<br><br><br>";
echo "--------".$versionType."----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, $versionType) !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "HERE<br><br>";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, $versionType) !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-".$versionType;
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, $versionType) !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAlbert = $lineOnes[1];
					echo $versionType;
					echo $mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, $versionType) !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					$mbaVersionAlbertCheckSum = $lineOnes[1];
					echo $versionType;
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "WRITE1";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,$versionType."=".$mbaVersionAlbert."");
					fwrite($fileWrite,$versionType."CHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3>THE ".$versionType." VALUE DOES NOT MATCH</h3><br>";
					if($_GET[$versionType]=="1")
					{
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,$versionType."=".$mbaVersionAlbert."");
					fwrite($fileWrite,$versionType."CHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"MBA=214.0.0.0-\r\n");
					//fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);

}


function projectCodeWriteIScsi($projectName, $buildConfigName){  
global $con;
echo "<br><br><br>";
echo "--------ISCSI----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "iSCSI_Boot") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					
					$mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					echo $mbaVersionAndy = str_replace("IPV4_IPV6","",$mbaVersionAndy);
					
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "iSCSI_Boot") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-iSCSI_Boot";
					$mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					echo $mbaVersionAndy = str_replace("IPV4_IPV6","",$mbaVersionAndy);
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "iSCSI_Boot") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAlbert = $lineOnes[1];
					echo "iSCSI_Boot";
					$mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					echo $mbaVersionAlbert = str_replace("IPV4_IPV6","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "iSCSI_Boot") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					$mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "iSCSI_Boot-";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "WRITE";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"iSCSI_Boot=".$mbaVersionAlbert."");
					fwrite($fileWrite,"iSCSI_BootCHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3>THE iSCSI_Boot VALUE DOES NOT MATCH</h3><br>";
					if($_GET["cfwp"]=="1")
					{
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"iSCSI_Boot=".$mbaVersionAlbert."");
					fwrite($fileWrite,"iSCSI_BootCHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"MBA=214.0.0.0-\r\n");
					//fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);

}



function projectCodeWriteIBoot($projectName, $buildConfigName){  
global $con;
echo "<br><br><br>";
echo "--------IBoot----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "IBOOT") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					
					$mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					echo $mbaVersionAndy = str_replace("IPV4_IPV6","",$mbaVersionAndy);
					
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "IBOOT") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-IBOOT";
					$mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					echo $mbaVersionAndy = str_replace("IPV4_IPV6","",$mbaVersionAndy);
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "IBOOT") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAlbert = $lineOnes[1];
					echo "IBOOT";
					$mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					echo $mbaVersionAlbert = str_replace("IPV4_IPV6","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "IBOOT") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					$mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "IBOOT-";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "WRITE";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"IBOOT=".$mbaVersionAlbert."");
					fwrite($fileWrite,"IBOOTCHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3>THE IBOOT VALUE DOES NOT MATCH</h3><br>";
					if($_GET["ibootchksum"]=="1")
					{
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"IBOOT=".$mbaVersionAlbert."");
					fwrite($fileWrite,"IBOOTCHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"MBA=214.0.0.0-\r\n");
					//fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);

}



function projectCodeWriteCFW($projectName, $buildConfigName){  
global $con;
echo "<br><br><br>";
echo "--------CFW----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "CFW     ") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "CFW     ") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-CFW";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "CFW     ") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					echo $mbaVersionAlbert = $lineOnes[1];
					echo "CFW-POL";
					echo $mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "CFW    ") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					$mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "CFW--";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "WRITE---";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"CFW=".$mbaVersionAlbert."");
					fwrite($fileWrite,"CFWCHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3>THE CFW VALUE DOES NOT MATCH</h3><br>";
					if($_GET["cfw"]=="1")
					{
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"CFW=".$mbaVersionAlbert."");
					fwrite($fileWrite,"CFWCHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"MBA=214.0.0.0-\r\n");
					//fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);

}



function projectCodeWritePCIE($projectName, $buildConfigName){
	
	
global $con;
echo "<br><br><br>";
echo "--------PCIE----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "PCIE    ") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "PCIE    ") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-PCIE    ";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
			echo "<br><br>";	
	echo $file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	echo "<br><br>";	echo "<br><br>";	
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	 $line = fgets($file);

	if((strpos($line, "PCIE    ") !== false) && (strpos($line, ")") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					echo "asal";
					echo $lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					echo $mbaVersionAlbert = $lineOnes[1];
					echo "PCIE-POL";
					echo $mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "PCIE") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					$mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "PCIE--";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		echo $mbaVersionAlbert;
		echo "<br><br>";
		echo $mbaVersionAndy;
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "WRITE---";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"PCIE=".$mbaVersionAlbert."");
					fwrite($fileWrite,"PCIECHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3>THE PCIE VALUE DOES NOT MATCH</h3><br>";
					if($_GET["pcie"]=="1")
					{
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"PCIE=".$mbaVersionAlbert."\r\n");
					fwrite($fileWrite,"PCIECHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"MBA=214.0.0.0-\r\n");
					//fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);

}

function projectCodeWriteTSCF($projectName, $buildConfigName){
	
	
global $con;
echo "<br><br><br>";
echo "--------TSCF----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "TSCF    ") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "TSCF    ") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-TSCF    ";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
			echo "<br><br>";	
	echo $file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	echo "<br><br>";	echo "<br><br>";	
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	 $line = fgets($file);

	if((strpos($line, "TSCF    ") !== false) && (strpos($line, ")") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					echo "asal";
					echo $lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					echo $mbaVersionAlbert = $lineOnes[1];
					echo "TSCF-POL";
					echo $mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "TSCF") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					$mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "TSCF--";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		echo $mbaVersionAlbert;
		echo "<br><br>";
		echo $mbaVersionAndy;
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "WRITE---";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"TSCF=".$mbaVersionAlbert."");
					fwrite($fileWrite,"TSCFCHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3>THE TSCF VALUE DOES NOT MATCH</h3><br>";
					if($_GET["tscf"]=="1")
					{
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"TSCF=".$mbaVersionAlbert."\r\n");
					fwrite($fileWrite,"TSCFCHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"MBA=214.0.0.0-\r\n");
					//fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);

}


function projectCodeWriteCCM($projectName, $buildConfigName){  
global $con;
echo "<br><br><br>";
echo "--------CCM----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "CCM") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "CCM") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-CCM";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "CCM") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAlbert = $lineOnes[1];
					echo "CCM";
					echo $mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "CCM") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					$mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "CCM";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "WRITE";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"CCM=".$mbaVersionAlbert."");
					fwrite($fileWrite,"CCMCHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3>THE CCM VALUE DOES NOT MATCH</h3><br>";
					if($_GET["ccm"]=="1")
					{
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"CCM=".$mbaVersionAlbert."");
					fwrite($fileWrite,"CCMCHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"MBA=214.0.0.0-\r\n");
					//fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);

}


function projectCodeWritePgfg00($projectName, $buildConfigName){  
global $con;
echo "<br><br><br>";
echo "--------PGFG 01 ----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "PCFG    00") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "PCFG    00") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-PCFG    00";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "PCFG    00") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAlbert = $lineOnes[1];
					echo "PCFG    00";
					echo $mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "PCFG   00") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					$mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "PCFG    00";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "WRITE";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"PCFG00=".$mbaVersionAlbert."");
					fwrite($fileWrite,"PCFG00CHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3>THE PCFG 00 VALUE DOES NOT MATCH</h3><br>";
					if($_GET["pcfg00"]=="1")
					{
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"PCFG00=".$mbaVersionAlbert."");
					fwrite($fileWrite,"PCFG00CHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"MBA=214.0.0.0-\r\n");
					//fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);

}

function projectCodeWritePgfg01($projectName, $buildConfigName){  
global $con;
echo "<br><br><br>";
echo "--------PGFG 01 ----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "PCFG    01") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "PCFG    01") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-PCFG    01";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "PCFG    01") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAlbert = $lineOnes[1];
					echo "PCFG    01";
					echo $mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "PCFG   01") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					$mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "PCFG    01";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "WRITE";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"PCFG01=".$mbaVersionAlbert."");
					fwrite($fileWrite,"PCFG01CHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3>THE PCFG 01 VALUE DOES NOT MATCH</h3><br>";
					if($_GET["pcfg01"]=="1")
					{
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"PCFG01=".$mbaVersionAlbert."");
					fwrite($fileWrite,"PCFG01CHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"MBA=214.0.0.0-\r\n");
					//fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);

}

function projectCodeWriteIbcfg00($projectName, $buildConfigName){  
global $con;
echo "<br><br><br>";
echo "--------IB_CFG  00 ----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "IB_CFG  00") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "IB_CFG  00") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-IB_CFG  00";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "IB_CFG  00") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAlbert = $lineOnes[1];
					echo "IBFC    00";
					echo $mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "IB_CFG 00") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					$mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "IB_CFG  00";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "WRITE";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"IBCFG00=".$mbaVersionAlbert."");
					fwrite($fileWrite,"IBCFG00CHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3>THE IBCFG00 00 VALUE DOES NOT MATCH</h3><br>";
					if($_GET["ibcfg00"]=="1")
					{
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"IBCFG00=".$mbaVersionAlbert."");
					fwrite($fileWrite,"IBCFG00CHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"MBA=214.0.0.0-\r\n");
					//fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		
fclose($fileWrite);

}

function getHexFromBinFile($fileName)
{

// Source File to Open
//$sourceFile = 'project_build/logitech/loigc_01/Working Folder/support/M1100G_fru_A2.bin';
$sourceFile = $fileName;
// Output File Name, or if blank, outputs to php://output (stdout is less dependable) (probably the screen, barring output buffering)
// Large files may crash your browser.
$outputFile = "";

// Chunk size. Only relevant for visual cases. 16 is typical, and the default.
$chunkSize = 16;

// End of line character used. PHP_EOL is the default, though you can change it to whatever you want \r\n, LOL, etc.
$eolString = PHP_EOL;

// Allows segments to be split up visually (16 byte rows, split at 4 bytes). False to disable.
$visualSplit = 8;


// ------------------------ \\
// | End of Configuration | \\
// ------------------------ \\


// Param Defaults
if ($outputFile=='') {
	$outputFile = 'php://output';
}
$position = $innerIterator = $maxRowLen = 0;
$rawView = '';

if ($visualSplit>=$chunkSize) { // Disable when it doesn't make sense.
	$visualSplit = false;
}
if ($chunkSize<1) {
	$chunkSize = 16;
}

// If we're not on the command line, emit header to prevent broken formatting and file execution.
if (PHP_SAPI!='cli') {
	header("Content-Type: text/plain");
}

// General File Checks
if (!is_readable($sourceFile)) {
	die("Cannot read source file.");
}
if (!is_writable($outputFile) && $outputFile!='php://output') {
	die("Cannot write to output file.");
}

$sourceFileSize = filesize($sourceFile);
if ($sourceFileSize<1) {
	die("Source File Blank -- Nothing to do.");
}

// Auto Left Pad, prepends a zero for elegance.
$leftPad = strlen(dechex($sourceFileSize/$chunkSize))+1;

// Get File Handles
$sourceFileHandle = fopen($sourceFile,'rb');
$outputFileHandle = fopen($outputFile,'wb');


// Draw Header table with ruler
$xHeader = $xHeaderRule = str_repeat(' ',$leftPad).'   ';
for ($i=0;$i<$chunkSize;$i++) {
	$xHeader .= str_pad(strtoupper(dechex($i)),2,'0',STR_PAD_LEFT) . ' ';
	$xHeaderRule .= "-- ";
	
	if ($visualSplit!=false) {
		if (($i+1)%$visualSplit==0) {
			$xHeader .= '  ';
			$xHeaderRule .= '  ';
		}
	}
}
//fwrite($outputFileHandle,"$xHeader$eolString$xHeaderRule$eolString");

// Process file
for ($i=0;$i<$sourceFileSize;$i+=$chunkSize) {
	
	// Grab next relevant chunk
	fseek($sourceFileHandle,$i);
	$chunk = fread($sourceFileHandle,$chunkSize);
	
	// Provide byte-range label.
	$row = str_pad(dechex($i),$leftPad,'',STR_PAD_LEFT) . '';
	
	// Chunk stream to size
	$thisChunk = str_split($chunk,1);
	foreach ($thisChunk as $v) {
		
		// Convert to hex, pad and upper.
		$row .= str_pad(strtoupper(dechex(ord($v))),2,'0',STR_PAD_LEFT) . ' ';
		
		// Generate raw visual output of printable chars
		if (ctype_print($v)) {
			$rawView .= $v;
		} else {
			$rawView .= '.';
		}
		
		// Process Visual Split
		if ($visualSplit!=false) {
			$innerIterator++;
			if (($innerIterator)%$visualSplit==0) {
				$row .= "";
				$rawView .= ' ';
			}
		}
	}
	
	// Used for spacing of last row if file isn't divisible by chunk size.
	if (strlen($row)>$maxRowLen) {
		$maxRowLen = strlen($row);
	}
	//fwrite($outputFileHandle,str_pad($row,$maxRowLen,' ').$eodlString);
	//echo "<br>".$row;
	//echo "<br> THE VALUE";
	$hexValue .= $row;
	

	$rawView = '';
}

return $hexValue;


}


function OEMRecordHeader($projectName, $buildConfigName){  

global $con;
echo "<br><br><br>";

$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	foreach($fileNameSearch as $fileNameS)
	{
		if(strpos($fileNameS, ".txt") !== false)
		{
			//file found
			echo "TXT_FILE";
			echo $txtFile = $fileNameS;
			$txtFileFound = true;
			
		}
	}
	$file = "project_build/$projectName/$buildConfigName/Working Folder/support/".$txtFile;
	$file = fopen($file,"r");

 echo $sql = "SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '12'";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {			
         echo $oemName = $row["value"];			
		}
		
		
		
			  
	while(! feof($file))
	  { 
	  echo $line = fgets($file);
echo "<br>";

if((strpos($line, "manufacturer") !== false) && (strpos($line, "Broadcom") === false))
				{
					
					$headerStart = explode(":",$line);
					
	if((strpos($oemName, "DELL") === false)){
			fwrite($fileWrite,"Brcm_FBChecksum = ".$headerStart[0].",");
				}else
				{
				fwrite($fileWrite,"Brcm_Checksum = ".$headerStart[0].",");
				}
		}  
		
		if((strpos($line, "[FRU END]") !== false))
				{
					
					$headerCheckSum = explode(":",$line);
	if((strpos($oemName, "DELL") === false)){
			fwrite($fileWrite, $headerCheckSum[0]);
				}else
				{
				fwrite($fileWrite, $headerCheckSum[0]);
				}
		}
		
	}
			

fclose($fileWrite);


}


function OEMStartCheckSum($projectName, $buildConfigName){  

global $con;
echo "<br><br><br>";

$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	foreach($fileNameSearch as $fileNameS)
	{
		if(strpos($fileNameS, ".txt") !== false)
		{
			//file found
			echo "TXT_FILE";
			echo $txtFile = $fileNameS;
			$txtFileFound = true;
			
		}
	}
	$file = "project_build/$projectName/$buildConfigName/Working Folder/support/".$txtFile;
	$file = fopen($file,"r");

 echo $sql = "SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '12'";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {			
         echo $oemName = $row["value"];			
		}
		
		
		
			  
	while(! feof($file))
	  { 
	  echo $line = fgets($file);
echo "<br>";

if((strpos($line, "[OEM Start]") !== false))
				{
					
					$headerStart = explode(":",$line);
					
	if((strpos($oemName, "DELL") === false)){
			fwrite($fileWrite,"Brcm_FBChecksum = ".$headerStart[0].",");
				}else
				{
				fwrite($fileWrite,"Brcm_Checksum = ".$headerStart[0].",");
				}
		}  
		
		if((strpos($line, "[OEM Header checksum]") !== false))
				{
					
					$headerCheckSum = explode(":",$line);
	if((strpos($oemName, "DELL") === false)){
			fwrite($fileWrite, $headerCheckSum[0].",".$headerCheckSum[0]);
				}else
				{
				fwrite($fileWrite, $headerCheckSum[0].",".$headerCheckSum[0]);
				}
		}
		
	}
			

fclose($fileWrite);


}

function chmod_r($path) {
    $dir = new DirectoryIterator($path);
    foreach ($dir as $item) {
        chmod($item->getPathname(), 0777);
        if ($item->isDir() && !$item->isDot()) {
            chmod_r($item->getPathname());
        }
		
		echo $item." changed to 777<br>";
    }
}

function compressToTar($projectName, $buildConfigName)
{
	
							//do the untar here
					
$archive_name = "project_build/$projectName/$buildConfigName/Working Folder/afdzal2.tar";
echo $dir_path = "project_build/$projectName/$buildConfigName/Working Folder/";


chmod_r($dir_path);

$archive = new PharData($archive_name);
$archive->buildFromDirectory($dir_path); // make path\to\archive\arch1.tar
$archive->compress(Phar::GZ); // make path\to\archive\arch1.tar.gz
//unlink($archive_name); // deleting path\to\archive\arch1.tar
	

//echo exec("tar zcf my-backup.tar.gz $dir_path");

echo "...Done...";

//rename 


$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	foreach($fileNameSearch as $fileNameS)
	{
		echo "<br>$fileNameS<br>";
		if(strpos($fileNameS, ".upd") !== false)
		{
			//file found
			echo "UPD FILE FOUND";  
			echo $txtFile = $fileNameS;
			
			
$txtFiles = explode(".", $txtFile);
echo $txtFiles[0]; // piece1


			$txtFileFound = true;
			
		}
	}
	
if(rename($archive_name,$dir_path."/".$txtFiles[0].".mlf")) echo "<br><br>RENAMED";

//0) put in the increamental alphabet
//1) MOVE this mlf file to <prject file> - build no - 
//2) directly able to download from <project file> - build no


echo "<h3><a href='".$dir_path."".$txtFiles[0].".mlf"."'>DOWNLOAD MLF FILE HERE</h3></a>"; 

	
			
}



function OEMRecordHeaderCheckSum($projectName, $buildConfigName){  

global $con;
echo "<br><br><br>";

$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	foreach($fileNameSearch as $fileNameS)
	{
		if(strpos($fileNameS, ".txt") !== false)
		{
			//file found
			echo "TXT_FILE";
			echo $txtFile = $fileNameS;
			$txtFileFound = true;
			
		}
	}
	$file = "project_build/$projectName/$buildConfigName/Working Folder/support/".$txtFile;
	$file = fopen($file,"r");

 echo $sql = "SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '12'";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {			
         echo $oemName = $row["value"];			
		}
		
		
		
			  
	while(! feof($file))
	  { 
	  echo $line = fgets($file);
echo "<br>";
  
		
		
		
		if((strpos($line, "[OEM Record checksum]") !== false))
				{
					
					$headerCheckSum = explode(":",$line);
	if((strpos($oemName, "DELL") === false)){
			fwrite($fileWrite, ",".$headerCheckSum[0]."\r\n");
				}else
				{
				fwrite($fileWrite, ",".$headerCheckSum[0]."\r\n");
				}
		}
	}
			

fclose($fileWrite);


}


function brcmFBCheckSum($projectName, $buildConfigName){  

global $con;
echo "<br><br><br>";

$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	foreach($fileNameSearch as $fileNameS)
	{
		if(strpos($fileNameS, ".txt") !== false)
		{
			//file found
			echo "TXT_FILE";
			echo $txtFile = $fileNameS;
			$txtFileFound = true;
			
		}
	}
	$file = "project_build/$projectName/$buildConfigName/Working Folder/support/".$txtFile;
	$file = fopen($file,"r");

 echo $sql = "SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '12'";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {			
         echo $oemName = $row["value"];			
		}
		
		
		
			  
	while(! feof($file))
	  { 
	  echo $line = fgets($file);
echo "<br>";

if((strpos($line, "[HEADER Start]") !== false))
				{
					echo "<br>";echo "<br>";
					$headerStart = explode(":",$line);
	if((strpos($oemName, "DELL") === false)){
			fwrite($fileWrite,"Brcm_FBChecksum = ".$headerStart[0].",");
				}else
				{
				fwrite($fileWrite,"Brcm_Checksum = ".$headerStart[0].",");
				}
		}
		
		if((strpos($line, "[Header checksum]") !== false))
				{
					echo "<br>";echo "<br>";
					$headerCheckSum = explode(":",$line);
	if((strpos($oemName, "DELL") === false)){
			fwrite($fileWrite, $headerCheckSum[0].",".$headerCheckSum[0]."\r\n");
				}else
				{
				fwrite($fileWrite, $headerCheckSum[0].",".$headerCheckSum[0]."\r\n");
				}
		}
	}
			

fclose($fileWrite);


}


function brcmFBCheckSumLineTwo($projectName, $buildConfigName){  

global $con;
echo "<br><br><br>";

$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	foreach($fileNameSearch as $fileNameS)
	{
		if(strpos($fileNameS, ".txt") !== false)
		{
			//file found
			echo "TXT_FILE";
			echo $txtFile = $fileNameS;
			$txtFileFound = true;
			
		}
	}
	$file = "project_build/$projectName/$buildConfigName/Working Folder/support/".$txtFile;
	$file = fopen($file,"r");

 echo $sql = "SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '12'";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {			
         echo $oemName = $row["value"];			
		}
		
		
		
			  
	while(! feof($file))
	  { 
	  echo $line = fgets($file);
echo "<br>";

if((strpos($line, "[BOARD Start]") !== false))
				{
					echo "<br>";echo "<br>";
					$headerStart = explode(":",$line);
	if((strpos($oemName, "DELL") === false)){
			fwrite($fileWrite,"Brcm_FBChecksum = ".$headerStart[0].",");
				}else
				{
				fwrite($fileWrite,"Brcm_Checksum = ".$headerStart[0].",");
				}
		}
		
		if((strpos($line, "[Board checksum]") !== false))
				{
					echo "<br>";echo "<br>";
					$headerCheckSum = explode(":",$line);
	if((strpos($oemName, "DELL") === false)){
			fwrite($fileWrite, $headerCheckSum[0].",".$headerCheckSum[0]."\r\n");
				}else
				{
				fwrite($fileWrite, $headerCheckSum[0].",".$headerCheckSum[0]."\r\n");
				}
		}
	}
			

fclose($fileWrite);


}


function brcmFBCheckSumLineThree($projectName, $buildConfigName){  

global $con;
echo "<br><br><br>";

$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	foreach($fileNameSearch as $fileNameS)
	{
		if(strpos($fileNameS, ".txt") !== false)
		{
			//file found
			echo "TXT_FILE";
			echo $txtFile = $fileNameS;
			$txtFileFound = true;
			
		}
	}
	$file = "project_build/$projectName/$buildConfigName/Working Folder/support/".$txtFile;
	$file = fopen($file,"r");

 echo $sql = "SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '12'";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {			
         echo $oemName = $row["value"];			
		}
		
		
		
			  
	while(! feof($file))
	  { 
	  echo $line = fgets($file);
echo "<br>";

if((strpos($line, "[Product Start]") !== false))
				{
					echo "<br>";echo "<br>";
					$headerStart = explode(":",$line);
	if((strpos($oemName, "DELL") === false)){
			fwrite($fileWrite,"Brcm_FBChecksum = ".$headerStart[0].",");
				}else
				{
				fwrite($fileWrite,"Brcm_Checksum = ".$headerStart[0].",");
				}
		}
		
		if((strpos($line, "[Product checksum]") !== false))
				{
					echo "<br>";echo "<br>";
					$headerCheckSum = explode(":",$line);
	if((strpos($oemName, "DELL") === false)){
			fwrite($fileWrite, $headerCheckSum[0].",".$headerCheckSum[0]."\r\n");
				}else
				{
				fwrite($fileWrite, $headerCheckSum[0].",".$headerCheckSum[0]."\r\n");
				}
		}
	}
			

fclose($fileWrite);


}



function templateSize($projectName, $buildConfigName){  

global $con;
echo "<br><br><br>";
echo "--------Template size----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	foreach($fileNameSearch as $fileNameS)
	{
		
if(strpos($fileNameS, "A0.bin") !== false)
		{
			//file found
			//fwrite($fileWrite,$fileNameS."\r\n");
			
			echo $binFile = $fileNameS;
		}
		
	}

$binFile = "Wilshire_J3D14_FRU_X00_3.bin";
$fileSizeBin = filesize("project_build/$projectName/$buildConfigName/Working Folder/support/".$binFile);

fwrite($fileWrite,"TEMPLATE_SIZE = ".$fileSizeBin."\r\n");



//Template_checksum

//$hex = dechex(bindec($binary));
//echo $hex;

getHexFromBinFile("project_build/$projectName/$buildConfigName/Working Folder/support/".$binFile);

    $file = "CRC8.txt";
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $fileSizeCheckSum = fgets($file);
	  }



		
fwrite($fileWrite,"TEMPLATE_CHECKSUM = ".$fileSizeCheckSum."\r\n");
$valueX = "0byte";
$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '47'");
			while($rowcol = mysqli_fetch_array($col)){
				$valueX = $rowcol['value']; 
			}
			
			
			
fwrite($fileWrite,"Checksum_Verification = ".$valueX."\r\n");


$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '40'");
			while($rowcol = mysqli_fetch_array($col)){
				$valueX = $rowcol['value']; 
			}
	
	
fwrite($fileWrite,"Fru_Template = ".$binFile."=".$valueX."\r\n");

$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '45'");
			while($rowcol = mysqli_fetch_array($col)){
				$brcmdate = $rowcol['value']; 
			}
			fwrite($fileWrite,"Begin\r\n");
			if($brcmdate=="")
			{
				$brcmdate = "1";
				fwrite($fileWrite,"BRCM_DATE = ".$brcmdate."\r\n");
			}else
			{
				fwrite($fileWrite,"BRCM_DATE = 1,".$brcmdate."B\r\n");
			}		

$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '46'");
			while($rowcol = mysqli_fetch_array($col)){
				$brcmloc = $rowcol['value']; 
			}
			
			if($brcmloc=="")
			{
				$brcmloc = "1";
				fwrite($fileWrite,"BRCM_BlockWriteSinglebyteMode = ".$brcmloc."\r\n");
			}else
			{
				fwrite($fileWrite,"BRCM_BlockWriteSinglebyteMode = 1,".$brcmloc."B\r\n");
			}	
$brcmloc="";
$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '46'");
			while($rowcol = mysqli_fetch_array($col)){
				$brcmloc = $rowcol['value']; 
			}
			
			if($brcmloc=="")
			{
				$brcmloc = "00";
				
			}			
			 
		$txtFileFound = false;	
$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	foreach($fileNameSearch as $fileNameS)
	{
		
		
	
		
		if(strpos($fileNameS, ".txt") !== false)
		{
			//file found
			echo "TXT_FILE";
			echo $txtFile = $fileNameS;
			$txtFileFound = true;
			
		}
		
		
	}
	
	
	
	
			
	//read from AX.txt
	
	$file = "project_build/$projectName/$buildConfigName/Working Folder/support/".$txtFile;
	$file = fopen($file,"r");



 echo $sql = "SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '12'";
    $query = mysqli_query($con, $sql);
  
        while ($row = mysqli_fetch_array($query))
        {			
         $oemName = $row["value"];			
		}
		
		
		
			  
	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($oemName, "DELL") === false)){
			   
			if((strpos($line, "serial") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $line;
					$labelLoc = strtoupper(substr($line,2,2));
					
					$dataOne = explode("(",$line);
					$dataTwo = explode(")",$dataOne[1]);
					$labelLength = dechex($dataTwo[0]);
						
				fwrite($fileWrite,"BRCM_OEM_SN=".$labelLoc.",".$brcmloc.",".$labelLength." \r\n");	
				}
				
			
				}
				else
				{
					$brcmloc="";
					
					//if OEM NAME == DELL 
				if((strpos($line, "PPID") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $line;
					//0x34:	Board Serial PPID Country = VN (2) (02) 
					
					

$lines = explode("(", $line);
$labelLength = $lines[2]; // piece1
$brcmloc =  $lines[1]; // piece2


$brcmlocs = explode(")", $brcmloc);
$brcmloc =  $brcmlocs[0]; // piece2

$labelLengths = explode(")", $labelLength);
//$labelLength =  $labelLengths[0]; // piece2

$labelLoc = strtoupper(substr($line,2,2));


$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '46'");
			while($rowcol = mysqli_fetch_array($col)){
				$brcmloc = $rowcol['value']; 
			}
			
			if($txtFileFound==false || $brcmloc==""){$brcmloc = "00";}	
			if($txtFileFound==true || $brcmloc==""){$brcmloc = $brcmloc;}			
			
					
					$dataOne = explode("(",$line);
					$dataTwo = explode(")",$dataOne[1]);
					$labelLength = dechex($labelLengths[0]);
					
					
					
			if($txtFileFound==false && $brcmloc==""){$labelLength = "00";}	
			if($txtFileFound==true && $brcmloc==""){$labelLength = $labelLength;}			
			
					
				
				fwrite($fileWrite,"BRCM_OEM_SN=".$labelLoc.",".$labelLength.",".$brcmloc." \r\n");	
				}
				
				}
	  }
			

fclose($fileWrite);

}


function projectCodeWriteIbcfg01($projectName, $buildConfigName){  
global $con;
echo "<br><br><br>";
echo "--------IB_CFG  01 ----";
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");

	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAndyFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "IB_CFG  01") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
				
				if((strpos($line, "IB_CFG  01") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					echo $mbaInAndyFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAndy = $lineOnes[1];
					echo "AFDZAL-IB_CFG  01";
					echo $mbaVersionAndy = str_replace(" ","",$mbaVersionAndy);
					
					break;
				}else
				{
					//$mbaInAndyFound = false;
				}
	  }
					
				}
			
		}
		
		/////check on albert
		
		
	$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$mbaInAlbertFound = false;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "IB_CFG  01") !== false) && (strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(")", $lineOne);
					$mbaVersionAlbert = $lineOnes[1];
					echo "IBFC    01";
					echo $mbaVersionAlbert = str_replace(" ","",$mbaVersionAlbert);
					break;
				}
	  }
	  
	  while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "IB_CFG 01") !== false) && !(strpos($line, ".") !== false))
				{
					//bnxtmt version  : 216.2.73.0
					$mbaInAlbertFound = true;
					$lineOne = $line;
					
					$lineOnes = explode(") ", $lineOne);
					$mbaVersionAlbertCheckSum = $lineOnes[1];
					echo "IB_CFG  01";
					echo $mbaVersionAlbertCheckSum = substr($mbaVersionAlbertCheckSum,9,8);
					break;
				}
	  }
	  
					
				}
		
		}
		
		echo "<br><br>check";
		echo $mbaInAlbertFound;
		echo "<br><br>check";
		echo $mbaInAndyFound;
		echo "<br><br>";
		if($mbaInAlbertFound && $mbaInAndyFound)
			{	
				//if both files found
				if($mbaVersionAlbert == $mbaVersionAndy)
				{
					echo "WRITE";
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"IBCFG01=".$mbaVersionAlbert."");
					fwrite($fileWrite,"IBCFG01CHKSUM=".$valueCS."\r\n\r\n");
					
				}else
				{
					//echo "NO WRITE";
					echo "<h3>THE IBCFG 01 VALUE DOES NOT MATCH</h3><br>";
					if($_GET["ibcfg01"]=="1")
					{
					
					echo $valueCS = $mbaVersionAlbertCheckSum;
					fwrite($fileWrite,"IBCFG01=".$mbaVersionAlbert."");
					fwrite($fileWrite,"IBCFG01CHKSUM=".$valueCS."\r\n\r\n");
					echo "<br><br><h3>ALBERTS VALUE</h3>";
					
					}else
					{
						
					}
					
					
				}
			}else
				
				{
					
					//fwrite($fileWrite,"MBA=214.0.0.0-\r\n");
					//fwrite($fileWrite,"MBACHKSUM=2144df1c\r\n");
	
	



				}
		fwrite($fileWrite,";------------------------ MODEL PARAMS (FRU SPECIFIC) --------------------------\r\n\r\n");
fclose($fileWrite);

}




function compareFileVersioning(){  
global $con;
 //delete all files in uploads/
 $read = false;
 $versionTextA = array();
 $versionTextB = array();
 
 $checksumTextA = array();
 $checksumTextB = array();

$fileNameSearch = scandir("uploads/");
	
	$x = 0;
	$fileNameTRC = array();
	$mlfDate = array();
	
	$fileSeq = 1;
	
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".trc") !== false)
			{
				
				//file found
				$fileNameTRC[] = $fileNameS;
				
			}
			
			
	}
	
	
	echo '<pre>';
        print_r ($fileNameTRC);
        echo  '</pre>';
		
	
	foreach($fileNameTRC as $trcFile)
	{
		
	$file = "uploads/".$trcFile;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "VERSION       :") !== false))
				{
					
					echo "<br><br>"; 
					
					$versionNumber[] = $line;	
					
				}
		
					



		
	
	
	if((strpos($line, "VERSION       :") !== false))
				{
					$read = true;
					echo "aaa";
				}
				
				
				if((strpos($line, "Computed") !== false))
				{
					$read = false;
					echo "bbb";
				}
				
				if($read) 
				{  
			
			
			if($fileSeq==1) {$versionTextA[] = $line;}
			if($fileSeq==2) {$versionTextB[] = $line;}
					 
				}	
			}
echo "FILE SEQ : ";
		echo $fileSeq++;			
	  
		
		//check for each versionText
		
		if($versionTextA[0]==$versionTextB[1])
		{
			echo "VERSION is the same";
		}else{
			echo "VERSION is not the same";
		}
		
		echo "<br><br><br>File Seq 1<br><br><br>";
		echo '<pre>';
        print_r ($versionTextA);
        echo  '</pre>';
		
		echo "File Seq 2<br><br><br>";
		echo '<pre>';
        print_r ($versionTextB);
        echo  '</pre>';
		
		$i=0;
		foreach($versionTextA as $versionTextAcmp)
		{
			if($versionTextA[$i]==$versionTextB[$i]) {echo "VERSION line $i : MATCHED";} 
			if($versionTextA[$i]!=$versionTextB[$i]) {echo "VERSION line $i : NOT MATCHED<br><br><br>";echo $versionTextA[$i].' <br><br>'.$versionTextB[$i].'<br><br>';}
			echo "<br>";
			$i++;
		}
	
	
}
}



function compareFileChecksum(){  
global $con;
 //delete all files in uploads/
 $read = false;

 
 $checksumTextA = array();
 $checksumTextB = array();

$fileNameSearch = scandir("uploads/");
	
	$x = 0;
	$fileNameTRC = array();
	$mlfDate = array();
	
	$fileSeq = 1;
	
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".trc") !== false)
			{
				
				//file found
				$fileNameTRC[] = $fileNameS;
				
			}
			
			
	}
	 
	
	echo '<pre>';
        //print_r ($fileNameTRC);
        echo  '</pre>';
		
	
	foreach($fileNameTRC as $trcFile)
	{
		
	$file = "uploads/".$trcFile;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);
	
	
	if((strpos($line, "Computed") !== false))
				{
					$read = true;
					echo "aaa";
				}
				
				
				if((strpos($line, "PRODUCT_NAME = ") !== false))
				{
					$read = false;
					echo "bbb";
				}
				
				if($read) 
				{  
			
			
			if($fileSeq==1) {$checksumTextA[] = $line;}
			if($fileSeq==2) {$checksumTextB[] = $line;}
					 
				}	
			}
echo "FILE SEQ : ";
		echo $fileSeq++;			
	  
		
		
		echo "<br><br><br>File Seq 1<br><br><br>";
		echo '<pre>';
        //print_r ($checksumTextA);
        echo  '</pre>';
		
		echo "File Seq 2<br><br><br>";
		echo '<pre>';
       // print_r ($checksumTextB);
        echo  '</pre>';
		
		$i=0;
		
	
}

foreach($checksumTextA as $checksumTextAcmp)
		{
			//, PKG_LOG, FCFG
			if((!(strpos($checksumTextAcmp, "VPD") !== false))&&
			(!(strpos($checksumTextAcmp, "PKG_LOG") !== false))&&
			(!(strpos($checksumTextAcmp, "FCFG") !== false)))
			{
				
			if($checksumTextA[$i]==$checksumTextB[$i]) {echo "CHECKSUM line $i : MATCHED";} 
			if($checksumTextA[$i]!=$checksumTextB[$i]) {echo "CHECKSUM line $i : NOT MATCHED<br><br><br>";echo $checksumTextA[$i].' <br><br>'.$checksumTextB[$i].'<br><br>';}
			
			}else
			{
				{echo "CHECKSUM line $i : IGNORE FOR VPD, PKG_LOG & FCFG";}
			}
			echo "<br>";
			$i++;
		}
	
}



function compareProdName(){  
global $con;
 //delete all files in uploads/
 $read = false;

 
 $prodNameA = array();
 $prodNameB = array();

$fileNameSearch = scandir("uploads/");
	
	$x = 0;
	$fileNameTRC = array();
	$mlfDate = array();
	
	$fileSeq = 1;
	
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".trc") !== false)
			{
				
				//file found
				$fileNameTRC[] = $fileNameS;
				
			}
			
			
	}
	
	
	echo '<pre>';
        print_r ($fileNameTRC);
        echo  '</pre>';
		
	
	foreach($fileNameTRC as $trcFile)
	{
		
	$file = "uploads/".$trcFile;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);
	
	
	if((strpos($line, "PRODUCT_NAME = ") !== false))
				{
					$read = true;
					echo "aaa";
				}
				
				
				if((strpos($line, "Reading temperature") !== false))
				{
					$read = false;
					echo "bbb";
				}
				
				if($read) 
				{  
			
			
			if($fileSeq==1) {$prodNameA[] = $line;}
			if($fileSeq==2) {$prodNameB[] = $line;}
					 
				}	
			}
echo "FILE SEQ : ";
		echo $fileSeq++;			
	  
		
		
		echo "<br><br><br>File Seq 1<br><br><br>";
		echo '<pre>';
        print_r ($prodNameA);
        echo  '</pre>';
		
		echo "File Seq 2<br><br><br>";
		echo '<pre>';
        print_r ($prodNameB);
        echo  '</pre>';
		
		$i=0;
		
	
}

foreach($prodNameA as $checksumTextAcmp)
		{
		
				
			if($prodNameA[$i]==$prodNameB[$i]) {echo "PRODUCT NAME line $i : MATCHED";}
			if($prodNameA[$i]!=$prodNameB[$i]) {echo "PRODUCT NAME line $i : NOT MATCHED<br><br><br>";echo $prodNameA[$i].' <br><br>'.$prodNameB[$i].'<br><br>';}
			
			
			echo "<br>";
			$i++;
		}
	
}



function compareTemp(){  
global $con;
 //delete all files in uploads/
 $read = false;
//TEMPERATURE Check PASSED!!! if not found, either file, report out 
 
 $tempA = array();
 $tempB = array();

$fileNameSearch = scandir("uploads/");
	
	$x = 0;
	$fileNameTRC = array();
	$mlfDate = array();
	
	$fileSeq = 1;
	
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".trc") !== false)
			{
				
				//file found
				$fileNameTRC[] = $fileNameS;
				
			}
			
			
	}
	
	
	echo '<pre>';
        print_r ($fileNameTRC);
        echo  '</pre>';
		
	
	foreach($fileNameTRC as $trcFile)
	{
		
	$file = "uploads/".$trcFile;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);
	
	
	if((strpos($line, "Reading temperature") !== false))
				{
					$read = true;
					echo "aaa";
				}
				
				
				if((strpos($line, "Duration:") !== false))
				{
					$read = false;
					echo "bbb";
				}
				
				if($read) 
				{  
			
			
			if($fileSeq==1) {$tempA[] = $line;}
			if($fileSeq==2) {$tempB[] = $line;}
					 
				}	
			}
echo "FILE SEQ : ";
		echo $fileSeq++;			
	  
		
		
		echo "<br><br><br>File Seq 1<br><br><br>";
		echo '<pre>';
        print_r ($tempA);
        echo  '</pre>';
		
		echo "File Seq 2<br><br><br>";
		echo '<pre>';
        print_r ($tempB);
        echo  '</pre>';
		
		$i=0;
		
	
}

foreach($tempA as $checksumTextAcmp)
		{
		
				if($i==1){
			if($tempA[$i]==$tempB[$i]) {echo "TEMPERATURE line $i : MATCHED";}
			if($tempA[$i]!=$tempB[$i]) {echo "TEMPERATURE line $i : NOT MATCHED";}
				}
			
			echo "<br>";
			$i++;
		}
	
}


function compareTRCile(){  
global $con;
 //delete all files in uploads/
 $read = false;
 $versionText = array();

$fileNameSearch = scandir("uploads/");
	
	$x = 0;
	$fileNameTRC = array();
	$mlfDate = array();
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".trc") !== false)
			{
				
				//file found
				$fileNameTRC[] = $fileNameS;
				
			}
			
			
	}
	
	
	echo '<pre>';
        print_r ($fileNameTRC);
        echo  '</pre>';
		
	
	foreach($fileNameTRC as $trcFile)
	{
		
	echo $file = "uploads/".$trcFile;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "MLF Name:") !== false))
				{
					
					echo $line;
					echo "<br><br>"; 
					
					$mlfDate[] = substr($line, -12);	
					
				}
		

				if((strpos($line, "copy READMAC.txt") !== false))
				{
					$read = true;
				}
				
				if((strpos($line, "bnxtmt version") !== false))
				{
					$read = false;
				}
				
				if($read) 
				{  

if((strpos($line, "1 :") !== false))
				{			
			
			
			    $versionText[] = $line;
				}	 
				}
					
					
					
					
				}		
	  }
	
	
	echo '<pre>';
        print_r ($versionText);
        echo  '</pre>';
				
				//print_r (explode(":",$versionText[0]));  
				$boardVersionA = explode(":",$versionText[0]);
				$boardVersionB = explode(":",$versionText[1]);
				
				//print_r ($boardVersion);
				echo "<br><br>";
				echo $boardVersionFileA = substr($boardVersionA[1].":".$boardVersionA[2], 0, 9);
				echo "<br><br>";
				
				echo $boardVersionFileB = substr($boardVersionB[1].":".$boardVersionB[2], 0, 9);
				echo "<br><br>";
				
				echo $spdBaseA = substr($versionText[0], 25, 13);
				echo "<br><br>";
				echo $spdBaseB = substr($versionText[1], 25, 13);
				echo "<br><br>";
				
				echo $famVerA = substr($versionText[0], -19);
				echo "<br><br>";
				echo $famVerB = substr($versionText[1], -19);
				echo "<br><br>";
				
				
				if($mlfDate[0]!=$mlfDate[1])
				{
					echo "MLF file NOT SAME";
					exit();
				}else
					
					{
					echo "MLF file SAME. OK to CONTINUE"; 	
					}
				
}

function compareAndyAlbertCFG($projectName, $buildConfigName){  
global $con;
$countAndyMac = 0;
	$countAlbertMac = 0;
 
$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$x = 0;
	$lineAlbertMac = array();
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".cfg") !== false)
			{
				
				//file found
				$logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
								
				echo $file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "1: [F] MAC address") !== false) ||
	(strpos($line, "[P] BMC MAC Address") !== false) ||
	(strpos($line, "1: [F] Mac address") !== false) ||
	(strpos($line, "[P] BMC Mac Address") !== false)
	)
				{
					//bnxtmt version  : 216.2.73.0
					$lineAlbertMac[$x] = $line;
					
				}
				$x++;
				
				if((strpos($line, "1: [F] MAC address") !== false)||(strpos($line, "1: [F] Mac address") !== false))
				{echo $countAlbertMac++;}
	  }
				
			
				  
				   echo '<pre>';
        print_r ($lineAlbertMac);
        echo  '</pre>';
				
			}
			
	}
	
	echo "--------------------------------------------------------";
	
	
	
	
$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$x = 0;
	$lineAndyMac = array();
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".cfg") !== false)
			{
				
				//file found
				$logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
								
				echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "1: [F] MAC address") !== false) ||
	(strpos($line, "[P] BMC MAC Address") !== false) ||
	(strpos($line, "1: [F] Mac address") !== false) ||
	(strpos($line, "[P] BMC Mac Address") !== false)
	)
				{
					//bnxtmt version  : 216.2.73.0
					$lineAndyMac[$x] = $line;
					
				}
				$x++;
				
				if((strpos($line, "1: [F] MAC address") !== false)||(strpos($line, "1: [F] Mac address") !== false))
				{$countAndyMac++;}
				
	  }
				
			
				  
				   echo '<pre>';
        print_r ($lineAndyMac);
        echo  '</pre>';
				
			}  
			
	}
	
	$BMCfoundAlbert = false;
	$BMCfoundAndy = false;
	$BMCAlbertCount = 0;
	$BMCAndyCount = 0;
	
	foreach ($lineAlbertMac as $stringCheckAlbert) {
		  if((strpos($stringCheckAlbert, "BMC") !== false))
		  {
			 $BMCfoundAlbert = true;
			 $BMCAlbertCount++;
		  }
	}
	
	foreach ($lineAndyMac as $stringCheckAndy) {
		  if((strpos($stringCheckAndy, "BMC") !== false))
		  {
			 $BMCfoundAndy = true;
			 $BMCAndyCount++;
		  }
	}
	
	if($BMCfoundAndy)
	{
		echo "FOUND: BMC MAC Address in Andy CFG file - ".$BMCAndyCount;
	}else
	{
		echo "NOT FOUND: BMC MAC Address in Andy CFG file - ".$BMCAndyCount; 
	}
	 

  echo "<br><br>";
 
if($BMCfoundAlbert)
	{
		echo "FOUND: BMC MAC Address in Albert CFG file - ".$BMCAlbertCount; 
	}else
	{
		echo "NOT FOUND: BMC MAC Address in Albert CFG file - ".$BMCAlbertCount;
	}
	
	//check increment MAC
	
	foreach ($lineAlbertMac as $stringCheckAlbert) {
		  if((strpos($stringCheckAlbert, "BMC") !== false))
		  {
			 $BMCfoundAlbert = true;
			 $BMCAlbertCount++;
		  }
	}
	
	foreach ($lineAndyMac as $stringCheckAndy) {
		  if((strpos($stringCheckAndy, "BMC") !== false))
		  {
			 $BMCfoundAlbert = true;
			 $BMCAlbertCount++;
		  }
	}
	
	$albertMacOnly = array();
	$x=0;
	foreach ($lineAlbertMac as $stringCheckAlbert) {
		  if((strpos($stringCheckAlbert, "[F] MAC address") !== false))
		  {
			$albertMacOnly[$x] = $stringCheckAlbert;
			$x++;
		  }
	}
	
	$andyMacOnly = array();
	$x=0;
	foreach ($lineAndyMac as $stringCheckAndy) {
		  if((strpos($stringCheckAndy, "[F] MAC address") !== false))
		  {
			$andyMacOnly[$x] = $stringCheckAndy;
			$x++;
		  }
	}
	
	
 $newlineAlbertMac = array();
 $newlineAndyMac = array();
   
   echo "<br><br>";
   echo "MAC ONLY ALBERT";
   echo "<br><br>";
   echo '<pre>';
   $newlineAlbertMac = array_slice($albertMacOnly,0,2);
print_r($newlineAlbertMac); 
        echo  '</pre>';


 echo "<br><br>";
   echo "MAC ONLY ANDY"; 
   echo "<br><br>";

echo '<pre>';
   $newlineAndyMac = array_slice($andyMacOnly,0,2);
print_r($newlineAndyMac); 
        echo  '</pre>';
		
		$macAlbert = array();
		$x=0;
		foreach ($newlineAlbertMac as $macCheckAlbert) {
		  $macAlbert[$x] = substr($macCheckAlbert, -3);		  
		  $x++;
			}
			
			$macAndy = array();
		$x=0;
		foreach ($newlineAndyMac as $macCheckAndy) {
		  $macAndy[$x] = substr($macCheckAndy, -3);		  
		  $x++;
			}
		
		echo '<pre>';
print_r($macAndy); 
        echo  '</pre>';
		
		//check increamental
		echo "Incremental CHECK MAC for Andy: ";
		echo $macDiffAndy = hexdec($macAndy[1]) - hexdec($macAndy[0]);
		echo "<br><br>";
		echo "Incremental CHECK MAC for Albert: ";
		echo $macDiffAlbert = hexdec($macAlbert[1]) - hexdec($macAlbert[0]);
		echo "<br><br>";
		echo "MUST BE ONE?";
		echo "<br><br>";
		if(($macDiffAlbert == $macDiffAndy))
		{
		echo "Incremental check OK";
		}else
		{
			echo "Incremental check FAULT";
		}
		echo "<br><br>";
		echo "count [F] MAC address  Albert :".$countAlbertMac;
		echo "<br><br>";
		echo "count [F] MAC address  Andy :".$countAndyMac; 
		echo "<br><br>";
		if(($countAlbertMac == $countAndyMac))
		{
		echo "Count check OK";
		}else
		{
			echo "Count check FAULT";
		}
		
		
		
}


function compareAndyLogCFG($projectName, $buildConfigName, $folderSearch){  
global $con;
$countAndyMac = 0;
$countLogMac = 0;

echo "<br><br>-----------------------   COMPARE WITH LOG   -------------------<br><br>";
 
    //$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$x = 0;
	$lineLogMac = array();
	
		//get NVRAM INFORMTION
			//echo $folderSearch;
			echo "<br><br>";
 $fileNameSearch = scandir($folderSearch."/log/evram/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	//project_build/logitech/loigc_01/logitech-M0_999 Test Logs/
	$x = 1;
	
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".cfg") !== false)
			{
				
				
				
				//file found
				$logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
								
				echo $file = $folderSearch."log/evram/".$logFileName;
				
			
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "1: [F] MAC address") !== false) ||
	(strpos($line, "[P] BMC MAC Address") !== false) ||
	(strpos($line, "1: [F] Mac address") !== false) ||
	(strpos($line, "[P] BMC Mac Address") !== false)
	)
				{
					//bnxtmt version  : 216.2.73.0
					$lineLogMac[$x] = $line;
					
				}
				$x++;
				
				if((strpos($line, "1: [F] MAC address") !== false)||(strpos($line, "1: [F] Mac address") !== false))
				{$countLogMac++;}
				
	  }
				
			
				  
				   echo '<pre>';
        print_r ($lineLogMac);
        echo  '</pre>';
				
				
			}
	
	}
	
	
	
	echo "--------------------------------------------------------";
	
	
	
	
$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$x = 0;
	$lineAndyMac = array();
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".cfg") !== false)
			{
				
				//file found
				$logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
								
				echo $file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if((strpos($line, "1: [F] MAC address") !== false) ||
	(strpos($line, "[P] BMC MAC Address") !== false) ||
	(strpos($line, "1: [F] Mac address") !== false) ||
	(strpos($line, "[P] BMC Mac Address") !== false)
	)
				{
					//bnxtmt version  : 216.2.73.0
					$lineAndyMac[$x] = $line;
					
				}
				$x++;
				
				if((strpos($line, "1: [F] MAC address") !== false)||(strpos($line, "1: [F] Mac address") !== false))
				{$countAndyMac++;}
				
	  }
				
			
				  
				   echo '<pre>';
        print_r ($lineAndyMac);
        echo  '</pre>';
				
			}  
			
	}
	
	$BMCfoundLog = false;
	$BMCfoundAndy = false;
	$BMCLogCount = 0;
	$BMCAndyCount = 0;
	
	foreach ($lineLogMac as $stringCheckLog) {
		  if((strpos($stringCheckLog, "BMC") !== false))
		  {
			 $BMCfoundLog = true;
			 $BMCLogCount++;
		  }
	}
	
	foreach ($lineAndyMac as $stringCheckAndy) {
		  if((strpos($stringCheckAndy, "BMC") !== false))
		  {
			 $BMCfoundAndy = true;
			 $BMCAndyCount++;
		  }
	}
	
	if($BMCfoundAndy)
	{
		echo "FOUND: BMC MAC Address in Andy CFG file - ".$BMCAndyCount;
	}else
	{
		echo "NOT FOUND: BMC MAC Address in Andy CFG file - ".$BMCAndyCount; 
	}
	 

  echo "<br><br>";
 
if($BMCfoundLog)
	{
		echo "FOUND: BMC MAC Address in LOG CFG file - ".$BMCLogCount; 
	}else
	{
		echo "NOT FOUND: BMC MAC Address in LOG CFG file - ".$BMCLogCount;
	}
	
	//check increment MAC
	
	foreach ($lineLogMac as $stringCheckLog) {
		  if((strpos($stringCheckLog, "BMC") !== false))
		  {
			 $BMCfoundLog = true;
			 $BMCLogCount++;
		  }
	}
	
	$logMacOnly = array();
	$x=0;
	foreach ($lineLogMac as $stringCheckLog) {
		  if((strpos($stringCheckLog, "[F] MAC address") !== false))
		  {
			$logMacOnly[$x] = $stringCheckLog;
			$x++;
		  }
	}
	
	$andyMacOnly = array();
	$x=0;
	foreach ($lineAndyMac as $stringCheckAndy) {
		  if((strpos($stringCheckAndy, "[F] MAC address") !== false))
		  {
			$andyMacOnly[$x] = $stringCheckAndy;
			$x++;
		  }
	}
	
 $newlineLogMac = array();
 $newlineAndyMac = array();
    
      echo "<br><br>";
   echo "MAC ONLY LOG";
   echo "<br><br>";
   
   
   echo '<pre>';
   $newlineLogMac = array_slice($logMacOnly,0,2);
print_r($newlineLogMac); 
        echo  '</pre>';



echo '<pre>';
   $newlineAndyMac = array_slice($andyMacOnly,0,2);
print_r($newlineAndyMac); 
        echo  '</pre>';
		
		$macLog = array();
		$x=0;
		foreach ($newlineLogMac as $macCheckLog) {
		  $macLog[$x] = substr($macCheckLog, -3);		  
		  $x++;
			}
			
			$macAndy = array();
		$x=0;
		foreach ($newlineAndyMac as $macCheckAndy) {
		  $macAndy[$x] = substr($macCheckAndy, -3);		  
		  $x++;
			}
		
		echo '<pre>';
print_r($macAndy); 
        echo  '</pre>';
		
		//check increamental
		echo "Incremental CHECK MAC for Andy: ";
		echo $macDiffAndy = hexdec($macAndy[1]) - hexdec($macAndy[0]);
		echo "<br><br>";
		echo "Incremental CHECK MAC for LOG: ";
		echo $macDiffLog = hexdec($macLog[1]) - hexdec($macLog[0]);
		echo "<br><br>";
		if(($macDiffLog == $macDiffAndy))
		{
		echo "Incremental check OK";
		}else
		{
			echo "Incremental check FAULT";
		}
		echo "<br><br>"; 
		echo "count [F] MAC address  LOG :".$countLogMac;
		echo "<br><br>";
		echo "count [F] MAC address  Andy :".$countAndyMac; 
		echo "<br><br>";
		if(($countLogMac == $countAndyMac))
		{
		echo "Count check OK";
		}else
		{
			echo "Count check FAULT";
		}
		
		
		
}


function strToHex($string){
    $hex = '';
    for ($i=0; $i<strlen($string); $i++){
        $ord = ord($string[$i]);
        $hexCode = dechex($ord);
        $hex .= substr('0'.$hexCode, -2);
    }
    return strToUpper($hex);
}
function hexToStr($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}

function compareAndyAlbert($projectName, $buildConfigName){  
global $con;


}

function boardChecksum($target_file_fru, $target_file_bin){  
global $con;
$read=true;
$boardValueHexNow = "";

 $file = $target_file_fru;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  
	    $line = fgets($file);

		if(strpos($line, "[BOARD Start]") !== false){
		echo $boardValue = $line;
		$boardValueHex = explode(":", $boardValue);
		$boardValueHexNow = $boardValueHex[0];
		$boardValueHexNowReal = explode("x", $boardValueHexNow);
		break;
		}
		
	  
	  
	}
	
	
	
 $file = $target_file_fru;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  
	    $line = fgets($file);

		if(strpos($line, "[Board checksum]") !== false){
		$boardCheckValue = $line;
		$boardValueCheckHex = explode(":", $boardCheckValue);
		$boardValueHexCheckNow = $boardValueCheckHex[0];
		
		$boardValueCheckHexReal = explode("x", $boardValueHexCheckNow);
		break;
		}
		
		
	  
	  
	}
	
	
	$decValStart = hexdec($boardValueHexNowReal[1]);
	$boardValueHexNowReal[1] = dechex($decVal);
	 
	
	$decVal = hexdec($boardValueCheckHexReal[1]);
	$decVal = $decVal-1;
	$boardValueCheckHexReal[1] = dechex($decVal);
	$length = $decVal - $decValStart; 
		
		
		$hexes = explode(" ", getHexFromBinFile($target_file_bin));
		$newArrayBoardStart = array_splice($hexes, $decValStart, ($length+1));
		//echo getHexFromBinFile($target_file_bin);
		$checkSumToCompare = substr(getHexFromBinFile($target_file_bin),309,2);
		//$checkSumToCompare = array_splice($hexes, 76, 1);  
		
		//echo '<pre>';
        //print_r ($checkSumToCompare);
       // echo  '</pre>';
		
		//echo '<pre>';
        //print_r ($newArrayBoardStart);
        //echo  '</pre>';
		echo "<br><br>";
		//echo implode(" ",$newArrayBoardStart);  
		
		echo "CHECK SUM FROM BIN FILE <input id='checksumonebin' type='text' value='".$checkSumToCompare."' readonly /><br>";
		echo "<br><br>";
		echo "CHECK SUM CALCULATED<input id='checksumonecal' type='text' value='' readonly /><br>";
		echo "<br><br>";
		echo "<textarea  type='text' id='checksumone' name='checksumone' readonly rows='8' cols='80' value='"; echo implode(" ",$newArrayBoardStart); echo "'>".implode(" ",$newArrayBoardStart)."</textarea>";
		echo "<br><br>";
		echo "<p id='checksumonenote'></p>";
}



function productChecksum($target_file_fru, $target_file_bin){  
global $con;
$read=true;
$boardValueHexNow = "";

 $file = $target_file_fru;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  
	    $line = fgets($file);

		if(strpos($line, "[Product Start]") !== false){
		$boardValue = $line;
		$boardValueHex = explode(":", $boardValue);
		$boardValueHexNow = $boardValueHex[0];
		$boardValueHexNowReal = explode("x", $boardValueHexNow);
		break;
		}
		
	  
	  
	}
	
	
	
 $file = $target_file_fru;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  
	    $line = fgets($file);

		if(strpos($line, "[Product checksum]") !== false){
		$boardCheckValue = $line;
		$boardValueCheckHex = explode(":", $boardCheckValue);
		$boardValueHexCheckNow = $boardValueCheckHex[0];
		
		$boardValueCheckHexReal = explode("x", $boardValueHexCheckNow);
		break;
		}
		
		
	  
	  
	}
	
	
	$decValStart = hexdec($boardValueHexNowReal[1]);
	
	 
	
	$decVal = hexdec($boardValueCheckHexReal[1]);
	$decVal = $decVal-1;
	$boardValueCheckHexReal[1] = dechex($decVal);
	$length = $decVal - $decValStart; 
		
		
		$hexes = explode(" ", getHexFromBinFile($target_file_bin));
		$newArrayBoardStart = array_splice($hexes, $decValStart, ($length+1));
		
		//$checkSumToCompare = array_splice($hexes, 104, 1);
		
		//echo getHexFromBinFile($target_file_bin); 
		$checkSumToCompare = substr(getHexFromBinFile($target_file_bin),597,2);
		
		
		//echo '<pre>';
        //print_r ($newArrayBoardStart);
        //echo  '</pre>';
		
		//echo '<pre>';
        //print_r ($newArrayBoardStart);
        //echo  '</pre>';
		echo "<br><br>";
		//echo implode(" ",$newArrayBoardStart);  
		
		echo "CHECK SUM FROM BIN FILE <input id='checksumonebinprod' type='text' value='".$checkSumToCompare."' readonly /><br>";
		echo "<br><br>";
		echo "CHECK SUM CALCULATED<input id='checksumonecalprod' type='text' value='' readonly /><br>";
		//echo "<br><br>";
		echo "<textarea  type='text' id='checksumoneprod' name='checksumoneprod' readonly rows='8' cols='80' value='"; echo implode(" ",$newArrayBoardStart); echo "'>".implode(" ",$newArrayBoardStart)."</textarea>";
		echo "<br><br>";
		echo "<p id='checksumonenoteprod'></p>";
}


function oemRecordChecksum($target_file_fru, $target_file_bin){  
global $con;
$read=true;
$boardValueHexNow = "";

 $file = $target_file_fru;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  
	    $line = fgets($file);

		if(strpos($line, "[OEM Header checksum]") !== false){
		$boardValue = $line;
		$boardValueHex = explode(":", $boardValue);
		$boardValueHexNow = $boardValueHex[0];
		$boardValueHexNowReal = explode("x", $boardValueHexNow);
		break;
		}
		
	  
	  
	}
	
	
	
 $file = $target_file_fru;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  
	    $line = fgets($file);

		if(strpos($line, "[FRU END]") !== false){
		$boardCheckValue = $line;
		$boardValueCheckHex = explode(":", $boardCheckValue);
		$boardValueHexCheckNow = $boardValueCheckHex[0];
		
		$boardValueCheckHexReal = explode("x", $boardValueHexCheckNow);
		break;
		}
		
		
	  
	  
	}
	
	
	$decValStart = hexdec($boardValueHexNowReal[1]);
	$decValStart++;
	 
	
	$decVal = hexdec($boardValueCheckHexReal[1]);
	$decVal = $decVal-1;
	$boardValueCheckHexReal[1] = dechex($decVal);
	$length = $decVal - $decValStart; 
		
		
		$hexes = explode(" ", getHexFromBinFile($target_file_bin));
		$newArrayBoardStart = array_splice($hexes, $decValStart, ($length+1));
		
		//echo getHexFromBinFile($target_file_bin);   
		$checkSumToCompare = substr(getHexFromBinFile($target_file_bin),609,2); 
		
		 
		//echo '<pre>';
        //print_r ($hexes);
        //echo  '</pre>';
		
		//echo '<pre>';
        //print_r ($newArrayBoardStart);
        //echo  '</pre>';
		echo "<br><br>";
		//echo implode(" ",$newArrayBoardStart);  
		
		echo "CHECK SUM FROM BIN FILE <input id='checksumonebinrecord' type='text' value='".$checkSumToCompare."' readonly /><br>";
		echo "<br><br>";
		echo "CHECK SUM CALCULATED<input id='checksumonecalrecord' type='text' value='' readonly /><br>";
		echo "<br><br>";
		echo "<textarea  type='text' id='checksumonerecord' name='checksumonerecord' readonly rows='8' cols='80' value='"; echo implode(" ",$newArrayBoardStart); echo "'>".implode(" ",$newArrayBoardStart)."</textarea>";
		echo "<br><br>";
		echo "<p id='checksumonenoterecord'></p>";
}



function oemHeaderChecksum($target_file_fru, $target_file_bin){  
global $con;
$read=true;
$boardValueHexNow = "";

 $file = $target_file_fru;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  
	    $line = fgets($file);

		if(strpos($line, "[OEM Start]") !== false){
		$boardValue = $line;
		$boardValueHex = explode(":", $boardValue);
		$boardValueHexNow = $boardValueHex[0];
		$boardValueHexNowReal = explode("x", $boardValueHexNow);
		break;
		}
		
	  
	  
	}
	
	
	
 $file = $target_file_fru;
				
				
				$file = fopen($file,"r");

	while(! feof($file))
	  {
	  
	    $line = fgets($file);

		if(strpos($line, "[OEM Record checksum]") !== false){
		$boardCheckValue = $line;
		$boardValueCheckHex = explode(":", $boardCheckValue);
		$boardValueHexCheckNow = $boardValueCheckHex[0];
		
		$boardValueCheckHexReal = explode("x", $boardValueHexCheckNow);
		break;
		}
		
		
	  
	  
	}
	
	
	echo $decValStart = hexdec($boardValueHexNowReal[1]);
	
	 
	
	$decVal = hexdec($boardValueCheckHexReal[1]);
	$decVal = $decVal;
	$boardValueCheckHexReal[1] = dechex($decVal);
	$length = $decVal - $decValStart; 
		
		
		$hexes = explode(" ", getHexFromBinFile($target_file_bin));
		$newArrayBoardStart = array_splice($hexes, $decValStart, ($length+1));
		
		//echo getHexFromBinFile($target_file_bin); 
		$checkSumToCompare = substr(getHexFromBinFile($target_file_bin),612,2);
		
		echo '<pre>';
        print_r ($checkSumToCompare);
        echo  '</pre>';
		
		//echo '<pre>';
        //print_r ($newArrayBoardStart);
        //echo  '</pre>';
		echo "<br><br>";
		//echo implode(" ",$newArrayBoardStart);  
		
		echo "CHECK SUM FROM BIN FILE <input id='checksumonebinheader' type='text' value='".$checkSumToCompare."' readonly /><br>";
		echo "<br><br>";
		echo "CHECK SUM CALCULATED<input id='checksumonecalheader' type='text' value='' readonly /><br>";
		echo "<br><br>";
		echo "<textarea  type='text' id='checksumoneheader' name='checksumoneheader' readonly rows='8' cols='80' value='"; echo implode(" ",$newArrayBoardStart); echo "'>".implode(" ",$newArrayBoardStart)."</textarea>";
		echo "<br><br>";
		echo "<p id='checksumonenoteheader'></p>";
}


function compareAndyLog($projectName, $buildConfigName, $folderSearch){  
global $con;

			//get NVRAM INFORMTION
			echo $folderSearch;
			echo "<br><br>";
 $fileNameSearch = scandir($folderSearch."/log/evram/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	//project_build/logitech/loigc_01/logitech-M0_999 Test Logs/
	$x = 1;
	
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				$logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				echo "<br><br><br>";	
	$file = $folderSearch."log/evram/".$logFileName;
	echo "<br><br><br>";	
	
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if(strpos($line, "bnxtmt version") !== false)
				{
					//bnxtmt version  : 216.2.73.0
					
					$lineOne = $line;
					
					$lineOnes = explode("  : ", $lineOne);
					echo $bnxtmtVerEVA = $lineOnes[1];
					
					
				}
				
				if(strpos($line, "  VERSION") !== false)
				{
					$lineOne = $line;
					$lineOnes = explode("       :	", $lineOne);
					$versionNVRAM = $lineOnes[1];			
				}
				
				if(strpos($line, "REG HDR VER") !== false)
				{
					$lineOne = $line;
					$lineOnes = explode("   :	", $lineOne);
					$regHdrNVRAM = $lineOnes[1];			
				}
				
				if(strpos($line, "HWRM VER") !== false)
				{
					$lineOne = $line; 
					$lineOnes = explode("      :	", $lineOne);
					$hwrmVerNVRAM = $lineOnes[1];			
				}
				
				if(strpos($line, "1 : ") !== false)
				{
					$lineOne = $line; 
					$lineOnes = explode(" ", $lineOne);
					$pci1NVRAM = $lineOnes[4];											
				}
				
				if(strpos($line, "1 : ") !== false)
				{
					$lineOne = $line; 
					$lineOnes = explode("   ", $lineOne);
					
					$spdNVRAM = substr($lineOnes[1],0,3);											
				}
				
				if(strpos($line, "1 : ") !== false)
				{
					$lineOne = $line; 
					$lineOnes = explode(" ", $lineOne);
					
					$famVerNVRAM = substr($line,62,12);											
				}
				
				//
				
				
				
				
	  }
					
				}
			
		}
		
		
		

			//get ANDY INFORMTION
$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$x = 1;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				$logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ANDY/".$logFileName,"r");
					
	$file = "project_build/$projectName/$buildConfigName/ANDY/andy/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if(strpos($line, "bnxtmt version") !== false)
				{
					//bnxtmt version  : 216.2.73.0
					
					$lineOne = $line;
					
					$lineOnes = explode("  : ", $lineOne);
					echo $bnxtmtVerANDY = $lineOnes[1];
					echo "<br>";
					
					
				}
				
				if(strpos($line, "  VERSION") !== false)
				{
					$lineOne = $line;
					$lineOnes = explode("       :	", $lineOne);
					echo $versionANDY = $lineOnes[1];			
					echo "<br>";
				}
				
				if(strpos($line, "REG HDR VER") !== false)
				{
					$lineOne = $line;
					$lineOnes = explode("   :	", $lineOne);
					echo $regHdrANDY = $lineOnes[1];			
					echo "<br>";
				}
				
				if(strpos($line, "HWRM VER") !== false)
				{
					$lineOne = $line; 
					$lineOnes = explode("      :	", $lineOne);
					echo $hwrmVerANDY = $lineOnes[1];			
					echo "<br>";
				}
				
				if(strpos($line, "1 : ") !== false)
				{
					$lineOne = $line; 
					$lineOnes = explode(" ", $lineOne);
					echo $pci1ANDY = $lineOnes[4];											
					echo "<br>";
				}
				
				if(strpos($line, "1 : ") !== false)
				{
					$lineOne = $line; 
					$lineOnes = explode("   ", $lineOne);
					
					echo $spdANDY = substr($lineOnes[1],0,3);											
					echo "<br>";
				}
				
				if(strpos($line, "1 : ") !== false)
				{
					$lineOne = $line; 
					$lineOnes = explode(" ", $lineOne);
					
					echo $famVerANDY = substr($line,62,12);											
					
				}
				
				//
				
				
				
				
	  }
					
				}
			
		} 
		
if($bnxtmtVerEVA != $bnxtmtVerANDY)
{ echo "ANDY and NhhVRAM log file not match for bnxtmt value<br><br>"; exit();}
else

{ 	echo "NVRAM bnxt".$bnxtmtVerNVRAM;
echo "<br>Andy bnxt".$bnxtmtVerANDY;
echo "ANDY and NVRAM log file MATCH for bnxtmt value<br><br>"; }

if($versionNVRAM != $versionANDY)
{ echo "ANDY and NVRAM log file not match for VERSION value<br><br>"; exit();}
else
{ echo "ANDY and NVRAM log file MATCH for VERSION value<br><br>"; }


if($versionNVRAM != $versionANDY)
{ echo "ANDY and NVRAM log file not match for VERSION value<br><br>"; exit();}
else
{ echo "ANDY and NVRAM log file MATCH for VERSION value<br><br>"; }

if($regHdrNVRAM != $regHdrANDY)
{ echo "ANDY and NVRAM log file not match for REG HDR VERSION value<br><br>"; exit();}
else
{ echo "ANDY and NVRAM log file MATCH for REG HDR VERSION value<br><br>"; }


if($hwrmVerNVRAM != $hwrmVerANDY)
{ echo "ANDY and NVRAM log file not match for REG HDR VERSION value<br><br>"; exit();}
else
{ echo "ANDY and NVRAM log file MATCH for REG HDR VERSION value<br><br>"; }





if($pci1NVRAM != $pci1ANDY)
{ echo "ANDY and NVRAM log file not match for PCI1 value<br><br>"; exit();}
else
{ echo "ANDY and NVRAM log file MATCH for PCI1 value<br><br>"; }

if($spdNVRAM != $spdANDY)
{ echo "ANDY and NVRAM log file not match for SPD value<br><br>"; exit();}
else
{ echo "ANDY and NVRAM log file MATCH for SPD value<br><br>"; }

if($famVerNVRAM != $famVerANDY)
{ echo "ANDY and NVRAM log file not match for FamVer value<br><br>"; exit();}
else
{ echo "ANDY and NVRAM log file MATCH for FamVer value<br><br>"; }
	

}

function projectCodeWriteSecond($projectName, $buildConfigName){  
global $con;
//unlink("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd");  
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd","a");
$file = fopen($file,"r");
echo "project_build/$projectName/$buildConfigName/Working Folder/projectcode.upd";

//;
$valueX = "";

$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '38'");
			while($rowcol = mysqli_fetch_array($col)){
				$valueX = $rowcol['value']; 
			}
	
	if($valueX!="") 
	{
			fwrite($fileWrite,"i2cDevice = ".$valueX);
	}else
	{
		fwrite($fileWrite,"i2cDevice = Atmel AT24C04");
	}
fwrite($fileWrite,"\r\n");
$valueX = "";

$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '39'");
			while($rowcol = mysqli_fetch_array($col)){
				$valueX = $rowcol['value']; 
			}
	
	if($valueX!="") 
	{
			fwrite($fileWrite,"method = ".$valueX);
	}else
	{
		fwrite($fileWrite,"method = EERPOM1AddWord");
	}
	
	
fwrite($fileWrite,"\r\n");
$valueX = "";

$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '42'");
			while($rowcol = mysqli_fetch_array($col)){
				$valueBinPrefix = $rowcol['value']; 
			}
	
$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '40'");
			while($rowcol = mysqli_fetch_array($col)){
				$valueX = $rowcol['value']; 
			}
	
	if($valueX!="") 
	{
			fwrite($fileWrite,"i2cAddress = ".$valueX);
	}else
	{
		fwrite($fileWrite,"i2cAddress = ".$valueBinPrefix);
	}
fwrite($fileWrite,"\r\n");
$valueX = "";	
	
$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '41'");
			while($rowcol = mysqli_fetch_array($col)){
				$valueX = $rowcol['value']; 
			}
	
	if($valueX!="") 
	{
			fwrite($fileWrite,"pageSize = ".$valueX);
	}else
	{
		fwrite($fileWrite,"pageSize = 4");
	}
fwrite($fileWrite,"\r\n");	
$valueX = "";


$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/Working Folder/support/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	foreach($fileNameSearch as $fileNameS)
	{
		
		if(strpos($fileNameS, $valueBinPrefix.".bin") !== false)
		{
			//file found
			fwrite($fileWrite,$fileNameS."\r\n");
			$binFile = $fileNameS;
		}
		
		
	}
	
$fileSizeBin = filesize("project_build/$projectName/$buildConfigName/Working Folder/support/".$binFile);

fwrite($fileWrite,"deviceMemorySize = ".$fileSizeBin."\r\n");


$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '43'");
			while($rowcol = mysqli_fetch_array($col)){
				$valueX = $rowcol['value']; 
			}
	
	if($valueX!="") 
	{
			fwrite($fileWrite,"EnableSingleByteFRU = ".$valueX);
	}else
	{
		fwrite($fileWrite,"EnableSingleByteFRU = 1");
	}
	
fwrite($fileWrite,"\r\n");

$col = mysqli_query($con,"SELECT * FROM buildConfigParam where md5(bcId) = '$_GET[id]' and paramId = '7'");
			while($rowcol = mysqli_fetch_array($col)){
				$valueX = $rowcol['value']; 
			}
	
	if($valueX!="") 
	{
			fwrite($fileWrite,"PART_NUMBER = ".$valueX);
	}else
	{
		fwrite($fileWrite,"PART_NUMBER = ");
	}

fwrite($fileWrite,"\r\n");

echo "project_build/$projectName/$buildConfigName/ALBERT/";
$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ALBERT/");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$x = 1;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				echo $logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ALBERT/".$logFileName,"r");
				
				
	$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");

	while(! feof($file))
	  {
	  $line = fgets($file);

	if(strpos($line, "bnxtmt version") !== false)
				{
					//bnxtmt version  : 216.2.73.0
					
					$lineOne = $line;
					
					$lineOnes = explode("  : ", $lineOne);
					$bnxtmtVer = $lineOnes[1];
					
					break;
				}
	  }
					
				}
			
		}
		

echo $logFileName;

//Hardware count 
$file = "project_build/$projectName/$buildConfigName/ALBERT/".$logFileName;
	$file = fopen($file,"r");
	
	while(! feof($file))
	  {
	  $line = fgets($file);

	if(strpos($line, "1 : ") !== false)
				{ 	$countMac = "1";
					$lineOne = $line;
					
					$lineOnes = explode("  ", $lineOne);
					$text1 = $lineOnes[2];
					
					$text1s = explode(" ", $text1);
					$macAddr1 = $text1s[0];
					
					
		
				}
				
				if(strpos($line, "2 : ") !== false)
				{
					$countMac = "2";
					$lineTwo = $line;
					
					$lineTwos = explode("  ", $lineTwo);
					$text2 = $lineTwos[2];
					
					$text2s = explode(" ", $text2);
					$macAddr2 = $text2s[0];
					
					
				}
				
				if(strpos($line, "3 : ") !== false)	{ $countMac = "3";}
				if(strpos($line, "4 : ") !== false)	{ $countMac = "4";}
				if(strpos($line, "5 : ") !== false)	{ $countMac = "5";}
				if(strpos($line, "6 : ") !== false)	{ $countMac = "6";}
				if(strpos($line, "7 : ") !== false)	{ $countMac = "7";}
				if(strpos($line, "8 : ") !== false)	{ $countMac = "8";}
				if(strpos($line, "9 : ") !== false)	{ $countMac = "9";}
				if(strpos($line, "10 : ") !== false){ $countMac = "10";}
				if(strpos($line, "11 : ") !== false){ $countMac = "11";}
				if(strpos($line, "12 : ") !== false){ $countMac = "12";}
				if(strpos($line, "13 : ") !== false){ $countMac = "13";}
				if(strpos($line, "14 : ") !== false){ $countMac = "14";}
				if(strpos($line, "15 : ") !== false){ $countMac = "15";}
				if(strpos($line, "16 : ") !== false){ $countMac = "16";}
	  }
	  echo "<br><br>";
	  echo $macDiff = hexdec($macAddr2) - hexdec($macAddr1);
	  $macHex = strtoupper(dechex($macDiff));
	  $countMac = strtoupper(dechex($countMac));

fwrite($fileWrite,"MAC_COUNT = 0x0".$countMac."\r\n");
fwrite($fileWrite,"MAC_INCREMENT = 0x0".$macHex."\r\n");
fwrite($fileWrite,"engineering_diagnostics=".$bnxtmtVer."\r\n");


fclose($fileWrite);




}


function insertQAif($file, $paramId, $projectName, $buildConfigName){  
unlink("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini");  
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  { 
  $line = fgets($file);
  
			  
			   if(strpos($line, "fififi") !== false){
			   $line = "fi
			   
if [ -s DIAG.txt ]; then
	rm DIAG.txt
fi

#creates new file, \"copy DIAG.txt\" is for the parser and must be present, the end
#of this \"copy\" is in FCTTEST.sh
echo \"copy DIAG.txt\" > \$output_file
			   
			   ";
			
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}


function replacemfgload($file, $paramId, $projectName, $buildConfigName, $mfgload2Text){  
unlink("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini");  
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","a");
$file = fopen($file,"r");
$lineOneNotDone = true;
$lineTwoNotDone = true;

while(! feof($file))
  { 
  $line = fgets($file);
  
			  
			   if((strpos($line, "echo ./mfgload.sh -sysop -no_swap -none") !== false) && $lineOneNotDone){
			   $line = "echo ".$mfgload2Text."\r\n";
			   $lineOneNotDone = false;
			
			  }else
			  {
				  $line = $line;
			  }
			  
			   if((strpos($line, "./mfgload.sh -sysop -no_swap -none") !== false) && $lineTwoNotDone){
				$line = $mfgload2Text."\r\n";
				$lineTwoNotDone = false;
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}



function replaceStres($file, $paramId, $projectName, $buildConfigName){  
unlink("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini");  
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","a");
$file = fopen($file,"r");
$lineOneNotDone = true;
$lineTwoNotDone = true;

while(! feof($file))
  { 
  echo $line = fgets($file);
  
			  
			   if((strpos($line, "echo ./mfgload2.sh -sysop -no_swap -none") !== false) && $lineOneNotDone){
			   echo $line = "AFDZAL\r\n";
			   $lineOneNotDone = false;
			
			  }else
			  {
				  $line = $line;
			  }
			  
			   if((strpos($line, "./mfgload2.sh -sysop -no_swap -none") !== false) && $lineTwoNotDone){
				echo $line = "NAZRI\r\n";
				$lineTwoNotDone = false;
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}




function replaceforins($file, $paramId, $projectName, $buildConfigName, $mfgload2Text){  
unlink("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini");  
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","a");
$file = fopen($file,"r");
$lineOneNotDone = true;
$lineTwoNotDone = true;
$endOfWrite = false;

while(! feof($file))
  { 

if($endOfWrite) {break;}

  $line = fgets($file);
  
			  
			   if((strpos($line, "echo ./mfgload.sh -sysop -no_swap -none") !== false) && $lineOneNotDone){
			   $line = "echo ".$mfgload2Text."\r\n";
			   $lineOneNotDone = false;
			
			  }else
			  {
				  $line = $line;
			  }
			  
			   if((strpos($line, "./mfgload.sh -sysop -no_swap -none") !== false) && $lineTwoNotDone){
				$line = $mfgload2Text."\r\n";
				$lineTwoNotDone = false;
				
				$endOfWrite = true;
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}



function insertAfterLine($file, $paramId, $projectName, $buildConfigName){  

$fp = fopen($file, 'a');//opens file in append mode  
fwrite($fp, "


#search output file for pass/fail
#continue to run external loopback test if previous tests passed, otherwise stop here!
if grep -Fq \"\$success_string\" \"\$output_file\" ; then
    # External loopback test requires L2 driver to be loaded.
    insmod bnxt_en.ko
    
    # Work around for CTRL-34559 - Force max speed on all devices
    file=\"/proc/net/dev\"
    while IFS= read -r line
    do
        dev=\"\$(echo \$line | cut -f 1 -d \" \")\"
        dev=\${dev%?}
        drv=\"\$(ethtool -i \$dev 2> /dev/null| grep driver|awk {'print \$2'})\"
        if [ \"\$drv\" == \"bnxt_en\" ]; then
            ethtool -s \$dev speed 100000 autoneg off
        fi
    done <\"\$file\"

    LINE_A
    LINE_B
    
    # Revert to auto neg
    while IFS= read -r line
    do
        dev=\"\$(echo \$line | cut -f 1 -d \" \")\"
        dev=\${dev%?}
        drv=\"\$(ethtool -i \$dev 2> /dev/null| grep driver|awk {'print \$2'})\"
        if [ \"\$drv\" == \"bnxt_en\" ]; then
            ethtool -s \$dev autoneg on
        fi
    done <\"\$file\"

    rmmod bnxt_en.ko
fi

echo \"FCT test completed\" >> \$output_file

#\"file(s) copied\" is for the parser and must be present. The begining of \"files 
#copied\" is in FCTPrg.sh
echo \"file(s) copied\" >> \$output_file



");  
fclose($fp);  
  
echo "File appended successfully";  

}


function replacemfgloadSecond($file, $paramId, $projectName, $buildConfigName, $test3Text){  
unlink("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini");  
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","a");
$file = fopen($file,"r");
$lineOneNotDone = true;
$lineTwoNotDone = true;

while(! feof($file))
  { 


  $line = fgets($file);
  
			  
			   if((strpos($line, "LINE_A") !== false) && $lineOneNotDone){
			   $line = "echo ".$test3Text."\r\n";
			   $lineOneNotDone = false;
			
			  }else
			  {
				  $line = $line;
			  }
			  
			   if((strpos($line, "LINE_B") !== false) && $lineTwoNotDone){
				$line = $test3Text."\r\n";
				$lineTwoNotDone = false;
				
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}



function replaceStresFirst($file, $paramId, $projectName, $buildConfigName, $test3Text){  
unlink("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini");  
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/support/test.ini","a");
$file = fopen($file,"r");
$lineOneNotDone = true;
$lineTwoNotDone = true;

while(! feof($file))
  { 


  $line = fgets($file);
  
			  
			   if((strpos($line, "AFDZAL") !== false) && $lineOneNotDone){
				   $test3Text = str_replace(array("\n", "\r"), '', $test3Text);
			   $line = "echo ".$test3Text." -I \$num_loops\r\n\r\n";
			   $lineOneNotDone = false;
			
			  }else
			  {
				  $line = $line;
			  }
			  
			   if((strpos($line, "NAZRI") !== false) && $lineTwoNotDone){
				   $test3Text = str_replace(array("\n", "\r"), '', $test3Text);
				$line = $test3Text." -I \$num_loops\r\n";
				$lineTwoNotDone = false;
				
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}

function replace009INI($file, $paramId, $projectName, $buildConfigName){ 
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  {
  $line = fgets($file);
  
			  
			  if(strpos($line, "APP::ProgramVerifyFRU") !== false){
			   $line = $line;
		
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}

function insertINI($file, $paramId, $projectName, $buildConfigName){ 
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");
 
while(! feof($file))
  {
  echo $line = fgets($file);
  
    if(strpos($line, "Label1=Mylabel") !== false){
			   $line = "Label1=Mylabel\r\nRevDevLabel1=MyRevDevLabel\r\n";
			   
  			
			  }else
			  {
				  $line = $line;
			  }
			  

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}


function insert002INI($file, $paramId, $projectName, $buildConfigName){ 
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  {
  echo $line = fgets($file);
  
        if(strpos($line, "APP::GenerateSerial") !== false){
			   $line = "001=APP::GenerateSerial\r\n002=APP::GenerateRevDev\r\n";
			   
  			
			  }else
			  {
				  $line = $line;
			  }
			  

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}



function removeUnWanted($file, $paramId, $projectName, $buildConfigName){ 
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  {
  echo $line = fgets($file);
   
			  
			  if(strpos($line, "aaaa") !== false){
			   $line = "";
			
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);




}



function removeUnWantedNum($file, $paramId, $projectName, $buildConfigName){ 
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  {
  echo $line = fgets($file);
   
			  
			  if(strpos($line, "Nurmccs") !== false){
			   $line = "";
			
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);




}



function rewriteProductionTasks($file, $paramId, $projectName, $buildConfigName){ 



unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");
$prodTask = false;
$prodTaskNum = 0;
while(! feof($file))
  {
  $line = fgets($file);
  
        if(strpos($line, "[ProductionTasks]") !== false){
			//$line = $line;
			$prodTask = true;
			  }
			  
			  if(strpos($line, "[OBATasks]") !== false){
			//$line = $line;
			$prodTask = false;
			  }
			  
			  if(!$prodTask){
				  echo "NOT<br>";
					 $line = $line;
			  }else
				  
				  {
					echo "PROD PROCESS HERE<br>"; 

						if(strpos($line, "[ProductionTasks]") !== false){
						$line = $line;
						}

						if(strpos($line, "Num_Task") !== false){
						$line = $line;
						}
						
						if((strpos($line, ";") !== false)){
						$line = "";
						}
						
						if((strpos($line, "::") !== false)){
							$prodTaskNum = str_pad($prodTaskNum, 3, '0', STR_PAD_LEFT);
						$newLine = explode("=",$line);
						$line = $prodTaskNum."=".$newLine[1];
						$prodTaskNum++;
						}
						
					 echo $line;
				  }
			  

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);




}

function removeTaskNumProd($file, $paramId, $projectName, $buildConfigName){ 


unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");
$numTask = false;
while(! feof($file))
  {
  $line = fgets($file);
  
        if(strpos($line, "[ProductionTasks]") !== false){
			$line = $line;
			$numTask = true;
			
  			
			  }else
			  {
				  if(($numTask==true) && (strpos($line, "Num_Task") !== false))
				  {
					$line = "aaaa\r\n"; //this is to delete numtask at ProductionTasks
					echo "DELETED!!";
					$numTask = false;
				  }else{					  
				  
				  $line = $line;
				  }
			  }
			  

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);



}


function writeNumbers($file, $paramId, $projectName, $buildConfigName, $taskQty){ 

unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  {
  $line = fgets($file);
  
        if(strpos($line, "[ProductionTasks]") !== false){
			   echo $line = "[ProductionTasks]\r\nNurmccs_Task=".$taskQty."\r\n";
			   
  			
			  }else
			  {
				  
				  $line = $line;
			  }
			  

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);



}


function writeNumbersProd($file, $paramId, $projectName, $buildConfigName, $taskQty){ 

unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");
//$taskQty++;
while(! feof($file))
  {
  $line = fgets($file);
  
        if(strpos($line, "[ProductionTasks]") !== false){
			   echo $line = "[ProductionTasks]\r\nNum_Task=".$taskQty."\r\n";
			   
  			
			  }else
			  {
				  
				  $line = $line;
			  }
			  

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);



}


function insert008INI($file, $paramId, $projectName, $buildConfigName){ 

unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  {
  echo $line = fgets($file);
  
        if(strpos($line, "[OBATasks]") !== false){
			   $line = "008=APP::FruUnlock\r\n009=APP::ProgramVerifyFRU\r\n010=APP::FruLock\r\n[OBATasks]\r\n";
			   
  			
			  }else
			  {
				  $line = $line;
			  }
			  

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}

function handleProgramVerifyFRU($file, $paramId, $projectName, $buildConfigName){ 


}

function remove008INI($file, $paramId, $projectName, $buildConfigName){ 



unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  {
  echo $line = fgets($file);
  
			  
			  if(strpos($line, "APP::FruUnlock") !== false){
			   $line = "";
			
			  }else
			  {
				  $line = $line;
			  }
			  
			   if(strpos($line, "APP::ProgramVerifyFRU") !== false){
			   $line = "";
			
			  }else
			  {
				  $line = $line;
			  }
			  
			  if(strpos($line, "APP::FruLock") !== false){
			   $line = "";
			
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);



fclose($fileWrite);



}


function remove008INIA($file, $paramId, $projectName, $buildConfigName){ 



unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  {
  echo $line = fgets($file);
  
			  
			  
			  
			   if(strpos($line, "APP::ProgramVerifyFRU") !== false){
			   $line = "";
			
			  }else
			  {
				  $line = $line;
			  }
			  
			

fwrite($fileWrite,$line);
  }
fclose($file);



fclose($fileWrite);



}




function removeINI($file, $paramId, $projectName, $buildConfigName){ 
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  {
  echo $line = fgets($file);
  
			  
			  if(strpos($line, "RevDevLabel1=MyRevDevLabel") !== false){
			   $line = "";
			
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}


function remove002INI($file, $paramId, $projectName, $buildConfigName){ 
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  {
  $line = fgets($file);
  
			  
			  if(strpos($line, "APP::GenerateRevDev") !== false){
			   $line = "";
			
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}



function remove009INI($file, $paramId, $projectName, $buildConfigName){ 
unlink("project_build/$projectName/$buildConfigName/Working Folder/test.ini");
$fileWrite = fopen("project_build/$projectName/$buildConfigName/Working Folder/test.ini","a");
$file = fopen($file,"r");

while(! feof($file))
  {
  $line = fgets($file);
  
			  
			  if(strpos($line, "APP::ProgramVerifyFRU") !== false){
			   $line = "";
			
			  }else
			  {
				  $line = $line;
			  }

fwrite($fileWrite,$line);
  }
fclose($file);
fclose($fileWrite);


}

function addAuditTrail($userid,$activity){
	global $con;
	global $currenttime;
	$sql = "INSERT INTO useractivity(userId,activity,activitytime) VALUES ('$userid','$activity','$currenttime')";
	mysqli_query($con,$sql);
}

function extractGzipFile($source, $destination)
{
	$file_name = $source;
	$buffer_size = 4096; // The number of bytes that needs to be read at a specific time, 4KB here
	$out_file_name = str_replace('.gz', '.tar.gz', $file_name);
	$file = gzopen($file_name, 'rb'); //Opening the file in binary mode
	$out_file = fopen($out_file_name, 'wb');
	// Keep repeating until the end of the input file
	while (!gzeof($file)) {
	   fwrite($out_file, gzread($file, $buffer_size)); //Read buffer-size bytes.
	}
	fclose($out_file); //Close the files once they are done with
	gzclose($file);
	
	

	return true;

}

function extractZipFile($source, $destination)
{
	
	unlink("logfilezip.php"); //delete the log file
	$zip = new ZipArchive;
$res = $zip->open($source);
if ($res === TRUE) {
  $zip->extractTo($destination); 
  $zip->close();
  file_put_contents("logfilezip.php", "UNZIP FILE OK - \r\n", FILE_APPEND);
  return true; 
  
} else {
	file_put_contents("logfilezip.php", $source. "UNZIP NOT OK \r\n", FILE_APPEND);
	return false;
  
}


}

function optionMaster($table, $col_display, $col_value, $value)
{

    global $con;
    $sql = "SELECT * FROM $table ORDER BY $col_display ASC";
    $query = mysqli_query($con, $sql);
    if (mysqli_num_rows($query) > 0)
    {
        while ($row = mysqli_fetch_array($query))
        {
            if ($value == $row[$col_value])
            {
                $selected = 'selected';
            }
            else
            {
                $selected = '';
            }
            $data[] = '<option value="' . $row[$col_value] . '" ' . $selected . '>' . $row[$col_display] . '</option>';
        }
        print_r($data);
    }
}



function optionMasterSelection($table, $col_display, $col_value, $value, $col_selection, $val_select)
{

    global $con;
    $sql = "SELECT * FROM $table WHERE $col_selection like '%$val_select%'  ORDER BY $col_display ASC";
    $query = mysqli_query($con, $sql);
    if (mysqli_num_rows($query) > 0)
    {
        while ($row = mysqli_fetch_array($query))
        {
            if ($value == $row[$col_value])
            {
                $selected = 'selected';
            }
            else
            {
                $selected = '';
            }
            $data[] = '<option value="' . $row[$col_value] . '" ' . $selected . '>' . $row[$col_display] . '</option>';
        }
        print_r($data);
    }
}


function optionMasterFile($table, $col_display, $col_value, $value)
{
//AFDZAL PUT IN HERE to cater removal of return text 
    global $con;
    $sql = "SELECT * FROM $table ORDER BY $col_display ASC";
    $query = mysqli_query($con, $sql);
    if (mysqli_num_rows($query) > 0)
    {
        while ($row = mysqli_fetch_array($query))
        {
            if ($value == $row[$col_value])
            {
                $selected = 'selected';
            }
            else
            {
                $selected = '';
            }
            $data[] = '<option value="' . $row[$col_value] . '" ' . $selected . '>' . str_replace("../../modules/input/files_master_file_versioning/extracted/Master File Versioning/", "", $row[$col_display]) . '</option>';
        }
        print_r($data);
    }
}

function addReturn($data,$new_data){
global $con;
foreach($new_data as $tablecolumn => $datas){
	$table = explode('_',$tablecolumn)[0];
	$column = explode('_',$tablecolumn)[1];
	$data_key = explode('_',$tablecolumn)[2];
	$return_col = explode('_',$tablecolumn)[3];
	$ids = rand(10000000,99999999);
	
	//$sql_check = mysqli_query($con,"SELECT * FROM $table")
	$sql_newdata = "INSERT INTO $table(ids,$column) VALUES ('$ids','$datas')";
	$query_newdata = mysqli_query($con,$sql_newdata);
	$sql_select_newdata = "SELECT * FROM $table WHERE ids = $ids";
	$query_select_newdata = mysqli_query($con,$sql_select_newdata);
	$rownewdata = mysqli_fetch_array($query_select_newdata);
	$data[$data_key] = $rownewdata[$return_col];
}
return $data;
}


   
function custom_copy($src, $dst) {  
   
    $dir = opendir($src);  
    @mkdir($dst);  
   
	foreach (scandir($src) as $file) {  
   
        if (( $file != '.' ) && ( $file != '..' )) {  
            if ( is_dir($src . '/' . $file) )  
            {   
                custom_copy($src . '/' . $file, $dst . '/' . $file);     
            }  
            else {  
                copy($src . '/' . $file, $dst . '/' . $file);  
            }  
        }  
    }  
   
    closedir($dir); 
}   

?>