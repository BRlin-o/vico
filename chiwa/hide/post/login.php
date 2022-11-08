<?php
login();

function login(){
	global $mysql, $isLogin;
	
    /*
	if(!$islogin){
        echo json_encode(array('s' => 0, 'e' => '尚未登入.'));
        return;
    }
	//*/
	
    if(!isset($_POST['user']) || !isset($_POST['pass'])){
        echo json_encode(array('s' => 0, 'e' => '輸入不得為空.'));
        return;
    }
	
    $user = htmlspecialchars($_POST['user'], ENT_QUOTES);	
	$user = mysqli_real_escape_string($mysql, $user);
    $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES);
	$pass = mysqli_real_escape_string($mysql, $pass);
	
    if($user == "" || $pass == ""){
        echo json_encode(array('s' => 0, 'e' => '輸入不得為空.'));
        return;
    }
		
	$qy = "SELECT `id`, `nickname`, `password`, `permission_id` FROM `user` WHERE `login` = '$user'; ";
	$qdata = mysqli_query($mysql, $qy);
	$rs = mysqli_fetch_row($qdata);
	if(!isset($rs)){
		sleep(5);
        echo json_encode(array('s' => 0, 'e' => '帳號或密碼錯誤'));
        return;
	}
	
	$pass = hash('sha256', $pass);
	if($pass != $rs[2]){
		sleep(5);
        echo json_encode(array('s' => 0, 'e' => '帳號或密碼錯誤.'));
        return;
	}
	
	$_SESSION['user_id'] = $rs[0];
	$_SESSION['nickname'] = $rs[1];
	$_SESSION['permission'] = $rs[3];
	
	
    echo json_encode(array('s' => 1, 'e' => ''));
}