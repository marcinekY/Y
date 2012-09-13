<?php


class Trigger {

	public $name;
	public $fn;

	private static $triggers;

	public function __construct($name,$fn,$ext_id=null){
		if(!function_exists($fn)) return false;
		if(is_numeric($ext_id)) {
			$this->ext_id = $ext_id;
		}
		$this->name = $name;
		$this->fn = $fn;

		self::$triggers[$name][] =& $this;
		return $this;
	}

	static function addTrigger($name,$fn){
		new Trigger($name, $fn);
	}

	static function addTriggers(Plugin $plugin){
		if($t = $plugin->getTriggers()){
			foreach ($t as $fname=>$fn){
				self::$triggers[$fname][$plugin->getName()] = $fn;
			}
		}
	}

	static function runTrigger($trigger_name){
		$params = func_get_args();
		array_shift($params); //usuwa parametr $trigger_name
		//sort($params);
 		//var_dump($params);
		if(!is_array(self::$triggers[$trigger_name])) return;
		Logger::addLog('runtrigger.'.$trigger_name, 'Uruchamiam trigger: '.$trigger_name.'.', 'INFO');
		// 				print_r($arg);
		foreach (self::$triggers[$trigger_name] as $t){
			if(function_exists($t->fn)){
				if($refFunc = new ReflectionFunction($t->fn)) {
					$args = array();
					foreach($refFunc->getParameters() as $k=>$param ){
						//invokes ■ReflectionParameter::__toString
						//echo 'k.'.$k;
						if($params[$k]){
							//echo 'k.'.$k;
							if($param->isPassedByReference()) {
								$args[$k] =& $params[$k];
							} else {
								$args[$k] = $params[$k];
							}
						} else $args[$k] = $params[$k];
					}
					if(count($args)>0) {
						//var_dump($args);
						
						return $refFunc->invokeArgs($args);
					} else {
						return $refFunc->invoke();
					}
				}

// 				if(!is_null($arg)) {
// 					if(is_array($arg)) return call_user_func_array($t->fn, $arg);
// 					else return call_user_func($t->fn,$arg);
// 				}
// 				else return call_user_func($t->fn);
			}
		}

		//self::runTriggerFunctions(self::$triggers[$trigger_name],$argv);
	}

	private static function runTriggerFunctions($functionsName,&$argv=null){
		if(!is_array($functionsName)) return;
		foreach ($functionsName as $pname=>$fname) {
			if(!is_null($argv)) {
				if(is_array($argv)) return call_user_func_array($fname, $argv);
				else return call_user_func($fname,$argv);
			}
			else return $fname();
		}


	}

}