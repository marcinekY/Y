<?php
if(!defined('E')) die ('DIE intruder!!!');

if(!defined('BASENAME')) define('BASENAME', 'ysystem/war/');

include_once $_SERVER['DOCUMENT_ROOT'].'/'.BASENAME.'.private/dbConfig.php';

$c_path = E.'libs/';


$classInclude = array(
//    array('name'=>'MySQL','v_name'=>'db','path'=>$c_path.'db/MySQL.php','run'=>array(array('name'=>'setHost','param'=>$dbConf['db_dns']),array('name'=>'setDBName','param'=>$dbConf['db_name']),array('name'=>'setUser','param'=>array($dbConf['db_user'],$dbConf['db_pass'])),array('name'=>'connect'))),
    
    array('name'=>'Logger','v_name'=>'logger','path'=>$c_path.'basic/Logger.php'),
    array('name'=>'FileManagment','path'=>$c_path.'basic/FileManagment.php'),
    
    array('name'=>'Users','v_name'=>'users','path'=>$c_path.'basic/Users.php','param'=>'db'),
    array('name'=>'Smarty','v_name'=>'smarty','path'=>$c_path.'Smarty-3.1.6/Smarty.class.php'),
    
    array('name'=>'Pagination','v_name'=>'pagination','path'=>$c_path.'basic/Pagination.php'),
    array('name'=>'Messages','v_name'=>'messages','path'=>$c_path.'basic/Messages.php'),
    
);

// { include class from classInclude array
foreach($classInclude as $c){
    if($c['v_name'] && $c['name'] && $c['path']) {
        $$c['v_name'] = getClass($c['name'], $c['path']);
    } elseif($c['name'] && $c['path']) {
        getClass($c['name'], $c['path']);
    }
    if($c['param']){
        //ustawia parametry obiektu
        if(!is_array($c['param'])) $c['param'] = array($c['param']);
        foreach($c['param'] as $param){
            if(is_object($$c['v_name'])) {
                $$c['v_name']->$param = $$param;
            }
        }
    }
    if($c['run']){
        //uruchamia metody
        foreach($c['run'] as $run){
            if(is_string($run)) $run = array('name'=>$run);
            if(!$run['name']) continue;
            
            if(is_object($$c['v_name'])) {
                if(method_exists($$c['v_name'], $run['name'])){
                    $params = array();
                    if($run['param']) {
                        if(!is_array($run['param'])) $run['param'] = array($run['param']);
                        foreach ($run['param'] as $param){
                            if($$param) $params[] = $$param;
                            else $params[] = $param;
                        }
                    }
                    call_user_func_array(array($$c['v_name'],$run['name']), $params);
                }
            }
        }
    }
    
//    var_dump($$c['v_name']);
}
// }



//conf SMARTY
//$smarty->template_dir = './'.TPL_DIR;
$smarty->compile_dir = './tpl/c/compile/';
$smarty->cache_dir = './tpl/c/cache/';
$smarty->caching = false;
//$smarty->error_reporting = E_ALL;
//end conf SMARTY

//include_once $c_path.'db/MySql.php';
//$db = new MySql();


//wczytuje klase z pliku
function getClass($name,$c_path){
    if(is_file($c_path)) {
        include_once $c_path;
        if(class_exists($name)) return new $name;
    }
    die('Class <strong>'.$name.'</strong> not found.');
}//e f

//jesli pierwszy znak jest litera, to zmienia ja na duza (rowniez polskie znaki)
function ucfirst_utf8($str) {
   if (mb_check_encoding($str,'UTF-8')) {
       $first = mb_substr(mb_strtoupper($str, "utf-8"),0,1,'utf-8');
       return $first.mb_substr(mb_strtolower($str,"utf-8"),1,mb_strlen($str),'utf-8');
   } else {
       return $str;
   }
}

?>
