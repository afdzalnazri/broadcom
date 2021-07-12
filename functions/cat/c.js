function create(formname,dt){ 
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

	$("#btn_submit").attr('disabled',true);
	$.ajax({
        url: "functions/cat/create.php",
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

