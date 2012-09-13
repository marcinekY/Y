<?php


//include ADMINCONFIG.'adminTopMenu.php';


if(!class_exists('Assets')) die('Menus::brak klasy Assets');
//$adminMenuAsset = Assets::getAsset('admin-top-menu');

$adminTopMenu = $adminMenuAsset->getValue();
if(!is_array($adminTopMenu)) $adminTopMenu = array();


print_r($adminTopMenu);
$smarty->assign('');
$smarty->assign('CONTENT',$smarty->fetch('menus/content.html'));