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
			
			
              <div class="card-body">
                <h5 class="card-title"></h5>
                <p class="card-text">
                </p>
					<form>
					  <div class="row row-form">
					  <div class="col-sm-12">
                      <div class="form-group">
					  <div class="form-group">
                         <label>Family</label>	
                        <select class="form-control" id="familyID" onchange="selbcFamily(this.value)">
						<option>Select Family</option>
						<?php echo optionMaster('masterFamily','familyName','id','');?>
                        </select>
                      </div>
					  
					  <div class="form-group">
                         <label>Project</label>	
                        <select class="form-control" id="projectId" onchange="selbcBc(this.value)">
						<option>Select Project</option>
						<?php //echo optionMaster('project','productName','id','');?>
                        </select>
                      </div>
					  
					   <div class="form-group">
                         <label>Build Configuration</label>	
                        <select class="form-control" id="bcId_sel" onchange="selbcFile(this.value)">
						<option>Select Build Configuration</option>
                        </select>
                      </div>
					  
					  <div class="form-group"> 
                         <label id="editButton"></label>
						<!-- <div id="file_explorer" style="height:200px;border:1px solid #efefef;padding:20px;overflow-y:auto">
						-->
						 </div>
                        <!--<select class="form-control" id="bcFile_sel" onchange='$("#btn_edit_bc").attr("disabled",true);$("#bc_editor").html("");'> 
						<option value="">Select file</button>
                        </select>-->
                      </div>
					  <input type="hidden" id="bcFile_sel" />
                      </div>
                    </div>
					
					
					 </div>
					</form>
					 <!--<div class="row row-form">
						<div class="col-md-12">
						<button class="btn btn-primary" onclick="dispbcFile()">Load File</button>
						</div>
					</div>-->
						
				 
				 <br>
				
				<form>
				<input type="hidden" id="bcid" name="bcid" value="">
				 <!--  <div class="row row-form">
        <div class="col-md-12">
          <div class="card card-outline card-danger">
            <div class="card-header">
              <h3 class="card-title">  
                Editor
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                  <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool btn-sm" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fas fa-times"></i></button>
              </div>
            </div>
            <div class="card-body pad">
              <div class="mb-3">
                <textarea id="bc_editor" class="textarea"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
              </div>
              
            </div>
          </div>
        </div>
      </div> -->
</form>	  
<!--
		<div class="row row-form">
			<div class="col-md-12">
				<button id="btn_edit_bc" onclick="editbcFile()" class="btn btn-primary" disabled>Save File</button>
			</div>
		</div>
	    	-->
				  
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