<?php

if(!class_exists('MySQL')) require 'MySQL.php';

class Asset {
	public $id;
	//public $name;
	//public $type;
	public $itemId;
	public $itemType;
	public $parentId;
	public $parentType;
	public $value;

	public static $instances = array();
	private static $instancesByAll = array();
	private static $tableName = 'asset';
	public static $createMode = true; //true pozwala tworyzc obiekty ktore sa wywolywane, ale nie ma ich w bazie danych (zwraca puste obiekty - bez konfiguracji lub obiekt z bazy jesli istnieje)


	function __construct($itemId,$itemType,$parentId=null,$parentType=null){
		if((!is_numeric($itemId) && !is_array($itemId)) || is_null($itemType) || !is_string($itemType)) return false;
		if($itemType=='from_db' && is_array($itemId)){
			$this->setFromDBArray($itemId);
			$this->id = $item['id'];
			$this->value = json_decode(stripslashes($item['value']),true);
		} else {
			//$name = strtolower($name);
			$this->itemId = $itemId;
			$this->itemType = preg_replace('#[^a-z0-9/]#','-',strtolower($itemType));
			$this->parentId = $parentId;
			$this->parentType = preg_replace('#[^a-z0-9/]#','-',strtolower($parentType));

			// 		$this->type = $type;
			//$this->name = $name;
			$dbArr = $this->getDBArray();
			$sql = 'SELECT * FROM `'.self::$tableName.'` WHERE (`item_id` = \''.$itemId.'\') AND (`item_type` = \''.$itemType.'\') AND (`parent_id` '.(is_null($parentId)?'IS NULL':'=\''.$parentId.'\'').') AND (`parent_type` '.(is_null($parentType)?'IS NULL':'=\''.$parentType.'\'').')';
			if($item = MySQL::getRow($sql)){
				//print_r($item);
				$this->id = $item['id'];
				$this->value = json_decode(stripslashes($item['value']),true);
				
				if(is_numeric($this->id) && !self::$instances[$this->id]) self::$instances[$this->id] =& $this;
			}
		}
		
		if(!is_numeric($this->id) && !self::$createMode) return false;
		
		return self::$instancesByAll[$this->itemType][$this->itemId][$this->parentType][$this->parentId] =& $this;
		
		/* 
		if(!$byParent){
			self::$instancesByItem[$this->itemType][$this->itemId]['default'] =& $this;
			return self::$instancesByItem[$this->itemType][$this->itemId]['default'];
		} else {
			return self::$instancesByParent[$this->itemType][$this->itemId]['parent'][$this->parentType][$this->parentId];
		} */
	}

	/* 	function __construct($name,$type,$itemId,$itemType){
		if(!is_numeric($itemId) || is_null($name) || !is_string($name) || is_null($itemType) || !is_string($itemType) || is_null($type) || !is_string($type)) return false;
	$this->itemId = $itemId;
	$this->itemType = $itemType;
	$this->type = $type;
	$this->name = $name;
	$sql = 'SELECT * FROM `'.self::$tableName.'` WHERE `item_id`=\''.$itemId.'\' AND `name`=\''.$name.'\' AND `item_type`=\''.$itemType.'\' AND `type`=\''.$type.'\'';
	if($item = MySQL::getRow($sql)){
	$this->id = $item['id'];
	$this->value = json_decode(stripslashes($item['value']),true);
	self::$instances[$this->type][$this->itemType][$this->name][$this->itemId] =& $this;
	} else return false;
	} */

	public static function getAsset($itemId,$itemType,$parentId=null,$parentType=null){
		if(!is_numeric($itemId) || is_null($itemType) || !is_string($itemType)) return false;
		if(!is_null($parentType)) $parentType=preg_replace('#[^a-z0-9/]#','-',strtolower($parentType));
		$itemType = preg_replace('#[^a-z0-9/]#','-',strtolower($itemType));
		if(!isset(self::$instancesByAll[$itemType][$itemId][$parentType][$parentId]))
			new Asset($itemId,$itemType,$parentId,$parentType);
		return self::$instancesByAll[$itemType][$itemId][$parentType][$parentId];
		/* if(is_numeric($parentId) && !is_null($parentType)) {
			if(self::$instancesByParent[$itemType][$itemId]['parent'][$parentType][$parentId])
				return self::$instancesByParent[$itemType][$itemId]['parent'][$parentType][$parentId];
			$byParent=true;
		} else if(isset(self::$instancesByItem[$itemType][$itemId]['default'])) {
			//print_r(self::$instancesByItem[$itemType][$itemId]['default']);
			return self::$instancesByItem[$itemType][$itemId]['default'];
		} */
		//echo 'tu:'.$itemId.$itemType;
		
		//print_r(self::$instancesByItem);
		/* if(!$byParent) {
			return self::$instancesByParent[$itemType][$itemId]['parent'][$parentType][$parentId];
		} else return self::$instancesByItem[$itemType][$itemId]['default']; */
	}

	public static function getParentsAsset($itemId,$itemType){
		$sql = 'SELECT * FROM `'.self::$tableName.'` WHERE `item_id`=\''.$itemId.'\' AND `item_type`=\''.$itemType.'\ AND `parent_id` IS NOT NULL AND `parent_type` IS NOT NULL';
		if($items = MySQL::getRow($sql,true)){
			foreach ($items as $item){
				new Asset($item, 'from_db');
			}
			return self::$instancesByParent[$itemId][$itemType]['parent'];
		}
	}


	private function setFromDBArray($array){
		$this->id = $array['id'];
		//$this->name = $array['name'];
		//$this->type = $array['type'];
		$this->itemId = $array['itemId'];
		$this->itemType = $array['item_type'];
		$this->parentId = $array['parent_id'];
		$this->parentType = $array['parent_type'];
		$this->value = is_array($array['value'])?$array['value']:json_decode($array['value'],true);
	}

	private function getDBArray(){
		if(is_numeric($this->id)) $r['id'] = $this->id;
		//$r['name'] = $this->name;
		//$r['type'] = $this->type;
		$r['item_id'] = $this->itemId;
		$r['item_type'] = $this->itemType;
		$r['parent_id'] = $this->parentId;
		$r['parent_type'] = $this->parentType;
		if(is_array($this->value)) $r['value'] = addslashes(json_encode($this->value));
		return $r;
	}

	function save(){
		if(is_array($this->value) && count($this->value)>0) {
			$arr = $this->getDBArray();
			if(!is_numeric($arr['parent_id'])) {
				unset($arr['parent_id']);
				unset($arr['parent_type']);
			}
		//print_r($arr);
			if(is_numeric($arr['id'])) {

				$r['id'] = $arr['id'];
				unset($arr['id']);
				if(MySQL::editData(self::$tableName, $r, $arr)) return true;
			} elseif(MySQL::addData(self::$tableName, $arr)) return true;
		}
		return false;
	}

	function getId(){
		return $this->id;
	}

	function setId($id){
		$this->id = $id;
	}

	function getName(){
		return $this->name;
	}

	function setName($name){
		$this->name = $name;
	}

	function getType(){
		return $this->type;
	}

	function setType($type){
		$this->type = $type;
	}

	function setValue($array){
		$this->value = $array;
		//		$this->save();
	}

	function getValue(){
		return $this->value;
	}

	function getValueKey($key){
		if($this->value[$key]) return $this->value[$key];
	}
}


class Assets {
	private static $tableName = 'asset';
	private static $assets = array();
	//private static $definedTypes = array('ext','tem','sit','pag','wid','sec');

	function __construct($name,$type,$typeId){

	}

	/**
	 * zwraca instancje obiektu Asset lub false jesli brak konfiguracji
	 * @param string $name
	 * @param string $type
	 * @return Asset $asset;
	 */
	public static function getAsset($name,$type,$typeId=null){
		if(isset(self::$assets[$name][$type])) return self::$assets[$name][$type];
		if(!in_array($type, self::$definedTypes)) return false;
		else $itemName = $type.'_id';
		$sql = 'SELECT * FROM `'.self::$tableName.'` WHERE `name`=\''.$name.'\' AND `'.$itemName.'` !IS NULL '.(is_numeric($typeId)?' AND `'.$itemName.'`=\''.$typeId.'\'':'');
		if($item = MySQL::getRow($sql)){
			self::$assets[$name][$type] = new Asset($item);
			return self::$assets[$name][$type];
		}
		return false;
	}

	public static function setAsset($name,$array,$type,$ref_id){
		if(!is_array($array)) return false;
		if($item = self::getAsset($name, $type)){
			$array = array_merge($item->getValue(),$array);
			$sql = 'UPDATE `'.self::$tableName.'` SET `value`=\''.json_encode($array).'\' WHERE `name`=\''.$name.'\' AND `type`=\''.$type.'\'';
		} else {
			$sql = 'INSERT INTO  `'.self::$tableName.'` (`name` ,`type` ,`value`) VALUES ('.$name.', '.$type.', '.json_encode($array).')';
		}
		if(MySQL::dbQuery($sql)) {
			if(is_numeric($ref_id)) {
				$sql = '';
			}
		}
	}
}

class AssetRelation {
	private static $tableName = 'asset';
	private static $instance;
	private static $definedTypes = array('ext','tem','sit','pag','wid','sec');
	public $assetId;
	public $itemId;
	public $type;

	function __construct($assetId,$itemId,$type){
		if(self::$instance[$itemId][$type]) retrun;

		if(MySQL::getRow($sql))
			self::$instance[$itemId][$type] &= this;


	}

	static function getInstance($itemId, $type) {
		if(is_array(self::$instance[$assetId])){
			foreach (self::$instance[$assetId] as $instance){
				$tmp = array_diff_assoc($relations,$instance->array);
				if(is_array($tmp) && count($tmp)==0) {
					return $instance;
				}
			}
		} else {
			//pobranie danych z bazy
			$request = array('id'=>$assetId);
			foreach (self::$definedTypes as $type){
				$request[$type] = $relations[$type];
			}
			if($items = MySQL::getData(self::$tableName, $request)){
				$instance[$assetId][] = new AssetRelation($assetId);
			}
		}
	}

	function setO($assetId,$relations) {
		if(!is_numeric($id)) return false;
		foreach (self::$definedTypes as $type){
			if(!is_numeric($relations[$type])){
				$this->array[$type] = $relations[$type];
			}
		}
		return true;
	}

	function setDB(){
		if(count($this->array)>0){
			$arr = $this->array;
			$arr['id'] = $this->assetId;
			if(MySQL::replaceData(self::$tableName, $arr)){
				return true;
			}
		}
		return false;
	}
}



