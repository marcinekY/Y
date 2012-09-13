<?php
require 'login-libs.php';

$login = $_POST['email'];
$pass = $_POST['password'];
$captchaChallengeField = $_POST["recaptcha_challenge_field"];
$captchaResponseField = $_POST["recaptcha_response_field"];

login_check_is_email_provided($login);

if(is_null($pass) || empty($pass) || $pass=='') Redirect::redirect('nopassword');

//login_check_is_captcha_provided($captchaChallengeField,$captchaResponseField);
//login_check_is_captcha_valid($captchaChallengeField,$captchaResponseField);

$pass = md5($login.'|'.$pass);
class_exists('Users');
if(!Users::login($login, $pass)){
	Redirect::redirect('loginfailed');
} else Redirect::setUrl($_SERVER['PHP_SELF'],true);