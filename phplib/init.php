<?php
session_start();
header( 'Content-Type: text/html; charset=UTF-8' );
$IcludeDirName = dirname(__FILE__);


include_once $IcludeDirName.'/include/define.php';
include_once $IcludeDirName.'/include/lang_hu.php';
include_once $IcludeDirName.'/include/functions.php';
include_once $IcludeDirName.'/class/db.class.php';
include_once $IcludeDirName.'/class/phpmailer/class.phpmailer.php';
include_once $IcludeDirName.'/class/mobiledetect.class.php';

$DB = new db();
?>