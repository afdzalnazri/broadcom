<?php 
echo $filePath = "../../project_build/logitech/loigc_01/Working Folder/support/FCTPRG.sh";
				echo "<br><br><br>";		
fclose($filePath);
if (file_exists($filePath)) {
   					// yes the file does exist
  					 echo "YES";
					 
					 			
if(unlink($filePath)) {
	echo "deleted";
}else
{
echo "dada";
}


				}else{
					echo "NO";
				}
	
?>