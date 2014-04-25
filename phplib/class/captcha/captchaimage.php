<?php
include_once dirname(__FILE__).'/../../init.php';

$CaptchaText = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
$CaptchaText1 = $CaptchaText[rand('0','25')];
$CaptchaText2 = $CaptchaText[rand('0','25')];
$CaptchaText3 = $CaptchaText[rand('0','25')];
$CaptchaText4 = $CaptchaText[rand('0','25')];
$CaptchaText5 = $CaptchaText[rand('0','25')];
$CaptchaTxt = $CaptchaText1 . $CaptchaText2 . $CaptchaText3 . $CaptchaText4 . $CaptchaText5;
$_SESSION['captcha'] = $CaptchaTxt;
$CaptchaImage = @imagecreate (170, 70); //Image Size
imagecolortransparent ($CaptchaImage, imagecolorallocate ($CaptchaImage,255, 255, 255)); //Background color
$TextColorShadow = imagecolorallocate ($CaptchaImage, 227, 84, 73); //Text Shadow color
$TextColor = imagecolorallocate ($CaptchaImage, 0, 0, 0); //Text Color
imagettftext ($CaptchaImage, 40, 0, 10, 40, $TextColorShadow , "ttf/white.ttf" , $CaptchaTxt);
imagettftext ($CaptchaImage, 40, 4, 12, 44, $TextColor , "ttf/white.ttf" , $CaptchaTxt); //Size Angle X Y Color ttf Text
header ("Content-Type: image/jpeg");
imagepng ($CaptchaImage);
imagedestroy ($CaptchaImage); 
?> 
