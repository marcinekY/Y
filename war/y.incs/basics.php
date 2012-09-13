<?php
/**
 * plik basic.php zawiera funkcje wsp�lne dla ca�ego systemu
 * zawiera dane dostepu do bazy danych i ustawienia podstawowych zmiennych
 */

session_start();

//definiowanie stalych
/** glowny katalog serwera */
if(!defined('SCRIPTBASE')) define('SCRIPTBASE', $_SERVER['DOCUMENT_ROOT'].'/');
/** lokalizacja systemu w glownym katalogu serwera */
if(!defined('BASENAME')) define('BASENAME', 'ysystem/war/');
/** pelna lokalizacja glowna (SCRIPTBASE+BASENAME) */
if(!defined('BASICPATH')) define('BASICPATH', SCRIPTBASE.BASENAME);
/** lokalizacja folderu incs */
if(!defined('INCSPATH')) define('INCSPATH', BASICPATH.'y.incs/');
/** lokalizacja silnika systemu */
if(!defined('E')) define('E', BASICPATH.'y.system/');
/** lokalizacja silnika systemu */
if(!defined('THEMEPATH')) define('THEMEPATH', BASICPATH.'y.tpl/');
/** lokalizacja modulow */
if(!defined('MODULES')) define('MODULES', E.'modules/');
/** lokalizacja pluginow */
if(!defined('EXTPATH')) define('EXTPATH', BASICPATH.'y.ext/');
/** lokalizacja bibliotek */
if(!defined('LIBS')) define('LIBS', E.'lib/');
/** lokalizacja pliku konfiguracujnego */
if(!defined('CONFIGPATH')) define('CONFIGPATH', BASICPATH.'.private/'); 
include_once CONFIGPATH.'config.php';


require_once LIBS.'CORE.php';
/* CORE::addClassesToMap(LIBS);
CORE::addClassesToMap(E);
CORE::saveMap(); */
CORE::getClassMap();

if(!function_exists('__autoload')){
	function __autoload($className) {
		CORE::loadClass($className);
	}
}

class_exists('Trigger');


//funkcja auatoload


class_exists('URL');
URL::setRequestString(str_replace(BASENAME, '', $_SERVER['REQUEST_URI']));

$tmp = URL::getVar('noemail');
var_dump($tmp);

set_include_path(LIBS.PATH_SEPARATOR.get_include_path());




//wczytanie i uruchomienie klasy MYSQL
$dbClassPath = LIBS.'MySQL.php';
//$dbClassRunArgs = array('run'=>array(array('name'=>'setHost','param'=>$dbConf['db_dns']),array('name'=>'setDBName','param'=>$dbConf['db_name']),array('name'=>'setUser','param'=>array($dbConf['db_user'],$dbConf['db_pass'])),array('name'=>'connect')));
//$DB = getObject('StaticMySQL',$dbClassPath,$dbClassRunArgs);

/** konfiguracja polaczenia z baza danych */
class_exists('MySQL');
MySQL::setHost($PAGECONF['db_dns']);
MySQL::setDBName($PAGECONF['db_name']);
MySQL::setUser($PAGECONF['db_user'],$PAGECONF['db_pass']);
MySQL::connect();

//if(!is_object($DB) || !is_a($DB, 'MySQL')) die('Error! Contact with your administrator.');

class_exists('Site');
class_exists('Logger');
class_exists('Page');
class_exists('FileManagment');
class_exists('Redirect');
class_exists('Extension');
class_exists('Template');




// { wtyczki
//Plugins::setPlugins();
//Plugins::setPluginsFromPath(PLUGINSPATH);
//var_dump(Plugins::getTriggers());
// }

// { szablony ; themes

// }



/** jesli pierwszy znak jest litera, to zmienia ja na duza (rowniez polskie znaki) */
function ucfirst_utf8($str) {
	if (mb_check_encoding($str,'UTF-8')) {
		$first = mb_substr(mb_strtoupper($str, "utf-8"),0,1,'utf-8');
		return $first.mb_substr(mb_strtolower($str,"utf-8"),1,mb_strlen($str),'utf-8');
	} else {
		return $str;
	}
}


/**
 * Merges any number of arrays / parameters recursively, replacing
 * entries with string keys with values from latter arrays.
 * If the entry or the next value to be assigned is an array, then it
 * automagically treats both arguments as an array.
 * Numeric entries are appended, not replaced, but only if they are
 * unique
 *
 * calling: result = array_merge_recursive_distinct(a1, a2, ... aN)
 **/

function array_merge_recursive_distinct () {
	$arrays = func_get_args();
	$base = array_shift($arrays);
	if(!is_array($base)) $base = empty($base) ? array() : array($base);
	foreach($arrays as $append) {
		if(!is_array($append)) $append = array($append);
		foreach($append as $key => $value) {
			if(!array_key_exists($key, $base) and !is_numeric($key)) {
				$base[$key] = $append[$key];
				continue;
			}
			if(is_array($value) or is_array($base[$key])) {
				$base[$key] = array_merge_recursive_distinct($base[$key], $append[$key]);
			} else if(is_numeric($key)) {
				if(!in_array($value, $base)) $base[] = $value;
			} else {
				$base[$key] = $value;
			}
		}
	}
	return $base;
}




/** tworzy obiekt klasy i zwraca go */
// function getObject($className,$path,$vars=array()){
// 	if(!class_exists($className)) if(!class_exists($className)) die('Brak klasy: '.$className); //wczytanie klasy

// 	$rf = new ReflectionClass($className);
// 	if($vars['construct']){
// 		if(!is_array($vars['construct'])) $vars['construct'] = array($vars['construct']);
// 		$params = array();
// 		foreach ($vars['construct'] as $param){
// 			if($$param) $params[] = $$param;
//             else $params[] = $param;
// 		}
		
// 		$a = $rf->newInstanceArgs($params);
// 	}
// 	//  use with php 5.4.0 if(!$a) $a = $rf->newInstanceWithoutConstructor();
// 	if(!$a) $a = $rf->newInstance();
// 	//ustawienie zmiennych publicznych
// 	if($vars['param']){
// 		if(!is_array($vars['param'])) $vars['param'] = array($vars['param']);
// 		foreach($c['param'] as $param){
//            	if(is_object($a)) $a->$param = $$param;
//        	}
// 	}
// 	//uruchomienie metod
// 	if($vars['run']){
// 		if(is_array($vars['run'])){
// 			foreach ($vars['run'] as $run){
// 				if(is_string($run)) $run = array('name'=>$run);
//            		if(!$run['name']) continue;
           		
//            		if(is_object($a)) {
//             		if(method_exists($a, $run['name'])){
//                     	$params = array();
//                     	if($run['param']) {
//                         	if(!is_array($run['param'])) $run['param'] = array($run['param']);
//                         	foreach ($run['param'] as $param){
//                             	if($$param) $params[] = $$param;
//                             	else $params[] = $param;
//                         	}
//                     	}
//                     	call_user_func_array(array($a,$run['name']), $params);
//                 	}
//            		}
// 			}
// 		}
// 	}
// 	return $a;
// }






/**
 *
 * teraz w klasie URL
 if(strlen($_SERVER['REQUEST_URI']) > 0) {
 if($_SERVER['REQUEST_URI']{0}=='/') $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'],1);
 $tmp = urldecode($_SERVER['REQUEST_URI']);
 $urlVars = explode("/", $tmp);
 //    unset($G[0]);
 foreach ($urlVars as $k=>$v) {
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
 }
 }//e if
 //print_r($_GET);

 */