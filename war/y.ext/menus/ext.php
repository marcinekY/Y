<?php
$ext=array(
		'name'=>'Menu',
		'description'=>'Tworzy menu.',
		'version'=>'0',
		'admin'=>array(
				'menu'=>array(
						'Menu>Projektant menu'=>'menu_mng',
						'Menu>Elementy menu'=>'menu_items'
				),
		),
		'triggers'=>array(
				'menu-created'=>'menu_show'
		)
);

function menu_show($asset){
	if(isset($PARENTDATA->vars->comments_disabled) && $PARENTDATA->vars->comments_disabled=='yes') return;
	require_once SCRIPTBASE.BASENAME.'y.plugins/page-comments/frontend/show.php';
}