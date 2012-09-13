<?php
error_reporting(E_ERROR | E_PARSE);

include_once 'system/lib/LOG.php';
include_once 'system/modules/dataManager/DataManager.php';

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
if(count($returnArray)>0){
    if($_GET['callback']) echo $_GET['callback'].'('.json_encode($returnArray).');';
} else {
    if($_GET['callback']) echo $_GET['callback'].'({});';
}
?>
