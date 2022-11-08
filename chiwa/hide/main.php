<?php
// ==============================
// Functions
function getRandState(){
	global $mysql;
    $length = 16; $bid = '';
    $word = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';   //亂數內容
    $len = strlen($word);
    for($i = 0;$i < $length;$i++){$bid .= $word[rand() % $len];}
    return $bid;
}
// ==============================
// Initial
// session_save_path('../PHPTmp');
session_start();
$title = "";
$site = "線上瑜伽課程互動平台";

$includeFrameFlag = true;

$ref = "?ref=".$_SERVER['REQUEST_URI'];
if($_SERVER['REQUEST_URI'] == "" || $_SERVER['REQUEST_URI'] == "/"){
	$ref = "";
}
// ==============================
// SQL
$mysql = new mysqli($db_ip, $db_id, $db_pd, $db_na);//連結伺服器
$mysql->query("SET NAMES utf8mb4");
//*/
// ==============================
// Session
$isLogin = false;
if(isset($_SESSION['user_id'])){
	$isLogin = true;
	$nickname = $_SESSION['nickname'];
	$permission = $_SESSION['permission'];
}
// ==============================
// Main
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	include("post.php");
}else{
	$argsLimit = 1;
	$sel = "";
	switch($args[0]){
		case "":
			$includeFrameFlag = false;
			$includeFile = "pages/home.php";
			include("frame0.php");
			break;
		case "privacy":
			$includeFrameFlag = false;
			$title = "隱私權政策 - ";
			$includeFile = "pages/privacy.php";
			include("frame0.php");
			break;
		case "about":
			$includeFrameFlag = false;
			$title = "關於 - ";
			$includeFile = "pages/about.php";
			include("frame0.php");
			break;
		case "contact":
			$includeFrameFlag = false;
			$title = "聯繫我們 - ";
			$includeFile = "pages/contact.php";
			include("frame0.php");
			break;
		case "login":
			if($isLogin){
				header("Location: //$domainName/account/course");
				mysqli_close($mysql); exit();
			}
			$includeFrameFlag = false;
			$title = "登入 - ";
			$includeFile = "pages/login.php";
			include("frame0.php");
			break;
		case "logout":
			session_destroy();
			header("Location: //$domainName/");
			mysqli_close($mysql); exit();
			break;
		case "account":
			if(!$isLogin){
				header("Location: //$domainName/login$ref");
				mysqli_close($mysql); exit();
			}
			$argsLimit = 2;
			switch(@$args[1]){
				case "":
					$includeFile = "pages/account/home.php";
					$sel = "account";
					$title = "帳號主頁 - ";
					break;
				case "login":
					$includeFile = "pages/demo/login.php";
					$sel = "login";
					break;
				case "course":
					$includeFile = "pages/demo/course.php";
					$sel = "course";
					break;
				case "order":
					$includeFile = "pages/demo/order.php";
					$sel = "order";
					break;
				default:
					header("Location: //$domainName/account");
					mysqli_close($mysql); exit();
			}
			break;
		default:
			header("Location: //$domainName/");
			mysqli_close($mysql); exit();
	}
	if(count($args) > $argsLimit){
		$argsStr = "";
		for($i=0;$i<$argsLimit;$i++){
			$argsStr .= "/".$args[$i];
		}
		header("Location: //$domainName".$argsStr);
		mysqli_close($mysql); exit();
	}
	if($includeFrameFlag){
		include("frame.php");
	}
}
mysqli_close($mysql);
// ==============================