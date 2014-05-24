<?php

require_once ('phplib/init.php');

//NICE URL WRITE
$subdir  = substr(realpath(dirname(__FILE__)), strlen(realpath($_SERVER['DOCUMENT_ROOT'])));
$tmp_array = explode('?', trim($_SERVER['REQUEST_URI']));
$uri = str_replace($subdir, '', $tmp_array[0]);
$uri = ltrim($uri, '/');
$pages = explode("/", $uri);

if($pages[0] == 'logout'){
  $_SESSION['userid'] = false;
  $_SESSION['username'] = false;
  setcookie("AutoLogin", "", time()-3600, "/");
  header('location: /');
  exit;
}

foreach($Lang as $LangKey => $LangValue){
  if($pages[0] == $LangValue){
    $pages[0] = $LangKey;
  }
}


include ('style/php/head.php');

if(!$pages || $pages[0] == ""){
  include ('style/php/page_index.php');
}else if(!@include ('style/php/page_' . $pages[0] . '.php')){
  header("HTTP/1.0 404 Not Found");
  include ('style/php/page_404.php');
}

include ('style/php/foot.php');
?>
