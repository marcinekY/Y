<?php
/**
 * dodaje do smarty katalogi szablonu
 * @param Smarty $smarty_instance - instancja smarty
 * @param array $dirs_array - tablica folderow w szablonie
 */
function smarty_set_tamplate_dirs(&$smarty_instance, $dirs_array){
	echo 'smarty_add_dirs';
	if(!is_array($dirs_array) || !is_a($smarty_instance, 'Smarty')) return;
	foreach ($dirs_array as $key=>$dir){
		if(is_dir($dir)) $smarty_instance->addTemplateDir($dir,$key);
	}
}