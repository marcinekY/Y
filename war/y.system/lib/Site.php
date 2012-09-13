<?php




class Site {
	static $instances         = array();
	static $instancesByName   = array();
	static $actual;
	static $table = 'sites';
	static $confType = 'site';

	public $id;
	public $tem_id;
	public $name;
	public $url;
	public $path;
	public $template;
	public $extensions;
	public $pages = array();
	public $assets = array();

	function __construct($v,$byField=0,$setActual=false){
		# byField: 0=ID; 1=Name; 3=
		if (!$byField && is_numeric($v)){ // wg identyfikatora
			$r=MySQL::getRow("select * from `".self::$table."` where `id`='$v' limit 1");
		}
		else if ($byField == 1){ // wg nazwy
			$name=strtolower(str_replace('-','_',$v));
			// 			$fname='page_by_name_'.md5($name);
			$r=MySQL::getRow("select * from `".self::$table."` where `name` like '".addslashes($name)."' limit 1");
		}
		// 		else if ($byField == 3 && is_numeric($v)){ // wg pola special
		// // 			$fname='page_by_special_'.$v;
		// 			$r=MySQL::getRow("select * from pages where special&$v limit 1");
		// 		}
		else return false;
		if(!count($r || !is_array($r))) return false;

		//pobranie id i nazw stron;
		if(!isset($r['name']))$r['name']='NO NAME SUPPLIED';
		foreach ($r as $k=>$v) $this->{$k}=$v;
		$this->dbVals=$r;
		self::$instances[$this->id] =& $this;
		self::$instancesByName[preg_replace('/[^a-z0-9]/','-',strtolower($this->name))] =& $this;
		// 		self::$instancesBySpecial[$this->special] =& $this;
		if($setActual) {
			
			self::$actual =& $this;
		}
		return $this;
	}

	
	/**
	 * zwracja instancje obiektu Asset
	 * @param string $name
	 * @return Asset $this->assets[$name]:
	 */
	function getAsset($parentId=null,$parentType=null){
		return Asset::getAsset($this->id, static::$confType,$parentId,$parentType);
	}
	
	
	 /**
	 * zwracja instancje obiektu Asset
	 * @param string $name
	 * @return Asset $this->assets[$name]:
	 */
	/*function getAsset($parentId=null,$parentType=null){
		if(is_numeric($parentId) && !is_null($parentType)) {
			if(is_a($this->assets['parents'][$parentType][$parentId], 'Asset')){
				return $this->assets['parents'][$parentType][$parentId]
			}
		}
		if(is_a($this->assets['default'], 'Asset')) return $this->assets['default'];
		if(is_null(static::$confType)) return false;
		//print_r($as);
		
		if($as =& Asset::getAsset($this->id, static::$confType,$parentId,$parentType)){
			if(is_numeric($parentId) && !is_null($parentType)) $this->assets['parents'][$parentId][$parentType] = $as;
			return $as;
		}
		return false;
	} */
	
	function getParentsAsset() {
		$this->assets['parents'] =& Asset::getParentsAsset($this->id, self::$confType);
		return $this->assets['parents'];
	}
	
	function getTemplate(){
		if(!is_numeric($this->tem_id)) return false;
		if(is_null($this->template)) $this->template =& Template::getInstance($this->tem_id);
		return $this->template;
	}
	
	/**
	 * zwraca rozszerzenia wykorzystywane w stronie
	 * @return boolean|Ambigous <boolean, Extension[]:, multitype:>
	 */
	function getExtensions(){
		if(!is_numeric($this->id)) return false;
		if(is_null($this->extensions)) $this->extensions =& Extension::getInstancesBySiteId($this->id);
		return $this->extensions;
	}
	
	function getPages() {
		return $this->pages = Page::getInstancesBySiteId($this->id);
	}
	
	/**
	 * Zwraca instancje strony dla witryny
	 * @param unknown $name
	 * @return multitype:|Page $page|boolean
	 */
	function getPageByName($name){
// 		return Page::

		if(is_array($this->pages)) {
			foreach ($this->pages as $key=>$page){
				if($page->name == $name) return $this->pages[$key]; 
			}
		}
		
		$p =& Page::getInstanceBySitIdAndAlias($name, $this->id);
// 		print_r($p);
		if(is_a($p, 'Page')) return $this->pages[$p->id] =& $p; else return false;
	}
	
	/**
	 * zwraca instancje strony po jej id
	 * @param number $id
	 * @param string $setActual
	 * @return boolean|Site $this:
	 */
	static function getInstance($id=0,$setActual=false){
		if (!is_numeric($id)) return false;
		if (!@array_key_exists($id,self::$instances))
			self::$instances[$id]=new Site($id,0,$fromRow,$setActual);
		return self::$instances[$id];
	}
	
	/**
	 * zwraca instancje strony po jej nazwie
	 * @param string $name
	 * @param string $setActual
	 * @return Site $this
	 */
	static function getInstanceByName($name='',$setActual=false){
		$name=strtolower($name);
		$nameIndex=preg_replace('#[^a-z0-9/]#','-',$name);
		if(@array_key_exists($nameIndex,self::$instancesByName))
			return self::$instancesByName[$nameIndex];
		self::$instancesByName[$nameIndex]=new Site($nameIndex,1,$setActual);
		return self::$instancesByName[$nameIndex];
	}

	static function setAsActual(){
		self::$actual =& $this;
	}

	/**
	 * zwraca instancje ktora jest oznaczona jako aktualna
	 * @return Site|boolean
	 */
	static function getActual(){
		if(is_a(self::$actual, 'Site')) return self::$actual;
		return false;
	}
	
	

	


}