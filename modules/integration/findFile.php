<?php
$dir = "../../project_build/logitech/loigc_01/Working Folder/support/";
	$fileNameSearch = scandir($dir);
	foreach($fileNameSearch as $fileNameS)
	{
		if(strpos($fileNameS, "mpf") !== false)
		{
			echo $fileNameS;
		}
	}
	
	
	//print_r($fileNameSearch);
	
	?>
									