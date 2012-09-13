<?php

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

if(!function_exists('__autoload')){
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
}

class Item {
	/* 	protected static $instances         = array();
	 protected static $instancesByName   = array(); */

	protected static $className;
	protected static $table;
	protected static $confType;
	protected static $instancesBy = array();
	protected static $instancesSearchFilters = array('id','name');
	protected static $debug = false;

	public $asset;

	public $dbVals;

	//	public $assets = array();

	function __construct($v,$byField=0){
		//var_dump($v);

		# byField: 0=ID; 1=Name; 5=dbArray
		if(is_null(static::$table)) return false;
		if (!$byField && is_numeric($v)){ // wg identyfikatora
			$r=MySQL::getRow("select * from `".static::$table."` where id=$v limit 1");
		}
		else if ($byField == 1){ // wg nazwy
			$name=strtolower(str_replace('-','_',$v));
			// 			$fname='page_by_name_'.md5($name);
			$r=MySQL::getRow("select * from `".static::$table."` where name like '".addslashes($name)."' limit 1");
		} else if($byField==5 && is_array($v)) {
			$r = $v;
		} else return false;
		if(!count($r || !is_array($r))) return false;

		if(static::$debug){
			echo "<pre>";
			print_r($r);
			echo "</pre>";
		}
		$this->dbVals=$r;
		//pobranie id i nazw stron;
		if(!isset($r['name']))$r['name']='NO NAME SUPPLIED';
		foreach ($this->dbVals as $k=>$v) $this->{$k}=&$this->dbVals[$k];

		if(@count(static::$instancesSearchFilters)>0 && is_array(static::$instancesBy)){
			foreach (static::$instancesSearchFilters as $filter) {
				if(!is_array($filter)) $filter = array('name'=>$filter, 'type'=>'simple');
				/* echo $this->name;
				 print_r($filter); */
				if(isset($this->{$filter['name']})){
					switch ($filter['type']){
						case 'simple':
							static::$instancesBy[$filter['name']][$this->{$filter['name']}] =& $this;
							break;
						case 'array':
							static::$instancesBy[$filter['name']][$this->{$filter['name']}][$this->id] =& $this;
							break;
						case 'multi':
							if($filter['and'] && is_string($filter['and'])){
								if(isset($this->{$filter['and']})) {
									static::$instancesBy[$filter['name']][$this->{$filter['name']}][$this->{$filter['and']}] =& $this;
								}
							}
							break;
					}
				}
			}
		}
		//print_r(self::$instancesBy);

		// 		self::$instancesBySpecial[$this->special] =& $this;

		return $this;
	}

	/**
	 * zwracja instancje obiektu Asset
	 * @param string $name
	 * @return Asset $this->assets[$name]:
	 */
	function getAsset($parentId=null,$parentType=null){
		if(is_null($this->id)) return false;
		if(!$this->asset[$parentId][$parentType])
			$this->asset[$parentId][$parentType] =& Asset::getAsset($this->id, static::$confType,$parentId,$parentType);
		return $this->asset[$parentId][$parentType];
	}

	function getAssetValueByKey($key){
		$compare = $this->compareAssets();
		if(@array_key_exists($key, $compare)) return $compare[$key];
		return false;
	}

	function compareAssets(){
		if(!is_array($this->asset)) return false;

		$arr = array();
		foreach ($this->asset as $parentId=>$itemsByType){
			if(is_array($itemsByType)) {
				foreach ($itemsByType as $parentType=>$asset){
					if(is_a($asset, 'Asset')) {
						if($v = $asset->getValue()) {
							if(is_array($v)) $arr[] = $v;
						}
					}
				}
			}

		}
		$c = count($arr);
		//print_r($arr);
		if($c==0) {
			return false;
		} elseif($c==1){
			return $arr[0];
		} elseif($c>1) {
			$r = call_user_func_array('array_merge_recursive_distinct', $arr);
			//print_r($r);
			return $r;
		}
	}

	static function get_class_name() {
		return static::$className;
	}

	/**
	 * Zwraca instancje obiektu po jego id
	 * @param unknown $id
	 * @return boolean|self::$className $this;
	 */
	static function getInstance($id){
		/* echo "\r\n $id";
		 var_dump(static::$instancesBy);
		echo "\n\r\n\r\n\r"; */
		if (!is_numeric($id)) return false;
		if (!@array_key_exists($id,static::$instancesBy['id'])) {
			$className = static::get_class_name();
			new $className($id,0);
		}
		//print_r(static::$instancesBy['id']);
		return static::$instancesBy['id'][$id];
	}

	static function getInstanceByName($name){
		$name=strtolower($name);
		$nameIndex=preg_replace('#[^a-z0-9/]#','-',$name);
		if(@array_key_exists($nameIndex,self::$instancesBy['name']))
			return self::$instancesBy['name'][$nameIndex];
		self::$instancesBy['name'][$nameIndex]=new parent::$className($nameIndex,1);
		return self::$instancesBy['name'][$nameIndex];
	}
}