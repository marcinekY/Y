<?php


class Content {
	static $table = 'contents';
	static $tablePag = 'pages_contents';
	static $instancesBy = array();

	protected static $instancesSearchFilters = array('id',array('name'=>'name','type'=>'array'),array('name'=>'pag_id','type'=>'array'),array('name'=>'sec_id','type'=>'array'));
	public static $createMode = true; //true pozwala tworyzc obiekty ktore sa wywolywane, ale nie ma ich w bazie danych (zwraca puste obiekty - bez konfiguracji lub obiekt z bazy jesli istnieje)
	static $debug = false;
	
	public $id;
	public $sec_id;
	public $wid_id;
	public $pag_id;
	public $name;
	public $value;

	function __construct($v,$byField=0) {
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
		}
		// 		else if ($byField == 3 && is_numeric($v)){ // wg pola special
		// // 			$fname='page_by_special_'.$v;
		// 			$r=MySQL::getRow("select * from pages where special&$v limit 1");
		// 		}
		else return false;
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
		if(isset($r['value'])) $this->value &= json_decode(stripslashes($item['value']),true);
		//static::$instances[$this->id] =& $this;
		
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
									static::$instancesBy[$filter['name']][$this->{$filter['and']}] =& $this;
								}
							}
							break;
					}
				}
			}
		}
		//print_r(self::$instancesBy);
		return $this;
	}


	static function getContentsByPageId($pageId){
		if(!@array_key_exists($pageId, self::$instancesBy['pag_id'])){
			$sql = 'SELECT `c`.`id`,`c`.`name`,`c`.`wid_id`,`c`.`sec_id`,`c`.`value` , `cp`.`id` AS `cp_id`,`cp`.`pag_id`,`cp`.`ord`,`cp`.`published`
					FROM `'.self::$tablePag.'` AS `cp` JOIN `'.self::$table.'` AS `c` ON `cp`.`con_id` = `c`.`id`
							WHERE `cp`.`pag_id`=\''.$pageId.'\'' ;
			if($items = MySQL::getRow($sql,true)){
				//print_r($items);
				foreach ($items as $item){
					new Content($item,5);
				}
			}
		}
		return self::$instancesBy['pag_id'][$pageId];
		//print_r(self::$instancesBy['id']);
	}
        
        static function getContentsBySectionId($secId){
            if(!@array_key_exists($pageId, self::$instancesBy['pag_id'])){
			$sql = 'SELECT `c`.`id`,`c`.`name`,`c`.`wid_id`,`c`.`sec_id`,`c`.`value` , `cp`.`id` AS `cp_id`,`cp`.`pag_id`,`cp`.`ord`,`cp`.`published`
					FROM `'.self::$tablePag.'` AS `cp` JOIN `'.self::$table.'` AS `c` ON `cp`.`con_id` = `c`.`id`
							WHERE `c`.`sec_id`=\''.$secId.'\'' ;
			if($items = MySQL::getRow($sql,true)){
				//print_r($items);
				foreach ($items as $item){
					new Content($item,5);
				}
			}
		}
		return self::$instancesBy['pag_id'][$pageId];
        }
}