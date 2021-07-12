<?php	
//echo $tarfile = $folderName.".tar";
//C:\xampp\htdocs\broadcom\project_build\Thor\BCM957504-N1100G\BC-10367.3\bc\bnxtmt-218.0.169.1-x86_64-bnxt_en-1.10.2-218.0.67.0\bnxtmt-218.0.169.1-x86_64-bnxt_en-1.10.2-218.0.67.0
/*
$folderName = "bnxtmt-218.0.169.1-x86_64-bnxt_en-1.10.2-218.0.67.0";
echo $tarfile= "../../project_build/Thor/BCM957504-N1100G/BC-10367.3/bc/".$folderName.".tar";
//$p = new \PharData($tarfile);
echo "<br>1";

//$tarfile = "2.5.0.0-RC1.tar";
$pd = new \PharData($tarfile);
echo "<br>2";

$pd->buildFromDirectory("../../project_build/Thor/BCM957504-N1100G/BC-10367.3/bc/".$folderName."/");

echo "<br>3";
$pd->compress(\Phar::GZ);
echo "<br>4";

echo "compress done";
*/
/*form system 1
try 
{
	$a = new PharData('fromsystem.tar');
	echo "1<br>";
	//$a->addFile('a.txt');
	
	//a->addFile('b.txt');
	$folderName = "bnxtmt-218.0.169.1-x86_64-bnxt_en-1.10.2-218.0.67.0";
	$a->buildFromDirectory("../../project_build/Thor/BCM957504-N1100G/BC-10367.3/bc/".$folderName."/");

	echo "2<br>";
	$a->compress(Phar::BZ2);
	$a->compress(\Phar::GZ);
	echo "3<br>";
} 
catch (Exception $e) 
{
	echo "Exception : " . $e;
}
*/

try 
{
    $a = new PharData('fromsystem3.tar');

   $folderName = "bnxtmt-218.0.169.1-x86_64-bnxt_en-1.10.2-218.0.67.0";
	$a->buildFromDirectory("../../project_build/Thor/BCM957504-N1100G/BC-10367.3/bc/".$folderName."/");

	echo "2<br>";
} 
catch (Exception $e) 
{
   echo "Exception : " . $e;
}
file_put_contents('fromsystem3.tar.gz' , gzencode(file_get_contents('fromsystem3.tar')));
//Now compress to tar.gz
//file_put_contents('archive.tar.gz' , gzencode(file_get_contents('archive.tar')));

	echo "3<br>";
?>