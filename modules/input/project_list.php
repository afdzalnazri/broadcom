<?php
$table = 'project';
$col = mysqli_query($con,"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'");
while($rowcol = mysqli_fetch_array($col)){
	$columns[] = $rowcol['COLUMN_NAME']; 
}

$column =
				[
				[
						'db_column'=>'family',
						'title_column'=>'Family',
						'fk'=>[
							'fk_table'=>'masterFamily',
							'fk_id_column'=>'id',
							'fk_db_column'=>'family',
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
						'width'=>'20%'
					],
					[
						'db_column'=>'productName',
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
						'width'=>'20%'
					],
					[
						'db_column'=>'productNumber',
						'title_column'=>'Product Number',
						'fk'=>[
							'fk_table'=>'masterProduct',
							'fk_id_column'=>'id',
							'fk_db_column'=>'productNumber',
							'fk_display_column'=>'productNumber'
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
									'page'=>'?page=project-details',
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
					/*[
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
											'function_params'=>['row_id','project','id']
										]
									]
								],
							'format'=>''
						],
						'width'=>'5%'
					],*/
										
				];
				//$where = [];
				
			if($_GET["prodName"]!="")
					{
				$where = [];
					}
				
				$order = 
				[
					'column'=>'created',
					'order'=>'DESC'
				];
				$filter = [
					[
						'db_column'=>'family',
						'input_name'=>'option_family',
						'operator'=>'=',
						'condition'=>'',
						'fk'=>[]
					],
				];
$cat_read->table = $table;
$cat_read->column = $column;
$cat_read->where = $where;
$cat_read->filter = $filter;
$cat_read->order = $order;

if($page == 'project-list'){
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
				
				<div class="col-md-6">
				
				
						
				</div>
				
					<div class="col-md-12">
						<h2 id="headerSelect" name="headerSelect"></h2>
				<br><br>
				<script>
				function changeText(sel) {
					  document.getElementById("headerSelect").innerHTML = sel.options[sel.selectedIndex].text;
					  //alert(sel);
}
				</script>
				<form onsubmit="return false" class="filter-form" id="filter_vars"> 
				<div class="row">
					<div class="col-md-12">
						<select id="option_family" name="option_family" onchange='read("filter_vars",<?php echo json_encode($cat_read);?>,1); changeText(this);' class="form-control">
							<option value="">Select Family</option>
							<?php echo optionMaster('masterFamily','familyName','id',''); ?>
						</select>
					</div>
					<!--<div class="col-md-2"><button style="width:100%" class="btn btn-success" onclick='read("filter_vars",<?php echo json_encode($read_dt);?>,1);$("#reset").attr("hidden",false);'>Search</button></div>-->
				</div> 
				</form>
				<br>
						<div class="row">
							<div class="col-md-12">
								<center><u><a href="javascript:void(0)" class="" onclick='resetTable();read("filter_vars",<?php echo json_encode($cat_read);?>,1);$("#reset").attr("hidden",true);'>View All</a></u></center>
							</div>
						</div>
						<br><br>
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
else if($page == 'project-details'){
$table = 'project';

$sql = "SELECT * FROM $table WHERE md5(id) = '$_GET[id]'";
$query = mysqli_query($con,$sql);
$row = mysqli_fetch_array($query);


$col = mysqli_query($con,"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'");
while($rowcol = mysqli_fetch_array($col)){
	$columns[] = $rowcol['COLUMN_NAME']; 
}

$cat_insert->columns = $columns;
$cat_insert->table = $table;
$cat_insert->return_action = 'direct';
$cat_insert->return_modaltext = '
<div class="row">
	<div class="col-md-12"><center>
		<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
		<p><b>Successful Project Update</b></p> 
	</center></div>
</div>';
$cat_insert->return_link = '?page=user-access';
$cat_insert->fk = [];
$cat_insert->id_value = $row['id'];


$query_check_bc = "SELECT * FROM buildConfig WHERE projectName = '$row[productName]'";
$sql_check_bc = mysqli_query($con,$query_check_bc);
$delete_disabled = '';
$delete_notice = '';
if(mysqli_num_rows($sql_check_bc)>0){
	$delete_disabled = 'disabled';
	$delete_notice = '<i><font color="red">Delete is disabled due to availability of <a target="_blank" href="?page=build-config-list">Build Config</a></font></i>';
}
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
				<li class="breadcrumb-item">Project</li>
				<li class="breadcrumb-item"><a href="?page=project-list">Project List</a></li>
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
				  <form id="form-project" onsubmit="return false" enctype="multipart/form-data">
				  
				  <div class="row row-form">
					<div class="col-md-12">
						<h2><?php echo $row['productName']; ?></h2>
					</div>
				  </div>
				  <br>
				  <div class="row row-form">
				   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Family</label>
                        <select onchange="resetInput(this.value,'newFamily')" class="form-control" name="family" id="family">
						  <option value="">Select Family</option>
						  <?php echo optionMaster('masterFamily', 'familyName', 'id', $row['family']); ?>
                        </select>
                      </div>
                    </div>
					
					
					<div class="col-sm-6">
						<div class="form-group">
							<label>New Family</label>
							<input onkeyup="resetInput(this.value,'family')" type="text" class="form-control" id="newFamily" name="newFamily" placeholder="">
						</div>
                    </div>
				</div>
					
				<div class="row row-form">
					
					 <div class="col-sm-6">

                      <div class="form-group">
                        <label>Product Number</label>
                        <select onchange="resetInput(this.value,'newProductNumber')" class="form-control" name="productNumber" id="productNumber">
							<option value="">Product Number</option>
							<?php echo optionMaster('masterProduct', 'productNumber', 'id', $row['productNumber']); ?>
                        </select>
                      </div>
                    </div>
					
					 <div class="col-sm-6">
                      <div class="form-group">
                        <label>New Product Number</label>
                        <input onkeyup="resetInput(this.value,'productNumber')" type="text" class="form-control" id="newProductNumber" name="newProductNumber" placeholder="">
                      </div>
                    </div>
					
					</div>
					
					  
				  
				   <div class="row row-form">
				   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Customer</label>
                        <select onchange="resetInput(this.value,'newCustomer')" name="customer" id="customer" class="form-control">
						<option value="">Select Customer</option>
						<?php echo optionMaster('masterCustomer', 'customerName', 'id', $row['customer']); ?>
                        </select>
                      </div>
                    </div>
					
					
					 <div class="col-sm-6">
                      <div class="form-group">
                        <label>New Customer</label>
						<input onkeyup="resetInput(this.value,'customer')" type="text" class="form-control" id="newCustomer" name="newCustomer" placeholder="">
                      </div>
                    </div>
					</div>
					
					<div class="row row-form">
					
					  <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>Form Factor</label>
                        <select onchange="resetInput(this.value,'newFormFactor')" name="formFactor" id="formFactor" class="form-control">
						  <option value="">Select Form Factor</option>
						  <?php echo optionMaster('masterFormFactor', 'formFactorName', 'id', $row['formFactor']); ?> 
                        </select>
                      </div>
                    </div>
					
					 <div class="col-sm-6">
                      <div class="form-group">
                        <label>New Form Factor</label>
                        <input onkeyup="resetInput(this.value,'formFactor')" type="text" class="form-control" id="newFormFactor" name="newFormFactor" placeholder="">			   
                      </div>
                    </div>
				</div>
					
					<div class="row row-form">
					<div class="col-sm-12">
					 <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $row['description']?>"> 
                  </div>
				  </div>
				  
					</div>
					
					<div class="row row-form">
					  <div class="col-sm-6">
                      <div class="form-group">
                        <label>BRCM Linux Tool Versioning</label>
                        <select onchange="resetInput(this.value,'new_brcmMinIsoFw')" name="brcmMinIsoFw" id="brcmMinIsoFw" class="form-control">
                          <option value="">Select an option</option>
						  <?php echo optionMaster('masterIsoFw', 'isoFwVer', 'isoFwVer', $row['brcmMinIsoFw']); ?>
                        </select>
						<br>
						 <select onchange="resetInput(this.value,'new_brcmMinDstVer')" name="brcmMinDstVer" id="brcmMinDstVer" class="form-control">                        
                          <option value="">Select an option</option>
						  <?php echo optionMaster('masterDstVer', 'dstVer', 'dstVer', $row['brcmMinDstVer']); ?>
                        </select>
						<br>
						 <select onchange="resetInput(this.value,'new_brcmDstWinCtrl')" name="brcmDstWinCtrl" id="brcmDstWinCtrl" class="form-control">
                          <option name="brcmDstWinCtrl" id="brcmDstWinCtrl" value="">Select an option</option>
						  <?php echo optionMaster('masterDstWinCtrl', 'dstWinCtrl', 'dstWinCtrl', $row['brcmDstWinCtrl']); ?>
                        </select>
                      </div>
                    </div>
					
					 <div class="col-sm-6">
                      <div class="form-group">
                        <label>New BRCM Linux Tool Versioning</label>
                       <input onkeyup="resetInput(this.value,'brcmMinIsoFw','masterIsoFw')" type="text" class="form-control" id="new_brcmMinIsoFw" name="new_brcmMinIsoFw" placeholder="">
					<br>  					   
					   <input onkeyup="resetInput(this.value,'brcmMinDstVer','masterDstVer')" type="text" class="form-control" id="new_brcmMinDstVer" name="new_brcmMinDstVer" placeholder="">
					
					<br>
					   <input onkeyup="resetInput(this.value,'brcmDstWinCtrl','masterDstWinCtrl')" type="text" class="form-control" id="new_brcmDstWinCtrl" name="new_brcmDstWinCtrl"placeholder="">
                      </div>
                    </div>
					</div>
					</form>

					<div class="row row-form">
						<div class="col-md-12">
							<button onclick='prjUpdt("project",<?php echo json_encode($cat_insert);?>,<?php echo $row['id'];?>)' class="btn btn-primary" id="btn_submit" >Update Project</button>
							<button onclick="remove(<?php echo $row['id']?>,'project','id')" class="btn btn-danger" <?php echo $delete_disabled; ?>>Delete</button> <?php echo $delete_notice; ?>
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