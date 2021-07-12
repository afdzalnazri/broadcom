<?php

$tarfile = "2.5.0.0-RC1.tar";
$pd = new \PharData($tarfile);
$pd->buildFromDirectory("build/");
$pd->compress(\Phar::GZ);

?>