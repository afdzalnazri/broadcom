<?php 
session_start();
include '../connection.php';
$return = new \stdClass();

$column = $_POST['columns'];
$column = explode(',',$column);
$fk =  json_decode($_POST['fk'],true);
	
$table = $_POST['table'];
$ind = $_POST['ind'];
	
	if(isset($_POST['empty_fields'])){$emptyfield = explode(',',$_POST['empty_fields']);};
	if(isset($_POST['empty_fields_validation'])){$emptyfieldvalidation = true; }else{$emptyfieldvalidation = false;};
	
	/*Return action*/
	if(isset($_POST['return_action'])){$return_action = $_POST['return_action'];}else{$return_action = '';}
	if(isset($_POST['return_modalid'])){$return_modalid = $_POST['return_modalid'];}else{$return_modalid = '';}
	if(isset($_POST['return_modaltext'])){$return_modaltext = $_POST['return_modaltext'];}else{$return_modaltext = '';}
	if(isset($_POST['return_function'])){$return_function = $_POST['return_function'];}else{$return_function = '';}
	if(isset($_POST['return_params'])){$return_params = $_POST['return_params'];}else{$return_params = '';}
	if(isset($_POST['return_link'])){$return_link = $_POST['return_link'];}else{$return_link = '';}

	$non_files = Array();
	$empty_fields = 0;
	$error_msg = '<center><font color="red">Operation Error</font></center>';
	
	if(isset($_POST['check_data_exist'])){
		$check_data = json_decode($_POST['check_data_exist']);
		$exists = 0;
		foreach($check_data as $key=>$val){
		$table = $key;
		foreach($val as $clmn => $message){
			$sql = "SELECT $clmn FROM user WHERE $clmn = '".$_POST[$column]."'";
			$query = mysqli_query($con,$sql);
			if(mysqli_num_rows($query)>0){
				$exists++;
				$error_msgs[] = $message;
			}
		}
	}
	
	if($exists > 0){
		$return->status = 0;
		$return->error_msg = '<center><b>'.implode('&',$error_msgs).'</b></center>';
		echo json_encode($return);
		exit();
	}
	}

	foreach($column as $col){
		if(isset($_POST[$col])){
			if($_POST[$col] != ''){
				$arr_value[] = '"'.$_POST[$col].'"';
				$arr_column[] = $col;

			}else{
				if(!in_array($col, $emptyfield)){
					$empty_fields++;
				}
			}
		}


		if(isset($_FILES[$col])){ // Files
			if($_FILES[$col]["name"] != ''){
			$files[] = $_FILES[$col];
			$arr_column[] = $col;
			$arr_value[] = '"'.$ind.'_'. basename($_FILES[$col]["name"]).'"';
			}else{
				//$empty_fields++;
			}
		}else{
			$files = [];
		}
	}

	if(isset($_POST['cb_counter'])){
		if(($empty_fields > 0) || ($_POST['cb_counter'] == 0)){$return->status = 0;$return->error_msg = '<center><font color="red">Please fill up all fields</font></center>'; echo json_encode($return);exit();}
	}

	if($emptyfieldvalidation){
		if($empty_fields > 0){$return->status = 'empty';$return->error_msg = '<center><font color="red">Please fill up all fields</font></center>'; echo json_encode($return);exit();}
	}
	
	$arr_column[] = 'created';
	$arr_value[] = '"'.$currenttime.'"';
	
	
	/*if(isset($_POST['ind'])){
		$arr_column[] = 'indicator';
	    $arr_value[] = '"'.$ind.'"';
	}*/
	
	/*if(isset($_POST[''.$table.'Approve_user_2']) && isset($_POST[''.$table.'Approve_user_3'])){
		$arr_column[] = $table.'Approve_user_2';
		$arr_value[] = '"'.$second_approver.'"';
		$arr_column[] = $table.'Approve_user_3';
		$arr_value[] = '"'.$third_approver.'"';
	}*/

	
	


	$str_column = implode(',',$arr_column);
	$str_value = implode(',',$arr_value);


	$sql = "INSERT INTO $table($str_column) VALUES ($str_value)"; 
	$query = mysqli_query($con,$sql);

		if(true === $query){ // Files
			if(sizeof($files)>0){
				foreach($files as $file){
					echo $target_file = '../docs/' .$ind.'_'. basename($file["name"]);
					move_uploaded_file($file["tmp_name"], $target_file);

				}
			}

			$recent_data = mysqli_query($con,"SELECT * FROM $table WHERE indicator = $ind");
			$rowrecent = mysqli_fetch_array($recent_data);

			$itemid = $rowrecent['id'];
		}





	/* Data for FK table */

	if($query === true && is_array($fk) && sizeof($fk)>0){
		$total_columns = 0;
		foreach($fk as $fk_table => $fk_columns){
			$inputs = sizeof($_POST[$fk_table][$fk_columns[1]]);
			for($lines=0;$lines<$inputs;$lines++){$line[$lines] = Array();}
				foreach($fk_columns as $column){
					$total_columns++;
					for($i=0;$i<$inputs;$i++){
						if($_POST[$fk_table][$column][$i] != ''){
							array_push($line[$i],[$column=>$_POST[$fk_table][$column][$i]]);
						}
					}
			}
			addItem($fk_table,$line,$inputs,$total_columns);
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
		$return->table = $table;
	}else{
		$return->status = 0;
		$return->error_msg = $error_msg;
	}
	echo json_encode($return);

?>