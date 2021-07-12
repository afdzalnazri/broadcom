<?php

function crcnifull ($dato, $byte)
{
  static $PolyFull=0x8c;
 
  for ($i=0; $i<8; $i++)
  {
    $x=$byte&1;
    $byte>>=1;
    if ($dato&1) $byte|=0x80;
    if ($x) $byte^=$PolyFull;
    $dato>>=1;
  }
  return $byte;
}
 
function crc8 (array $ar,$n=false)
{
  if ($n===false) $n=count($ar);
  $crcbyte=0;
  for ($i=0; $i<$n; $i++) $crcbyte=crcnifull($ar[$i], $crcbyte);
  return $crcbyte;
}
 
function sbin2ar($sbin)
{
  $ar=array(); 
  $ll=strlen($sbin);
  for ($i=0; $i<$ll; $i++) $ar[]=ord(substr($sbin,$i,1));
  return $ar;
}
 
echo $crc8=crc8(sbin2ar("AA"));

?>