<?php 
if(isset($_GET['page'])){

/* Admin */
if($page == 'user-access'){$title = 'User Access';}
else if($page == 'user-creation'){$title = 'User Creation';}
else if($page == 'user-update'){$title = 'User Update';}
else if($page == 'user-log-activity'){$title = 'User Log Activity';}

/* Input */
else if($page == 'project-creation'){$title = 'Project Creation';}
else if($page == 'project-list'){$title = 'Project List';}
else if($page == 'project-details'){$title = 'Project Details';}
else if($page == 'project-creation-file-extraction'){$title = 'Project Creation (File Extraction)';}
else if($page == 'master-file-versioning'){$title = 'Master File Versioning';}
else if($page == 'bc-script-editing'){$title = 'BC Script Editing';}
else if($page == 'build-config-list'){$title = 'Build Config';}
else if($page == 'build-config-creation'){$title = 'Build Config (Creation)';}
else if($page == 'build-config-copy'){$title = 'Build Config (Copy)';}
else if($page == 'build-config-details'){$title = 'Build Config (Details)';}
else if($page == 'bin_checksum'){$title = 'BIN Checksum Validation';}
else if($page == 'checksum_extra'){$title = 'BIN Checksum Validation - Extra';}

/* Integration */
else if($page == 'create-compilation'){$title = 'Create Compilation';}
else if($page == 'edit-bc-files'){$title = 'Edit BC Files';}
else if($page == 'compilation-start'){$title = 'Start Compilation';}

/* Output */
else if($page == 'mlf-compress-file'){$title = 'MLF Compress File';}

/* File Validation */
else if($page == 'fru-related-verification'){$title = 'FRU Related Verification';}
else if($page == 'compare_file'){$title = 'File Compare';}
else if($page == 'compare_file_cfg'){$title = 'File Compare - TRC';}
else if($page == 'add_checksum'){$title = 'Add Checksum';}
/* Profile */
else if($page == 'change-password'){$title = 'Change Password';}

/* Master Data */
else if($page == 'master-brcm-linux-tool-versioning'){$title = 'BRCM Linux Tool Versioning';}
else if($page == 'master-products'){$title = 'Products';}
else if($page == 'master-family'){$title = 'Family';}
else if($page == 'master-customer'){$title = 'Customer';}
else if($page == 'master-form-factor'){$title = 'Form Factor';}
else if($page == 'master-configuration-parameters'){$title = 'Configuration Parameters';}


/* Page Error */
else{$title = 'Error 404';}

}else{
$title = 'Project Creation';
}
?>