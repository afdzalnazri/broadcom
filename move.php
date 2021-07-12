<?php

 // Function to remove folders and files 
    function rrmdir($dir) {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file)
                if ($file != "." && $file != "..") rrmdir("$dir/$file");
            rmdir($dir);
        }
        else if (file_exists($dir)) unlink($dir);
    }

    // Function to Copy folders and files       
    function rcopy($src, $dst) {
        if (file_exists ( $dst ))
            rrmdir ( $dst );
        if (is_dir ( $src )) {
            mkdir ( $dst );
            $files = scandir ( $src );
            foreach ( $files as $file )
                if ($file != "." && $file != "..")
                    rcopy ( "$src/$file", "$dst/$file" );
        } else if (file_exists ( $src ))
            copy ( $src, $dst );
    }
	
	 function recurse_copy($src,$dst) { 
        $dir = opendir($src); 
        mkdir($dst); 
        while(false !== ( $file = readdir($dir)) ) { 
            if (( $file != '.' ) && ( $file != '..' )) { 
                if ( is_dir($src . '/' . $file) ) { 
                    recurse_copy($src . '/' . $file,$dst . '/' . $file); 
					//echo "la..";
                } 
                else { 
                    copy($src . '/' . $file,$dst . '/' . $file); 
					//echo "li..";
                } 
            } 
        } 
        closedir($dir); 
    }
	
	 //..\..\project_build\BCM957504-N1100FZ\change_name
//..\..\project_build\BCM957504-N1100FY\change_name


	//$source = "project_build\\Thor\\BCM957504-N1100FY\\change_name";
	//$destination = "project_build\\Thor\\BCM957504-N1100FZ\\change_name";
	
	
?>