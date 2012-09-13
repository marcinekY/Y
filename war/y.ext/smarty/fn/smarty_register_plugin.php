<?php

/**
 * dodaje plugin do instancji smarty
 * @param unknown $smarty_instance - instancja smarty
 * @param unknown $tagname - nazwa tagu uruchomienia
 * @param unknown $fn - nazwa funkcji
 * @param string $type - type of plugin
 */
function smarty_register_plugin(&$smarty_instance,$tagname,$fn,$type='function'){
	echo 'smarty_register_function: '.$tagname.':'.$fn;
	if(!function_exists($fn) || !is_a($smarty_instance, 'Smarty')) return;
	$smarty->registerPlugin($type,$tagname,$fn);
}