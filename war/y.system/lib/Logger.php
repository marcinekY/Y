<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logger
 *
 * @author Ja
 */
class Logger {
    private static $logs;
    private static $errorType = 'ERROR';
    private static $successType = 'SUCCESS';

    function __construct() {
        self::$logs = array();
    }
    
    /**
     * 
     * @param boolean $type
     * @param type $name
     * @param type $value 
     */
    static function addLog($name,$value,$type) {
        if(!self::getLog($name)) self::$logs[$name] = new Log($name, $value, $type);
    }//end function
    static function addError($name,$error){
        self::addLog($name, $error, self::$errorType);
    }
    static function addSuccess($name,$success){
        self::addLog($name, $success, self::$successType);
    }
    static function getLog($name){
        if(self::$logs[$name]) return self::$logs[$name];
        return false;
    }//end function
    static function getAllLogs(){
        if(count(self::$logs)>0) return self::$logs;
        return false;
    }//end function
    
	static function getAllSuccess(){
        $r = array();
        foreach (self::$logs as $log) {
            if($log->getType()==self::$successType) $r[$log->getName()] = $log;
        }
        if(count($r)>0) return $r;
        return false;
    }
    
    static function getAllErrors(){
    	if(!is_array(self::$logs)) return false;
        $r = array();
        foreach (self::$logs as $log) {
            if($log->getType()==self::$errorType) $r[$log->getName()] = $log;
        }
        if(count($r)>0) return $r;
        return false;
    }
    
    static public function saveLogs(){
    	if(!class_exists('FileManagment')) return false;
    	foreach (self::$logs as $log){
    		$remoteAddress = $log->getRemoteAddress();
        	$requestUri = $log->getRequestUri();
        	$time = date("d/m/Y G:i:s",$log->getTime());
        	$type = strtoupper($log->getType());
        	$log = $remoteAddress.' ('.$type.')'.' - - ['.$time.'] ['.$operation.'] ['.$text.'] || request:'.$requestUri;
        	FileManagment::addLineInFile(BASICPATH.'log/LOG.log', $log);
    	}
    	return true;
    }
    
    static function clear(){
    	self::$logs = array();
    }
}

class Log {
    private $type;
    private $name;
    private $value;
    private $time;
    private $remoteAddress;
    private $requestUri;
    
    
    function __construct($name,$value,$type) {
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->time = time();
        $this->remoteAddress = $_SERVER['REMOTE_ADDR'];
        $this->requestUri = $_SERVER['REQUEST_URI'];
    }
    
    public function isSuccess(){
        return ($this->type=='SUCCESS'?true:false);
    }

    public function getTime(){
    	return $this->time;
    }
    
    public function getRemoteAddress() {
    	return $this->remoteAddress;
    }
    
    public function getRequestUri() {
    	return $this->requestUri;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }
}

?>
