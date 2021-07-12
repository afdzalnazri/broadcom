<?php
$file_name = 'a.gz';
$buffer_size = 4096; // The number of bytes that needs to be read at a specific time, 4KB here
$out_file_name = str_replace('.gz', '', $file_name);
$file = gzopen($file_name, 'rb'); //Opening the file in binary mode
$out_file = fopen($out_file_name, 'wb');
// Keep repeating until the end of the input file
while (!gzeof($file)) {
   fwrite($out_file, gzread($file, $buffer_size)); //Read buffer-size bytes.
}
fclose($out_file); //Close the files once they are done with
gzclose($file);
?>