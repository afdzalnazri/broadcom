<?php

// decompress from gz
$p = new PharData('bnxtmt_en.tar_0_10212020152252.gz');
$p->decompress(); // creates /path/to/my.tar

// unarchive from the tar
//$phar = new PharData('bnxtmt_en.tar_0_10212020152252.tar');
//$phar->extractTo('../build/afdzal/');
echo "OKaa";
/*
function uncompress($srcName, $dstName) {
    $sfp = gzopen($srcName, "rb");
    $fp = fopen($dstName, "w");

    while ($string = gzread($sfp, 4096)) {
        fwrite($fp, $string, strlen($string));
    }
    gzclose($sfp);
    fclose($fp);
	echo "DONE";
}

uncompress("bnxtmt_en.tar_0_10212020152252.gz", "bnxtmt_en.tar_0_10212020152252");
*/
?>