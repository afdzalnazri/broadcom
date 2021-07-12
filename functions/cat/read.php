<?php 
session_start();
include '../connection.php';
$return = new \stdClass();
$action = $_POST['action'];

if($action == 'read_table'){

$table = str_replace('"','',$_POST['table']);
$columns = json_decode($_POST['column'],true);
$where = json_decode($_POST['where'],true);
$filter = json_decode($_POST['filter'],true);
$order = json_decode($_POST['order'],true);

$result = '';
$sql_columns = '';
$sql_where = '';
$sql_order = '';
$sql_filter = '';
$error_msg = 'Operation Error';

	/*--- Columns ---*/
	if(is_array($columns)){
		foreach($columns as $col_details){
			$tbl_header[] = $col_details['title_column'];
		}
	}

	/*--- Where ---*/

	if(is_array($where) && sizeof($where)>0){
		$sql_where .= 'WHERE ';
		foreach($where as $where_details){
				$sql_where .= ' '.$where_details['condition'].' '.$where_details['column'].' '.$where_details['operator'].' "'.$where_details['value'].'"';
		}
	}

	/*--- Order ---*/
	if(is_array($order) && sizeof($order)>0){
		$sql_order = 'ORDER BY '.$order['column'].' '.$order['order'];
	}


	/*--- Filter ---*/

	if(is_array($filter) && sizeof($filter)){
		$filter_str = '';
		$filter_count = 0;
		foreach($filter as $filter_info){
			$db_col = $filter_info['db_column'];
			$operator = $filter_info['operator'];
			$value = $_POST[$filter_info['input_name']];
			$condition = $filter_info['condition'];
			$fk_filter = $filter_info['fk'];

			if(is_array($fk_filter) && sizeof($fk_filter) > 0){
				$fk_table = $fk_filter['fk_table'];
				$fk_search_col = $fk_filter['fk_col'];
				$fk_return_col = $fk_filter['fk_return_col'];
				if($value != ''){
					$filter_fk_filtering = "SELECT * FROM $fk_table WHERE $fk_search_col LIKE '%$value%'";
					$filter_fk = mysqli_query($con,$filter_fk_filtering);
						if(mysqli_num_rows($filter_fk)>0){
							$rowfilter = mysqli_fetch_array($filter_fk);
							$value = $rowfilter[$fk_return_col];
						}
				}
			}

			if($value != ''){
			  $filter_count++;
			  if($filter_count == 1){$condition = '';}
			  if($operator == 'LIKE'){$value = '"%'.$value.'%"';}else{$value = '"'.$value.'"';}
			  $filter_str .= ' '. $condition.' '.$db_col.' '.$operator.' '.$value.'';
			}
		}

		if($filter_count > 0){
			if(sizeof($where) == 0){
				$sql_where .= 'WHERE ';
			}
			if(is_array($where) && sizeof($where)>0){
				$sql_where .= 'AND ';
			}
			 $sql_where .= '('.$filter_str.')';
		}
	}


	/* Pagination */
	if(isset($_POST['page_no'])){
		$page_no = (int)$_POST['page_no'];
	}else{
		$page_no = 1;
	}

	$records_per_page = 20; 
	$offset = ($page_no - 1) * $records_per_page;
	$total_pages_sql = mysqli_query($con,"SELECT COUNT(*) FROM $table $sql_where");
	$total_rows = mysqli_fetch_array($total_pages_sql)[0];
	$total_pages = ceil($total_rows / $records_per_page);

	$sql = "SELECT * FROM $table $sql_where $sql_order LIMIT $offset, $records_per_page";
	$query = mysqli_query($con,$sql);

	if(mysqli_num_rows($query)>0){

		$result .= '<table class="table table-head-fixed text-nowrap">';

		/*--- Header(Start) ---*/
		$result .= '<thead><tr>';
		$result .= '<th>#</th>';
		foreach($tbl_header as $key=>$tbl_header_display){
			$result .= '<th>'.$tbl_header_display.'</th>';
		}
		$result .= '</tr></thead>';
		/*--- Header(End) ---*/

		$result .= '<tbody>';
		$num = $offset+1;
		$i_row = 0;
		while($row = mysqli_fetch_array($query)){
		$num_row = $i_row++;
		$result .= '<tr>';
		$result .= '<td width="5%">'.$num++.'.</td>';
		$i_col = 0;
		if(is_array($columns)){
		
		foreach($columns as $col_details){
			//$href=$col_details['display']['property']['page'].'&'.$col_details['display']['property']['param'].'=';
			$num_col = $i_col++;

			$function_params = '';
			$params = [];

			if(sizeof($col_details['fk'])>0){ // If FK is available
					$fk_table = $col_details['fk']['fk_table']; // Table containing FK
					$fk_id_col = $col_details['fk']['fk_id_column']; // Reference column in FK table
					$fk_db_col = $col_details['fk']['fk_db_column']; // Reference table in main table
					$fk_display_col = $col_details['fk']['fk_display_column']; // Column to display
					$fk_sql = "SELECT $fk_display_col FROM $fk_table WHERE $fk_id_col = $row[$fk_db_col]";
					$fk_query = mysqli_query($con,$fk_sql);
						$rowfk = mysqli_fetch_array($fk_query);
						$td_display = $rowfk[$fk_display_col];


			}else{
					$td_display = $row[$col_details['db_column']];
			}

			$display_type = $col_details['display']['type'];
			if($col_details['display']['format'] == 'date'){
					$td_display = date_format(date_create($td_display),"d-M-Y");
			}
			if($col_details['display']['format'] == 'datetime'){
					$td_display = date_format(date_create($td_display),"d-M-Y (h:i A)");
			}
			if($col_details['display']['format'] == 'number'){
				$td_display = number_format($td_display,2);
			}

			$href = ''.$col_details['display']['property']['page'].'&'.$col_details['display']['property']['param'].'='.md5($td_display).'';

			/*---- Functions ----*/
			$func_list = [];
			$functions_str = '';
			$functions = $col_details['display']['property']['function'];

			if(sizeof($functions)>0){

				foreach($functions as $func_det){
					$function_call = $func_det['function_call'];
					$function_name = $func_det['function_name'];
					$function_params = $func_det['function_params'];

					foreach($function_params as $param){
						if(strpos($param, 'row') !== false){
							$params[] = "'".$row[substr($param,4)]."'";
						} else{
							$params[] = "'".$param."'";
						}
					}
					$func_params = implode(',',$params);
					$func_list[] = ''.$function_name.'('.$func_params.')';


				}
					$href="javascript:void(0)";
					$functions_str = implode(',',$func_list);
			}


			$display_as = $col_details['display']['display_as'];
			if(isset($display_as) && sizeof($display_as)>0){
				if(array_key_exists($td_display,$display_as)){
					$td_display = $display_as[$td_display];
				}
			}
			
			// Assign ID
			//$element_id = '';
			if(isset($col_details['display']['property']['id'])){
				$element_id = $col_details['display']['property']['id'];
				$arr_element_id = explode('_',$element_id);
				$arr_element_id_total = sizeof($arr_element_id);
				$arr_id =  Array();

				// Detect if last string is row
				if(end($arr_element_id) == "row"){
					for($i_id=0;$i_id<($arr_element_id_total - 2);$i_id++){
						$arr_id[] = $arr_element_id[$i_id];
					}
					$element_id_db = $arr_element_id[$arr_element_id_total-2];
					$arr_id[] = $row[$element_id_db];
				}else{
					for($i_id=0;$i_id<($arr_element_id_total);$i_id++){
						$arr_id[] = $arr_element_id[$i_id]; 
					}
				}

				$element_id = implode('_',$arr_id);
			}else{
				$element_id = 'col_'.$num_col.'_'.$row['id'].''; 
			}

			if($display_type == 'text'){
				$result .= '
				<td width="'.$col_details['width'].'" id="'.$element_id.'">'.$td_display.'</td>';
			}else if($display_type == 'link'){
				$result .= '
				<td width="'.$col_details['width'].'">
					<a id="'.$element_id.'" class="'.$col_details['display']['property']['class'].'" target="'.$col_details['display']['property']['target'].'" href="'.$col_details['display']['property']['page'].'&'.$col_details['display']['property']['param'].'='.md5($td_display).'">'.$rowfk[$fk_display_col].'</a>
				</td>';
			}else if($display_type == 'button'){

				if($col_details['display']['property']['text'] == 'td_display'){$button_text = $td_display;}
				else{$button_text = $col_details['display']['property']['text'];}

				$result .= '
				<td width="'.$col_details['width'].'">
					<a target="'.$col_details['display']['property']['target'].'" href="'.$href.'">
						<button class="'.$col_details['display']['property']['class'].'" id="'.$element_id.'" onclick='.$functions_str.' >'.$button_text.'</button>
					</a>
				</td>';
			}else if($display_type == 'status'){
				$arr_conditions = $col_details['display']['property_status']['conditions'];
				$selected_key = 'hee';
				foreach($arr_conditions as $key=>$condition){
					$cond = true;
					$arr_values = $condition['values'];
					foreach($arr_values as $column=>$value){
						$sql_status = "SELECT * FROM $table WHERE $col_details[db_column] = '$td_display'";
						$query_status = mysqli_query($con,$sql_status);
						$rowstatus = mysqli_fetch_array($query_status);
						
						if($rowstatus[$column] == $value){
							$cond = true;
						}else{
							$cond = false;
						}
					}
					$selected_key = $key;
					if($cond){break;}
					
				}
				
				$display_type = $col_details['display']['property_status']['conditions'][$selected_key]['display_type'];
				$display_text = $col_details['display']['property_status']['conditions'][$selected_key]['display_text'];
				
				$check_text = substr($display_text, 0, 2);
				
				if($check_text == 'row'){$display_text = $td_display;}
				
				$display_class = $col_details['display']['property_status']['conditions'][$selected_key]['display_class'];
				
				if($display_type == 'text'){
					$result .= '<td width="'.$col_details['width'].'"><font class="'.$display_class .'" id="'.$element_id.'">'.$display_text.'</font></td>';
				}else{
				
					$display_page = $col_details['display']['property_status']['conditions'][$selected_key]['display_page'];
					$arr_display_params = $col_details['display']['property_status']['conditions'][$selected_key]['display_params'];
					foreach($arr_display_params as $param=>$param_details){
						$encryption = $param_details[1];
						$param_value = $param_details[0];
						
						$check_param = substr($param_value, 0, 4);
				
						if($check_param == 'row_'){$param_value = $td_display;}
						
						if($encryption == 'md5'){
							$param_value = md5($param_value);
						}
						$parameters[] = $param.'='.$param_value;
					}
				
					$params = implode('&',$parameters);
					
					$href_status = '?page='.$display_page.'&'.$params;
					
					if($display_type == 'button'){
						$result .= '
						<td width="'.$col_details['width'].'">
						<a target="'.$col_details['display']['property']['target'].'" href="'.$href_status.'">
							<button class="'.$display_class.'" id="'.$element_id.'">'.$display_text.'</button>
						</a>
					</td>';
						
						
					}else if($display_type == 'link'){
						
						
					}
					
					
				
				}

				
			}



		}
	}

		$result .= '</tr>';


		}

		$result .='
			</tbody>
		</table>';

		if($total_pages > 1){
	$result .= '
	<div class="row row-form"><div class="col-md-12"><center>
	<ul style="margin:auto" class="pagination">';

	$next_page = $page_no + 1;
	$last_page = $page_no - 1;

	if($total_pages > 3){

		if($page_no != $total_pages){
		if($last_page == 0){
			$last_page = 1;
			$limit_page = $next_page + 1;
		}else{
			$limit_page = $next_page;
			$result .= '<li class="pagination-lg page-link" style="background-color:#efefef;font-weight:bold" onclick=\'read("'.$_POST['formname'].'",'.$_POST['dt'].','.$last_page.')\'><a href="javascript:void(0)">Prev</a></li>';
		}

		for($i=$last_page;$i<=$limit_page;$i++){
			if($i == $page_no){$class_pagination = 'class="active pagination-lg page-link"';}else{$class_pagination = 'class="pagination-lg page-link"';}
			$result .= '<li '.$class_pagination.' onclick=\'read("'.$_POST['formname'].'",'.$_POST['dt'].','.$i.')\'><a href="javascript:void(0)">'.$i.'</a></li>';
		}

		if($next_page != $total_pages){
			$result .= '<font style="display:inline-block;margin:0px 10px">...</font>';
			$result .= '<li class="pagination-lg page-link" onclick=\'read("'.$_POST['formname'].'",'.$_POST['dt'].','.$total_pages.')\'><a href="javascript:void(0)">'.$total_pages.'</a></li>';
		}

		if($next_page != $total_pages){
			$result .= '<li class="pagination-lg page-link" style="background-color:#efefef;font-weight:bold" onclick=\'read("'.$_POST['formname'].'",'.$_POST['dt'].','.$next_page.')\'><a href="javascript:void(0)">Next</a></li>';
		}


		}else{
			$result .= '<li style="background-color:#efefef;font-weight:bold" onclick=\'readTable("'.$_POST['formname'].'",'.$_POST['dt'].','.$last_page.')\'><a href="javascript:void(0)">Prev</a></li>';
			for($i=1;$i<=3;$i++){
				$result .= '<li class="pagination-lg page-link" onclick=\'read("'.$_POST['formname'].'",'.$_POST['dt'].','.$i.')\'><a href="javascript:void(0)">'.$i.'</a></li>';
			}
			$result .= '<font style="display:inline-block;margin:0px 10px">...</font>';
			$result .= '<li class="active" onclick=\'read("'.$_POST['formname'].'",'.$_POST['dt'].','.$total_pages.')\'><a href="javascript:void(0)">'.$total_pages.'</a></li>';
		}



	}else{
		for($i=1;$i<=$total_pages;$i++){
			if($i == $page_no){$class_pagination = 'class="pagination-lg page-link active"';}else{$class_pagination = 'class="pagination-lg page-link"';}
			$result .= '<li '.$class_pagination.' onclick=\'read("'.$_POST['formname'].'",'.$_POST['dt'].','.$i.')\'><a href="javascript:void(0)">'.$i.'</a></li>';
		}
	}


	$result .= '<ul/></center></div></div>';
	}

	}else{
		$result = '<div class="alert alert-danger" role="alert"><center>Data Unavailable</center></div>';
	}

	$return->data = $result;
	$return->sql = $sql;
	$return->numrows = mysqli_num_rows($query);
	
}

if($action == 'filter_option'){
	$table = $_POST['table'];
	$value = $_POST['value'];
	$searchcol = $_POST['searchcol'];
	$displaycol = $_POST['displaycol'];
	$valuecol = $_POST['valuecol'];
	

	$sql = "SELECT * FROM $table WHERE $searchcol = '$value'";
	$query = mysqli_query($con,$sql);
	if(mysqli_num_rows($query)>0){
		$option[] = '<option value="">Select an option</option>';
		while($row = mysqli_fetch_array($query)){
			$option[] = '<option value="'.$row[$valuecol].'">'.$row[$displaycol].'</option>';
		}
		$return->status = 1;
	}else{
		$return->status = 0;
	}

	$return->options = $option;
	
}

$return->sql = $sql;
echo json_encode($return);
?>