<?php 
// include the Diff class
require_once 'class.Diff.php';


echo Diff::toTable(Diff::compareFiles('old.txt', 'new.txt'));

?>