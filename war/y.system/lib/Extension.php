<?php

class_exists('Item');

class Extension extends Item {
	//nadpisanie zmiennych klasy Item
	protected static $table = 'extends';
	protected static $confType = 'extend';
	protected static $className = 'Extension';

	/* protected static $instances         = array();
	 protected static $instancesByName   = array(); */
	protected static $instancesBy = array();
	//protected static $instancesSearchFilters = array('id','name');

	//zmienne klasy Extension
	protected static $tableExtSite = 'extends_sites';
	protected static $instancesBySite = array();
	protected static $tableExtTem = 'extends_templates';
	protected static $instancesByTemplate = array();
	protected static $defaultConfName = '_default';

	public $id;
	public $name;
	public $description;
	public $type;
	public $path;
	public $version;
	public $config_file_array = array();
	public $triggers = array();

	/**
	 * pobiera rozszerzenie z bazy danych i wczytuje z katalogu
	 * @param number|string $v
	 * @param number $field - 0-pobiera po id, 1-pobiera po nazwie
	*/
	function __construct($v, $field=0,$load=false) {
		parent::__construct($v,$field);
		if($load) $this->load();
	}

	function load(){
		if(is_dir(EXTPATH.$this->path)){
			if(is_file(EXTPATH.$this->path.'ext.php')){
				require_once EXTPATH.$this->path.'ext.php';
				if(is_array($ext)) {
					$this->config_file_array =& $ext;
					if($this->version < $ext['version']) {
						//zrobic update pluginu
						$this->update($ext);
					}
					if(is_array($ext['triggers'])) {
						foreach ($ext['triggers'] as $fname=>$fn){
							if(function_exists($fn)){
								Trigger::addTrigger($fname, $fn);
								$this->triggers[$fname] = $fn;
							}
						}
					}
					//$this->getDefaultConfig();
				}
			}
		}
	}

	/* 	function getDefaultConfig(){
		if($def =& $this->getAsset(self::$defaultConfName)) {
	return $def;
	}
	return false;
	} */

	function update($update_set){
		echo 'funkcja update';
	}

	/**
	 *
	 * @param unknown $sit_id
	 * @return boolean|Extension[]:
	 */
	static function getInstancesBySiteId($sit_id){
		if(!is_numeric($sit_id)) return false;
		if(@array_key_exists($sit_id, self::$instancesBySite['id'])) return self::$instancesBySite['id'][$sit_id];
		$sql = 'SELECT `ext_id`,`enabled` FROM `'.self::$tableExtSite.'` WHERE `sit_id`=\''.$sit_id.'\'';
		if($items = MySQL::getRow($sql,true)){
			//			print_r($items);
			foreach ($items as $item){
				//tworzy nowy obiekt typu Extension; jesli wlasciwosc `enabled` występuje, sprawdzana jest wersja rozszerzenia oraz ladowane sa funkcje
				$ex = Extension::getInstance($item['ext_id']);
				$ex->sit_id = $sit_id;
				if($item['enabled']==1) {
					$ex->enabled=true;
					$ex->load();
				}
				self::$instancesBySite['id'][$sit_id][$item['ext_id']] = $ex;
				self::$instancesBySite['name'][$sit_id][$item['ext_id']] = $ex;
			}
			return self::$instancesBySite['id'][$sit_id];
		}
	}

	static function getInstancesByTemplateId($tem_id){
		if(!is_numeric($tem_id)) return false;
		if(@array_key_exists($tem_id, self::$instancesByTemplate)) return self::$instancesByTemplate[$tem_id]['name'];
		$sql = 'SELECT `ext_id` FROM `'.self::$tableExtTem.'` WHERE `tem_id`=\''.$tem_id.'\'';
		if($items = MySQL::getRow($sql,true)){
			//			print_r($items);
			foreach ($items as $item){
				$ex = Extension::getInstance($item['ext_id']);
				if(is_a($ex, Extension::$className)) {
					//print_r($ex);
					$ex->tem_id = $tem_id;
					self::$instancesByTemplate[$tem_id]['name'][$ex->name] = $ex;
					self::$instancesByTemplate[$tem_id]['id'][$ex->id] = $ex;
				}
			}
			return self::$instancesByTemplate[$tem_id]['name'];
		}
	}

}