<?php


/**
 * zwraca stringa z danymi meta generujac je na podstawie informacji z tablicy
 * @param $meta_array - tablica informacji meta w postaci:
 * array(
 * 	'tag'=>'nazwa tagu
 * 	'param'=>array(
 * 		'nazwa_parametru'=>'wartosc parametru'
 * 		)
 * )
 */
function smarty_html_head_generator($meta_array) {
	if(!is_array($meta_array)) return;
	foreach ($meta_array as $item){
		$md .= '<'.$item['tag'].generate_param($item['param']).'/>'."\r\n";
	}
	return $md;
}

/**
 * generuje parametry do dodania do elementu xhtml;
 * uzywa ja fn. load_head()
 * @param array $param_array
 * @return void|string
 */
function generate_param($param_array){
	if(!is_array($param_array)) return;
	foreach ($param_array as $param=>$value){
		$pd.=' '.$param.'="'.$value.'"';
	}
	return $pd;
}