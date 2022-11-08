<style>
#box{
    min-height: calc(100vh - 207px);
    display: flex;
    align-items: center;
    justify-content: center;
}
#box2{
    width: fit-content;
}
#box2 .a{
	font-size: 18px;
	margin-bottom: 4px;
    line-height: 30px;	
}
#box2 input{
	font-size: 16px;
	margin-bottom: 16px;
    border: none;
    box-shadow: 0 0 4px grey;
    border-radius: 6px;
    padding: 6px 10px;
    outline: none;
}
#frbar{
    border-bottom: 1px solid #00000033;
	background-color: #f9f9f9;
}
#frbar > div{
    font-size: 20px;
    font-weight: bold;
    position: relative;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}
#title{
    text-align: center;
}
.min{
	font-family: consolas, monospace, Microsoft JhengHei;
	max-width: 800px;
	margin: auto;
    padding: 16px 8px;
    min-height: calc(100vh - 207px);
}
.btn {
    padding: 6px 12px;
    margin: 8px;
    background-color: #ffc107;
    border-radius: 6px;
    width: fit-content;
    cursor: pointer;
    box-shadow: 2px 2px 4px #9e9e9e;
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
#alertBox{
    position: absolute;
    background-color: #f2f2f2;
    padding: 10px 20px;
    border-radius: 4px;
    box-shadow: 0 0 8px 2px #000000;
    font-size: 18px;
}
</style>
<script>
$(()=>{
	let getUrlParameter = function getUrlParameter(sParam) {
		let sPageURL = window.location.search.substring(1),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			}
		}
		return false;
	};
	$("#user").focus();
	$("#user").keypress((e)=>{
		let user = $("#user").val();
		if(e.keyCode == 13 && user != ""){
			$("#pass").focus();
		}
	});
	$("#pass").keypress((e)=>{
		let pass = $("#pass").val();
		if(e.keyCode == 13 && pass != ""){
			$("#btn_login").click();
			$("#pass").blur();
		}
	});
	let isSend = false;
	$("#btn_login").click(()=>{
		let user = $("#user").val();
		let pass = $("#pass").val();
		if(user == "" || pass == ""){return;}
		if(!isSend){
			isSend = true;
			$("#alertBox").text("登入中..");
			$("#alertBox").fadeIn(200);
			$.ajax({type:"POST",url:"//<?php echo "$domainName/login";?>",dataType:"json",
			data:{user:user, pass:pass},
			success: function(data) {
				if (data.s) {
					if(getUrlParameter("ref")){
						window.location = window.location.origin + getUrlParameter("ref");
					}else{
						window.location = "//<?php echo $domainName;?>/account";
					}
				}else{
					$("#alertBox").text(data.e);
					setTimeout(()=>{$("#alertBox").fadeOut(200);}, 1500);
					isSend = false;
				}
			},error: function(jqXHR) {
				$("#alertBox").fadeOut(100);
				setTimeout(()=>{alert("網路錯誤. 請重新整理頁面.");}, 100);
				console.log(jqXHR);
				isSend = false;
			}});
		}
	});
})
</script>
<div id='frbar'><div>
	<div id='title'>線上瑜伽課程互動平台</div>
</div></div>
<div id='box' class='min'>
	<div id='box2'>
		<div class='a'>帳號</div>
		<div><input id='user' type='text' placeholder='請輸入帳號' maxlength="40"/></div>
		<div class='a'>密碼</div>
		<div><input id='pass' type='password' placeholder='請輸入密碼'/></div>
		<div><div id='btn_login' class='btn' style='right: 0;left: 0;margin: 8px auto;'>登入</div></div>
	</div>
	<div id='alertBox' style='display:none;'></div>
</div>
<?php
/*

INSERT INTO `user` (`id`, `login`, `nickname`, `password`, `permission_id`) 
			VALUES (NULL, 'user', 'nickname', 'password', '0');

*/
?>