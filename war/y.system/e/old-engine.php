<?php
$e_config = array(
    'smarty' => array(
        'name' => 'Smarty',
        'path' => ''
    ),
    'mysql' => 'MySql',
);

$exeClass = new ExeClass($e_config);

$tmp = $exeClass->includeClassByName('mysql');


if(is_array($e_config)){
    foreach($e_config as $k=>$class){
        
    }
}

class ExeClass {
    private $exe_class;
    private $config;
    
    function __construct($config) {
        $this->config = $config;
        $this->exe_class = $this->setClass();
    }//e f
    
    function includeClassByName($name) {
        if($this->exe_class[$name]){
            if(is_file($this->exe_class[$name])) {
                include_once $this->exe_class[$name];
                if(class_exists($name)){
                    return new $this->config[$class_name];
                }
            }
        }
    }//e f
    
    function getClassPathByName($name) {
        if($this->exe_class[$name]){
            return $this->exe_class[$name];
        }
    }//e f
    
    private function setClass() {
        $exe_class = array();
        $files = new DirectoryIterator(E.'exe_class');
        foreach($files as $f){
            if($f->isFile()){
                $tmp = explode('.', $f->getFilename());
                $exe_class[$tmp[0]] = $f->getPath();
            }
        }
        return $exe_class;
    }//e f
}//e c



function exe_class($class){
    
}//e f

?>
