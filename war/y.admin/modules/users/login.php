<?php

$head_array = array(
	array(
		'tag'=>'base',
		'param'=>array(
			'href'=>'http://'.$_SERVER['SERVER_NAME'].'/'.ADMINBASENAME,
			'target'=>'_self'
		)
	),
	array(
		'tag'=>'meta',
		'param'=>array(
			'http-equiv'=>'description',
			'content'=>'logowanie do systemu cms'
		)
	),
	array(
		'tag'=>'link',
		'param'=>array(
			'href'=>$smarty->getTemplateDir('css').'basic.css',
			'type'=>'text/css',
			'rel'=>'stylesheet'
		)
	)
);

if($_POST['action']=='login'){
	require INCSPATH.'login.php';
}
if($_POST['action']=='pass-remind'){
	require INCSPATH.'password-reminder.php';
}
//echo md5('marcinbrodowski@gmail.com|toja');



if($_GET['msg']) {
	require INCSPATH.'login-codes.php';
	if(isset($login_msg_codes[$_GET['msg']])) $smarty->assign('msg',$login_msg_codes[$_GET['msg']]);
}

$smarty->assign('METADATA',load_head($head_array));

$smarty->assign('CONTENT',$smarty->fetch('login/content.html'));

$smarty->display('index.html');