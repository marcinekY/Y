<?php
$ext=array(
		'name'=>'smarty',
		'description'=>'System szalonów Smarty v.1.3.6',
		'version'=>'1',
		'type'=>'parser-tamplate',
		'triggers'=>array(
				'parser-setup'=>'smarty_parser_setup',
				'parser-register-value'=>'smarty_assign_value',
				'parser-fetch-string'=>'smarty_fetch_string',
				'parser-set-dirs'=>'smarty_set_tamplate_dirs',
				'parser-add-function'=>'smarty_register_plugin',
		)
);

//ustawienia asset
$confP = array(
		'config'=>array(
				'left_delimiter'=>'{{',
				'right_delimiter'=>'}}',
				'caching'=>false,
				'compile_dir'=>'cache/compile/'
				//'compile_dir'=>$this->site->path.'cache/template_'.$this->template->name.'/compile/',
				//'cache_dir'=>$this->site->path.'cache/template_'.$this->template->name.'/'
		)
);

/**
 * funkcja zwraca skonfigurowany obiekt Smarty
 * @param array $conf - tablica konfiguracji Smarty
 * 			def. $conf = array(
 'left_delimiter'=>'{{',
 'right_delimiter'=>'}}',
 'caching'=>false,
 'cache_dir'=>BASICPATH.'cache/',
 'compile_dir'=>BASICPATH.'cache/'
 );
 *
* */
function smarty_parser_setup($conf=null){
	echo 'smarty_parser_setup'."\n\r";
	//var_dump($conf);
	class_exists('Smarty');
	$smarty = new Smarty;
	class_exists('FileManagment');
	$defaultConf = array(
			'left_delimiter'=>'{{',
			'right_delimiter'=>'}}',
			'caching'=>false,
			'cache_dir'=>'cache/',
			'compile_dir'=>'cache/'
	);
	if(!is_array($conf)) $conf = $defaultConf;
	print_r($conf);
	if(!FileManagment::checkDir(BASICPATH.$conf['compile_dir'],0755)) return;
	if(!FileManagment::checkDir(BASICPATH.$conf['cache_dir'],0755)) return;
	foreach ($conf as $n=>$v) {
		if(property_exists($smarty, $n)) {
			if(preg_match('/.*dir$/i', $n)){
				$v = BASICPATH.$v;
			}
			$smarty->{$n} = $v;
		}
	}
	return $smarty;
}

/**
 * dodaje zmienna do parsera
 * @param Smarty $smartyInstance
 * @param string $name
 * @param mixed $v
 */
function smarty_assign_value(&$smartyInstance, $name, $v){
	/* $params =& func_get_args();
	array_shift($params);
	print_r($params); */
	echo 'smarty_assign_value:'.$name."\n\r";
	if(!is_a($smartyInstance, 'Smarty')) return;
	//echo 'wartosci:'.$name.'vvv'.$v;
	$smartyInstance->assign($name,$v);
}

/**
 * zwraca wynik parsera po przeanalizowaniu tresci html
 * @param Smarty $smartyInstance
 * @param string $html
 */
function smarty_fetch_string(&$smartyInstance, $html){
	echo 'smarty_fetch_string'."\n\r";
	//echo $html;
	//print_r($smartyInstance);
	if(!is_a($smartyInstance, 'Smarty')) return;
	return $smartyInstance->fetch('string:'.$html);
}

/**
 * dodaje do smarty katalogi szablonu
 * @param Smarty $smarty_instance - instancja smarty
 * @param array $dirs_array - tablica folderow w szablonie
 */
function smarty_set_tamplate_dirs(&$smartyInstance, $dirs_array){
	echo 'smarty_add_dirs'."\n\r";
	if(!is_array($dirs_array) || !is_a($smartyInstance, 'Smarty')) return;
	foreach ($dirs_array as $key=>$dir){
		if(is_dir($dir)) $smartyInstance->addTemplateDir($dir,$key);
	}
}

/**
 * dodaje plugin do instancji smarty
 * @param unknown $smarty_instance - instancja smarty
 * @param unknown $tagname - nazwa tagu uruchomienia
 * @param unknown $fn - nazwa funkcji
 * @param string $type - type of plugin
 */
function smarty_register_plugin(&$smartyInstance,$tagname,$fn,$type='function'){
	echo 'smarty_register_plugin: '.$tagname.':'.$fn."\n\r";
	if(!function_exists($fn) || !is_a($smartyInstance, 'Smarty')) return;
	$smarty->registerPlugin($type,$tagname,$fn);
}


/**
 * funkcja zwraca skonfigurowany obiekt Smarty
 * @param compileDir - folder w katalogu cache w ktorym maja byc przechowywane skompilowane pliki szablonu
 * */
/* function smarty_setup($compileDir){
 class_exists('Smarty');
$smarty = new Smarty;
class_exists('FileManagment');
if(!FileManagment::checkDir(BASICPATH.'cache/'.$compileDir,0755)) return;
$smarty->compile_dir = $smarty->cache_dir = BASICPATH.'cache/'.$compileDir;
$smarty->left_delimiter = '{{';
$smarty->right_delimiter = '}}';
$smarty->caching = false;
//$smarty->register_function('MENU','generate_metadata');
return $smarty;
} */







