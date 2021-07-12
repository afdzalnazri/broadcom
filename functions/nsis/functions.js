

function sendEmail(formname,dt){
	event.preventDefault();
	var form = $('#form-'+formname+'')[0];
    var formdata = new FormData(form);
	$.each(dt, function( index, value ) {
		if(index == 'fk' || index == 'check_data_exist'){
			formdata.append(index,JSON.stringify(value));
		}
		else{
			formdata.append(index,value);
		}
	});
	formdata.append('action','user_creation');
	$.ajax({
        url: "functions/nsis/email.php",
        type: "POST",
        data: formdata,
        processData: false,
        contentType: false,
        success: function(data) {
        }
    });
}

function resetInput(value,resetinput,table){
	if(value.length > 0){
		$("#"+resetinput+"").val("");

	}
}


/*function selectCI(value,id,inputid){
	var a = $('#' + id).is(":checked");
	if(a){
		configInput.push(value);
	}else{
		var index = configInput.indexOf(value);
		configInput.splice(index, 1);
	}
	
	var ci = configInput.filter((v, i, a) => a.indexOf(v) === i);
	$("#"+inputid+"").val(ci);

}*/

function assCP(cb_value,cb_id){
	var action = 'build_config_last_value';
	$.ajax({
        url: "functions/nsis/insert.php",
        type: "POST",
        data: {action,cb_value},
        success: function(data) {
			var d = jQuery.parseJSON(data);
			$("#value_"+cb_id).val(d.value);
			if($("#"+cb_id).is(":checked")){
				$("#value_"+cb_id).attr("hidden",false); 
			}else{
				$("#value_"+cb_id).attr("hidden",true);
			}
        }
    });
}

function addCP(){
	var cp = '<label>New Configuration</label>';
	cp += '<div class="row row-form">';
	cp += '<div class="col-md-3">Parameter</div>';
	cp += '<div class="col-md-9"><input name="newConfigEntry[]" id="newConfigEntry" type="text" class="form-control"></div>';
	cp += '</div>';
	cp += '<br>';
 	cp += '<div class="row row-form">';
	cp += '<div class="col-md-3">Value</div>';
	cp += '<div class="col-md-9"><input name="newConfigEntryVal[]" id="newConfigEntryVal" type="text" class="form-control"></div>';
	cp += '</div>';
	$("#new_cp").append(cp);
}

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

/* Project Creation */
function prjCrt(formname,dt,columns){
	
	//var pqa_type = document.getElementById("pqaTestLogFile").value;
	//var file_type = document.getElementById("fileName").value;
	//pqa_type = pqa_type.substr(pqa_type.lastIndexOf('.')+1,pqa_type.length);
	//file_type = file_type.substr(file_type.lastIndexOf('.')+1,file_type.length);
	
	//if((pqa_type != 'zip' && pqa_type != 'tar' && pqa_type != 'ini' && pqa_type != 'txt' && pqa_type != '')){
	//	alert("Invalid 'PQA Test Logging File Upload'. File must be in .zip or .tar");
	//	return false;
	//}
	
	//if((file_type != 'zip' && file_type != 'tar' && file_type != 'ini' && file_type != 'txt' && file_type != '')){
	//	alert("Invalid 'File Input'. File must be in .zip or .tar");
	//	return false;
	//}

	var empty = 0;
	empty = parseInt(empty);
	
	$.each(columns, function( index, value ) {
		
		if($('#'+value+'').length){
			
			if($('#'+value+'').val().length == 0){
				 empty = empty + 1
				$('#'+value).addClass('empty-border');
				
				if(value == 'family' && $('#newFamily').val().length > 0){
					empty = empty - 1;
					$('#'+value).removeClass('empty-border');
				}
				if(value == 'productNumber' && $('#newProductNumber').val().length > 0){
					empty = empty - 1;
					$('#'+value).removeClass('empty-border');
				}
				if(value == 'customer' && $('#newCustomer').val().length > 0){
					empty = empty - 1;
					$('#'+value).removeClass('empty-border');
				}
				if(value == 'formFactor' && $('#newFormFactor').val().length > 0){
					empty = empty - 1;
					$('#'+value).removeClass('empty-border');
				}
				if(value == 'brcmMinIsoFw' && $('#new_brcmMinIsoFw').val().length > 0){
					empty = empty - 1;
					$('#'+value).removeClass('empty-border');
				}
				if(value == 'brcmMinDstVer' && $('#new_brcmMinDstVer').val().length > 0){
					empty = empty - 1;
					$('#'+value).removeClass('empty-border');
				}
				if(value == 'brcmDstWinCtrl' && $('#new_brcmDstWinCtrl').val().length > 0){
					empty = empty - 1;
					$('#'+value).removeClass('empty-border');
				}
			
			}else{
				$('#'+value).removeClass('empty-border');
			}
		}
	});
	
	if(empty > 0){
		alert("Please fill up all fields");
		return false;
	}

	var form = $('#form-'+formname+'')[0];
    var formdata = new FormData(form);
	formdata.append('action','project_creation');
	formdata.append('table','project');
	$.ajax({
		    xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
                var percent = (evt.loaded / evt.total)*100;
				percent = percent.toFixed(0);
				bar.set(percent,false);
            }
			}, false);

			xhr.addEventListener("progress", function(evt) {
			if (evt.lengthComputable) {
               var percent = (evt.loaded / evt.total)*100;
			   percent = percent.toFixed(0);
			   bar.set(percent,false);
			}
			}, false);
			return xhr;
		},
        url: "functions/nsis/insert.php",
        type: "POST",
		data: formdata,
	    processData: false,
        contentType: false,
        beforeSend: function() {
			$('#page_modal').modal('show');
		},
        success: function(data) {
			var d = jQuery.parseJSON(data);
			$('#page_modal_content').html(d.message);
			
			//Check duplicate
			if(d.status == 'duplicate_prod'){
				setInterval(function(){$('#page_modal').modal('hide');}, 3000);
			}else{
				setInterval(function(){location.replace("./?page=project-list");}, 3000);
			}
			
			
        }
    });
}

/* Project Creation */
function prjUpdt(formname,dt,id){
	
	//var pqa_type = document.getElementById("pqaTestLogFile").value;
	//var file_type = document.getElementById("fileName").value;
	//pqa_type = pqa_type.substr(pqa_type.lastIndexOf('.')+1,pqa_type.length);
	//file_type = file_type.substr(file_type.lastIndexOf('.')+1,file_type.length);
	
	//if((pqa_type != 'zip' && pqa_type != 'tar' && pqa_type != 'ini' && pqa_type != 'txt' && pqa_type != '')){
	//	alert("Invalid 'PQA Test Logging File Upload'. File must be in .zip or .tar");
	//	return false;
	//}
	
	//if((file_type != 'zip' && file_type != 'tar' && file_type != 'ini' && file_type != 'txt' && file_type != '')){
	//	alert("Invalid 'File Input'. File must be in .zip or .tar");
	//	return false;
	//}
	
	var form = $('#form-'+formname+'')[0];
    var formdata = new FormData(form);
	formdata.append('action','project_update');
	formdata.append('table','project');
	formdata.append('id_value',id);
	$.ajax({
		    xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
                var percent = (evt.loaded / evt.total)*100;
				percent = percent.toFixed(0);
				bar.set(percent,false);
            }
			}, false);

			xhr.addEventListener("progress", function(evt) {
			if (evt.lengthComputable) {
               var percent = (evt.loaded / evt.total)*100;
			   percent = percent.toFixed(0);
			   bar.set(percent,false);
			}
			}, false);
			return xhr;
		},
        url: "functions/nsis/update.php",
        type: "POST",
		data: formdata,
	    processData: false,
        contentType: false,
        beforeSend: function() {
			$('#page_modal').modal('show');
		},
        success: function(data) {
			console.log(data);
			var d = jQuery.parseJSON(data);
			$('#page_modal_content').html(d.message);
			setInterval(function(){location.reload();}, 3000);
        }
    });
}



function checkDuplicate(str) {

var e = document.getElementById("option_product");
var option_product = e.options[e.selectedIndex].text;

var e = document.getElementById("option_family");
var option_family_text = e.options[e.selectedIndex].text;

var buildConfigName = document.getElementById("buildConfigName").value;



            var xhr = new XMLHttpRequest();
            var url = "http://206.189.155.0/broadcom/functions/nsis/getdata.php?project="+option_product+"&family="+option_family_text+"&bc="+buildConfigName;


            xhr.onreadystatechange = function (response) {

                if (xhr.readyState == 4 && xhr.status == 200) {
                   
                    if (xhr.responseText==" DUPLICATE FOUND") {
						//alert(xhr.responseText);
                        alert('There is duplication of Build Config in your selection. You can change the build config name or proceed but the files for this build config name will be overwrite');
				
                    }else
					{
							}
                }

            }
            xhr.open("GET", url, true);
            xhr.send();


        

}

/* Build Config Creation */
function bcCrt(formname,dt){
	
	var empty = 0;
	empty = parseInt(empty);
	var columns = ['buildConfigName','familyId','projectId'];
	$.each(columns, function( index, value ) {
		if($('#'+value+'').length){
			if($('#'+value+'').val().length == 0){
				 empty = empty + 1
				$('#'+value).addClass('empty-border');
			}else{
				$('#'+value).removeClass('empty-border');
			}
		}
	});
	
	if(empty > 0){
		alert("Please fill up the highlighted field(s)");
		return false;
	}
	
	//--Check Reference File and Product File type
	var reference_type = document.getElementById("referenceFile").value;
	var product_type = document.getElementById("productFile").value;
	reference_type = reference_type.substr(reference_type.lastIndexOf('.')+1,reference_type.length);
	product_type = product_type.substr(product_type.lastIndexOf('.')+1,product_type.length);
	console.log(product_type);
	if((reference_type != 'zip' && reference_type != 'tar' && reference_type != 'ini' && reference_type != 'txt' && reference_type != '') ){
		alert("Invalid 'Reference File'. File must be in .zip or .tar");
		return false;
	}
	if((product_type != 'zip' && product_type != 'tar' && product_type != 'ini' && product_type != 'txt' && product_type != '')){
		alert("Invalid 'Product File'. File must be in .zip or .tar");
		return false;
	}
	
	var form = $('#form-'+formname+'')[0];
    var formdata = new FormData(form);
	formdata.append('table','buildConfig');
	
	//--Include data from 'dt'
	$.each(dt, function( index, value ) {
		formdata.append(index,value);
	});
	
	$.ajax({
		    xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
                var percent = (evt.loaded / evt.total)*100;
				percent = percent.toFixed(0);
				bar.set(percent,false);
            }
			}, false);

			xhr.addEventListener("progress", function(evt) {
			if (evt.lengthComputable) {
               var percent = (evt.loaded / evt.total)*100;
			   percent = percent.toFixed(0);
			   bar.set(percent,false);
			}
			}, false);
			return xhr;
		},
        url: "functions/nsis/insert.php",
        type: "POST",
		data: formdata,
	    processData: false,
        contentType: false,
        beforeSend: function() {
			$('#page_modal').modal('show');
		},
        success: function(data) {
			var d = jQuery.parseJSON(data);
			$('#page_modal_content').html(d.message);
			if(d.status == 'duplicate'){
				setInterval(function(){$('#page_modal').modal('hide');}, 3000);
			}else{
				setInterval(function(){location.reload();}, 3000);
			}
			console.log(data);
			/*
			setInterval(function(){location.reload();}, 3000);*/
        }
    });
}


function selbcFamily(familyid){
	$("#btn_edit_bc").attr("disabled",true);
	$("#file_explorer").html('');
	var action = 'get_bc_family';
	if(familyid == ''){
		
		
	}
	console.log('ok');
	$.ajax({
         url: "functions/nsis/misc.php",
        type: "POST",
        data: {action,familyid},
        success: function(data) {
			var d = jQuery.parseJSON(data);
			
			$("#projectId").html(d.data);
			$("#editButton").html("");
			
        }
    });
}


function selbcBc(projid){
	$("#btn_edit_bc").attr("disabled",true);
	$("#file_explorer").html('');
	var action = 'get_bc_bc';
	if(projid == ''){
		$("#bc_editor").html('');
		$("#bcFile_sel").html('<option value="">Select File</option>');
	}
	console.log('ok');
	$.ajax({
         url: "functions/nsis/misc.php",
        type: "POST",
        data: {action,projid},
        success: function(data) {
			var d = jQuery.parseJSON(data);
			$("#bcFile_sel").html('<option value="">Select File</option>');
			$("#bcId_sel").html(d.data);
        }
    });
}

function selbcFile(bcid){
	$("#btn_edit_bc").attr("disabled",true);
	$("#file_explorer").html('');
	var action = 'get_bc_file';
	if(bcid == ''){$("#bc_editor").html('');}
	$.ajax({
         url: "functions/nsis/misc.php",
        type: "POST",
        data: {action,bcid},
        success: function(data) {
			var d = jQuery.parseJSON(data);
			$("#editButton").html(d.data);
			/*if(bcid != ''){
				$("#bcFile_sel").html(d.data);
			}else{
				$("#bcFile_sel").html('<option value="">Select File</option>');}*/
			
        }
    });
}

function dispbcFile(scriptname){
	var action = 'display_bc_file';
	$("#bcFile_sel").val(scriptname);
	//var scriptname = document.getElementById("bcFile_sel").value; 
	$.ajax({
         url: "functions/nsis/misc.php",
        type: "POST",
        data: {action,scriptname},
        success: function(data) {
			console.log(data);
			$("#btn_edit_bc").attr("disabled",false);
			var d = jQuery.parseJSON(data);
			$("#bc_editor").html(d.data);
        }
    });
}

function editbcFile(){
	var action = 'edit_bc_file';
	var bcid = document.getElementById("bcId_sel").value;
	var scriptname = document.getElementById("bcFile_sel").value;
	var scripttext = document.getElementById("bc_editor").value;
	$.ajax({
		    xhr: function() {
			var xhr = new window.XMLHttpRequest();
			xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
                var percent = (evt.loaded / evt.total)*100;
				percent = percent.toFixed(0);
				bar.set(percent,false);
            }
			}, false);

			xhr.addEventListener("progress", function(evt) {
			if (evt.lengthComputable) {
               var percent = (evt.loaded / evt.total)*100;
			   percent = percent.toFixed(0);
			   bar.set(percent,false);
			}
			}, false);
			return xhr;
		},
        url: "functions/nsis/insert.php",
        type: "POST",
        data: {action,scriptname,scripttext,bcid},
		        beforeSend: function() {
			$('#page_modal').modal('show');
		},
        success: function(data) {
			console.log(data);
			var d = jQuery.parseJSON(data);
			$('#page_modal_content').html(d.message);
			setInterval(function(){location.reload();}, 3000);
        }
    });
}


