<?php
$table = 'buildConfig';
$col = mysqli_query($con,"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'");
while($rowcol = mysqli_fetch_array($col)){
	$columns[] = $rowcol['COLUMN_NAME']; 
}

$column =
				[
				[
						'db_column'=>'familyId',
						'title_column'=>'Family',
						'fk'=>[
							'fk_table'=>'masterFamily',
							'fk_id_column'=>'id',
							'fk_db_column'=>'familyId',
							'fk_display_column'=>'familyName'
						],
						'display'=>[
							'type'=>'text',
							'property'=>
								[
									'page'=>'',
									'param'=>'',
									'text'=>'',
									'target'=>'',
									'class'=>'',
									'function'=>[]
								],
							'format'=>''
						],
						'width'=>'15%'
					],
					[
						'db_column'=>'projectId',
						'title_column'=>'Product Name',
						'fk'=>[
							'fk_table'=>'project',
							'fk_id_column'=>'id',
							'fk_db_column'=>'projectId',
							'fk_display_column'=>'productName'
						],
						'display'=>[
							'type'=>'text',
							'property'=>
								[
									'page'=>'',
									'param'=>'',
									'text'=>'',
									'target'=>'',
									'class'=>'',
									'function'=>[]
								],
							'format'=>''
						],
						'width'=>'15%'
					],
				[
						'db_column'=>'buildConfigName',
						'title_column'=>'Build Config',
						'fk'=>[],
						'display'=>[
							'type'=>'text',
							'property'=>
								[
									'page'=>'',
									'param'=>'',
									'text'=>'',
									'target'=>'',
									'class'=>'',
									'function'=>[]
								],
							'format'=>''
						],
						'width'=>'20%'
					],
					
					[
						'db_column'=>'userId',
						'title_column'=>'Created By',
						'fk'=>[
							'fk_table'=>'user',
							'fk_id_column'=>'id',
							'fk_db_column'=>'userId',
							'fk_display_column'=>'name'
						],
						'display'=>[
							'type'=>'text',
							'property'=>
								[
									'page'=>'',
									'param'=>'',
									'text'=>'',
									'target'=>'',
									'class'=>'',
									'function'=>[]
								],
							'format'=>''
						],
						'width'=>'10%'
					],
					[
						'db_column'=>'created',
						'title_column'=>'Date Created',
						'fk'=>[],
						'display'=>[
							'type'=>'text',
							'property'=>
								[
									'page'=>'',
									'param'=>'',
									'text'=>'',
									'target'=>'',
									'class'=>'',
									'function'=>[]
								],
							'format'=>'date'
						],
						'width'=>'10%'
					],
										
															[
						'db_column'=>'id',
						'title_column'=>'',
						'fk'=>[],
						'display'=>[
							'type'=>'button',
							'property'=>
								[
									'page'=>'?page=build-config-details',
									'param'=>'id',
									'text'=>'Update',
									'target'=>'',
									'class'=>'btn btn-primary',
									'function'=>[]
								],
							'format'=>''
						],
						'width'=>'5%'
					],
					[
						'db_column'=>'id',
						'title_column'=>'',
						'fk'=>[],
						'display'=>[
							'type'=>'button',
							'property'=>
								[
									'page'=>'javascript:void(0)',
									'param'=>'',
									'text'=>'Delete',
									'target'=>'',
									'class'=>'btn btn-danger',
									'function'=>
									[
										[
											'function_call'=>'onclick',
											'function_name'=>'remove',
											'function_params'=>['row_id','buildConfig','id']
										]
									]
								],
							'format'=>''
						],
						'width'=>'5%'
					]
				];
				//$where = [];
				
			if($_GET["prodName"]!="")
					{
				$where = [
					[
					 'condition'=>'',
					 'column'=>'projectId',
					 'operator'=>'=',
					 'value'=>''.$_GET["prodName"].''
					]
				
				];
				$condition_filter = 'AND';
					}else{
						$condition_filter = '';
					}
				
				$order = 
				[
					'column'=>'created',
					'order'=>'DESC'
				];
				
				$filter = [
					[
						'db_column'=>'projectId',
						'input_name'=>'projectId', 
						'operator'=>'=',
						'condition'=>$condition_filter,
						'fk'=>[]
					],				
				];
$cat_read->table = $table;
$cat_read->column = $column;
$cat_read->where = $where;
$cat_read->filter = $filter;
$cat_read->order = $order;

if($page == 'build-config-list'){
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $title; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item">Input</li>
              <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
		
              <div class="card-body table-responsive">

				<div class="row row-form">
				
					<div class="col-md-12">
			<form onsubmit="return false" class="filter-form" id="filter_vars">  
				<div class="row">
					<div class="col-md-6">
						<b>Family</b><br>
						<select id="familyId" name="familyId" onchange='filterOption(this.value,"project","family","productName","id","projectId");read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control">
							<option value="" selected>Select an option</option>
							<?php echo optionMaster('masterFamily','familyName','id',''); ?>
						</select> 
					</div>
					<div class="col-md-6">
						<b>Product Name</b><br>
						<select id="projectId" name="projectId" onchange='read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control" disabled>
							<option value="#" selected>Select an option</option>
						</select>
					</div>
					<!--<div class="col-md-2"><button style="width:100%" class="btn btn-success" onclick='read("filter_vars",<?php echo json_encode($read_dt);?>,1);$("#reset").attr("hidden",false);'>Search</button></div>-->
				</div> 
				</form>
						<br><br>
						<div class="row">
							<div class="col-md-12">
								<center><u><a id="reset" href="javascript:void(0)" class="btn btn-default" onclick='resetTable();read("filter_vars",<?php echo json_encode($cat_read);?>,1);$("#reset").attr("hidden",true);' hidden>Reset Filters</a></u></center>
							</div>
						</div>

						<div class="row form-info-row">
							<div class="col-md-12">
							<script>$(document).ready(function(event){read('filter_vars',<?php echo json_encode($cat_read);?>,1);});</script>
								<div class="responsive-div" id="table_data"></div>
							</div>
						</div>
					</div>
				</div>

              </div>
	 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }
else if($page == 'build-config-creation'){ 
$cat_insert->columns = $columns;
$cat_insert->table = $table;
$cat_insert->return_action = 'direct';
$cat_insert->return_modaltext = '
<div class="row">
	<div class="col-md-12"><center>
		<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
		<p><b>Successful Project Creation</b></p>
	</center></div>
</div>';
$cat_insert->return_link = '?page=user-access';
$cat_insert->fk = [];
$cat_insert->action = 'build_config_creation';
?>

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $title; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home-</a></li>
				<li class="breadcrumb-item">Input</li>
              <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
			<form id="form-build_config" onsubmit="return false" enctype="multipart/form-data">
			
              <div class="card-body">

                <h5 class="card-title"></h5>

                <p class="card-text">
                </p>
				<div class="row row-form">
					  <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>Build Config</label>
						<input type="text" class="form-control" name="buildConfigName" id="buildConfigName" placeholder="">						
                      </div>
                    </div>
				</div>
				<div class="row row-form">
					<div class="col-md-6">
						<label>Family</label>
						<select id="familyId" name="familyId" onchange='filterOption(this.value,"project","family","productName","id","projectId");read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control">
							<option value="">Select an option</option>
							<?php echo optionMaster('masterFamily','familyName','id',''.$familyID.''); ?>
						</select> 
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Product Name</label>
							<select  onchange="checkDuplicate('')" id="projectId" name="projectId" onchange='read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control" disabled>
								<option value="">Select an option</option>
							</select>
						</div>
					</div>
				</div>	 
				<div class="row row-form">
					<div class="col-md-6">
						<div class="form-group">
							<label>Product file <a target="_blank" href="image/folder_struct.png">View Folder Structure</a></label>
							<input type="file" class="form-control" id="productFile" name="productFile">
						</div>
				  </div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Reference file <a target="_blank" href="image/folder_struct.png">View Folder Structure</a></label>
							<input type="file" class="form-control" id="referenceFile" name="referenceFile">
						</div>
					</div>
				</div>
					 
					  <div class="row row-form">
					  <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                       					
                      
					   <div class="form-group">
                         <label>Configuration</label>	
						<br>
					<div style="height:200px;overflow-y:auto;border:1px solid #efefef;padding:10px 20px">
					<?php
						$conf_input = mysqli_query($con,"SELECT * FROM masterConfigParam ORDER BY configName ASC");
						while($rowconf = mysqli_fetch_array($conf_input)){							
							echo '
							<div class="row">
								<div class="col-md-1"><input onclick="assCP(this.value,this.id)" class="cb" type="checkbox" id="conf_'.$rowconf['id'].'" name="configParamId[]" value="'.$rowconf['ids'].'"></div>
								<div class="col-md-5">'.$rowconf['configName'].'</div>
								<div class="col-md-6"><input id="value_conf_'.$rowconf['id'].'" style="display:block-inline" type="text" class="form-control" name="configParamValue'.$rowconf['ids'].'" hidden><br></div>
							</div>';

						}
					?>
 
                      </div>
					  </div>
                      </div>
                    </div>
					
					 <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
						<div id="new_cp">
                        <label>New Configuration</label>
						<div class="row row-form">
							<div class="col-md-3">Parameter</div>
							<div class="col-md-9"><input name="newConfigEntry[]" id="newConfigEntry" type="text" class="form-control"></div>
						</div>
						<br>
 						<div class="row row-form">
							<div class="col-md-3">Value</div>
							<div class="col-md-9"><input name="newConfigEntryVal[]" id="newConfigEntryVal" type="text" class="form-control"></div>
						</div>
						</div>
						<br>
						<div class="row row-form">
							<div class="col-md-12" style="text-align:center">
								<button class="btn btn-primary" onclick="addCP()">Add Configuration</button>
								<script></script>
							</div>
						</div>
                      </div>
                    </div>
					 </div>
					 </form>
					 <strong>Do not click at any area in the browser while file upload in progress<br>
					 Please wait until 100% file upload complete<br></strong>
					<div class="row row-form">
						<div class="col-md-12">
						<button onclick='bcCrt("build_config",<?php echo json_encode($cat_insert);?>)' class="btn btn-primary">Create Build Creation</button>
						</div>
					</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	
  </div>
  <div class="modal fade" id="page_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div style="padding:50px" class="modal-content">
      <div id="page_modal_content" class="modal-body"><center>
        <strong><font color="red">DO NOT CLICK ANYWHERE UNTIL UPLOAD FINISH</font></strong><br>Proccessing data..
		<div style="width:100%" id="process_var"></div>
		<script>
			var bar = new ldBar("#process_var");
		</script>
      </center></div>
    </div>
  </div>
</div>	
<?php }
else if($page == 'build-config-copy'){ 
$id = $_GET['id'];
$conf = mysqli_query($con,"SELECT * FROM buildConfig WHERE md5(id) = '$id'");
$rowconfi = mysqli_fetch_array($conf);

// Configuration
$confParam = mysqli_query($con,"SELECT * FROM buildConfigParam WHERE bcId = $rowconfi[id]");
while($rowconfparam = mysqli_fetch_array($confParam)){
	$param[] = $rowconfparam['id'];
	$param_values[] = $rowconfparam['value'];
}

$cat_insert->columns = $columns;
$cat_insert->table = $table;
$cat_insert->return_action = 'direct';
$cat_insert->return_modaltext = '
<div class="row">
	<div class="col-md-12"><center>
		<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
		<p><b>Successful Project Creation</b></p>
	</center></div>
</div>';
$cat_insert->return_link = '?page=user-access';
$cat_insert->fk = [];

?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $title; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item">Input</li>
              <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
			<form id="form-build_config" onsubmit="return false" enctype="multipart/form-data">
			
              <div class="card-body">

                <h5 class="card-title"></h5>

                <p class="card-text">
                </p>
	
	
	  
				  <div class="row row-form">
					  <div class="col-sm-6">
                      <!-- select --> 
                      <div class="form-group">
                        <label>Build Conddfig Name</label>						
                       <input onkeypress="checkDuplicate(this.value)" type="text" class="form-control" name="buildConfigName" id="buildConfigName" value="<?php echo $rowconfi['buildConfigName']?>"><br>
					    <label id="labelWarning" name="labelWarning"></label>
                      </div>
                    </div>
					
					 <div class="col-sm-6">
                      <!-- select -->
                        <div class="form-group">
                         <label>Project</label>	
                        <select name="projectId" id="projectId" class="form-control">
						<?php optionMaster('project','productName','id',$rowconfi['projectId']);?>
                        </select>
                      </div>
					  
					  
					  
                    </div>
					 </div>
					 
					  <div class="row row-form">
					  <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                       					
                      
					   <div class="form-group">
                         <label>Configuration</label>	
						<br>
					<div style="height:200px;overflow-y:auto;border:1px solid #efefef;padding:10px 20px">
					<?php 
				
						$conf_input = mysqli_query($con,"SELECT * FROM masterConfigParam ORDER BY configName ASC");
						while($rowconf = mysqli_fetch_array($conf_input)){
							if(in_array($rowconf['id'],$param)){
								$param_index = array_search($rowconf['id'],$param);
								$hidden = '';
								$checked = 'checked';
								$value = $param_values[$param_index];
							}else{$hidden = 'hidden'; $checked = '';$value= '';}
							
							
							
							echo '
							<div class="row">
								<div class="col-md-1"><input onclick="assCP(this.value,this.id)" class="cb" type="checkbox" id="conf_'.$rowconf['id'].'" name="configParamId[]" value="'.$rowconf['id'].'" '.$checked.'></div>
								<div class="col-md-5">'.$rowconf['configName'].'</div>
								<div class="col-md-6"><input id="value_conf_'.$rowconf['id'].'" style="display:block-inline" type="text" class="form-control" name="configParamValue'.$rowconf['id'].'" '.$hidden.' value="'.$value.'"><br></div>
							</div>';

						}
					?>
 
                      </div>
					  </div>
                      </div>
                    </div>
					
					 <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>New Configuration</label>
						<div class="row">
							<div class="col-md-3">Parameter</div>
							<div class="col-md-9"><input name="newConfigEntry[]" id="newConfigEntry" type="text" class="form-control"></div>
						</div>
						<br>
 						<div class="row">
							<div class="col-md-3">Value</div>
							<div class="col-md-9"><input name="newConfigEntryVal[]" id="newConfigEntryVal" type="text" class="form-control"></div>
						</div>                      
                      </div>
                    </div>
					 </div>
					 
					 <div class="row row-form">
					  <div class="col-sm-6">
                    <label for="referenceFileUpload">Reference file</label><br>
                     <input type="file" class="form-control" id="referenceFile" name="referenceFile">

				  </div>
				  
				   <div class="col-sm-6">
				   
				   	
                      <!-- select -->
                      <div class="form-group">
                        <label>ECO</label>					
                       <input name="ecoEntry" id="ecoEntry" type="text" class="form-control" id="econumbertext" value="<?php echo $rowconfi['ecoEntry'] ?>" >
                      </div>
               
					
					
				  </div>

					 </div>
					 
					 <div class="row row-form">
					  <div class="col-sm-6">
					    <div class="form-group">
                    <label for="productFileUpload">Product file</label>
					<input type="file" class="form-control" id="productFile" name="productFile">
                  </div>
				  </div>
				  
				   <div class="col-sm-6">
				   <div class="form-group">
                       					
                      
					 
                      </div>
					  </div>
					 </div>
					 
					 </form>
					<div class="row row-form">
						<div class="col-md-12">
							<button onclick='bcCrt("build_config",<?php echo json_encode($cat_insert);?>)' class="btn btn-primary">Create Build Creation</button>
						</div>
					</div>
                 
				
				  
				  
              </div>
			     	  
			  
            </div>

            
          </div>
        </div>
      </div>
    </div>
	
  </div>
  <div class="modal fade" id="page_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div style="padding:50px" class="modal-content">
      <div id="page_modal_content" class="modal-body"><center>
        Proccessing data..
		<div style="width:100%" id="process_var"></div>
		<script>
			var bar = new ldBar("#process_var");
		</script>
      </center></div>
    </div>
  </div>
</div>	
<?php
}

if($page == 'build-config-details'){
$id = $_GET['id'];
$conf = mysqli_query($con,"SELECT * FROM buildConfig WHERE md5(id) = '$id'");
$rowconfi = mysqli_fetch_array($conf);

// Configuration
$confParam = mysqli_query($con,"SELECT * FROM buildConfigParam WHERE bcId = $rowconfi[id]");
while($rowconfparam = mysqli_fetch_array($confParam)){
	$param[] = $rowconfparam['id'];
	$param_values[] = $rowconfparam['value'];
}

$cat_insert->columns = $columns;
$cat_insert->table = $table;
$cat_insert->return_action = 'direct';
$cat_insert->return_modaltext = '
<div class="row">
	<div class="col-md-12"><center>
		<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
		<p><b>Successful Build Config Update</b></p>
	</center></div>
</div>';
$cat_insert->return_link = '?page=user-access';
$cat_insert->fk = [];
$cat_insert->action = 'build_config_update';
$cat_insert->id = $rowconfi['id'];

?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $title; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item">Input</li>
              <li class="breadcrumb-item active"><?php echo $title; ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
			<form id="form-build_config" onsubmit="return false" enctype="multipart/form-data">
			
              <div class="card-body">

                <h5 class="card-title"></h5>

                <p class="card-text">
                </p>
				<div class="row row-form">
					  <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>Build Config Name</label>
						<input type="text" class="form-control" name="buildConfigName" id="buildConfigName" value="<?php echo $rowconfi['buildConfigName']; ?>">						
                      </div>
                    </div>
					
				
				<?php $_SESSION["allConfig"]= $rowconfi['buildConfigName'].'|'.$rowconfi['familyId'].'|'.$rowconfi['projectId']; ?>
					
				</div>
				<div class="row row-form">
					<div class="col-md-6">
						<label>Family</label>
						<select id="familyId" name="familyId" onchange='filterOption(this.value,"project","family","productName","id","projectId");read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control">
							<option value="">Select an option</option>
							<?php echo optionMaster('masterFamily','familyName','id',''.$rowconfi['familyId'].''); ?>
						</select> 
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Project</label>
							<select  onchange="checkDuplicate('')" id="projectId" name="projectId" onchange='read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control">
								<option value="">Select an option</option>
								<?php echo optionMasterSelection('project', 'productName', 'id', $rowconfi['projectId'], 'family', $rowconfi['familyId']) ?>
							</select>
						</div>
					</div>
				</div>	 
				<div class="row row-form">
					<div class="col-md-6">
						<div class="form-group">
							<!--<label>Product file</label>--><br> 
							<input type="hidden" class="form-control" id="productFile" name="productFile">
						</div>
				  </div>
					<div class="col-md-6">
						<div class="form-group">
							<!--<label>Reference file</label> -->
							<input type="hidden" class="form-control" id="referenceFile" name="referenceFile">
						</div>
					</div>
				</div>
					 
					  <div class="row row-form">
					  <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                       					
                      
					   <div class="form-group">
                         <label>Configuration</label>	
						<br>
					<div style="height:200px;overflow-y:auto;border:1px solid #efefef;padding:10px 20px">
					<?php
					
						$bcConfigParams = mysqli_query($con,"SELECT * FROM buildConfigParam WHERE bcId = '$rowconfi[ids]'");
						while($rowparams = mysqli_fetch_array($bcConfigParams)){
							$arr_params[$rowparams['paramId']] = $rowparams['value'];
						}
						
						$conf_input = mysqli_query($con,"SELECT * FROM masterConfigParam ORDER BY configName ASC");
						while($rowconf = mysqli_fetch_array($conf_input)){
							
							if(array_key_exists($rowconf['ids'],$arr_params)){
								$hidden = '';
								$checked = 'checked';
								$value = $arr_params[$rowconf['ids']];
							}else{$hidden = 'hidden'; $checked = '';$value= "";}
							
							echo '
							<div class="row">
								<div class="col-md-1"><input onclick="assCP(this.value,this.id)" class="cb" type="checkbox" id="conf_'.$rowconf['id'].'" name="configParamId[]" value="'.$rowconf['ids'].'" '.$checked.'></div>
								<div class="col-md-5">'.$rowconf['configName'].'</div>
								<div class="col-md-6"><input id="value_conf_'.$rowconf['id'].'" style="display:block-inline" type="text" class="form-control" name="configParamValue'.$rowconf['ids'].'" '.$hidden.' value="'.$value.'"><br></div>
							</div>';

						}
					?>
 
                      </div>
					  </div>
                      </div>
                    </div>
					
					 <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
						<div id="new_cp">
                        <label>New Configuration</label>
						<div class="row row-form">
							<div class="col-md-3">Parameter</div>
							<div class="col-md-9"><input name="newConfigEntry[]" id="newConfigEntry" type="text" class="form-control"></div>
						</div>
						<br>
 						<div class="row row-form">
							<div class="col-md-3">Value</div>
							<div class="col-md-9"><input name="newConfigEntryVal[]" id="newConfigEntryVal" type="text" class="form-control"></div>
						</div>
						</div>
						<br>
						<div class="row row-form">
							<div class="col-md-12" style="text-align:center">
								<button class="btn btn-primary" onclick="addCP()">Add Configuration</button>
								<script></script>
							</div>
						</div>
                      </div>
                    </div>
					 </div>
					 </form>
					<div class="row row-form">
						<div class="col-md-12">
						<button onclick='bcCrt("build_config",<?php echo json_encode($cat_insert);?>)' class="btn btn-primary">Update Build Creation</button>
						</div>
					</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	
  </div>
  <div class="modal fade" id="page_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div style="padding:50px" class="modal-content">
      <div id="page_modal_content" class="modal-body"><center>
        Proccessing data..
		<div style="width:100%" id="process_var"></div>
		<script>
			var bar = new ldBar("#process_var");
		</script>
      </center></div>
    </div>
  </div>
</div>
<?php 
}
?>