<?php
require_once ('phplib/init.php');
include ('style/php/head.php');

//NICE URL WRITE
$subdir  = substr(realpath(dirname(__FILE__)), strlen(realpath($_SERVER['DOCUMENT_ROOT'])));
$tmp_array = explode('?', trim($_SERVER['REQUEST_URI']));
$uri = str_replace($subdir, '', $tmp_array[0]);
$uri = ltrim($uri, '/');
$pages = explode("/", $uri);

foreach($Lang as $LangKey => $LangValue){
  if($pages[0] == $LangValue){
    $pages[0] = $LangKey;
  }
}

if(!$pages || $pages[0] == ""){
  include ('style/php/page_index.php');
}else if(!@include ('style/php/page_' . $pages[0] . '.php')){
  include ('style/php/page_404.php');
}

include ('style/php/foot.php');
?>