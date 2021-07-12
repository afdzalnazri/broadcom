<?php
session_start();
include '../connection.php';
$return = new \stdClass();


function rmdir_recursive($dirPath){
    if(!empty($dirPath) && is_dir($dirPath) ){
        $dirObj= new RecursiveDirectoryIterator($dirPath, RecursiveDirectoryIterator::SKIP_DOTS); //upper dirs not included,otherwise DISASTER HAPPENS :)
        $files = new RecursiveIteratorIterator($dirObj, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $path) 
            $path->isDir() && !$path->isLink() ? rmdir($path->getPathname()) : unlink($path->getPathname());
        rmdir($dirPath);
        return true;
    }
    return false;
}

$id = $_POST['id'];
$idcolumn = $_POST['idcolumn'];
$table = $_POST['table'];
$sql = "DELETE FROM `$table` WHERE $idcolumn = $id";
$familySelected = '';
$productSelected = '';
if($table == 'project'){

	$sql_select_newdata = "SELECT * FROM $table WHERE id = $id";
	$query_select_newdata = mysqli_query($con,$sql_select_newdata);
	$rownewdata = mysqli_fetch_array($query_select_newdata);
	$productName = $rownewdata['productName'];
	$familySelected = $rownewdata['family'];
	$productSelected = $rownewdata['productNumber'];
	
	
	addAuditTrail($_SESSION['userId'],'DELETE Project : '.$productName);
	
	//delete the family if no more needed
	
}

if($table=='buildConfig')
{
	 
	$sql_select_newdata = "SELECT * FROM $table WHERE id = $id";
	$query_select_newdata = mysqli_query($con,$sql_select_newdata);
	$rownewdata = mysqli_fetch_array($query_select_newdata);
	$buildConfigName = $rownewdata['buildConfigName'];
	$familyId = $rownewdata['familyId'];
	$projectId = $rownewdata['projectId'];
	
	$referenceFolder = $rownewdata['referenceFolder'];
	$productFolder = $rownewdata['productFolder'];
	//delete all the files and folder
	//Thor\BCM957504-N1100FY\test_rev_12
	
	$sql_select_newdata = "SELECT * FROM project WHERE id = $projectId";
	$query_select_newdata = mysqli_query($con,$sql_select_newdata);
	$rownewdata = mysqli_fetch_array($query_select_newdata);
	$productName = $rownewdata['productName'];
	
	$sql_select_newdata = "SELECT * FROM masterFamily WHERE id = $familyId";
	$query_select_newdata = mysqli_query($con,$sql_select_newdata);
	$rownewdata = mysqli_fetch_array($query_select_newdata);
	$familyName = $rownewdata['familyName'];
	
	
	
	$folderToDelete = "..\\..\\project_build\\".$familyName."\\".$productName."\\".$buildConfigName;
	rmdir_recursive($folderToDelete);
	
	addAuditTrail($_SESSION['userId'],'DELETE Build Cofig : '.$buildConfigName.'');
	
}


$query = mysqli_query($con,$sql);


if($table == 'project'){
	
	$query_delete_project = "DELETE FROM $table WHERE $idcolumn = $id ";
	$sql_delete_project = mysqli_query($con,$query_delete_project);

	/*$sql_select_newdata = "SELECT * FROM $table WHERE family = $family";
	$query_select_newdata = mysqli_query($con,$sql_select_newdata);
	$rownewdata = mysqli_fetch_array($query_select_newdata);
	$family = $rownewdata['family'];
	$productNumber = $rownewdata['productNumber'];
	
	
	if($family=="")
	{	
	//delete the family master if no more needed
	$sqlDeleteFamily = "DELETE FROM `masterFamily` WHERE id = $familySelected";
	unlink("sql.txt");
	file_put_contents("sql.txt", "DELETE FROM `masterFamily` WHERE id = $familySelected", FILE_APPEND);	
	$query = mysqli_query($con,$sqlDeleteFamily); 
	}
	
	if($productNumber=="")
	{	
	//delete the family master if no more needed
	$sqlDeleteproductNumber = "DELETE FROM `masterProduct` WHERE id = $productSelected";
	unlink("sql.txt");
	file_put_contents("sql.txt", "DELETE FROM `masterProduct` WHERE id = $productSelected", FILE_APPEND);	
	$query = mysqli_query($con,$sqlDeleteproductNumber); 
	}*/
	
}



if($query){
		$return->return_modaltext = '
		<div class="row">
			<div class="col-md-12">
				<center>
					<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
					<p><b>Item successfully removed</b></p>
				</center>
			</div>
		</div>';
}else{
	$return->return_modaltext = '
		<div class="row">
			<div class="col-md-12">
				<center>
					<font size="10" color="red"><i class="fa fa-times-circle"></i></font><br><br>
					<p><b>Item unsuccessfully removed</b></p>
				</center>
			</div>
		</div>';
}

echo json_encode($return);

?>