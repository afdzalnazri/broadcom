<?php 
$table = 'masterVersionFile';
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
		<p><b>Successful Master File Versioning</b></p>
	</center></div>
</div>';
$cat_insert->return_link = '?page=user-access';
$cat_insert->fk = [];

///////////////


$table = 'masterVersionFileList';
//echo "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'";
$col = mysqli_query($con,"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'");
while($rowcol = mysqli_fetch_array($col)){
	$columns[] = $rowcol['COLUMN_NAME']; 
}

$column =
				[
				
					[
						'db_column'=>'fileName',
						'title_column'=>'File Name',
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
						'db_column'=>'crc',
						'title_column'=>'CRC',
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
						'db_column'=>'versionNumber',
						'title_column'=>'Rev',
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
									
					
										
				];
				//$where = [];
		
				
				$order = 
				[
					'column'=>'id',
					'order'=>'ASC'
				];
				$filter = [
					[
						'db_column'=>'',
						'input_name'=>'',
						'operator'=>'',
						'condition'=>'',
						'fk'=>[]
					],
				];
				
$cat_read->table = $table;
$cat_read->column = $column;
$cat_read->where = $where;
$cat_read->filter = $filter;
$cat_read->order = $order;

////////////////
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
			
			
              <div class="card-body">

                <h5 class="card-title"></h5>

                <p class="card-text">
                </p>
	
				<form id="form-master_versioning" onsubmit="return false" enctype="multipart/form-data">
					<div class="row row-form">
					
						<!--<div class="col-md-4">
							<label>Build </label>	
                        <select name="bcId" id="bcId" class="form-control">
						<option value="">Select Build</option>
						<?php echo optionMaster('buildConfig','buildConfigName','id','');?>
                        </select>
						</div>-->
						
						<div class="col-md-12">
						<label for="referenceFileUpload">New Script Files Upload (eg: Filename :Master File Versioning.zip)</label>
                        <input name="scriptFileName" id="scriptFileName" type="file" class="form-control" id="exampleInputFile">
						</div>
						

					
					</div>
					</form>
					<div class="row row-form">
											<div class="col-md-3">
						<label for="referenceFileUpload"><font color="white">_</font></label><br>  
						<button onclick='mvCrt("master_versioning",<?php echo json_encode($cat_insert);?>)' class="btn btn-primary" onclick="">Upload</button>
						</div>
					</div>

              </div>
			     	  
			  </form>
			  
			  <div class="row form-info-row">
							<div class="col-md-12">
							<script>$(document).ready(function(event){read('filter_vars',<?php echo json_encode($cat_read);?>,1);});</script>
								<div class="responsive-div" id="table_data"></div>
							</div>
						</div>
						
            </div>
			
			 <div class="card">
			
			
              <div class="card-body">

                <h5 class="card-title"></h5>

                <p class="card-text">
				
                </p>
	
				<form id="form-master_versioning" onsubmit="return false" enctype="multipart/form-data">
					<div class="row row-form">
					
						<div class="col-md-4">
							<label>Select Script </label>	
                        <select name="bcId" id="bcId" class="form-control"  onchange="dispMasterFile(this.options[this.selectedIndex].value);">
						<option value=""> </option>
						<?php echo optionMasterFile('masterVersionFileList','fileDirectoryName','id','');?>
                        </select><br>
						<label for="">Create Date : </label>
						<label id="createdDate"></label><br>
						
						<label for="">Modified Date : </label>
						<label id="modifiedDate"></label><br>
						
						<label for="">Revision : </label>
						<label id="revision"></label><br>
						
						</div>
						<br><br><br><br><br>
						<div class="col-md-12">
						<label for="referenceFileUpload">Script Editor</label>
                        <textarea id="master_file_editor" class="textarea"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
             	</div>
						

					
					</div>
					</form>
					
					<div class="row row-form">
			<div class="col-md-12">
				<button id="btn_edit_master_file" onclick="editmasterFile()" class="btn btn-primary">Save File</button>
			</div>
		</div>
		

              </div>
			     	  
			  </form>
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
