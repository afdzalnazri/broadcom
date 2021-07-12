function update(formname,dt){ 
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
	formdata.append("action","update");
	$("#btn_submit").attr('disabled',true);
	$.ajax({
        url: "functions/cat/update.php",
        type: "POST",
        data: formdata,
        processData: false,
        contentType: false,
        success: function(data) {
			console.log(data);
			var d = jQuery.parseJSON(data);

			if(d.status == 1){
				if(d.return_action == 'reload'){
					location.reload();
				}else if(d.return_action == 'modal_show'){
					$('#modal_content_page_modal').html(d.return_modaltext);
					$('#page_modal').modal('show');
					setInterval(function(){location.reload();}, 3000);
				}else if(d.return_action == 'modal_hide'){
					$('#'+d.return_modalid+'').modal('hide');
				}else if(d.return_action == 'function'){
					var func = window[d.return_function];
					if (typeof func === "function") func.apply(null, d.return_params);
				}else if(d.return_action == 'direct'){
					$('#modal_content_page_modal').html(d.return_modaltext);
					$('#page_modal').modal('show');
					setInterval(function(){location.replace(d.return_link);}, 3000);
				}else if(d.return_action == 'open'){
					$('#modal_content_page_modal').html(d.return_modaltext);
					$('#page_modal').modal('show');
					setInterval(function(){location.replace(d.return_link);}, 3000);
				}
				
			}else if(d.status == 0){
				$('#modal_content_page_modal').html(d.error_msg);
				$('#page_modal').modal('show');
				setInterval(function(){$('#page_modal').modal('hide');}, 3000);
			}else if(d.status == 'empty'){
				$('#modal_content_page_modal').html(d.error_msg);
				$('#page_modal').modal('show');
				setInterval(function(){$('#page_modal').modal('hide');}, 3000);
			}else if(d.status == 'ponum'){
				$('#modal_content_page_modal').html(d.error_msg);
				$('#page_modal').modal('show');
				setInterval(function(){$('#page_modal').modal('hide');$( "#poserial_div" ).load(window.location.href + " #poserial_div" );}, 3000);
			}
        }
    });
}

function updateInline(id,columns){
	var datas = [];
	datas.push({'action': ''});
	datas.push({'id': id});
	console.log(datas);
	/*$.ajax({
        url: "functions/nsis/email.php",
        type: "POST",
        data: datas,
        success: function(data) {
			console.log(data);
        }
    });*/
}

function editInline(table,indexid,idcol,columns){
	var cols = Object.keys(columns);
	var ini_values = {};
	$("#btn_action_"+indexid+"").addClass("btn btn-success");
	document.getElementById("btn_action_"+indexid+"").innerText= "Save";
	var all_columns = JSON.parse(columns);
	if($("#edit_"+cols[0]+"_"+indexid+"").length == 0){ // Inputs for edit not exists

		$.each(all_columns, function(index,column_details) {
		var ini_value = document.getElementById("col_"+index+"_"+indexid+"").innerHTML;
		ini_value = ini_value.replace(/\s/g, '&nbsp;');

		ini_values[index] = ini_value;
		var type = column_details[0]; //Text,date,number,select
		var option = column_details[1];

		if(type != 'select'){
			
			$("#col_"+index+"_"+indexid+"").html("<input type='"+type+"' class='form-control' id='edit_"+index+"_"+indexid+"' value="+ini_value+">");
		}else{
			var html = '<select class="form-control" id="edit_'+index+'_'+indexid+'">';
			$.each(option, function(i,value) {
				html += '<option>'+value+'</option>';
			});
			html += '</select>';
			$("#col_"+index+"_"+indexid+"").html(html);
		}
		
		});
		
		var empty_value = 0;
		
		
		
		setInterval(function(){
		$.each(all_columns, function(index,column_details) {
			if($("#edit_"+index+"_"+indexid+"").length){
					var new_value = document.getElementById("edit_"+index+"_"+indexid+"").value;
			if(new_value == ''){$("#inline_submit_"+indexid+"").attr("disabled",true)}else{$("#inline_submit_"+indexid+"").attr("disabled",false)}; 
			}
		
		});
		}, 1000); 
		 
		var buttons = "<button id='inline_submit_"+indexid+"' class='btn btn-success' onclick=editInline('"+table+"','"+indexid+"','"+idcol+"',"+JSON.stringify(columns)+") disabled>Submit</button><br>";
		buttons += "<button  class='btn btn-danger' onclick=cancelEditInline('"+table+"','"+indexid+"','"+idcol+"',"+JSON.stringify(columns)+","+JSON.stringify(ini_values)+") style='margin-top:10px'>Cancel</button>";
		$("#td_editInline_"+indexid+"").html(buttons);

	}else{
		var values = {};
		$.each(all_columns, function(index,column_details) {
			var new_value = document.getElementById("edit_"+index+"_"+indexid+"").value;
			var new_value_type = document.getElementById("edit_"+index+"_"+indexid+"").type;
			values[index] = [new_value,new_value_type];
		});

		var action = 'update_inline';  
		$.ajax({
			url: "functions/cat/update.php",
			type: "POST",
			data: {action,table,indexid,idcol,values},
			success: function(data) {
					$("#btn_action_"+indexid+"").removeClass("btn btn-success");
					$("#btn_action_"+indexid+"").addClass("btn btn-primary");
					document.getElementById("btn_action_"+indexid+"").innerText= "Update";
					var d = jQuery.parseJSON(data);
					$.each(d.values, function(col,value) {
						$("#col_"+col+"_"+indexid+"").html(value);
						$("#td_editInline_"+indexid+"").html("<button class='btn btn-primary' onclick=editInline('"+table+"','"+indexid+"','"+idcol+"',"+JSON.stringify(columns)+")>Edit</button>");
					});
			}
		});
	}
}