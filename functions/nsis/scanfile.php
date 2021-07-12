<?php
$path = "../../project_build/ABN-001/q1/ALBERT";
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
$files = array(); 
foreach ($rii as $file) {
    if ($file->isDir()){ 
        continue;
    }
    $files[] = $file->getPathname(); 
}
print("<pre>".print_r($files,true)."</pre>");
echo "<br><br><br>";
foreach($files as $file) {   
   if (strpos($file, 'bc.sh') !== false) { 
   echo $file;//
   //copy the files here
   }
}
?>