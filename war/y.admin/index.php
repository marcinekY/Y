<?php
$menuTop = array(
	'logout'=>'Wyloguj'
);

include 'libs/admin_libs.php';





//print_r($_GET);

$head_array = array(
	array(
		'tag'=>'base',
		'param'=>array(
			'href'=>'http://'.$_SERVER['SERVER_NAME'].'/'.BASENAME.ADMINSOFTPATH,
			'target'=>'_self'
		)
	),
	array(
		'tag'=>'meta',
		'param'=>array(
			'http-equiv'=>'description',
			'content'=>'system zalogowany'
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


$smarty->assign('METADATA',load_head($head_array));


$smarty->assign('HEADER',$smarty->fetch('_header.html'));

$smarty->display('index.html');