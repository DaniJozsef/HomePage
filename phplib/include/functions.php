<?php

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

function __($LanguageString){
  global $Lang;
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
      return date("Y.m.d H:i", $Date);
    }else{
      return date("d.m.Y H:i", $Date);
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

function GetMobile(){
	$UserAgent = GetAgent();
	if(preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$UserAgent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($UserAgent,0,4))){
		return TRUE;
	}else{
		return FALSE; 
	}
}
?>
