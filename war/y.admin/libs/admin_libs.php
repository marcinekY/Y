<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/ysystem/war/y.incs/basics.php';

URL::setRequestString(substr_replace(ADMINBASENAME, '', $_SERVER['REQUEST_URI']));

// { site config
$siteName = 'admin';
$ADMINSITE = Site::getInstanceByName($siteName,true);


//$default_set = $ADMINSITE->getAsset('admin_site_default_set');

//$extensions = $ADMINSITE->getExtensions();


//print_r($site);



/* $a = array(
		'theme'=>'_default',
		'extends'=>array('menus','meta-builder'),
);
$default_set->setValue($a);
$default_set->save(); */
// }

$stable = array (
		'BASENAME'=>'',
		'SCRIPTBASE'=>'',
		'MODULES'=>'modules/',
		'CONFIGPATH'=>'!conf/',
		'TPL'=>'tpl'
);

/** krotka sciezka lokalizacji panelu (bez systemowej) */
$sitePath = Site::getActual()->path;
define('ADMINBASENAME', BASENAME.$sitePath);
/** dluga sciezka lokalizacji panelu (z systemowa) */
define('ADMINSCRIPTBASE', SCRIPTBASE.ADMINBASENAME);
/** lokalizacja modulow w panelu administracyjnym */
define('ADMINMODULES', ADMINSCRIPTBASE.'modules/');
/** lokalizacja konfiguracji w panelu administracyjnym */
define('ADMINCONFIGPATH', ADMINSCRIPTBASE.'!conf/');
/** lokalizacja templatek panelu administracji */
define('ADMINTHEMEPATH', ADMINSCRIPTBASE.'templates/');

//require_once MODULES.'smarty/smarty.php';
//new Extension('smarty',1,true);
// $s = new Smarty();
// $string = 'testowy string {$drugi}';
// $s->assign('drugi', ',drugi string testowy. zajebisty');
// echo $s->fetch('string:'.$string);


require ADMINMODULES.'users/users.php';

//$ADMINSITE->getExtensions();
//$ADMINSITE->getTemplate()->getExtensions();

$smarty = Trigger::runTrigger('parser-setup');

$template = $ADMINSITE->getTemplate();

//$sections = $template->setSections();
// print_r($sections);

var_dump(URL::getVars());



$tplDirs = array(
		0=>ADMINSCRIPTBASE.ADMINTPL.$template->path,
		'css'=>ADMINTPL.$template->path.'/css/',
		'js'=>ADMINTPL.$template->path.'/js/',
		'html'=>ADMINTPL.$template->path.'/html/'
);

Trigger::runTrigger('smarty-set-dirs',$smarty, $tplDirs);

//print_r($smarty);
//var_dump($smarty);







//$smarty->setTemplateDir($smarty->getTemplateDir(0));

if(is_null($smarty)) exit('Blad biblioteki Smarty');


require_once ADMINMODULES.'menus/menus.php';
