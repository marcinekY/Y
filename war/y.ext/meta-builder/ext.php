<?php
$ext=array(
	'name'=>'Konstruktor meta',
	'description'=>'Umożliwia ustawianie treści tagów meta.',
	'version'=>'0',
	'admin'=>array(
/*		'menu'=>array(
			'Strona>Konfiguracja'=>'global_config'
		),
*/		'page_tab'=>array(
			'name'=>'Dane mata',
			'function'=>'meta_builder_meta_data'
		)
	),
	'triggers'=>array(
		'meta-config-loader'=>'meta_data_load'
	)
);

function meta_builder_meta_data($PAGEDATA){
  require_once PLUGINSPATH.'meta-builder/admin/page-tab.php';
  return $html;
}
function meta_data_load($meta_array){
	echo 'funkcja meta_data_is_load:';
	var_dump($PAGEDATA);
  if(isset($PARENTDATA->vars->comments_disabled) && $PARENTDATA->vars->comments_disabled=='yes') return;
  require_once PLUGINSPATH.'meta-biulder/frontend/show.php';
}