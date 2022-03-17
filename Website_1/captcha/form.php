<?php
error_reporting (E_ALL); // Установите в error_reporting (0);

include('DMT-captcha-gen.php');

if(isset($_REQUEST[session_name()])){
	session_start();
}

$captcha = new DMTcaptcha();

if($_REQUEST[session_name()]){
	$_SESSION['captcha_keystring'] = $captcha->getKeyString();
}

?>
