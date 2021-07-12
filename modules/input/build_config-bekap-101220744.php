<?php
$table = 'buildConfig';
$col = mysqli_query($con,"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'");
while($rowcol = mysqli_fetch_array($col)){
	$columns[] = $rowcol['COLUMN_NAME']; 
}

$column =
				[
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
						'width'=>'10%'
					],
					[
						'db_column'=>'projectName',
						'title_column'=>'Product Name',
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
						'db_column'=>'id',
						'title_column'=>'',
						'fk'=>[],
						'display'=>[
							'type'=>'button',
							'property'=>
								[
									'page'=>'?page=build-config-creation',
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
					],
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
					'order'=>'ASC'
				];
				
				$filter = [
					[
						'db_column'=>'projectId',
						'input_name'=>'option_product', 
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
						<select id="option_family" name="option_family" onchange='filterOption(this.value,"project","family","productName","id","option_product");read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control">
							<option value="">Select an option</option>
							<?php echo optionMaster('masterFamily','familyName','id',''); ?>
						</select> 
					</div>
					<div class="col-md-6">
						<b>Project</b><br>
						<select id="option_product" name="option_product" onchange='read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control" disabled>
							<option value="#">Select an option</option>
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
if($_GET['id']!='') {$edit="(Edit)";}

?>

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Build Config <?php echo $edit;?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item">Input</li>
              <li class="breadcrumb-item active">Build Config <?php echo $edit;?></li>
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
						<?php 
						$editStatus = false;
						if($_GET['id']!='')
						{
							//echo "SELECT * from buildConfig where md5(id) = '".$_GET['id']."'";
							$editStatus = true;
							$col = mysqli_query($con,"SELECT * from buildConfig where md5(id) = '".$_GET['id']."'");
while($rowcol = mysqli_fetch_array($col)){
	$buildConfigName = $rowcol['buildConfigName']; 
	$projectName = $rowcol['projectName']; 
	$projectId = $rowcol['projectId']; 
	$id = $rowcol['id']; 
} 

$col = mysqli_query($con,"SELECT * from project where productName = '".$projectName."'");
while($rowcol = mysqli_fetch_array($col)){
	$familyID = $rowcol['family']; 
	
} 

						?>
						
						<input type="hidden" value="<?php echo $buildConfigName; ?>" name="buildConfigName" id="buildConfigName">
						<input type="hidden" value="true" name="isEditBC" id="isEditBC">
						<input type="hidden" value="<?php echo $id; ?>" name="idBC" id="idBC">
						
<input type="text" disabled class="form-control"  placeholder="" value="<?php echo $buildConfigName; ?>">
						<?php 
						}else{
							?> 
						<input type="hidden" value="false" name="isEditBC" id="isEditBC">
					    <input type="text" class="form-control" name="buildConfigName" id="buildConfigName" placeholder="">
						<input type="hidden" value="<?php echo $id; ?>" name="idBC" id="idBC">
						 
							<?php
						}
						?>
                       
                      </div>
                    </div>
					 </div>
				
				<form onsubmit="return false" class="filter-form" id="filter_vars">  
				 <div class="row row-form">
					<div class="col-md-6">
						<b>Family</b><br>
						<select id="option_family" name="option_family" onchange='filterOption(this.value,"project","family","productName","id","option_product");read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control">
							<option value="">Select an option</option>
							<?php echo optionMaster('masterFamily','familyName','id',''.$familyID.''); ?>
						</select> 
					</div>
					<div class="col-md-6">
						<b>Project</b><br>
						
						<?php 
						if($_GET['id']!='')
						{
						?>
						<select id="option_product" name="option_product" onchange='read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control">
							<option value="#">Select an option</option>
							<?php echo optionMasterSelection('project','productName','id',''.$projectId.'', 'family', ''.$familyID.''); ?>
						</select>
						<?php 
						}else{
							?>
							<select id="option_product" name="option_product" onchange='read("filter_vars",<?php echo json_encode($cat_read);?>,1)' class="form-control" disabled>
							<option value="#">Select an option</option>
						</select>
							<?php
						}
						
						?>
					</div>
					<!--<div class="col-md-2"><button style="width:100%" class="btn btn-success" onclick='read("filter_vars",<?php echo json_encode($read_dt);?>,1);$("#reset").attr("hidden",false);'>Search</button></div>-->
				</div> 
				</form>
					 
					 <div class="row row-form">
						<div class="col-md-6">
						<div class="form-group">
                    <label for="productFileUpload">Product file</label>
					<input type="file" class="form-control" id="productFile" name="productFile">
                  </div></div>
						<div class="col-md-6">                    <label for="referenceFileUpload">Reference file</label><br>
                     <input type="file" class="form-control" id="referenceFile" name="referenceFile"></div>
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
					"SELECT * FROM buildConfigParam WHERE bcId = $id";
					$confParam = mysqli_query($con,"SELECT * FROM buildConfigParam WHERE bcId = $id");
while($rowconfparam = mysqli_fetch_array($confParam)){
	
	
	$param[] = $rowconfparam['id'];
	$param_values[] = $rowconfparam['value'];
	$param_paramId[] = $rowconfparam['paramId'];
}

						$conf_input = mysqli_query($con,"SELECT * FROM masterConfigParam ORDER BY configName ASC");
						while($rowconf = mysqli_fetch_array($conf_input)){
							//echo "SELECT * FROM buildConfigParam WHERE paramId = $rowconf[id] ORDER BY created DESC LIMIT 1";
							
							$last_value = mysqli_query($con,"SELECT * FROM buildConfigParam WHERE paramId = $rowconf[id] ORDER BY created DESC LIMIT 1");
							$rowlastvalue = mysqli_fetch_array($last_value);

						if(in_array($rowconf['id'],$param_paramId)){
								$param_index = array_search($rowconf['id'],$param);
								$hidden = '';
								$checked = 'checked';
								$value = $param_values[$param_index];
								//echo "afdzal";
							}else{$hidden = 'hidden'; $checked = '';$value= ''; //echo "nazri";
							}							


							/*
							echo '
							<div class="row">
								<div class="col-md-1"><input onclick="assCP(this.value,this.id)" class="cb" type="checkbox" id="conf_'.$rowconf['id'].'" name="configParamId[]" value="'.$rowconf['id'].'" '.$checked.'></div>
								<div class="col-md-5">'.$rowconf['configName'].'</div>
								<div class="col-md-6"><input id="value_conf_'.$rowconf['id'].'" style="display:block-inline" type="text" class="form-control" name="configParamValue'.$rowconf['id'].'" '.$hidden.' value="'.$value.'"><br></div>
							</div>';
							*/
							echo '
							<div class="row">
								<div class="col-md-1"><input onclick="assCP(this.value,this.id)" class="cb" type="checkbox" id="conf_'.$rowconf['id'].'" name="configParamId[]" value="'.$rowconf['id'].'" '.$checked.'></div>
								<div class="col-md-5">'.$rowconf['configName'].'</div>
								<div class="col-md-6"><input id="value_conf_'.$rowconf['id'].'" style="display:block-inline" type="text" class="form-control" name="configParamValue'.$rowconf['id'].'" '.$hidden.' value="'.$rowlastvalue['value'].'"><br></div>
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
					 
					 <!--<div class="row row-form">
					  <div class="col-sm-6">
                    <label for="referenceFileUpload">Reference file</label><br>
                     <input type="file" class="form-control" id="referenceFile" name="referenceFile">

				  </div>
				  
				   <div class="col-sm-6">
				   
                      <div class="form-group">
                        <label>ECO</label>						
                       <input name="ecoEntry" id="ecoEntry" type="text" class="form-control" id="econumbertext" >
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
					 </div>--> 
					 
					 </form>
					<div class="row row-form">
						<div class="col-md-12">
						<?php 
						if($_GET["id"]!="")
						{
						?>
						
						 <div class="row row-form">
						<div class="col-md-6">
						<div class="form-group">
                    <label for="productFileUpload">MLF file</label>
					<input type="file" class="form-control" id="mlfFile" name="mlfFile">
                  </div></div>
						
					 </div>
					 
						<button onclick='bcCrt("build_config",<?php echo json_encode($cat_insert);?>)' class="btn btn-primary">Update Build Creation</button>
						
						<?php 
						}else{
						?>
							<button onclick='bcCrt("build_config",<?php echo json_encode($cat_insert);?>)' class="btn btn-primary">Create Build Creation</button>
							<?php 
						}
							?>
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
                        <label>Build Config Nassme</label>						
                       <input type="text" onkeypress="checkDuplicate(this.value)" class="form-control" name="buildConfigName" id="buildConfigName" value="<?php echo $rowconfi['buildConfigName']?>">
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
?>