function remove(id,table,idcolumn){ 
	event.preventDefault();

	if (confirm("Are you sure to remove item?") == false) {
		return false;
	}
	var action = 'delete';
	$.ajax({
        url: "functions/cat/delete.php",
        type: "POST",
        data: {action,table,id,idcolumn},
        success: function(data) {
			var d = jQuery.parseJSON(data);
			$('#modal_content_page_modal').html(''+d.return_modaltext+'');
			$('#page_modal').modal('show');
			setInterval(function(){
				if(table == 'project'){
					location.replace('./?page=project-list');
				}else{
					location.reload();
				}
				
			}, 3000);
        }
    });
}