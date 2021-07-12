
/* Master Versioning Creation */
function mvCrt(formname,dt){
	
	var file_type = document.getElementById("scriptFileName").value;
	file_type = file_type.substr(file_type.lastIndexOf('.')+1,file_type.length);


	
	if((file_type != 'zip' && file_type != 'tar' && file_type != 'ini' && file_type != 'txt' && file_type != '') ){
		alert("Invalid 'New Script Files'. File must be in .zip or .tar");
		return false;
	}
	
	
	var form = $('#form-'+formname+'')[0];
    var formdata = new FormData(form);
	formdata.append('action','master_file_versioning');
	formdata.append('table','masterVersionFile');

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
        url: "functions/abn/insert.php",
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
			setInterval(function(){location.reload();}, 3000);
        }
    });
}

function editmasterFile(){
	var action = 'editmasterFile';

	var fileID = document.getElementById("bcId").value;
	
	var scripttext = document.getElementById("master_file_editor").value;
	
	$.ajax({
        url: "functions/abn/insert.php", 
        type: "POST",
        data: {action,scripttext,fileID},
		
		 success: function(data) {
			var d = jQuery.parseJSON(data);
			$('#page_modal_content').html(d.message);
			setInterval(function(){location.reload();}, 3000);
        }
		
		
    });
	
	location.reload();
}

function dispMasterFile(scriptname){
	
	var action = 'display_master_file';
	$("#bcFile_sel").val(scriptname);
	//var scriptname = document.getElementById("bcFile_sel").value;   
	$.ajax({
         url: "functions/abn/misc.php",
        type: "POST",
        data: {action,scriptname},
        success: function(data) {
			
			var d = jQuery.parseJSON(data);
			$("#master_file_editor").html(d.data);
			$("#createdDate").html(d.createdDate);
			$("#modifiedDate").html(d.modifiedDate);
			$("#revision").html(d.revision);
			
        }
    });
}