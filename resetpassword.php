<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Broadcom | Reset Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="image/favicon.png" type="image/gif" sizes="16x16">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  
  <script type="text/javascript">
  
  
  
function resetpassword(formname){  

	var form = $('#'+formname+'')[0];
    var formdata = new FormData(form);
	$("#btn_"+formname).attr("disabled",true);    
	
	$.ajax({
        url: "functions/nsis/resetpassword.php",
        type: "POST",
        data: formdata,
        processData: false,
        contentType: false,
        success: function(data) {
			var d = jQuery.parseJSON(data);
			if(d.status == 1){
				$("#resetpassword-notice").html('<center><font color="green" size="2">Please check your e-mail for new password</font></center><br>');
			}
			else{
				//$("#btn_"+formname).attr("disabled",false);  
				$("#resetpassword-notice").html('<center><font color="red" size="2">No e-mail found</font></center><br>');
			}
        }
    });
}


  </script>
  
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
	<img src="image/broadcom.png">
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <!--<p class="login-box-msg">Sign in to start your session</p>-->
<center><h3>RESET PASSWORD</h3></center>
      <form id="resetpassword" onsubmit="return false">
        <div class="input-group mb-3">
          <input name="email" type="email" class="form-control" placeholder="Email" value="dev1@email.com">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        
		<input type="hidden" name="type" value="in"/>
		</form>
        <div class="row">
          <div class="col-12">
			<div id="resetpassword-notice"></div>
            <button style="width:100%" onclick="resetpassword('resetpassword')" id="reset_password" class="btn btn-danger btn-block">Send new password</button>
			<button style="width:100%" onclick="window.location.href = 'index.php'; " id="main_page" class="btn btn-danger btn-block">Main Page</button>

          </div>
        </div>
      

    </div>
  </div>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- JS Function NSIS --->
<script src="functions/nsis/functions.js"></script>
</body>
</html>
