<?php


class Render {
	static $defaultConfName = '_default';

	public $parserName = 'smarty';


	/**
	 * @var Page
	 */
	public $page;
	/**
	 * @var Smarty
	 */
	public $parser;
	/**
	 * @var Template
	 */
	public $template;
	/**
	 * @var Site
	 */
	public $site;
	/**
	 * @var User
	 */
	public $user;
	/**
	 * @var Extends[]
	 */
	public $extends;
	/**
	 * @var Section[]
	 */
	public $sections;
	/**
	 * @var Content[]
	 */
	public $contents;


	function __construct(Site &$site, Page &$page, User $user=null){
		$this->site = $site;
		$this->template = $template;
		$this->page = $page;
		if(!is_null($users)) $this->users = $users;
	}
	
	function loadSettings(){
		if(!$this->template = $this->page->getTemplate()){
			if(!$this->template = $this->site->getTemplate()) {
				Logger::addError('template_not_set', 'Brak szablonu strony');
				return false;
			}
		}
		if(!$this->template) {
			Logger::addError('template_loading', 'Nie udało się załadować szablonu strony.');
			return false;
		}
		//echo 'kurwa pierdolona mac';
		$this->template->fullPath = ADMINTHEMEPATH.$this->template->path;
		$this->checkExtends();
		//var_dump($this->template);
		//print_r($this->extends);
                
                //wczytanie konfiguracji rozszerzen
                foreach ($this->extends as $ext) {
                    $ext->getAsset();
                    $ext->getAsset($this->site->id,Site::$confType);
                    $ext->getAsset($this->template->id,Template::$confType);
                    //$config = $ext->getAssetValueByKey('config');
                }
		if($this->extends['smarty']){
                    $config = $this->extends['smarty']->getAssetValueByKey('config');
                    $this->parser =& Trigger::runTrigger('parser-setup',$config);
//                    print_r($config);
//                    print_r($this->parser);
		}
                
                $this->contents = $this->page->getContents();
                print_r($this->contents);
		$this->sections = $this->template->getSections();
                
                foreach($this->sections as $id => $sec) {
                    $sec->getAsset();
                }
		//print_r($sections);
		
		
		
		
		
		//var_dump($this->site);
		
		
		//$assetSmartyDef->setValue($confP);
		//$assetSmartyDef->save();

		//$this->sections
		
	}

	function render(){
		$this->loadSettings();
		
		echo $this->parseSection($this->sections[1]);
		
                print_r($this->parser->tpl_vars);
                
                
		if(Logger::getAllLogs()){
			print_r(Logger::getAllLogs());
		}
	}
	
	function parseSection(Section $section) {
		$content = 'BRAK WYNIKU '.$section->name;
		$varName = strtoupper($section->name);
                $contents = Content::getContentsBySectionId($section->id);
                foreach ($contents as $content) {
                    if(is_numeric($content->id) && !array_key_exists($content->id,$this->contents)) $this->contents[$content->id] = $content;
                    
                }
		if(is_array($section->sections)) {
			$content = '';
			foreach ($section->sections as $s){	
				$content .= $this->parseSection($s);
			}
		}
		//echo $varValue;
		
		Trigger::runTrigger('parser-register-value',$this->parser,$varName,$content);
		if($section->loadTemplate()){
			Logger::addSuccess('section_template_loaded', 'HTML sekcji '.$this->name.' załadowany');
			$content = Trigger::runTrigger('parser-fetch-string',$this->parser,$section->template);
		}
		return $content;
	}
	
	function renderSectionsInSection(Section $parentSection){
		//print_r($parentSection);
		$varName = strtoupper($parentSection->name);
		foreach ((array) $parentSection->sections as $k=>$s) {
			//print_r($s);
			$varValue = '';
			if($s->loadTemplate()){
				Logger::addSuccess('section_template_loaded', 'Szablon sekcji '.$this->name.' załadowany');
				//echo $s->template;
				$varValue .= Trigger::runTrigger('parser-fetch-string',$this->parser,$s->template);
				Trigger::runTrigger('parser-register-value',$this->parser,$varName,$varValue);
			}
		}
		
	}
	
	function renderSection($id){
		
	}

	function configCompare($confBase,$otherConf=array()) {
		if(!is_array($confBase) || !is_array($otherConf)) return false;
		if(count($otherConf)==0) return $confBase;
		foreach ($otherConf as $conf){

		}
	}

	function checkExtends(){
		$this->extends = $this->template->getExtensions();
		$sitExt = $this->site->getExtensions();
		foreach ($this->extends as $ext){

			if($sitExt[$ext->id]){
				if(!$sitExt[$ext->id]->enabled){
					Logger::addError('required_ext_'.$ext->name, 'Rozszerzenie: Id.'.$ext->id.' Name.'.$ext->name.' jest wyłączone');
				}
			} else Logger::addError('not_exists_ext_'.$ext->name, 'Rozszerzenie: Id.'.$ext->id.' Name.'.$ext->name.' nie jest dodane do rozszerzeń strony');
		}
	}

	function checkConfig(){

	}
}