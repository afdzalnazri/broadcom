<?php 
session_start();

error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 1);

include 'functions/connection.php';
//$_SESSION['userId'] = 1;
if(!isset($_SESSION['userId'])){ // If user is not logged in
	include 'login.php';
}else{
$userId = $_SESSION['userId'];
$user = mysqli_query($con,"SELECT * FROM user WHERE id = $userId");
$rowuser = mysqli_fetch_array($user);


$page = $_GET['page'];

include 'title.php';
include 'header.php';

if(isset($_GET['page'])){

/* Admin */
if($page == 'user-access'){include 'modules/admin/user_access.php';}
else if($page == 'user-creation'){include 'modules/admin/user_create.php';}
else if($page == 'user-update'){include 'modules/admin/user_update.php';}
else if($page == 'user-log-activity'){include 'modules/admin/user_log_activity.php';}

/* Input */
else if($page == 'project-creation'){include 'modules/input/project_creation.php';} 
else if($page == 'project-list'){include 'modules/input/project_list.php';} 
else if($page == 'project-details'){include 'modules/input/project_list.php';}
else if($page == 'project-creation-file-extraction'){include 'modules/input/project_creation_file_extraction.php';}
else if($page == 'master-file-versioning'){include 'modules/input/master_file_versioning.php';}
else if($page == 'bc-script-editing'){include 'modules/input/bc_script_editing.php';}
else if($page == 'build-config-list'){include 'modules/input/build_config.php';}
else if($page == 'build-config-creation'){include 'modules/input/build_config.php';}
else if($page == 'build-config-copy'){include 'modules/input/build_config.php';}
else if($page == 'build-config-details'){include 'modules/input/build_config.php';}

/* Integration */
else if($page == 'create-compilation'){include 'modules/integration/create_compilation.php';}
else if($page == 'compilation-start'){include 'modules/integration/compilation_start.php';}
else if($page == 'edit-bc-files'){include 'modules/integration/edit_bc_files.php';}


/* Output */
else if($page == 'mlf-compress-file'){include 'modules/output/mlf_compress_file.php';}

/* File Validation */
else if($page == 'fru-related-verification'){include 'modules/validation/fru_related_verification.php';}
else if($page == 'compare_file'){include 'modules/validation/compare_file.php';}
else if($page == 'compare_file_cfg'){include 'modules/validation/compare_file_config.php';}
else if($page == 'bin_checksum'){include 'modules/validation/bin_checksum.php';}
else if($page == 'add_checksum'){include 'modules/validation/add_checksum.php';}
else if($page == 'checksum_extra'){include 'modules/validation/checksum_extra.php';}


/* Profile */
else if($page == 'change-password'){include 'modules/admin/update_password.php';}

/* Master Data */
else if($page == 'master-brcm-linux-tool-versioning'){include 'modules/master/brcm_linux_tool_versioning.php';}
else if($page == 'master-products'){include 'modules/master/products.php';}
else if($page == 'master-family'){include 'modules/master/family.php';}
else if($page == 'master-customer'){include 'modules/master/customer.php';}
else if($page == 'master-form-factor'){include 'modules/master/form_factor.php';}
else if($page == 'master-configuration-parameters'){include 'modules/master/conf_parameters.php';}

/* output */
else if($page == 'mlf-compress-file-start'){include 'modules/output/mlf-compress-file-start.php';}

/* Page Error */
else{include 'modules/error/404.php';}

}else{
	include 'modules/input/project_creation.php'; 
}


include 'footer.php';	
}
?>