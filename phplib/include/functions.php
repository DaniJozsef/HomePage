<?php
//Created by Dajo
//PHP Functions v 1.00.01
//require lang_[hu, en, ...].php
//require class/phpmailer/class.phpmailer.php
//require class/db.class.php

date_default_timezone_set(TIMEZONE);

$GP = array();
if($_POST){
  foreach($_POST as $PostKey => $PostValue){
    $GP[$PostKey] = $PostValue;
  }
}
if($_GET){
  foreach($_GET as $GetKey => $GetValue){
    $GP[$GetKey] = $GetValue;
  }
}

if(function_exists('strripos') == false){
  function strripos($Haystack, $Needle){
    return strlen($Haystack) - strpos(strrev($Haystack), $Needle);
  }
}

function __($LanguageString, $CurrentText=FALSE){
  global $Lang;
  if($CurrentText){
    return $Lang[$LanguageString];
  }
  print $Lang[$LanguageString];
}

function emailvalidator($Email) {
	if (!@ereg("^[^@]{1,64}@[^@]{1,255}$", $Email)){
		return false;
	}
	$EmailArray = explode("@", $Email);
	$LocalArray = explode(".", $EmailArray[0]);
	for ($i = 0; $i < sizeof($LocalArray); $i++){
		if(!@ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",$LocalArray[$i])){
      return false;       
		}
	}
	if (!@ereg("^\[?[0-9\.]+\]?$", $EmailArray[1])){
    $DomainArray = explode(".", $EmailArray[1]);
    if (sizeof($DomainArray) < 2){
      return false;
    }
	}
  return true;
}

function DateFormat($Date=false){
  global $Language;
    if(!$Date){
      $Date = time();
    }
    if($Language == 'hu'){
      return date(ISO_DATETIME, $Date);
    }else{
      return date(ISO_DATETIME2, $Date);
    }
}

function HtmlToTxt($String){
  $From = array("<br />", "<hr />");
  $On   = array("\n", "--------------------------------------------------");
  $String = strip_tags(str_replace($From, $On, $String));
  return $String;
}

function EmailSend($From = FALSE, $To, $Subject, $Message){
  global $Language;
  if($From){
    if(is_array($From)){
      $From = implode(";", $Form);
    }
  }else{
    $From = EMAIL_DEFAULT_FROM;
  }

  $To	= trim(str_replace(" ", "", $To));
  $Headers 	= array(
    'MIME-Version: 1.0',
    'Content-Type: text/' . EMAIL_FORMAT == 'TXT' ? 'plain' : 'html' . '; charset="' . EMAIL_CHARSET . '";',
    'Content-Transfer-Encoding: 7bit',
    'Date: ' . date('r', $_SERVER['REQUEST_TIME']),
    'Message-ID: <' . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>',
    'From: ' . $From,
    'Reply-To: ' . EMAIL_RETURN,
    'Return-Path: ' . EMAIL_RETURN,
    'Subject: ' . $Subject,
    'X-Mailer: PHP v' . phpversion(),
    'X-Originating-IP: ' . $_SERVER['SERVER_ADDR']
  );
  
  if(EMAIL_FORMAT == 'TXT'){
    $Message = HtmlToTxt($Message);
  }

  if(!function_exists("openssl_error_string") || EMAIL_SENDER == 'MAIL'){
    $Sending = mail($To, $Subject, $Message, implode("\n", $Headers));
    if(!$Sending){
      $MailLog = 'Php mail() Error!';
      $LogType = 'Error';
    }else{
      $MailLog = 'Php mail() Ok!';
      $LogType = 'Success';
    }
  }elseif(function_exists("openssl_error_string") && EMAIL_SENDER == 'SMTP'){
    $Mail = new PHPMailer(true);
    $Mail->IsSMTP();
    //$Mail->IsHTML(SMTP_ISHTML);
    $Mail->IsHTML(SMTP_ISHTML);
    $Mail->SetLanguage( $Language ? $Language : DEFAULT_LANGUAGE, 'language/' );
    $Mail->CharSet 		= EMAIL_CHARSET;
    $Mail->SMTPDebug 	= SMTP_DEBUG;
    $Mail->SMTPAuth 	= SMTP_AUTH;
    $Mail->Host 		  = SMTP_HOST;
    $Mail->Username 	= SMTP_USER;  
    $Mail->Password 	= SMTP_PASS;
    $Mail->Port			  = SMTP_PORT;
    $Mail->SMTPSecure = SMTP_SECURE;
    $Mail->From			  = $From;
    //$Mail->FromName   = $FromName;
    $Mail->Subject		= $Subject;
    $Mail->Body			  = $Message;
    $MailTo			      = explode(";", $To);
    
    $To = '';
    foreach($MailTo as $EmailAddress){
      $Mail->AddAddress(trim($EmailAddress), '');
      $To = '<' . $EmailAddress . '>';
    }
    
    if(!$Mail->Send()) {
      $MailLog = 'SSL Mail Error: ' . $Mail->ErrorInfo;
      $LogType = 'Error';
    }else{
      $MailLog = 'SSL Mail Ok!';
      $LogType = 'Success';
    }
  }else{
    $MailLog = 'MAIL and SMTP bug';
    $LogType = 'Error';
  }
  
  $LogStr='SenderCore: ' . EMAIL_SENDER . ' >>> ' .
    'From: ' . $From . ' >>> ' .
    'To: ' . $To . ' >>> ' .
    'Subject: '. $Subject . ' >>> ' .
    'Message: ' . substr($Message, 0, 60000) . ' >>> ' .
    'Format: ' . EMAIL_FORMAT . ' >>> ' .
    'Status: ' . $MailLog;
  EventLog("MailLog", $LogType, $LogStr);
}

function EventLog($App, $LogType, $LogStr){
	global $DB;
	$NewLog = $DB->query("INSERT INTO " . DB_PREFIX . "eventlog (`app`, `logtype`, `ins_dt`, `logstr`) VALUES ('". $App ."', '" . $LogType . "', '" . time() . "', '" . $LogStr . "')", 'OBJ');
	return true;
}

function GetIP(){
  global $Lang;
  if (isSet($_SERVER)) {
    if (isSet($_SERVER["HTTP_X_FORWARDED_FOR"])){
      $RealIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }elseif (isSet($_SERVER["HTTP_CLIENT_IP"])){
      $RealIP = $_SERVER["HTTP_CLIENT_IP"];
    }else{
      $RealIP = $_SERVER["REMOTE_ADDR"];
    }
  }else{
    if (getenv('HTTP_X_FORWARDED_FOR')) {
      $RealIP = getenv('HTTP_X_FORWARDED_FOR');
    } 
    elseif (getenv('HTTP_CLIENT_IP')){
      $RealIP = getenv('HTTP_CLIENT_IP');
    } 
    elseif (getenv('REMOTE_ADDR')){
      $RealIP = getenv('REMOTE_ADDR');
    }else{
      $RealIP = $Lang['NonDescriptIP'] . '!';
    }
  }
  return $RealIP; 
}

function GetAgent() {
  global $Lang;
	if (isSet($_SERVER)){
		$RealAgent = $_SERVER["HTTP_USER_AGENT"];
	}elseif (getenv('HTTP_USER_AGENT')){
		$RealAgent = getenv('HTTP_USER_AGENT');
	}else {
		$RealAgent = $Lang['NonDescriptRealAgent'] . '!';
	}
	return $RealAgent;
}

function GetOS(){
  global $Lang;
  $OSList = array(
    'Windows 3.1' => 'Win16',
    'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
    'Windows ME' => '(Windows 98)|(Win 9x 4.90)|(Windows ME)',
    'Windows 98' => '(Windows 98)|(Win98)',
    'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
    'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
    'Windows Server 2003' => '(Windows NT 5.2)',
    'Windows Vista' => '(Windows NT 6.0)',
    'Windows 7' => '(Windows NT 6.1)',
    'Windows 8' => '(Windows NT 6.2)',
    'Windows NT' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
    'Open BSD' => 'OpenBSD',
    'SunOS' => 'SunOS',
    'Linux' => '(Linux)|(X11)',
    'MacOS' => '(Mac_PowerPC)|(Macintosh)',
    'QNX' => 'QNX',
    'BeOS' => 'BeOS',
    'OS2' => 'OS/2',
    'SearchBot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves/Teoma)|(ia_archiver)'
  );
  
  $UserAgent = strtolower(GetAgent());
  
  foreach($OSList as $OS=>$Match) {
    if (preg_match('/' . $Match . '/i', $UserAgent)) {
      break;	
    } else {
      $OS = $Lang['OSNotDetect'];	
    }
  }
  return $OS;
}

function GetBrowser(){
  $BrowserData = array(
    "Version" => "0.0.0",
    "Name" => "unknown",
    "Agent" => "unknown"
  );
  
  $Browsers = array(
    "firefox", "msie", "opera", "safari", "chrome", "chromium", "seamonkey", "konqueror", "netscape",
    "navigator", "mosaic", "lynx", "amaya", "omniweb", "avant", "camino", "flock", "aol"
  );
  
  $BrowserData["Agent"] = strtolower(GetAgent());
  foreach($Browsers as $Browser){
    if (preg_match("#($Browser)[/ ]?([0-9.]*)#", $BrowserData["Agent"], $Match)){
      $BrowserData["Name"] = $Match[1];
      $BrowserData["Version"] = $Match[2];
    }
  }
  return $BrowserData;
}

function MakeTimestamp($Hour, $Min, $Sec, $Month, $Day, $Year, $DST=-1){
  $TimeStamp = mktime($Hour, $Min, $Sec, $Month, $Day, $Year, $DST);
  return $TimeStamp;
}
?>
