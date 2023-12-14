/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
	
	jQuery(document).on("click", ".deleteStaff", function(){
		var staffId = $(this).data("staffid"),
			hitURL = baseURL + "staff/delete",
			currentRow = $(this);
		
		var confirmation = confirm("このスタッフを削除してもよろしいですか？");
		
		if(confirmation)
		{

			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { staff_id : staffId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) {
					alert("正常に削除されました");
					location.href=baseURL + "staff";
				}
				else if(data.status = false) { alert("削除に失敗しました"); }
				else { alert("Access denied..!"); }
			});
		}
		return false;
	});
	$().on("click", ".searchList", function(){

	});

	jQuery(document).on("click", ".searchList", function(){
		
	});
	
});
