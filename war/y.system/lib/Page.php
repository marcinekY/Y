<?php
class Page {
	static $instances         = array();
	static $instancesBy = array();
	static $instancesByName   = array();
	static $instancesBySpecial= array();

	private static $instancesSearchFilters = array('id','special','alias','sit_id');
	//,array('name'=>'sit_id','and'=>'alias','type'=>'multi')

	static $actual;
	static $table = 'pages';
	static $tableCon = 'pages_contents';
	static $confType = 'page';


	public $template;
	public $category;
	public $contents;
	public $assets = array();



	function __construct($v,$byField=0,$fromRow=0,$pvq=0,$setActual=false){
		# byField: 0=ID; 1=Name; 3=special; ; 5=bdVars
		if (!$byField && is_numeric($v)){ // wg identyfikatora
			$r=$fromRow?$fromRow:($v?MySQL::getRow("select * from `".self::$table."` where id=$v limit 1"):array());
		}
		else if ($byField == 1){ // wg nazwy
			$name=strtolower(str_replace('-','_',$v));
			$fname='page_by_name_'.md5($name);
			$r=MySQL::getRow("select * from `".self::$table."` where alias like '".addslashes($name)."' limit 1");
		}
		else if ($byField == 3 && is_numeric($v)){ // wg pola special
			$fname='page_by_special_'.$v;
			$r=MySQL::getRow("select * from `".self::$table."` where special&$v limit 1");
		} else if($byField == 5 && is_array($v)) {
			$r = $v;
		}
		else return false;
		if(!count($r || !is_array($r)))return false;
		if(!isset($r['id']))$r['id']=0;
		if(!isset($r['type']))$r['type']=0;
		if(!isset($r['special']))$r['special']=0;
		foreach ($r as $k=>$v) $this->{$k}=$v;
		//		preg_replace('#[^a-z0-9/]#','-',$name);
		$this->urlname=$r['alias'];
		$this->dbVals=$r;
		self::$instances[$this->id] =& $this;
		foreach (self::$instancesSearchFilters as $filter) {
			if(!is_array($filter)) $filter = array('name'=>$filter, 'type'=>'array');
			if(isset($this->{$filter['name']})){
				switch ($filter['type']){
					case 'simple':
						self::$instancesBy[$filter['name']][$this->{$filter['name']}] =& $this;
						break;
					case 'array':
						self::$instancesBy[$filter['name']][$this->{$filter['name']}][$this->id] =& $this;
						break;
					case 'multi':
						if($filter['and'] && is_string($filter['and'])){
							if(isset($this->{$filter['and']})) {
								self::$instancesBy[$filter['name']][$this->{$filter['and']}] =& $this;
							}
						}
						break;
				}
			}
		}




		// 		self::$instances[$this->id] =& $this;
		// 		self::$instancesByName[preg_replace(
		// 				'/[^a-z0-9]/','-',strtolower($this->urlname)
		// 		)] =& $this;
		// 		self::$instancesBySpecial[$this->special] =& $this;
		// 		if(is_numeric($this->sit_id)) self::$instancesBy['sit_id'][$this->sit_id][$this->id] =& $this;
		if($setActual) self::$actual &= $this;
		return self::$instances[$this->id];
	}

	function getTemplate(){
		if(is_null($this->template)) {
			if(is_numeric($this->tem_id)){
				$this->template =& Template::getInstance($this->tem_id);
			} else $this->template = false;
		}
		return $this->template;
	}

	function getContents(){
		if(!$this->contents || is_null($this->contents)) {
			$this->contents = Content::getContentsByPageId($this->id);
		}
		return $this->contents;
	}

	function setAsActual(){
		self::$actual =& $this;
	}

	function getAsset($name){
		if($this->assets[$name]) return $this->assets[$name];
		if($this->assets[$name] =& Asset::getAsset($name, $name,$this->id, self::$confType)){
			return $this->assets[$name][$this->type];
		}
	}

	static function getInstance($id=0,$fromRow=false,$pvq=false){
		if (!is_numeric($id)) return false;
		if (!@array_key_exists($id,self::$instancesBy['id']))
			new Page($id,0,$fromRow,$pvq);
		return self::$instances['id'][$id];
	}

	// 	static function getInstance($id=0,$fromRow=false,$pvq=false){
	// 		if (!is_numeric($id)) return false;
	// 		if (!@array_key_exists($id,self::$instances))
		// 			self::$instances[$id]=new Page($id,0,$fromRow,$pvq);
		// 		return self::$instances[$id];
		// 	}

	static function getInstanceByName($name=''){
		$name=strtolower($name);
		$nameIndex=preg_replace('#[^a-z0-9/]#','-',$name);
		if(@array_key_exists($nameIndex,self::$instancesBy['alias']))
			return self::$instancesBy['alias'][$nameIndex];
		self::$instancesBy['alias'][$nameIndex]=new Page($name,1);
		return self::$instancesBy['alias'][$nameIndex];
	}

	/* static function getInstanceByName($name=''){
		$name=strtolower($name);
	$nameIndex=preg_replace('#[^a-z0-9/]#','-',$name);
	if(@array_key_exists($nameIndex,self::$instancesByName))
		return self::$instancesByName[$nameIndex];
	self::$instancesByName[$nameIndex]=new Page($name,1);
	return self::$instancesByName[$nameIndex];
	} */



	static function getInstanceBySpecial($sp=0){
		if (!is_numeric($sp)) return false;
		if (!@array_key_exists($sp,self::$instancesBy['special']))
			self::$instancesBy['special'][$sp]= new Page($sp,3);
		return self::$instancesBy['special'][$sp];
	}

	/* static function getInstanceBySpecial($sp=0){
		if (!is_numeric($sp)) return false;
	if (!@array_key_exists($sp,self::$instancesBySpecial))
		self::$instancesBySpecial[$sp]= new Page($sp,3);
	return self::$instancesBySpecial[$sp];
	} */



	static function getInstancesBySiteId($sit_id){
		if (!is_numeric($sit_id)) return false;
		if (!@array_key_exists($sit_id,self::$instancesBy['sit_id'][$sit_id])) {
			$sql = 'SELECT * FROM `'.self::$table.'` WHERE `sit_id`=\''.$sit_id.'\'';
			if($items = MySQL::getRow($sql,true)){
				foreach (@$items as $item){
					new Page($item,5);
				}
			}
		}
		return self::$instancesBy['sit_id'][$sit_id];
	}

	static function getInstanceBySitIdAndAlias($alias,$sit_id){
		if(is_numeric($sit_id)){
			$nameIndex=preg_replace('#[^a-z0-9/]#','-',$alias);
			if(is_array(self::$instancesBy['sit_id'][$sit_id])) {
				foreach (self::$instancesBy['sit_id'][$sit_id] as $k=>$instance){
					if($instance->alias = $nameIndex) $id = $instance->id;
				}

			}
			$sql = "select * from `".self::$table."` where `alias` like '".$nameIndex."' AND `sit_id`='".$sit_id."' limit 1";
			if($item = MySQL::getRow($sql)){
				$p = new Page($item,5);
				$id = $p->id;
			}
			if(!$id) return false;
			//echo 'ID::::'.$id;
			//print_r(self::$instancesBy['sit_id'][$sit_id][$id]);
			return self::$instancesBy['sit_id'][$sit_id][$id];
		}
	}

	static function setActual(Page $page){
		self::$actual = $page;
	}

	static function getActual(){
		if(is_a(self::actual, 'Page')) return self::actual;
		return false;
	}
}