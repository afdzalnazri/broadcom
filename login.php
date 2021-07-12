<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Broadcom | Log in</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="image/favicon.png" type="image/gif" sizes="16x16">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  
  <script type="text/javascript">
  
  
  
function log(formname){  

	var form = $('#'+formname+'')[0];
    var formdata = new FormData(form);
	$("#btn_"+formname).attr("disabled",true);    
	
	$.ajax({
        url: "functions/nsis/log.php",
        type: "POST",
        data: formdata,
        processData: false,
        contentType: false,
        success: function(data) {
			var d = jQuery.parseJSON(data);
			if(d.status == 1){
				location.replace('./');
			}
			else{
				$("#btn_"+formname).attr("disabled",false);  
				$("#login-notice").html('<center><font color="red" size="2">Login Failed</font></center><br>');
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

      <form id="login" onsubmit="return false">
        <div class="input-group mb-3">
          <input name="email" type="email" class="form-control" placeholder="Email" value="dev1@email.com">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="password" type="password" class="form-control" placeholder="Password" value="123">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
		<input type="hidden" name="type" value="in"/>
		</form>
        <div class="row">
          <div class="col-12">
			<div id="login-notice"></div>
            <button style="width:100%" onclick="log('login')" id="btn_login" class="btn btn-danger btn-block">Sign In</button>
			<button style="width:100%" onclick="window.location.href = 'resetpassword.php';" id="btn_forgot_password" class="btn btn-danger btn-block">Forgot Password</button>
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
