<?php 
session_start();
include '../connection.php';

$action = $_POST['action'];
$userid = $_SESSION['userId'];

$return = new \stdClass();

if($action == 'get_bc_family'){
	$familyid = $_POST['familyid'];
	
	$sql = "SELECT * FROM project WHERE family = $familyid";
	$query = mysqli_query($con,$sql);
	$option[] = '<option value="">Select Project</option>';
	while($row = mysqli_fetch_array($query)){
		$option[] = '<option value="'.$row['id'].'">'.$row['productName'].'</option>';
	}
	
	$return->data = $option;
	echo json_encode($return);
}


if($action == 'get_bc_bc'){
	$projid = $_POST['projid'];
	
	$sql = "SELECT * FROM buildConfig WHERE projectId = $projid";
	$query = mysqli_query($con,$sql);
	$option[] = '<option value="">Select Build Configuration</option>';
	while($row = mysqli_fetch_array($query)){
		$option[] = '<option value="'.$row['id'].'">'.$row['buildConfigName'].'</option>';
		
		
	}
	
	$return->data = $option;
	echo json_encode($return);
}

if($action == 'get_bc_file'){
	$bcid = $_POST['bcid'];
	
	$sql = "SELECT * FROM buildConfig WHERE id = $bcid";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query);
	$product_folder = "../../modules/input/files_build_config/".$row['productFolder'];
    $reference_folder = "../../modules/input/files_build_config/".$row['referenceFolder'];
	$projectNameReal = $row['projectName'];
	$projectId = $row['projectId'];
	$familyID = $row['familyId'];
	
	$sqlFamily = "SELECT * FROM masterfamily WHERE id = $familyID";
	$queryFamily = mysqli_query($con,$sqlFamily);
	$rowFamily = mysqli_fetch_array($queryFamily);
	$familyName = $rowFamily['familyName'];
	$bcName  = $row['buildConfigName'];
		$buildConfigNameReal = $familyName."/".$row['buildConfigName'];
	$options[] = '<option value="">Select File</option>';

	// Get all files
	$product_files = scandir($product_folder);
	$reference_files = scandir($reference_folder);


	foreach($product_files as $index=>$product_file){
		if($product_file != '.' && $product_file != '..'){  
			$options[] = '<option value="'.$row['productFolder'].'/'.$product_file.'">'.$product_file.' (Products File)</option>';
			//$productfiles[] = '<a href="javascript:void(0)" onclick=\'dispbcFile("'.$row['productFolder'].'/'.$product_file.'")\'>'.$product_file.'</a>';
			$productfiles[] = '<a href="fm/index.php?p='.$row['productFolder'].'">Product File</a>';//afdzal change this
		}
	}
	foreach($reference_files as $index=>$reference_file){
		if($reference_file != '.' && $reference_file != '..'){
			$options[] = '<option value="'.$row['referenceFolder'].'/'.$reference_file.'">'.$reference_file.' (Reference File)</option>';
			$referencefiles[] = '<a href="javascript:void(0)" onclick=\'dispbcFile("'.$row['referenceFolder'].'/'.$reference_file.'")\'>'.$reference_file.'</a>';
			//$referencefiles[] = '<a href="'.$row['referenceFolder'].'/'.$reference_file.'")\'>'.$reference_file.'"</a>'; //afdzal change this
		}	$referencefiles[] = '<a href="fm/index.php?p='.$row['referenceFolder'].'">Reference File</a>';//afdzal change this
	}
	
	$fileexplorer = '<b><a href="#">Products Files</a></b><br>';
	$i = 1;
	foreach($productfiles as $index => $pf){
		$fileexplorer .= '<div class="row row-form">
			<div class="col-md-1">'.$i++.'.</div>
			<div class="col-md-11">'.$pf.'</div>
		</div>'; 
		break;
	}
	
	$fileexplorer .= '<br><br><b><a href="#">Reference Files</a></b><br>';
	$j = 1;
	foreach($referencefiles as $index => $rf){
		$fileexplorer .= '<div class="row row-form">
			<div class="col-md-1">'.$j++.'.</div>
			<div class="col-md-11">'.$rf.'</div>
		</div>'; 
		break;
	} 

	//$return->data = $options;
	//$return->data = $fileexplorer;   
	//$_SESSION['fileHome'] = $projectNameReal."/".$buildConfigNameReal;
	
	//$return->data = "<a href='fm/index.php?p=".$projectNameReal."/".$buildConfigNameReal."' class='btn btn-primary' >EDIT BUILD FILE</a>";
	
	$sql = "SELECT * FROM project WHERE id = $projectId";
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query);
	$projectNameReal = $row['productName'];
	
	//$_SESSION['fileHome'] = $projectNameReal."/".$buildConfigNameReal;
	$_SESSION['fileHome'] = $familyName."/".$projectNameReal."/".$bcName;
	$return->data = "<a href='fm/index.php?p=".$a."' class='btn btn-primary' >EDIT BUILD FILE</a>";
	
	//$return->data = "<a href="">Reference File for : http://206.189.155.0/broadcom/fm/index.php?p=products_51280887</a><br><a>Product File file for : </a>";
	
	
	
	echo json_encode($return);
}

if($action == 'display_bc_file'){
	$scriptname = $_POST['scriptname'];
	$data = file_get_contents('../../modules/input/files_build_config/'.$scriptname);
	$return->data = $data;
	echo json_encode($return);
}

if($action == 'check_existing'){
	$table = $_POST['table'];
	$column = $_POST['resetinput'];
	$value = $_POST['valus'];
	
	$query = "SELECT * FROM $table WHERE $column = '$value'";
	$sql = mysqli_query($con,$query);
	if(mysqli_num_rows($sql)>0){
		$return->status = 1;
	}else{
		$return->status = 0;
	}
	echo json_encode($return);
}


?>