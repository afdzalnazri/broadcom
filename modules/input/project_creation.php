<?php 
$table = 'project';
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
				
				<form id="form-project" onsubmit="return false" enctype="multipart/form-data">
				<div class="row row-form">
					<div class="col-sm-12">
						<div class="form-group">
							<label>Product Name</label>
							<input type="text" class="form-control" id="productName" name="productName" />
                      </div>
                    </div>
				</div>

				<!--<div class="row row-form">
					<div class="col-md-12">
					<div class="form-group">
                    <label for="exampleInputFile">File Input</label><br>
                        <input type="file" class="form-control" id="fileName" name="fileName">
                  </div>
					</div>
				</div>
	
				<div class="row row-form">
					<div class="col-md-12">
				   <div class="form-group">
                    <label for="exampleInputFile">PQA Test Logging File Upload</label><br>
                        <input type="file" class="form-control" id="pqaTestLogFile" name="pqaTestLogFile">
                  </div>
					</div>
				</div>-->
				  <div class="row row-form">
				   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Family</label>
                        <select onchange="resetInput(this.value,'newFamily')" class="form-control" name="family" id="family">
						  <option value="">Select Family</option>
						  <?php echo optionMaster('masterFamily', 'familyName', 'id', ''); ?>
                        </select>
                      </div>
                    </div>
					
					<div class="col-sm-6">
						<div class="form-group">
							<label>New Family</label>
							<input onkeyup="resetInput(this.value,'family')" type="text" class="form-control" id="newFamily" name="newFamily" placeholder="">
						</div>
                    </div>
				</div>
					
				<div class="row row-form">
					
					 <div class="col-sm-6">

                      <div class="form-group">
                        <label>Product Number</label>
                        <select onchange="resetInput(this.value,'newProductNumber')" class="form-control" name="productNumber" id="productNumber">
							<option value="">Product Number</option>
							<?php echo optionMaster('masterProduct', 'productNumber', 'id', ''); ?>
                        </select>
                      </div>
                    </div>
					
					 <div class="col-sm-6">
                      <div class="form-group">
                        <label>New Product Number</label>
                        <input onkeyup="resetInput(this.value,'productNumber')" type="text" class="form-control" id="newProductNumber" name="newProductNumber" placeholder="">
                      </div>
                    </div>
					
					</div>
					
					  
				  
				   <div class="row row-form">
				   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Customer</label>
                        <select onchange="resetInput(this.value,'newCustomer')" name="customer" id="customer" class="form-control">
						<option value="">Select Customer</option>
						<?php echo optionMaster('masterCustomer', 'customerName', 'id', ''); ?>
                        </select>
                      </div>
                    </div>
					
					
					 <div class="col-sm-6">
                      <div class="form-group">
                        <label>New Customer</label>
						<input onkeyup="resetInput(this.value,'customer')" type="text" class="form-control" id="newCustomer" name="newCustomer" placeholder="">
                      </div>
                    </div>
					</div>
					
					<div class="row row-form">
					
					  <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>Form Factor</label>
                        <select onchange="resetInput(this.value,'newFormFactor')" name="formFactor" id="formFactor" class="form-control">
						  <option value="">Select Form Factor</option>
						  <?php echo optionMaster('masterFormFactor', 'formFactorName', 'id', ''); ?>
                        </select>
                      </div>
                    </div>
					
					 <div class="col-sm-6">
                      <div class="form-group">
                        <label>New Form Factor</label>
                        <input onkeyup="resetInput(this.value,'formFactor')" type="text" class="form-control" id="newFormFactor" name="newFormFactor" placeholder="">			   
                      </div>
                    </div>
				</div>
					
					<div class="row row-form">
					<div class="col-sm-12">
					 <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                  </div>
				  </div>
				  
					</div>
					
					<div class="row row-form">
					
					  <div class="col-sm-6">
                      <div class="form-group">
                        <label>BRCM Linux Tool Versioning</label>
                        <select onchange="resetInput(this.value,'new_brcmMinIsoFw')" name="brcmMinIsoFw" id="brcmMinIsoFw" class="form-control">
                          <option value="">Select an option</option>
						  <?php echo optionMaster('masterIsoFw', 'isoFwVer', 'isoFwVer', ''); ?>
                        </select>
						<br>
						 <select onchange="resetInput(this.value,'new_brcmMinDstVer')" name="brcmMinDstVer" id="brcmMinDstVer" class="form-control">                        
                          <option value="">Select an option</option>
						  <?php echo optionMaster('masterDstVer', 'dstVer', 'dstVer', ''); ?>
                        </select>
						<br>
						 <select onchange="resetInput(this.value,'new_brcmDstWinCtrl')" name="brcmDstWinCtrl" id="brcmDstWinCtrl" class="form-control">
                          <option name="brcmDstWinCtrl" id="brcmDstWinCtrl" value="">Select an option</option>
						  <?php echo optionMaster('masterDstWinCtrl', 'dstWinCtrl', 'dstWinCtrl', ''); ?>
                        </select>
                      </div>
                    </div>
					
					 <div class="col-sm-6">
                      <div class="form-group">
                        <label>New BRCM Linux Tool Versioning</label>
                       <input onkeyup="resetInput(this.value,'brcmMinIsoFw')" type="text" class="form-control" id="new_brcmMinIsoFw" name="new_brcmMinIsoFw" placeholder="">
					<br>  					   
					   <input onkeyup="resetInput(this.value,'brcmMinDstVer')" type="text" class="form-control" id="new_brcmMinDstVer" name="new_brcmMinDstVer" placeholder="">
					
					<br>
					   <input onkeyup="resetInput(this.value,'brcmDstWinCtrl')" type="text" class="form-control" id="new_brcmDstWinCtrl" name="new_brcmDstWinCtrl"placeholder="">
                      </div>
                    </div>
					</div>
					</form>

					<div class="row row-form">
						<div class="col-md-12">
							<button onclick='prjCrt("project",<?php echo json_encode($cat_insert);?>,<?php echo json_encode($columns);?>)' class="btn btn-primary" id="btn_submit" >Create Project</button>
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