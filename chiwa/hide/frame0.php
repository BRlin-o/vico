<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title.$site;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
	<link href="//<?php echo $domainName;?>/awefont/all.min.css" rel="stylesheet"/>
	<script src="//<?php echo $domainName;?>/js/jquery-3.6.1.min.js"></script>
	<script src="//<?php echo $domainName;?>/js/js.cookie.3.0.1.min.js"></script>
<style>
body{
	margin: 0;
    font-family: monospace;
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
#floor{
	border-top: 1px solid #00000033;
	border-bottom: 1px solid #00000033;
	padding: 24px 0;
	background-color: #f2f2f2;
}
#floor > div{
	max-width: 800px;
	right: 0;
	left: 0;
	margin: auto;
	padding: 8px 12px;
	font-size: 16px;
}
#floor .left{
	float: left;
    margin: 8px 0;
}
#floor .right{
	float: right;
    margin: 8px 0;
}
#floor > div::after{
	content: " ";
	clear: both;
	display: block;
}
#floor .right a{
    text-decoration: none;
    color: #000;
    cursor: pointer;
}
#floor .right a:hover{
    text-decoration: underline;
	color: #2196f3;
	
}
</style>
</head>
<body>
<?php include($includeFile);?>
<div id='floor'>
	<div>
		<div class='left'>
			<div>Copyright&nbsp;&copy;&nbsp;<?php echo (date("Y")!=2022?'2022-':"").date("Y");?>&nbsp;VICO虛擬教練</div>
			<div>線上瑜伽運動平台</div>
		</div>
		<div class='right'>
			<a href='//<?php echo $domainName;?>'>Home</a>．<a href='//<?php echo $domainName;?>/about'>About</a>．<a href='//<?php echo $domainName;?>/contact'>Contact</a>．<a href='//<?php echo $domainName;?>/privacy'>Privacy Policy</a>
		</div>
	</div>
</div>
</body>
</html>