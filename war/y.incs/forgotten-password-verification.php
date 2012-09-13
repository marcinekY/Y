<?php
require 'login-libs.php';



login_check_is_email_provided();

// sprawdzenie czy zostal podany kod weryfikujacy
if(
	!isset($_REQUEST['verification_code']) || $_REQUEST['verification_code']==''
){
	login_redirect($url,'novalidation');
}

// sprawdzenie czy kombinacja adresu e-mail i kodu weryfikujacego pasuja do jakiegos wiersza w bazie danych uzytkownik�w
$password=md5($_REQUEST['email'].'|'.$_REQUEST['password']);
$r=dbRow('select * from user_accounts where
	email="'.addslashes($_REQUEST['email']).'" and
	verification_code="'.$_REQUEST['verification_code'].'" and active'
);
if($r==false){
	login_redirect($url,'validationfailed');
}

// utworzenie zmiennej sescji i usuniecie kodu z
// bazy danych, a nastepnie dokonanie przekierowania
$_SESSION['userdata']=$r;
$groups=json_decode($r['groups']);
$_SESSION['userdata']['groups']=array();
foreach($groups as $g)$_SESSION['userdata']['groups'][$g]=true;
if($r['extras']=='')$r['extras']='[]';
$_SESSION['userdata']['extras']=json_decode($r['extras']);

login_redirect($url,'verified');
