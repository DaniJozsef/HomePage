<?php
header('Content-Type: text/html; charset=utf-8');
include "captcha/captcha.php";
session_start();
?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
</head>
<body>
<center>
<form method="post">
<?php
captcha_text();
captcha_text_2();
captcha_num();
captcha_num_2();
captcha_mat();
captcha_mat_2();
captcha_white();
?>

<input type="submit" name="ok" value="próba">
</form>
<?php
if($_POST['ok']){
?>
Te Válaszod --- helyes válasz<br>
<?php
echo $_POST['captcha_text']." --- ".$_SESSION['captcha_text'];
if($_POST['captcha_text']==$_SESSION['captcha_text']){
echo " - eltaláltad<br>";
}else{
echo " - nem találtad el<br>";
}
echo $_POST['captcha_mat']." --- ".$_SESSION['captcha_mat'];
if($_POST['captcha_mat']==$_SESSION['captcha_mat']){
echo " - eltaláltad<br>";
}else{
echo " - nem találtad el<br>";
}
echo $_POST['captcha_num']." --- ".$_SESSION['captcha_num'];
if($_POST['captcha_num']==$_SESSION['captcha_num']){
echo " - eltaláltad<br>";
}else{
echo " - nem találtad el<br>";
}
echo $_POST['captcha_text2']." --- ".$_SESSION['captcha_text2'];
if($_POST['captcha_text2']==$_SESSION['captcha_text2']){
echo " - eltaláltad<br>";
}else{
echo " - nem találtad el<br>";
}
echo $_POST['captcha_mat2']." --- ".$_SESSION['captcha_mat2'];
if($_POST['captcha_mat2']==$_SESSION['captcha_mat2']){
echo " - eltaláltad<br>";
}else{
echo " - nem találtad el<br>";
}
echo $_POST['captcha_num2']." --- ".$_SESSION['captcha_num2'];
if($_POST['captcha_num2']==$_SESSION['captcha_num2']){
echo " - eltaláltad<br>";
}else{
echo " - nem találtad el<br>";
}
echo $_POST['captcha_white']." --- ".$_SESSION['captcha_white'];
if($_POST['captcha_white']==$_SESSION['captcha_white']){
echo " - eltaláltad<br>";
}else{
echo " - nem találtad el<br>";
}
}
?>
<br>
</body>
</html>
