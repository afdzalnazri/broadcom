<?php


function crc8_calc($hex_string)
{
    echo $bin_data = pack('H*',$hex_string);
    $bin_length = strlen($bin_data);

    $CRC = 0;
    $tmp = 0;
    $pos = 0;

    while($bin_length>0)
    {
        $tmp = $CRC << 1;
        $tmp = $tmp + ord($bin_data[$pos]); //Added ord

        $CRC = ($tmp + ($tmp >> 8)) & 0xFF;
        $bin_length --;
        $pos++ ;
    }
    return $CRC;
}
echo crc8_calc("5");
?>