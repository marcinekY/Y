<?php

/**
 *
 * Klasa odpowiada za przechowywanie zmiennych url'a i wysukiwanie wartosci
 * @author Y
 *
 */
class URL {
	private static $vars = array();
	private static $requestString = '';

	public static function setRequestString($string){
		self::$requestString = $string;
		if(strlen(self::$requestString) > 0) {
			if(self::$requestString{0}=='/') self::$requestString = substr(self::$requestString,1);
			self::$requestString = urldecode(self::$requestString);
			$r = explode("/", self::$requestString);
			$r = array_filter($r, 'strlen');
			$mx = count($r);
			for($i=0;$i<$mx;$i++){
				$v = trim(htmlspecialchars($r[$i]));
				$r[$i] = $v;
			}
			self::addVars($r);
			print_r(self::$vars);
		}
	}
	
	public static function clear($param) {
		self::$vars = array();
	}
	
	/**
	 * dodaje elementy tablicy do tablicy adresu/
	 * funkcje nalezy poprawicz, poniewaz nadpisuje elementy z tymi samymi kluczami
	 * @param array $v
	 */
	public static function addVars($v){
		if(!is_array($v)) $v = array($v);
		self::$vars = array_merge(self::$vars,$v);   //nadpisuje wartosci jesli wartosc nie jest tablica i klucz jest taki sam
	}
	
	public static function setVars($v){
		if(is_array($v)) self::$vars = $v;
	}

	/**
	 * Funkcja zwraca, czy w adresie wystepuje wartosc podana w argumencie. Wartoscia moze byc tablica kluczy lub patternow regex lub i to i to
	 * @param mixed(string|array) $patterns
	 */
	public static function getVar($patterns){
		$r = array();
		if(!is_array($patterns)) if(is_string($patterns)) $patterns=array($patterns); else return false;
		$pregs = array();
		$values = array();
		foreach ($patterns as $key=>$pattern) {
			if($i = preg_match('/([\/#]){1}.*?(?:\1|\1\w+){1}$/i', $pattern, $m)){
				if($i>0){
					$preg['pattern'] = $pattern;
					if(is_string($key)) $preg['name'] = $key;
					if($j = preg_match_all('/\(\?P<(?P<vars>.+?)>.+?\)+?/i', $pattern, $vars)){
						if($j>0){
							$preg['vars'] = $vars['vars'];
						}
					}
					if(is_string($key)) $pregs[$key] = $pattern; else $pregs[] = $pattern;
				}
			} else {
				if(is_string($key)) $values[$key] = $pattern; else $values[] = $pattern;
			}
		}
		//print_r($pregs);
		//print_r($values);
		//if(preg_match(PREG_OFFSET_CAPTURE, $patterns,$m)) print_r($m);

		//if(preg_match('/^page(?<page>\d{1,})$/', $patterns, $m))
		$r = array();
		foreach (self::$vars as $var){
			foreach ($values as $k=>$v){
				if($v==$var){
					if(is_string($k)) $r[$k] = $var; else $r[] = $var;
				}
			}
			foreach ($pregs as $k=>$p){
				$preg_result = false;
				if($i = preg_match($p['pattern'], $v, $m)){
					if($i>0){
						if(is_array($p['vars'])){
							$vars = array();
							foreach ($p['vars'] as $name){
								if($m[$name]) $vars[$name] = $m[$name];
							}
							if(count($vars)>0) {
								$preg_result['value'] = $var;
								$preg_result['vars'] = $vars;
							}
						}
						if(!$preg_result) $preg_result['value'] = $var;
						if(is_string($k)) $r[$k] = $preg_result; else $r[] = $preg_result;
					}
				}
			}
		}
		if(count($r)>0) return $r;
		return false;
	}
	
	static function getVars() {
		return self::$vars;
	}
	
	
}
