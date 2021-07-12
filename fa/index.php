<?php 
////////////////
unlink("file1.txt");
	$target_dir = "uploads/";
$target_file_A = $target_dir . basename($_FILES["fileA"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file_A,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image

  

 
// Allow certain file formats
if($imageFileType != "log") {
  echo "<strong>Sorry, only LOG files are allowed.</strong>";
  $uploadOk = 0;
}
 
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<strong>Sorry, your file was not uploaded.</strong>";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileA"]["tmp_name"], "../".$target_file_A)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileA"]["name"])). " has been uploaded.";
  } else {
    echo "<strong>Sorry, there was an error uploading your file.</strong>";
  }
}


echo "<br>";     
echo "../".$target_file_A;
copy ("../".$target_file_A, $_FILES["fileA"]["name"]);
echo $fileA = $_FILES["fileA"]["name"];

if(rename($fileA,"file1.txt")) echo "renamed"; 


unlink("file2.txt");
	$target_dir = "uploads/";
$target_file_A = $target_dir . basename($_FILES["fileB"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file_A,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  

 
// Allow certain file formats
if($imageFileType != "log") {
  echo "<strong>Sorry, only LOG files are allowed.</strong>";
  $uploadOk = 0;
}
 
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<strong>Sorry, your file was not uploaded.</strong>";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileB"]["tmp_name"], "../".$target_file_A)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileB"]["name"])). " has been uploaded.";
  } else {
    echo "<strong>Sorry, there was an error uploading your file.</strong>";
  }
}
}

echo "<br>";     
echo "../".$target_file_A;
copy ("../".$target_file_A, $_FILES["fileB"]["name"]);
echo $fileB = $_FILES["fileB"]["name"];

if(rename($fileB,"file2.txt")) echo "renamed"; 



//////////////
// Display source code
if (basename ($_SERVER['PHP_SELF']) === basename (__FILE__)) {
    if (isset ($_GET['source'])) {
        header ('Content-type: text/plain; charset=UTF-8');
        exit (file_get_contents (basename (__FILE__)));
    }
}


// Replace '<' and '>' Characters
function replace ($input)
{
    return str_replace (array ('<', '>'), array ('&lt;', '&gt;'), $input);
} 
// Read files


$cf = replace (file_get_contents ('file1.txt')); // Current Version
$of = replace (file_get_contents ('file2.txt')); // Old Version
// Line Arrays
$cv = explode ("\n", $cf);
$ov = explode ("\n", $of);
// Count Lines - Set to Longer Version
$lc = (count ($cv) > count ($ov)) ? count ($cv) : count ($ov);
// Fix Mismatched Line Counts
for ($flc = count ($ov); $flc < $lc; $flc++) {
    $ov[$flc] = '';
}
// Begin HTML Table
echo '<table width="100%">', "\n<tbody>\n<tr>\n";
// Begin diff column
echo '<td valign="top">', "\nCurrent Version:<hr>\n<pre>\n";
for ($l = 0; $l < $lc; $l++) {
    // Word Arrays
    $cw = explode (' ', $cv[$l]); // Current Version
    $ow = explode (' ', $ov[$l]); // Old Version
    // Count Words - Set to Longer Version
    $wc = (count ($cw) > count ($ow)) ? count ($cw) : count ($ow);
    // Fix Mismatched Word Counts
    for ($fwc = count ($ow); $fwc < $wc; $fwc++) {
        $ow[$fwc] = '';
    }
    // If each line is identical, just echo the normal line. If not,
    // check if each word is identical. If not, wrap colored "<b>"
    // tags around the mismatched words.
    if ($cv[$l] !== $ov[$l]) {
        for ($w = 0; $w < $wc; $w++) {
            if ($cw[$w] === $ow[$w]) {
                echo $cw[$w];
                echo ($w !== ($wc - 1)) ? ' ' : "\n";
            } else {
                echo '<b style="color: #BB0000;">', $cw[$w];
                echo ($w !== ($wc - 1)) ? '</b> ' : "</b>\n";
            }
        }
    } else {
        echo $cv[$l], "\n";
    }
}
// End diff column
echo "</pre>\n</td>\n<td>&nbsp;</td>\n";
// Begin old version column
echo '<td valign="top">', "\nOld Version:<hr>\n<pre>\n";
echo $of, "\n";
// End old version column
echo "</pre>\n</td>\n";
// End HTML table
echo "</tr>\n</tbody>\n</table>";

