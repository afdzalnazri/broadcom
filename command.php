<?php
$output=null;
$retval=null;
//exec('tar -zxvf fm.tar.gz ../..//filecompare/', $output, $retval);
system("tar -cvzpf backup.tar.gz /fa/"); 
echo "Returned with status $retval and output:\n";
print_r($output);
?>