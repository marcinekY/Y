<?php
/**
 * funkcja zwraca skonfigurowany obiekt Smarty
 * @param compileDir - folder w katalogu cache w ktorym maja byc przechowywane skompilowane pliki szablonu
 * */
function smarty_setup($compileDir){
	class_exists('Smarty');
	$smarty = new Smarty;
	class_exists('FileManagment');
	if(!FileManagment::checkDir(BASICPATH.'cache/'.$compileDir,0755)) return;
	$smarty->compile_dir = BASICPATH.'cache/'.$compileDir;
	$smarty->left_delimiter = '{{';
	$smarty->right_delimiter = '}}';
	$smarty->caching = false;
	//$smarty->register_function('MENU','generate_metadata');
	return $smarty;
}