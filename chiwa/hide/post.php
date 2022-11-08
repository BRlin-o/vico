<?php
header('Content-Type: application/json; charset=UTF-8');

switch($args[0]){
	case "login":
		include("post/login.php");
		break;
	default:
		echo json_encode(array('s' => 0, 'e' => '404: Not Found'));
}