<?php 
$table = 'buildConfig';
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
		<p><b>Successful Project Creation</b></p>
	</center></div>
</div>';
$cat_insert->return_link = '?page=user-access';
$cat_insert->fk = [];
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
			<form id="form-build_config" onsubmit="return false" enctype="multipart/form-data">
			
              <div class="card-body">

                <h5 class="card-title"></h5>

                <p class="card-text">
                </p>
	
	
	  
				  <div class="row row-form">
					  <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>Build Config Creation Name</label>						
                       <input type="text" class="form-control" name="buildConfigName" id="buildConfigName" placeholder="">
                      </div>
                    </div>
					
					 <div class="col-sm-6">
                      <!-- select -->
                        <div class="form-group">
                         <label>Project</label>	
                        <select name="projectId" id="projectId" class="form-control">
						<?php optionMaster('project','productName','id','');?>
                        </select>
                      </div>
					  
					  
					  
                    </div>
					 </div>
					 
					  <div class="row row-form">
					  <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                       					
                      
					   <div class="form-group">
                         <label>Configuration input</label>	
						<br>
					<script>var configInput = [];</script>
					<input name="configInput" id="configInput" type="hidden"/>
					
					<input class="cb" type="checkbox" onclick="selectCI(this.value,this.id,'configInput')" id="Mac_Prof" value="MAC Prof">
					<label for="MAC Prof"> MAC Prof</label><br>
					<input class="cb" type="checkbox" id="Stride_value" onclick="selectCI(this.value,this.id,'configInput')" value="Stride value">
					<label for="Stride value"> Stride value</label><br>
					<input class="cb" type="checkbox" id="2D_Label" onclick="selectCI(this.value,this.id,'configInput')" value="2D Label">
					<label for="2D Label"> 2D Label</label><br>
					
					<input class="cb" type="checkbox" id="VPD" onclick="selectCI(this.value,this.id,'configInput')" value="VPD">
					<label for="VPD"> VPD</label><br>
					<input class="cb" type="checkbox" id="SN" onclick="selectCI(this.value,this.id,'configInput')" value="SN">
					<label for="SN"> SN</label><br>
					<input class="cb" type="checkbox" id="SN4" onclick="selectCI(this.value,this.id,'configInput')" value="SN4">
					<label for="SN4"> SN4</label><br>
						
					<input class="cb" type="checkbox" id="PART_NUMBER" onclick="selectCI(this.value,this.id,'configInput')" value="PART_NUMBER">
					<label for="PART_NUMBER"> PART_NUMBER</label><br>
					<input class="cb" type="checkbox" id="PART_REV" onclick="selectCI(this.value,this.id,'configInput')" value="PART_REV">
					<label for="PART_REV"> PART_REV</label><br>
					<input class="cb" type="checkbox" id="MAC_COUNT_-ANDYLOG" onclick="selectCI(this.value,this.id,'configInput')" value="MAC_COUNT -ANDYLOG">
					<label for="MAC_COUNT -ANDYLOG"> MAC_COUNT -ANDYLOG</label><br>
					
					<input class="cb" type="checkbox" id="MAC_INCREMENT-ANDYLOG" onclick="selectCI(this.value,this.id,'configInput')" value="MAC_INCREMENT-ANDYLOG">
					<label for="MAC_INCREMENT-ANDYLOG"> MAC_INCREMENT-ANDYLOG</label><br>
					<input class="cb" type="checkbox" id="PCIE" onclick="selectCI(this.value,this.id,'configInput')" value="PCIE">
					<label for="PCIE"> PCIE</label><br>
					<input class="cb" type="checkbox" id="FRU" onclick="selectCI(this.value,this.id,'configInput')" value="FRU">
					<label for="OEM"> OEM</label><br><input class="cb" type="checkbox" id="OEM" onclick="selectCI(this.value,this.id,'configInput')" value="OEM">
					<label for="OEM"> OEM</label><br>
				
						 
                      </div>
					  
                      </div>
                    </div>
					
					 <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>New Configuration Entry</label>						
                       <input name="newConfigEntry" id="newConfigEntry" type="text" class="form-control" id="econumber" placeholder="">
                      </div>
                    </div>
					 </div>
					 
					 <div class="row row-form">
					  <div class="col-sm-6">
                    <label for="referenceFileUpload">Reference Files Upload</label><br>
                     <input type="file" class="form-control" id="referenceFile" name="referenceFile">

				  </div>
				  
				   <div class="col-sm-6">
				   
				   	
                      <!-- select -->
                      <div class="form-group">
                        <label>ECO Entry</label>						
                       <input name="ecoEntry" id="ecoEntry" type="text" class="form-control" id="econumbertext" placeholder="">
                      </div>
               
					
					
				  </div>

					 </div>
					 
					 <div class="row row-form">
					  <div class="col-sm-6">
					    <div class="form-group">
                    <label for="productFileUpload">Product File Upload</label>
					<input type="file" class="form-control" id="productFile" name="productFile">
                  </div>
				  </div>
				  
				   <div class="col-sm-6">
				   <div class="form-group">
                       					
                      
					 
                      </div>
					  </div>
					 </div>
					 
					 </form>
					<div class="row row-form">
						<div class="col-md-12">
							<button onclick='bcCrt("build_config",<?php echo json_encode($cat_insert);?>)' class="btn btn-primary">Create Build Creation</button>
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