<?php 
if($rowuser['admin'] != 1){echo '<script>location.replace("./")</script>';}
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
				<form id="form-user" action='?page=change-password' method='POST' >
				  <div class="row row-form">
					  <div class="col-sm-5">
                      <div class="form-group">
                        <label>New Password</label>
						<input name="password" type="text" class="form-control" id="password"/>  
						
                    </div>
					 </div>
					</div>
				
				<div class="row row-form">
					<div class="col-md-12">
						<!-- <button onclick='update("user",<?php echo json_encode($cat_insert)?>)' class="btn btn-primary" id="btn_submit">Update Password</button> -->
						<input name="btn_password" type="submit" value="CHANGE PASSWORD" class="btn btn-primary" id="btn_password"/>  
					</div>
				</div>
				
				</form>
				
		
				<?php

if($_POST["btn_password"]!="")
{
	//echo $_POST["password"];
	$password = md5($_POST["password"]);
$col = mysqli_query($con,"UPDATE user set password = '$password' WHERE id = '$_SESSION[userId]'");
while($rowcol = mysqli_fetch_array($col)){
	
	echo "PASSWORD CHANGED";
}

}
?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>