<?php
if($rowuser['admin'] != 1){echo '<script>location.replace("./")</script>';}
$sql = mysqli_query($con,"SELECT * FROM user WHERE md5(id) = '$_GET[id]'"); 
$row = mysqli_fetch_array($sql);

$table = 'user';
$col = mysqli_query($con,"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table'");
while($rowcol = mysqli_fetch_array($col)){
	$columns[] = $rowcol['COLUMN_NAME']; 
}

$cat_insert->columns = $columns;
$cat_insert->table = $table;
$cat_insert->return_action = 'direct';
$cat_insert->return_modaltext = '<div class="row">
							<div class="col-md-12">
								<center>
								<font size="10" color="green"><i class="fa fa-check-circle"></i></font><br><br>
								<p><b>Successful User Update</b></p>
								</center>
							</div>
						</div>';
$cat_insert->return_link = '?page=user-access';
$cat_insert->fk = [];
$cat_insert->id_column = 'id';
$cat_insert->id = $row['id'];
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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
              <div class="card-body">
				<form id="form-user" onsubmit="return false">
				  <div class="row row-form">
					  <div class="col-sm-5">
                      <div class="form-group">
                        <label>Name</label>
						<input name="name" type="text" class="form-control" id="username" value="<?php echo $row['name'];?>"/>  
                      </div>
                    </div>
					
					 <div class="col-sm-5">
                      <div class="form-group">
                        <label>E-mail</label>
                       <input name="email" type="text" class="form-control" id="useremail" value="<?php echo $row['email'];?>"/>	   
                      </div>
					</div>
					<div class="col-sm-2">
                      <div class="form-group">
                        <label>Role</label>
						<select name="admin" class="form-control">
							<option value="0" <?php if($row['admin'] == 0){echo 'selected';}?>>User</option>
							<option value="1" <?php if($row['admin'] == 1){echo 'selected';}?>>Admin</option>
						</select>
                      </div>
					</div>
					 </div>
				</form>
				<div class="row row-form">
					<div class="col-md-12">
						<button onclick='update("user",<?php echo json_encode($cat_insert)?>)' class="btn btn-primary" id="btn_submit">Update User</button>
					</div>
				</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>