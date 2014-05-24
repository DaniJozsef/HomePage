<?php
include_once dirname(__FILE__).'/../init.php';

    $PathInfo=explode('/', trim($_SERVER['PATH_INFO'], '/'));
    if(count($PathInfo)>0){
      switch($PathInfo[0]){
        case 'hash':
          print json_encode(AjaxHash());
          break;
        case 'message':
          print json_encode(AjaxMessage());
          break;
        case 'TimestampDecoder':
          print json_encode(TimestampDecoder());
          break;
        case 'TimestampEncoder':
          print json_encode(TimestampEncoder());
          break;
        case 'Login':
          print json_encode(Login());
          break;
      }
    }

function HashSearch($string, $type){
	global $DB;
	$Sql="SELECT * FROM " . DB_PREFIX . "tools_hash WHERE _".$type."='".$string."'";
	$NewSearch = $DB->query($Sql, "OBJ");
	HashInsert($string);
	if($NewSearch['rows']==1){
		return array($NewSearch['data'][0]->_string, $NewSearch['data'][0]->_md5, $NewSearch['data'][0]->_sha1);
	}else{
		return false;
	}
}

function HashInsert($string){
	global $DB;
	$SqlSelect="SELECT * FROM " . DB_PREFIX . "tools_hash WHERE _string='".$string."'";
	$NewHashControl = $DB->query($SqlSelect, "OBJ");
  if($NewHashControl['rows'] == 0){//Ha még nincs ilyen az adatbázisban mentsük be
    $SqlInsert="INSERT INTO " . DB_PREFIX . "tools_hash (_string, _md5, _sha1) VALUES ('".$string."', '".md5($string)."', '".sha1($string)."')";
    $DB->query($SqlInsert);
  }
}

function AjaxHash(){
  global $GP;
  if(!$GP['string']){
    $Json =
      array(
        'post' => array(
          'string' => $GP['string'],
          'type' => $GP['type'],
        ),
        'returnData' => array(
          'success' => FALSE,
          'message_code' => 1, //Nem adott meg keresőszöveget
          'string' => '',
          'md5' => '',
          'sha1' => '')
      );
    return $Json;
  }else{
    $SearchResult = HashSearch($GP['string'], $GP['type']);
    if($GP['type'] == 'string'){
      $Json =
        array(
          'post' => array(
            'string' => $GP['string'],
            'type' => $GP['type'],
          ),
          'returnData' => array(
            'success' => TRUE,
            'message_code' => 0, //Minden rendben
            'string' => $GP['string'],
            'md5' => md5($GP['string']),
            'sha1' => sha1($GP['string'])
          )
        );
      return $Json; 
    }

    if($SearchResult && $GP['type'] != 'string'){
      //Ha van eredmény md5 vagy sha1 keresésre
      $Json =
        array(
          'post' => array(
            'string' => $GP['string'],
            'type' => $GP['type'],
          ),
          'returnData' => array(
            'success' => TRUE,
            'message_code' => 0, //Minden rendben
            'string' => $SearchResult[0],
            'md5' => $SearchResult[1],
            'sha1' => $SearchResult[2]
          )
        );
      return $Json; 
    }else{
      //Ha nincs eredmény
      $Json =
        array(
          'post' => array(
            'string' => $GP['string'],
            'type' => $GP['type'],
          ),
          'returnData' => array(
            'success' => TRUE,
            'message_code' => 2, //Nincs eredmény
            'string' => $GP['string'],
            'md5' => md5($GP['string']),
            'sha1' => sha1($GP['string'])
          )
        );
      return $Json; 
    }
  }
}

function AjaxMessage(){
  global $GP, $DB, $Lang;
  $ErrorStatus = 0;
  $ErrorMessage = '';
  if($GP['messageFormCaptcha'] != $_SESSION['captcha']){
    $ErrorStatus = 1;
    $ErrorMessage .= $Lang['CaptchaError'] . ',';
  }
  if(trim($GP['messageFormName']) == ''){
    $ErrorStatus = 1;
    $ErrorMessage .= $Lang['NameError'] . ',';
  }
  if(trim($GP['messageFormEmail']) == ''){
    $ErrorStatus = 1;
    $ErrorMessage .= $Lang['EmailError'] . ',';
  }
  if(!emailvalidator(trim($GP['messageFormEmail']))){
    $ErrorStatus = 1;
    $ErrorMessage .= $Lang['EmailValidError'] . ',';
  }
  if(trim($GP['messageFormText']) == ''){
    $ErrorStatus = 1;
    $ErrorMessage .= $Lang['MessageError'] . ',';
  }
  if($ErrorStatus == 0){
    $DB->query(sprintf("INSERT INTO " . DB_PREFIX . "connect_message (name, email, phone, message, client_status, noticesend_status, timestmp) ".
                       "VALUES ('%s', '%s', '%s', '%s', '%s', %b, %d)", 
                        trim($GP['messageFormName']), 
                        trim($GP['messageFormEmail']),
                        trim($GP['messageFormPhone']),
                        trim($GP['messageFormText']),
                        trim($GP['messageFormClient']),
                        FALSE,
                        time()), 'OBJ');
  }
                      
  return array(
          'ErrorStatus' => $ErrorStatus,
          'ErrorMessage' => $ErrorMessage
         );
}

function TimestampDecoder(){
  global $GP, $Lang;
  $ErrorStatus = 0;
  $ErrorMessage = '';
  $TimeStamp = intval($GP['TimeStamp']);
  if(!$TimeStamp){
    $ErrorStatus = 1;
    $ErrorMessage = $Lang['NumberFailed'];
  }
  $Json = array(
    'date' => DateFormat($TimeStamp),
    'ErrorStatus' => $ErrorStatus,
    'ErrorMessage' => $ErrorMessage
  );
  return $Json;
}

function TimestampEncoder(){
  global $GP, $Lang;
  $ErrorStatus = 0;
  $ErrorMessage = '';
  $Hour = intval($GP['Hour']);
  $Min = intval($GP['Min']);
  $Sec = intval($GP['Sec']);
  $Month = intval($GP['Month']);
  $Day = intval($GP['Day']);
  $Year = intval($GP['Year']);
  $Json = array(
    'timestamp' => MakeTimestamp($Hour, $Min, $Sec, $Month, $Day, $Year),
    'ErrorStatus' => $ErrorStatus,
    'ErrorMessage' => $ErrorMessage
  );
  return $Json;
}

function Login(){
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
    
    $Json = array(
      'userid' => $_SESSION['userid'],
      'username' => $_SESSION['username'],
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


?>