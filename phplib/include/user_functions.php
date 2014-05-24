<?php

function GetLogin(){
  if($_SESSION['username']){
    return TRUE;
  } 
  if(isset($_COOKIE["AutoLogin"])){
    $LoginParameters = explode('-', $_COOKIE["AutoLogin"]);
    $_SESSION['userid'] = (int)$LoginParameters[0];
    $_SESSION['username'] = $LoginParameters[1];
    SetUserLastLogin($LoginParameters[0]);
    header('refresh: 0');
    exit;
  }else{
    return FALSE;
  }
}

function GetUserName(){
  return $_SESSION['username'];
}

function GetUserData($UserID){
  global $DB;
  $Sql = "SELECT * FROM " . DB_PREFIX ."users WHERE id = " . $UserID;
  $UserDatas = $DB->query($Sql, "OBJ");
  
  return array(
  	"userid" => $UserDatas['data'][0]->id,
  	"username" => $UserDatas['data'][0]->username,
  	"email" => $UserDatas['data'][0]->email,
  	"lastlog_date" => $UserDatas['data'][0]->lastlog_date,
  	"logincount" => $UserDatas['data'][0]->logincount
  );
}

function SetUserLoginCount($UserID){
  global $DB;
  $Sql = "UPDATE " . DB_PREFIX . "users SET logincount = logincount + 1 WHERE id = " . $UserID;
  $DB->query($Sql, FALSE);
}

function SetUserLastLogin($UserID){
  global $DB;
  $DB->query("UPDATE " . DB_PREFIX . "users SET lastlog_date = logdate WHERE id = " . $UserID, FALSE);
  $DB->query("UPDATE " . DB_PREFIX . "users SET logdate = " . time() . " WHERE id = " . $UserID, FALSE);
}

function UserLogin(){
  global $DB, $GP, $Lang;
  $ErrorStatus = 0;
  $ErrorMessage = '';

  $Sql="SELECT * FROM " . DB_PREFIX . "users " .
       "WHERE passwd='" . md5($GP['Pass']) . "' AND " .
       "(username='" . $GP['User'] . "' OR email='" . $GP['User'] ."')";
  $UserLoginResult = $DB->query($Sql, "OBJ");
  if($UserLoginResult['rows']==1){
    $_SESSION['userid'] = $UserLoginResult['data'][0]->id;
    $_SESSION['username'] = $UserLoginResult['data'][0]->username;
    $CookieTime = ($GP['Auto'] == 1) ? time()+(3600*24*7) : time()-3600;
    setcookie("AutoLogin", $UserLoginResult['data'][0]->id . '-' . $UserLoginResult['data'][0]->username, $CookieTime, "/");
    SetUserLoginCount($UserLoginResult['data'][0]->id);
    SetUserLastLogin($UserLoginResult['data'][0]->id);
    
    $SqlAfterLogin="SELECT * FROM " . DB_PREFIX . "users " .
                   "WHERE id=" . $UserLoginResult['data'][0]->id;
    $UserAfterLoginResult = $DB->query($SqlAfterLogin, "OBJ");

    $Json = array(
        'userid' => $_SESSION['userid'],
        'username' => $_SESSION['username'],
        'email' => $UserAfterLoginResult['data'][0]->email,
        'lastlog' => $UserAfterLoginResult['data'][0]->lastlog_date,
        'logincount' => $UserAfterLoginResult['data'][0]->logincount,
        'ErrorStatus' => $ErrorStatus,
        'ErrorMessage' => $ErrorMessage
    );
  }else{
    $Json = array(
        'username' => '',
        'ErrorStatus' => 1,
        'ErrorMessage' => $Lang['LoginError']
    );
  }

  return $Json;
}

