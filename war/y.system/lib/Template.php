<?php

class_exists('Item');


class Template extends Item {
	//nadpisane zmienne klasy Item
	protected static $table = 'templates';
	public static $confType = 'template';
	protected static $className = 'Template';
	
/* 	protected static $instances         = array();*/
	protected static $instancesBy   = array(); 
	
	//zmienne klasy Template
	protected static $tableTemExt = 'templates_extends';
	
	public $extensions;
	public $sections;
	
	
	function __construct($v, $field=0) {
		parent::__construct($v,$field);
	}
	
	/**
	 * 
	 * @return boolean|Ambigous <boolean, Section[array], multitype:>
	 */
	function getSections(){
		if(!is_numeric($this->id)) return false;
		if(is_null($this->sections)) $this->sections =& Section::getInstancesByTemplateId($this->id);
		return $this->sections;
	}
	
	function getExtensions(){
		if(!is_numeric($this->id)) return false;
		if(is_null($this->extensions)) $this->extensions =& Extension::getInstancesByTemplateId($this->id);
		return $this->extensions;
	}
	
/* 	function setParser($conf){	
		$this->parserInstance =& Trigger::runTrigger('parser-setup',$conf);
	} */
}