<?php
  include_once dirname(__FILE__).'/../init.php';
  
  $PathInfo=explode('/', trim($_SERVER['PATH_INFO'], '/'));
  if(count($PathInfo)>0){
    switch($PathInfo[0]){
    	case 'fino':
    	  $SourcePage = 'http://kaposvarvolley.hu/interface.php';
    	  $VolleyJson = @file_get_contents($SourcePage);
    	  print $VolleyJson;
    	  break;
    	case 'roak':
    	  $SourcePage = 'http://roplabdaakademia.hu/roakinterface.php';
    	  $VolleyJson = @file_get_contents($SourcePage);
    	  print $VolleyJson;
    	  break;
    	case 'finoroak':
    	  $SourcePage1 = 'http://kaposvarvolley.hu/interface.php';
    	  $SourcePage2 = 'http://roplabdaakademia.hu/roakinterface.php';
    	  $VolleyJson1 = json_decode(@file_get_contents($SourcePage1));
    	  $VolleyJson2 = json_decode(@file_get_contents($SourcePage2));
    	  $VolleyJson = array_merge($VolleyJson1, $VolleyJson2);
    	  print json_encode($VolleyJson);	  
    	  break;
    }
  }  
?>