<?php
$myfile = fopen("CRC8.txt", "w") or die("Unable to open file!");
$txt = hexdec($_GET["chcSum8"]); 
fwrite($myfile, $txt);
fclose($myfile);

?>