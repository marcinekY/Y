<?php
require_once 'basics.php';

$url='/';
$err=0;

function login_redirect($url,$msg='success'){
	if($msg)$url.='?login_msg='.$msg;
	header('Location: '.$url);
	echo '<a href="'.htmlspecialchars($url).'">redirect</a>';
	exit;
}

if($_GET['redirect']) Redirect::setUrl($_GET['redirect']);

// konfiguracje przekierowania
//if(isset($_GET['redirect'])){
//	$url=preg_replace('/[\?\&].*/','',$_GET['redirect']);
//	if($url=='')$url='/';
//}

// sprawdzenie czy podano prawidłowy adres e-mail
function login_check_is_email_provided($email){
	if(!isset($email) || $email==''){
		Redirect::redirect('noemail');
	} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		Redirect::redirect('failemail');
	}
}

// sprawdzenie czy podano tekst testu captcha 
function login_check_is_captcha_provided($captchaChallengeField,$captchaResponseField){
	if(
	  !isset($captchaChallengeField) || $captchaChallengeField==''
		|| !isset($captchaResponseField) || $captchaResponseField==''
	){
		Redirect::redirect('nocaptcha');
	}
}

// sprawdzenie czy wprowadzony tekst captcha jest poprawny
function login_check_is_captcha_valid($captchaChallengeField,$captchaResponseField){
	require 'recaptcha.php';
	$resp=recaptcha_check_answer(
		RECAPTCHA_PRIVATE,
		$_SERVER["REMOTE_ADDR"],
		$captchaChallengeField,
		$captchaResponseField
	);
	if(!$resp->is_valid){
		Redirect::redirect('invalidcaptcha');
	}
}
