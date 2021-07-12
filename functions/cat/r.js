function read(formname,dt,page){
	var form = $('#'+formname+'')[0];
    var formdata = new FormData(form);
	$.each(dt, function( index, value ) {
		formdata.append(index,JSON.stringify(value));
	});
	formdata.append('action','read_table');
	formdata.append('page_no',page);
	formdata.append('dt',JSON.stringify(dt));
	formdata.append('formname',formname);
	$("#btn_submit").attr('disabled',true);
	$.ajax({
        url: "functions/cat/read.php",
        type: "POST",
        data: formdata,
        processData: false,
        contentType: false,
        success: function(data) {
			//console.log(data);
			var d = jQuery.parseJSON(data);
			if(d.numrows > 0){$("#export_button").attr("hidden",false);}else{$("#export_button").attr("hidden",true);}
			$("#btn_submit").attr('disabled',false);
			$("#table_data").html(d.data);
			$("#table_data_"+formname+"").html(d.data);
        }
    });
}


function filterOption(value,table,searchcol,displaycol,valuecol,assignid){
	
	var action = 'filter_option';
	$.ajax({
        url: "functions/cat/read.php",
        type: "POST",
        data: {action,value,table,searchcol,displaycol,valuecol,assignid},
        success: function(data) {
			console.log(data);
			var d = jQuery.parseJSON(data);
			if(d.status == 1){
				$("#"+assignid).attr('disabled',false);
				$("#"+assignid).html(d.options);
			}else{
				$("#"+assignid).html('<option value="">Select an option</option>');
				$("#"+assignid).attr('disabled',true);
			}
        }
    });
}

function resetTable(){
	document.getElementById("filter_vars").reset();
}