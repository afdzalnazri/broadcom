<?php 
session_start();
include '../connection.php';
$return = new \stdClass();

$column = $_POST['columns'];
$column = explode(',',$column);
$fk =  json_decode($_POST['fk'],true);

$table = $_POST['table'];
$id = $_POST['id'];
$str_column = '';
$random = rand(1000,9999);
$files = [];
$empty_fields = 0;
$id_column = $_POST['id_column'];
	
	if(isset($_POST['empty_fields'])){$emptyfield = explode(',',$_POST['empty_fields']);};
	if(isset($_POST['empty_fields_validation'])){$emptyfieldvalidation = true; }else{$emptyfieldvalidation = false;};



if(isset($_POST['action']) && $_POST['action'] == 'update_inline'){
	$table = $_POST['table'];
	$idval = $_POST['indexid'];
	$idcol = $_POST['idcol'];
	$values = $_POST['values'];
	
	foreach($values as $col=>$val){
		$col_index = $col + 2;
		$sql_column_name = "select column_name 
from information_schema.columns 
where table_name = '$table' and ordinal_position = $col_index;";
$query_column_name = mysqli_query($con,$sql_column_name);
$row_column_name = mysqli_fetch_array($query_column_name);
$column_name = $row_column_name['column_name'];


		$value = $val[0];
		$type = $val[1];
		if($type == 'date'){
			$value_return[$col] = date_format(date_create($value),'d-M-Y');
		}else{
			$value_return[$col] = $value;
		}
		$sql_str[] = "$column_name = '$value'";
	}
	$str = implode(',',$sql_str);
	$sql = "UPDATE $table SET $str WHERE $idcol = $idval";
	$query = mysqli_query($con,$sql);
	$return->values = $value_return;
	echo json_encode($return);
}else{
		/*Return action*/
	if(isset($_POST['return_action'])){$return_action = $_POST['return_action'];}else{$return_action = '';}
	if(isset($_POST['return_modalid'])){$return_modalid = $_POST['return_modalid'];}else{$return_modalid = '';}
	if(isset($_POST['return_modaltext'])){$return_modaltext = $_POST['return_modaltext'];}else{$return_modaltext = '';}
	if(isset($_POST['return_function'])){$return_function = $_POST['return_function'];}else{$return_function = '';}
	if(isset($_POST['return_params'])){$return_params = $_POST['return_params'];}else{$return_params = '';}
	if(isset($_POST['return_link'])){$return_link = $_POST['return_link'];}else{$return_link = '';}

	foreach($column as $col){
		if(isset($_POST[$col])){
			if($_POST[$col] != ''){
				$str_column .= "".$col." = '".$_POST[$col]."',";
			}else{
				$empty_fields++;
			}
		}
		if(isset($_FILES[$col])){ // Files

				if($_FILES[$col]['size'] != 0){
					$str_column .= "".$col." = '".$random.'_'. basename($_FILES[$col]["name"])."',";
				}
			$files[] = $_FILES[$col];
		}
	}
	
	if($empty_fields_validation){
	if($empty_fields > 0){$return->status = 'empty';$return->error_msg = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="red"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></font><br><br>
								<p><b>Please complete all fields</b></p>
								</center>
							</div>
						</div>'; echo json_encode($return);exit();}
						
   }

	$str_column = substr($str_column, 0, -1);
	$sql = "UPDATE $table SET $str_column WHERE $id_column = $id";
	$query = mysqli_query($con,$sql);

	if(true === $query){ // Files
	if(sizeof($files)>0){
		foreach($files as $file){
			$target_file = '../docs/' .$random.'_'. basename($file["name"]);
			move_uploaded_file($file["tmp_name"], $target_file);
		}
	}
	}

	/* Data for FK table */

	if($query === true && is_array($fk) && sizeof($fk)> 0){
		foreach($fk as $fk_table => $fk_columns){
			$inputs = sizeof($_POST[$fk_table][$fk_columns[0]]);
			for($lines=0;$lines<$inputs;$lines++){$line[$lines] = Array();}
			foreach($fk_columns as $column){
					for($i=0;$i<$inputs;$i++){
						array_push($line[$i],[$column=>$_POST[$fk_table][$column][$i]]);
					}
			}
			echo updateItem($fk_table,$line,$inputs);
		}
	}

	if(true === $query){
		$return->status = 1;
		$return->return_action = $return_action;
		$return->return_modalid = $return_modalid;
		$return->return_modaltext = $return_modaltext;
		$return->return_function = $return_function;
		$return->return_params = $return_params;
		$return->return_link = $return_link;
	}else{
		$return->status = 0;
		$return->error_msg = 'Unsuccessful Update. Please try again';
	}

echo json_encode($return);
}

?>