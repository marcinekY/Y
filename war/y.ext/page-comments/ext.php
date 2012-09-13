<?php
$ext=array(
	'name'=>'Komentarze',
	'description'=>'Umożliwia dodawanie komentarzy do stron.',
	'version'=>'0',
	'admin'=>array(
		'menu'=>array(
			'Komunikacja>Komentarze'=>'comments'
		),
		'page_tab'=>array(
			'name'=>'Komentarze',
			'function'=>'page_comments_admin_page_tab'
		)
	),
	'triggers'=>array(
		'page-content-created'=>'page_comments_show'
	)
);

function page_comments_admin_page_tab($PAGEDATA){
  require_once SCRIPTBASE.BASENAME.'y.plugins/page-comments/admin/page-tab.php';
  return $html;
}   
function page_comments_show($PAGEDATA){
	echo 'funkcja page_contents_show:';
	var_dump($PAGEDATA);
  if(isset($PARENTDATA->vars->comments_disabled) && $PARENTDATA->vars->comments_disabled=='yes') return;
  require_once SCRIPTBASE.BASENAME.'y.plugins/page-comments/frontend/show.php';
}