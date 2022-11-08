<?php
$list = array(
	array("name" => '用戶主頁', "icon" => 'user-solid', "type" => 1, "path" => 'account', "sel" => 'account'),
	array("name" => '我的課程', "icon" => 'folder-closed-solid', "type" => 1, "path" => 'account/order', "sel" => 'order'),
	array("name" => '課程列表', "icon" => 'graduation-cap-solid', "type" => 1, "path" => 'account/course', "sel" => 'course'),
	array("type" => 2),
	array("name" => '登出', "icon" => 'arrow-right-from-bracket-solid', "type" => 1, "path" => 'logout', "sel" => ''),
);
?>
<!DOCTYPE html>
<html light>
<head>
	<title><?php echo $title.$site;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
	<link href="//<?php echo $domainName;?>/awefont/all.min.css" rel="stylesheet"/>
	<script src="//<?php echo $domainName;?>/js/jquery-3.6.1.min.js"></script>
	<script src="//<?php echo $domainName;?>/js/js.cookie.3.0.1.min.js"></script>
<script>
const DomainName = "<?php echo $domainName;?>";
const Args = [<?php echo $argsStr;?>];
function getRand(){
	let L = 8;
	let b = "abcdefghijklmnopqrstuvwxyz0123456789"; let c = b[Math.floor(Math.random() * (b.length-10))];
	for(let i=0;i<L-1;i++){c += b[Math.floor(Math.random() * b.length)];}
	return c;
}
$(()=>{	
	$("#frmenu").click(()=>{
		$("#frmin").toggleClass("close");
	});
	$("#frMlistBk").click(()=>{
		if($("#frmin").hasClass("frmoreOpen")){
			$("#frmin").removeClass("frmoreOpen");
		}else if($("#frmin").hasClass("close")){
			$("#frmin").removeClass("close");
		}
	});
	let sx=0, sy=0;
	let isTouchStart = false;
	document.addEventListener('touchstart', function(e) {
		let list = e.changedTouches;
		if(list.length == 1 && !isTouchStart){
			let touch = list[0];
			sx = touch.pageX;
			sy = touch.pageY;
			isTouchStart = true;
		}else{
			isTouchStart = false;
		}
	}, false);
	document.addEventListener('touchend', function(e) {
		let list = e.changedTouches;
		if(list.length == 1 && isTouchStart){
			let touch = list[0];
			let ex = touch.pageX;
			let ey = touch.pageY;
			if(Math.abs(sy - ey) <= (window.innerHeight * 0.2)){
				if(!$("#frmin").hasClass("close") && (ex - sx) >= window.innerWidth * 0.20){
					$("#frmin").addClass("close");
				}else if($("#frmin").hasClass("close") && (sx - ex) >= window.innerWidth * 0.20){
					$("#frmin").removeClass("close");
				}
			}
		}
		isTouchStart = false;
	}, false);
});
</script>
<style><?php include("style.css");?></style>
</head>
<body>
<div id='frbar'><div>
	<div id='frmenu'><i><img src="<?php echo "//$domainName/img/bars-solid.svg";?>"/></i></div>
	<div id='title'>線上瑜伽課程互動平台</div>
	<!--div id='frmore'><i><img src="<?php echo "//$domainName/img/ellipsis-vertical-solid.svg";?>"/></i></div-->
</div></div>
<div id='frmin'>
	<div id='frMlistBk'></div>
	<div id='frMlist' class='scrollbar scrHov'>
		<?php 
		foreach($list as $it){
			$class = "";
			if($it['sel'] == $sel){
				$class = " sel";
			}
			switch($it['type']){
				case 1:
		?>
			<a class='it<?php echo $class;?>' href='<?php echo "//$domainName/".$it['path'];?>'><div><i><img src="<?php echo "//$domainName/img/".$it['icon'];?>.svg"/></i></div><div class='na'><?php echo $it['name'];?></div></a>
		<?php
					break;
				case 2:
					echo "<hr/>";
					break;
			}
		}
		?>
		<hr/>
		<div id='frflor'>
			<div>&copy;&nbsp;<?php echo (date("Y")!=2022?'2022-':"").date("Y");?>&nbsp;VICO虛擬教練</div>
			<div style='font-size: 12px;margin-top:6px;'><a href='//<?php echo $domainName;?>'>Home</a>．<a href='//<?php echo $domainName;?>/about'>About</a>．<a href='//<?php echo $domainName;?>/contact'>Contact</a><br/><a href='//<?php echo $domainName;?>/privacy'>Privacy Policy</a></div>
		</div>
	</div>
	<div id='moreMenu'>
		<a class='it'>
			<div><div class='icon'><img src='/img/circle-half-stroke-solid.svg'/></div><div class='na'>外觀：</div></div>
			<div class='icon'><i class="fa-solid fa-chevron-right"></i></div>
		</a>
	</div>
	<div id='frPage' class='scrollbar'>
		<div><?php include($includeFile);?></div>
	</div>
</div>

</body>
</html>