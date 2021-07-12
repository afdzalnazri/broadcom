<?php
foreach(glob("../../modules/input/files_master_file_versioning/extracted/Master File Versioning".'/*.*') as $file) {
    $i++;
	
	$crc = crc32(file_get_contents($file));
	echo $file."  -- ".$crc."<br>";
}
	?>