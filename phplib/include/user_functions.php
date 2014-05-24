<?php

function GetLogin(){
  if($_SESSION['username']){
    return TRUE;
  } 
  if(isset($_COOKIE["AutoLogin"])){
    $LoginParameters = explode('-', $_COOKIE["AutoLogin"]);
    $_SESSION['userid'] = $LoginParameters[0];
    $_SESSION['username'] = $LoginParameters[1];
    header('refresh: 0');
    exit;
  }else{
    return FALSE;
  }
}

function GetUserName(){
  return $_SESSION['username'];
}