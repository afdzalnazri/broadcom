
			//get ANDY INFORMTION
$fileNameSearch = scandir("project_build/$projectName/$buildConfigName/ANDY/andy");
	//echo "project_build/$projectName/$buildConfigName/Working Folder/support/";
	$x = 1;
	foreach($fileNameSearch as $fileNameS)
	{
		
			if(strpos($fileNameS, ".log") !== false)
			{
				//file found
				$logFileName = $fileNameS;
				
				//$logFileName = fopen("project_build/$projectName/$buildConfigName/ANDY/".$logFileName,"r");
					
	$file = "project_build/$projectName/$buildConfigName/ANDY/".$logFileName;
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
					echo "<br>";
				}
				
				//
				
				
				
				
	  }
					
				}
			
		}