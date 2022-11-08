<?php 
/*
ini_set('display_errors','1');
error_reporting(E_ALL);//*/
// ==============================
// 設定 Setting

// 網域名
$domainName = $_SERVER['SERVER_NAME'];
// 圖片位置

// 資料庫連線資訊
// IP 位置 
$db_ip = "192.168.1.138";
// 帳號名稱
$db_id = "root";
// 帳號密碼
$db_pd = "root";
// 資料庫名稱
$db_na = "vico";
// ==============================
// Functions

// ==============================

// date_default_timezone_set('Asia/Taipei');

$url = str_replace("//", "/", $_SERVER['REQUEST_URI']);
while(strpos($url, "//")!==false){
	$url = str_replace("//", "/", $url);
}

$url = preg_replace("/^\//i", "", $url);
if(strlen($url) != 0 && $url[strlen($url)-1] == "/"){
	header('Location: //'.$_SERVER['HTTP_HOST']."/".substr($url, 0, -1)); exit();
}

$urls = preg_split("~\?~", $url);
$args = preg_split("~/~", $urls[0]);

switch($args[0]){
	default:
		$dir = "../hide/"; chdir($dir);
		include("main.php");
		break;
}

?>