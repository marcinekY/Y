<?php
require 'login-libs.php';

login_check_is_email_provided();
login_check_is_captcha_provided();
login_check_is_captcha_valid();

$email = $_POST['email'];

login_check_is_email_provided($email);

// check that the email matches a row in the user table
$r=MySQL::getRow('SELECT `email` FROM `users` WHERE `email`="'.addslashes($email).'"');
if($r==false){
	login_redirect($url,'nosuchemail');
}

// success! generate a validation email, then redirect
$validation_code=md5(time().'|'.$r['email']);
$email_domain=preg_replace('/^www\./','',$_SERVER['HTTP_HOST']);
MySQL::dbQuery('UPDATE `users` SET `activation_key`="'.$validation_code.'" WHERE `email`="'.addslashes($r['email']).'"');
$validation_url='http://'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['PHP_SELF'].'/forgott-password-verify/vc_'.$validation_code.'&email='.$r['email'].'&redirect_url='.$url;

mail(
	$r['email'],
	"[$email_domain]: zapomniane haslo",
	"Witaj!\n\nKtos skorzystal z formularza pod adresem http://".$_SERVER['HTTP_
HOST']."/. Jesli nie masz z tym nic wsp�lnego, mozesz zignorowac 
te wiadomosc.\n\nAby zalogowac sie na swoje konto, kliknij
ponizszy odnosnik, a nastepnie zresetuj haslo.\n\n$validation_url", 
  "From: no-reply@$email_domain\nReply-to: no-reply@$email_domain" 
);


login_redirect($url,'validationsent');
