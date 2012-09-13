<?php

if(class_exists('CORE')) {
	CORE::loadClass('DataManager');
} else {
	require_once 'lib/DataManager.php';
}

$dataMng = new DataManager();



$dataSources = array();
foreach ($_GET as $name => $v){
	if(preg_match("/y[0-9]{1,}/i", $name)){
		//        echo 'matched!!!!!!!!!!!!!!!!!!!';
		$dataSources[] = array('name'=>$v,'path'=>'cmsdata/');
	}
}

if(count($dataSources)){
	//    print_r($dataSources);
	foreach ($dataSources as $source) {
		$dataMng->addData($source['path'],$source['name']);
	}
}
if($_GET['p']){
	//    $dataMng->setPlaceDir('cmsdata/');
	$dataMng->addData('cmsdata/',$_GET['p']);
	//    $returnArray['data'] = $placeObj->getPlaceArray();

}
//if($_GET['p'] && $_GET['i']) {
//    $dataMng->setPlaceDir('usrdir/');
//    $dataMng->addPlace($_GET['i']);
//    //$returnArray = $placeObj->getPlaceArray();
//}
$returnArray = $dataMng->getNamedArray();
//print_r($returnArray);

$callback = (!$_GET['callback']?class_exists('URL')?URL::getVar("callback"):false:$_GET['callback']).'('.(is_array($returnArray) && count($returnArray)>0?json_encode($returnArray):'{}').');';

echo $callback;