<?php
if($rowuser['admin'] != 1){echo '<script>location.replace("./")</script>';}
$table = 'user';
$column =
				[
					[
						'db_column'=>'name',
						'title_column'=>'Name',
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
						'db_column'=>'email',
						'title_column'=>'Email',
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
						'db_column'=>'lastlogin',
						'title_column'=>'Last Login',
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
									'page'=>'?page=user-update',
									'param'=>'id',
									'text'=>'View/Edit',
									'target'=>'',
									'class'=>'btn btn-primary',
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
									'param'=>'',
									'text'=>'Remove',
									'target'=>'',
									'class'=>'btn btn-danger',
									'function'=>
									[
										[
											'function_call'=>'onclick',
											'function_name'=>'remove',
											'function_params'=>['row_id','user','id']
										]
									]
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
									'page'=>'?page=user-log-activity',
									'param'=>'id',
									'text'=>'Activity',
									'target'=>'',
									'class'=>'btn btn-primary',
									'function'=>[]
								],
							'format'=>''
						],
						'width'=>'10%'
					],
				];
				$where = [];
				$order = 
				[
					'column'=>'created',
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
            <h1 class="m-0 text-dark"><?php echo $title;?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
			  <li class="breadcrumb-item">Admin</li>
              <li class="breadcrumb-item active"><?php echo $title;?></li>
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
						<a href="?page=user-creation"><button class="btn btn-primary">Add user</button></a>
					</div>
				</div>
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
				<!--<table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Date Created</th>
                      <th>Email</th>
					  <th>Last Login</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
				  
                    <tr>
                      <td>1</td>
                      <td>ADAM</td>
                      <td>11-10-2020</td>
                      <td><span class="tag tag-success">adam@gmail.com</span></td>
					  <td>11:54:19 AM 11-10-2020</td>
                       
					  <td> 
					  <a href="usercreate.html"><button class="btn btn-primary">View / Edit</button></a>
					  <a href="userremove.html"><button class="btn btn-primary">Remove</button></a>
					  <a href="useractivity.html"><button class="btn btn-primary">Activity</button></a>
					   
					</td>
                    </tr>
					
					 <tr>
                      <td>2</td>
                      <td>RICHARD</td>
                      <td>11-10-2020</td>
                      <td><span class="tag tag-success">richard@gmail.com</span></td>
					  <td>12:54:19 AM 11-10-2020</td>
                      <td> 
					  <a href="usercreate.html"><button class="btn btn-primary">View / Edit</button></a>
					  <a href="userremove.html"><button class="btn btn-primary">Remove</button></a>
					  <a href="useractivity.html"><button class="btn btn-primary">Activity</button></a>
					  
					</td>
                    </tr>
                    
                  </tbody>
                </table>-->
				
				
					</div>
				</div>			  
			  
			  	  <!--<a href="usercreate.html"><button class="btn btn-primary">Add user</button></a>
				
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Date Created</th>
                      <th>Email</th>
					  <th>Last Login</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
				  
                    <tr>
                      <td>1</td>
                      <td>ADAM</td>
                      <td>11-10-2020</td>
                      <td><span class="tag tag-success">adam@gmail.com</span></td>
					  <td>11:54:19 AM 11-10-2020</td>
                       
					  <td> 
					  <a href="usercreate.html"><button class="btn btn-primary">View / Edit</button></a>
					  <a href="userremove.html"><button class="btn btn-primary">Remove</button></a>
					  <a href="useractivity.html"><button class="btn btn-primary">Activity</button></a>
					   
					</td>
                    </tr>
					
					 <tr>
                      <td>2</td>
                      <td>RICHARD</td>
                      <td>11-10-2020</td>
                      <td><span class="tag tag-success">richard@gmail.com</span></td>
					  <td>12:54:19 AM 11-10-2020</td>
                      <td> 
					  <a href="usercreate.html"><button class="btn btn-primary">View / Edit</button></a>
					  <a href="userremove.html"><button class="btn btn-primary">Remove</button></a>
					  <a href="useractivity.html"><button class="btn btn-primary">Activity</button></a>
					  
					</td>
                    </tr>
                    
                  </tbody>
                </table>-->
              </div>
              <!-- /.card-body -->
			     	 
            </div>

            
          </div>
          <!-- /.col-md-6 -->
          
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->