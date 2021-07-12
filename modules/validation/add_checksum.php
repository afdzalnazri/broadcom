<?php 
//echo "INSERT INTO masterchecksum  (checksumname, starthex, endhex, checksumaddress) VALUES ('".$_POST["checkSumName"]."', '".$_POST["checkSumStart"]."', '".$_POST["checkSumEnd"]."', '".$_POST["checkSumLocation"]."');";


$table = 'masterchecksum';
$col = mysqli_query($con,"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'");
while($rowcol = mysqli_fetch_array($col)){
	$columns[] = $rowcol['COLUMN_NAME']; 
}

$column =
				[
				[
						'db_column'=>'checksumname',
						'title_column'=>'Checksum Name',
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
						'db_column'=>'starthex',
						'title_column'=>'Start Hex',
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
						'db_column'=>'endhex',
						'title_column'=>'End Hex',
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
						'db_column'=>'checksumaddress',
						'title_column'=>'Checksum Address (HEX)',
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
						'db_column'=>'id',
						'title_column'=>'',
						'fk'=>[],
						'display'=>[
							'type'=>'button',
							'property'=>
								[
									'page'=>'javascript:void(0)',
									'param'=>'id',
									'text'=>'Update',
									'target'=>'',
									'id'=>'btn_action_id_row',
									'class'=>'btn btn-primary',
									'function'=>[
										[
											'function_call'=>'onclick',
											'function_name'=>'editInline',
											'function_params'=>[$table,'row_id','id',json_encode(['checksumname','starthex','endhex','checksumaddress'])]
										]
									]
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
											'function_params'=>['row_id','masterchecksum','id']
										]
									]
								],
							'format'=>''
						],
						'width'=>'5%'
					],
				];
				$where = [];
		
				
				$order = 
				[
					'column'=>'id',
					'order'=>'ASC'
				];
				
				$filter = [
					[
					],				
				];
$cat_read->table = $table;
$cat_read->column = $column;
$cat_read->where = $where;
$cat_read->filter = $filter;
$cat_read->order = $order;


$myJSON = json_encode($cat_read);

//echo $myJSON;

if($_POST["checkSumSubmit"]!="")
{
	//write to DB
	global $con;
	$checksumname = "";
		$col = mysqli_query($con,"SELECT * FROM masterchecksum where checksumname = '".$_POST["checkSumName"]."'");
							while($rowcol = mysqli_fetch_array($col)){
								$checksumname = $rowcol['checksumname']; 
								
								
							}
			if($checksumname=="")				
	mysqli_query($con,"INSERT INTO masterchecksum  (checksumname, starthex, endhex, checksumaddress) VALUES ('".$_POST["checkSumName"]."', '".$_POST["checkSumStart"]."', '".$_POST["checkSumEnd"]."', '".$_POST["checkSumLocation"]."');");
	


}

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
              <li class="breadcrumb-item"><a href="./">Home</a></li>
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
				
				<form id="form-checksum" action="?page=add_checksum" method="POST" >
				<div class="row row-form">
					<div class="col-sm-3"><label>Checksum Name</label></div>
					<div class="col-sm-3"><label>Checksum Start (Hex)</label></div>
					<div class="col-sm-3"><label>Checksum End (Hex)</label></div>
					<div class="col-sm-3"><label>Checksum Address Location (Hex)</label></div>
                    </div>
				</div>
				
				<div class="row row-form">
					<div class="col-sm-3"><label><input id="checkSumName" name="checkSumName"></label></div>
					<div class="col-sm-3"><label><input id="checkSumStart" name="checkSumStart"><label></div>
					<div class="col-sm-3"><label><input id="checkSumEnd" name="checkSumEnd"></label></div>
					<div class="col-sm-3"><label><input id="checkSumLocation" name="checkSumLocation"></label></div>
                    </div>
					
					
						<div class="row row-form">
					<div class="col-sm-3"><label><input class="btn btn-primary" type="submit" id="checkSumSubmit" name="checkSumSubmit"></label></div>
					
                    </div>
					
				</div>
				
			
				</div>
				
				

					
				
					</form>

			
					
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