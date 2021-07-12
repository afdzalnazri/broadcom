<?php ini_set("memory_limit", "1024M"); ?>
<!DOCTYPE html>
<!--
206.189.155.0
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title><?php echo $title; ?></title>
  
	<link rel="icon" href="image/favicon.png" type="image/gif" sizes="16x16">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/loading-bar.min.css">
  <link rel="stylesheet" href="dist/css/custom.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/loading-bar.min.js"></script>
<!-- JS Function Cat --->
<script src="functions/cat/c.js"></script>
<script src="functions/cat/r.js"></script>
<script src="functions/cat/u.js"></script>
<script src="functions/cat/d.js"></script>

<!-- JS Function NSIS --->
<script src="functions/nsis/functions.js"></script>

<!-- JS Function ABN --->
<script src="functions/abn/functions.js"></script>


</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="./" class="nav-link">Home</a>
      </li>
    </ul>
<ul class="navbar-nav ml-auto">
      <li class="nav-item">
		<form id="out"><input type="hidden" name="type" value="out"/></form>
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" onclick="log(this.id)" id="out">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    </ul>
  </nav>

  <aside style="padding-bottom:40px;font-size:14px" class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="./" class="brand-link">
      <img src="image/broadcom.png" alt="AdminLTE Logo" class="brand-image elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">&nbsp &nbsp &nbsp &nbsp &nbsp </span>
    </a> 

    <div style="color:#fff" class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        </div>
        <div class="info">
			<font size="2">Logged in as</font><br><b><?php echo $rowuser['name']; ?></b><br>
			<font size="2"><u><a href="?page=change-password">Change Password</a></u></font>
			<br>  
			<font size="2"><a href="#">Version 29.06.21-1</a></font>
        </div>
      </div>

      <nav class="mt-2">
	  <?php if($rowuser['admin'] == 1){ ?>
	  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview <?php if($page == 'user-access' || $page == 'user-log-activity'){echo 'menu-open';}?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-shield"></i> 
              <p>
                Admin
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="?page=user-access" class="nav-link <?php if($page == 'user-access'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>User Access</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=user-log-activity" class="nav-link <?php if($page == 'user-log-activity'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>User Log Activity </p>
                </a>
              </li>		 
            </ul>
          </li>  
        </ul>
		<?php } ?>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview <?php if($page == 'project-creation' || $page == 'project-list' || $page == 'build-config-list' || $page == 'build-config-copy' || $page == 'master-file-versioning' || $page == 'bc-script-editing' || $page == 'copy-build-creation' || $page == 'build-config-creation' || $page == 'project-details'|| !isset($_GET['page'])){echo 'menu-open';}?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-import"></i>
              <p>
                Input
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             <li class="nav-item has-treeview <?php if($page == 'project-creation' || $page == 'project-list' || $page == 'project-details'){echo 'menu-open';}?>">
             <a href="#" class="nav-link" >
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>Project</p>
				  <i class="right fas fa-angle-left"></i>
                </a>
				
				<ul class="nav nav-treeview">
			  <li style="padding-left:20px" class="nav-item">
                <a href="?page=project-creation" class="nav-link <?php if($page == 'project-creation'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>Creation<?php //echo $page; ?></p>
                </a>
              </li>
			  
              <li style="padding-left:20px" class="nav-item">
                <a href="?page=project-list" class="nav-link <?php if($page == 'project-list'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>List<?php //echo $page; ?></p>
                </a>
              </li>
			</ul>
			
              </li>

		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview <?php if($page == 'build-config-creation' || $page == 'build-config-list'){echo 'menu-open';}?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-caret-right"></i>
              <p style="color:#d9d9d9">
                Build Config
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
			 <ul class="nav nav-treeview">
			  <li style="padding-left:20px" class="nav-item">
                <a href="?page=build-config-creation" class="nav-link <?php if($page == 'build-config-creation'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>Creation</p>
                </a>
              </li>
              <li style="padding-left:20px" class="nav-item">
                <a href="?page=build-config-list" class="nav-link <?php if($page == 'build-config-list'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>List</p>
                </a>
              </li>
			</ul>
			</li>
		</ul>

			 <li class="nav-item">
                <a href="?page=master-file-versioning" class="nav-link <?php if($page == 'master-file-versioning'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>Master File Versioning</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="?page=bc-script-editing" class="nav-link <?php if($page == 'bc-script-editing'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>BC Script Editing</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview <?php if($page == 'create-compilation' || $page == 'edit-bc-files'){echo 'menu-open';}?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Integration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=create-compilation" class="nav-link <?php if($page == 'create-compilation'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>Create compilation</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview <?php if($page == 'mlf-compress-file'){echo 'menu-open';}?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-export"></i>
              <p>
                Output
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=mlf-compress-file" class="nav-link <?php if($page == 'mlf-compress-file'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>MLF Compress file</p>
                </a>
              </li>		  
            </ul>
          </li>
        </ul>
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview <?php if($page == 'fru-related-verification' || $page == 'compare_file_cfg'){echo 'menu-open';}?>">
            <a href="?page=file-validation" class="nav-link">
              <i class="nav-icon fas fa-check-circle"></i>
              <p>
                File Validation
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=fru-related-verification" class="nav-link <?php if($page == 'fru-related-verification'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>FRU Related Verification</p>
                </a>
              </li>
            </ul>
			
			  <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=compare_file_cfg" class="nav-link <?php if($page == 'compare_file_cfg'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>TRC File Comparison</p>
                </a>
              </li>
            </ul>
			
			 <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=bin_checksum" class="nav-link <?php if($page == 'bin_checksum'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>BIN Checksum</p>
                </a>
              </li>
            </ul>
			
			 <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=add_checksum" class="nav-link <?php if($page == 'add_checksum'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>Manual Checksum Entry</p>
                </a>
              </li>
			  
			   <li class="nav-item">
                <a href="?page=checksum_extra" class="nav-link <?php if($page == 'checksum_extra'){echo 'active';}?>">
                  <i class="nav-icon fas fa-caret-right"></i>
                  <p>Manual Checksum</p>
                </a>
              </li>
            </ul>
			
          </li>
        </ul>
		
		
      </nav>
    </div>
  </aside>