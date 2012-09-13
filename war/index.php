<?php

if(session_id()=="") session_start();


$incs_actions_array = array(
	'forgott-password-verify' => 'forgotten-password-verification.php'
);

//if(!defined('E')) define('E','system/e/');

if(strlen($_SERVER['REQUEST_URI']) > 0) {
    if($_SERVER['REQUEST_URI']{0}=='/') $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'],1);
    $tmp = urldecode($_SERVER['REQUEST_URI']);
    $G = explode("/", $tmp);
//    unset($G[0]);
    foreach ($G as $k=>$v) {
        $v = trim($v);
        $_GET['p'] = $v;
        if(is_array($menuTop) && array_key_exists($v, $menuTop)) {
            $_GET['p'] = $v;
            $userMode = true;
        }
    	if(is_array($incs_actions_array) && array_key_exists($v, $incs_actions_array)) {
            $_GET['action'] = $v;
            $userMode = true;
        }
        elseif(preg_match('/^page(?<page>\d{1,})$/', $v, $m)){
            $_GET['page'] = $m['page'];
        }
        elseif(is_array($actionMenu) && array_key_exists($v, $actionMenu)){
            $_GET['action'] = $v;
            if($actionMenu[$v]==1) $userMode = true;
        }
        elseif($v=='logout') $_GET['p'] = $v;
        elseif(preg_match('/^(?<id>\d{1,11})_(?<alias>.*)/', $v, $m)) {
            $_GET['anons'] = $m['id'];
            $_GET['anonsAlias'] = $m['alias'];
        }
        elseif(preg_match('/^m_(?<id>\d{1,11})$/', $v, $m)){
            $_GET['message'] = $m['id'];
        }
        elseif(preg_match('/^(?<id>\d{1,11})$/', $v)){
            $_GET['id'] = $v;
        }
        elseif(preg_match('/^page(?<page>\d{1,})$/', $v, $m)){
            $_GET['page'] = $m['page'];
        }
        elseif(preg_match('/^[a-f0-9]{32}$/', $v)){
            $_GET['hash'] = $v;
        }
        /*
        elseif($cat = $categories->getCategoryByAlias($v)) {
            if(is_null($cat->getParent())) {
                $_GET['categories'] = $categories->getCategoriesByParentId($cat->getId());
            }
            $_GET['category'] = $cat->getId();
            $currentCategory = $cat;
        } 
        elseif($currentProvince = $cities->getProvinceByName($v)) $_GET['province'] = $currentProvince->getProvinceId();
        */
        
    }
    //if(count($_GET)==0) $_GET['p'] = 'moje';
    //if(!$_GET['page']) $_GET['page'] = 0;
}//e if
//print_r($_GET);

require_once('y.incs/common.php');


$external_scripts=array();
$external_css=array();


$page=isset($_GET['p'])?$_GET['p']:'';
$id=isset($_REQUEST['id'])?(int)$_REQUEST['id']:0;

if(!$id){
	if($page){ // wczytanie wg nazw
		@$r=Page::getInstanceByName($page);
		if($r && isset($r->id))$id=$r->id;
	}
	
	if(!$id){ // w przeciwnym przypadku wczytanie wg zawartosci pola special
		$special=1;
		if(!$page){
			@$r=Page::getInstanceBySpecial($special);
			if($r && isset($r->id))$id=$r->id;
		}
	}
}
// }
// { wczytanie danych strony
if($id){
	$PAGEDATA=(isset($r) && $r)?$r : Page::getInstance($id);
	Page::setActual($PAGEDATA);
}
else{
	echo 'Strona b��du 404';
	exit;
}

Plugins::runTrigger('page-content-created',$PAGEDATA);


print_r($PAGEDATA);
