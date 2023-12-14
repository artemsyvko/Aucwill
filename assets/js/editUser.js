/**
 * File : editUser.js 
 * 
 * This file contain the validation of edit user form
 * 
 * @author Kishor Mali
 */
$(document).ready(function(){
	
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

});