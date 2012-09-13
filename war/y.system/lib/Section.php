<?php

class_exists('Item');

class Section extends Item {
	//nadpisanie zmiennych klasy Item
	protected static $table = 'sections';
	protected static $confType = 'section';
	protected static $className = 'Section';
	
	protected static $instancesBy         = array();
	//protected static $instancesByName   = array();
	
	static $instancesByTemplateId;
	
	public $sections;
	
	
	function __construct($v,$byField=0) {
		parent::__construct($v,$byField);
		if(is_numeric($this->parent_id)) {
			$this->addTo($this->parent_id);
		}
	}
	
	function addTo($parentId){
		if($sec = Section::getInstance($parentId)){
			$this->parent_id = $parent_id;
			$sec->sections[$this->id] =& $this;
		}
	}
	
	function loadTemplate(){
		$path = Template::getInstance($this->tem_id)->fullPath;
		if(!is_dir($path)) return false;
		if(is_file($path.$this->name.'.html')) $this->file = $path.$this->name.'.html'; 
		else Logger::addError('section_load_theme', 'Brak pliku sekcji w szablonie.');
		$this->template = FileManagment::readFile($this->file);
		return true;
	}
	
	
	static function getInstancesByTemplateId($tem_id) {
		if(!is_numeric($tem_id)) return false;
		if(@array_key_exists($tem_id, self::$instancesByTemplateId)) return self::$instancesByTemplateId[$tem_id];
		$sql = 'SELECT * FROM `'.self::$table.'` WHERE `tem_id`=\''.$tem_id.'\'';
		if($items = MySQL::getRow($sql,true)){
			foreach ($items as $i){
				self::$instancesByTemplateId[$tem_id][$i['id']] =& Section::getInstanceByDBArray($i);
			}
			if(static::$debug) var_dump(self::$instancesByTemplateId[$tem_id]);
		}
		//print_r(self::$instancesByTemplateId[$tem_id]);
		return self::$instancesByTemplateId[$tem_id];
	}
	
	static function getInstanceByDBArray($arr){
		if(!is_array($arr)) return false;
		if(!@array_key_exists($arr['id'], self::$instancesBy['id'])) 
			new Section($arr,5);
		return self::$instancesBy['id'][$arr['id']];
		
	}
	
	
}