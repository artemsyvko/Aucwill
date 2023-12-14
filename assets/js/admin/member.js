/**
 * @author Kishor Mali
 */


jQuery(document).ready(function(){
		
	var addUserForm = $("#addUser");
	
	var validator = addUserForm.validate({
		
		rules:{
			fname :{ required : true },
			email : { required : true, email : true, remote : { url : baseURL + "checkEmailExists", type :"post"} },
			password : { required : true },
			cpassword : {required : true, equalTo: "#password"},
			mobile : { required : true, digits : true },
			role : { required : true, selected : true}
		},
		messages:{
			fname :{ required : "この項目は必須です" },
			email : { required : "この項目は必須です", email : "有効なメールアドレスを入力してください", remote : "メールアドレスが常に存在しています。" },
			password : { required : "この項目は必須です" },
			cpassword : {required : "この項目は必須です", equalTo: "同じパスワードを入力してください" },
			mobile : { required : "この項目は必須です", digits : "数字を入力してください。" },
			role : { required : "この項目は必須です", selected : "選択してください。" }
		}
	});

	var editUserForm = $("#editUser");
	
	var validator = editUserForm.validate({
		
		rules:{
			fname :{ required : true },
			email : { required : true, email : true, remote : { url : baseURL + "checkEmailExists", type :"post", data : { userId : function(){ return $("#userId").val(); } } } },
			cpassword : {equalTo: "#password"},
			mobile : { required : true, digits : true },
			role : { required : true, selected : true}
		},
		messages:{
			fname :{ required : "この項目は必須です" },
			email : { required : "この項目は必須です", email : "有効なメールアドレスを入力してください", remote : "メールアドレスが常に存在しています。" },
			cpassword : {equalTo: "同じパスワードを入力してください" },
			mobile : { required : "この項目は必須です", digits : "数字を入力してください。" },
			role : { required : "この項目は必須です", selected : "選択してください。" }
		}
	});

	var editProfileForm = $("#editProfile");
	
	var validator = editProfileForm.validate({
		
		rules:{
			fname :{ required : true },
			mobile : { required : true, digits : true },
			email : { required : true, email : true, remote : { url : baseURL + "checkEmailExists", type :"post", data : { userId : function(){ return $("#userId").val(); } } } },
		},
		messages:{
			fname :{ required : "この項目は必須です" },
			mobile : { required : "この項目は必須です", digits : "数字を入力してください。" },
			email : { required : "この項目は必須です", email : "有効なメールアドレスを入力してください", remote : "メールアドレスが常に存在しています。" },
		}
	});

	jQuery(document).on("click", ".deleteMember", function(){
		var userId = $(this).data("userid"),
			hitURL = baseURL + "admin/member/delete",
			currentRow = $(this);
		
		
		var confirmation = confirm("この店舗を削除してもよろしいですか？");
		
		if(confirmation)
		{

			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { userId : userId } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) {
					alert("正常に削除されました");
					location.href=baseURL + "admin/member";
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
function CopyToClipboard(container_id) {
	$('.code-copy-message').hide();
	if (window.getSelection) {
		if (window.getSelection().empty) { // Chrome
			window.getSelection().empty();
		} else if (window.getSelection().removeAllRanges) { // Firefox
			window.getSelection().removeAllRanges();
		}
	} else if (document.selection) { // IE?
		document.selection.empty();
	}

	if (document.selection) {
		var range = document.body.createTextRange();
		range.moveToElementText(document.getElementById(container_id));
		range.select().createTextRange();
		document.execCommand("copy");
	} else if (window.getSelection) {
		var range = document.createRange();
		range.selectNode(document.getElementById(container_id));
		window.getSelection().addRange(range);
		document.execCommand("copy");
	}
	if (window.getSelection) {
		if (window.getSelection().empty) { // Chrome
			window.getSelection().empty();
		} else if (window.getSelection().removeAllRanges) { // Firefox
			window.getSelection().removeAllRanges();
		}
	} else if (document.selection) { // IE?
		document.selection.empty();
	}
	$('.code-copy-message').show();
	$('.code-copy-message').fadeToggle(1000);
}
