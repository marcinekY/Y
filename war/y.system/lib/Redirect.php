<?php

/**
 * Klasa sluzy do wykonywania rzekierowan strony na inny adres wraz z komunikatem 
 */

class Redirect {
	public static $url;

	public function __construct($url='/'){
		self::setUrl($url);
	}
	
	public static function setUrl($url,$redirect=FALSE,$msg=FALSE){
		self::$url=preg_replace('/[\?\&].*/','',$url);
		if(self::$url=='') self::$url='/';
		if($redirect) self::redirect($msg);
	}
	
	public static function redirect($msg='success'){
		if($msg) self::$url.='?msg='.$msg;
		header('Location: '.self::$url);
		echo '<a href="'.htmlspecialchars($url).'">redirect</a>';
		exit;
	}
}