<?php

require_once 'Smarty-3.1.6/Smarty.class.php';
class_exists('FileManagment');

/** funkcja zwraca skonfigurowany obiekt Smarty @param compileDir - folder w katalogu cache w ktorym maja byc przechowywane skompilowane pliki szablonu */
function smarty_setup($compileDir){
	$smarty = new Smarty;
	if(!FileManagment::checkDir(BASICPATH.'cache/'.$compileDir,0755)) return;
	$smarty->compile_dir = BASICPATH.'cache/'.$compileDir;
	$smarty->left_delimiter = '{{';
	$smarty->right_delimiter = '}}';
	$smarty->caching = false;
	//$smarty->register_function('MENU','generate_metadata');
	return $smarty;
}

/** dodaje do biblioteki lokalizacje templatek */
function add_smarty_dirs(&$smarty_instance, $dirs_array){
	if(!is_array($dirs_array) || !is_a($smarty_instance, 'Smarty')) return;
	foreach ($dirs_array as $key=>$dir){
		if(is_dir($dir)) $smarty_instance->addTemplateDir($dir,$key);
	}
}



//$smarty->register_function('MENU','menu_show_fg');