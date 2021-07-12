<?php
if($rowuser['admin'] != 1){echo '<script>location.replace("./")</script>';}
$table = 'useractivity';
$column =
				[
					[
						'db_column'=>'userId',
						'title_column'=>'Name',
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
						'width'=>'20%'
					],
					[
						'db_column'=>'activitytime',
						'title_column'=>'Date / Time',
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
							'format'=>'datetime'
						],
						'width'=>'20%'
					],
					[
						'db_column'=>'activity',
						'title_column'=>'Activity',
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
						'width'=>'50%'
					]
				];
				
				
				
				if(isset($_GET['id'])){
					$where = [
						[
							'condition'=>'',
							'column'=>'md5(userId)',
							'operator'=>'=',
							'value'=>''.$_GET['id'].''
						
						]
					
					];
				}else{
					$where = [];
				}

				$order = 
				[
					'column'=>'activitytime',
					'order'=>'DESC'
				];
				$filter = [];
$cat_read->table = $table;
$cat_read->column = $column;
$cat_read->where = $where;
$cat_read->filter = $filter;
$cat_read->order = $order;

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
			  <li class="breadcrumb-item">Admin</li>
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
			
			 <!--<div class="card-header">
                <h3 class="card-title"></h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                  </div>
                </div>
              </div>-->
              <div class="card-body table-responsive">
				
				<div class="row row-form">
					<div class="col-md-12">
						<form onsubmit="return false" class="filter-form" id="filter_vars">
						</form>
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