<?php
include_once dirname(__FILE__).'/../init.php';

function MessageSenderService(){
	global $DB, $Lang;
	$Sql="SELECT * FROM " . DB_PREFIX . "connect_message WHERE noticesend_status=0";
	$NoSendedMessage = $DB->query($Sql, "OBJ");
	if($NoSendedMessage['rows']>0){
    $EmailBody = '<b>' . $Lang['MessageEmailNoticeTitle'] . '</b><br /><br />';
    foreach($NoSendedMessage['data'] as $MessageFields){
      $EmailBody .= '<b>' .$Lang['Name'] . '</b>: ' . $MessageFields->name . '<br />';
      $EmailBody .= '<b>' .$Lang['Email'] . '</b>: ' . $MessageFields->email . '<br />';
      $EmailBody .= '<b>' .$Lang['Phone'] . '</b>: ' . $MessageFields->phone . '<br />';
      $EmailBody .= '<b>' .$Lang['Client'] . '</b>: ' . $Lang[$MessageFields->client_status] . '<br />';
      $EmailBody .= '<b>' .$Lang['Date'] . '</b>: ' . DateFormat($MessageFields->timestmp) . '<br /><br />';
      $EmailBody .= '<b>' .$Lang['Message'] . '</b>: ' . $MessageFields->message . '<br /><br />';
      $EmailBody .= '<hr /><br /><br />';
    }
   /* $UpdateFields = array(
      'noticesend_status' => 1
    );
    $DB->update(DB_PREFIX . 'connect_message', $UpdateFields, 'noticesend_status=0');*/
	}
  EmailSend(EMAIL_NOREPLY, ADMIN_EMAIL, $Lang['NewMessageReceived'], $EmailBody);
}
 
MessageSenderService();

?>