<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Place
 *
 * @author Marcinek
 */
class Data {
    private $dir = null;
    private $fileName = null;
    private $name = null;
    private $data = null;


    public function __construct($dir, $name) {
        $this->setDir($dir);
        $this->setName($name);
        $this->setFileName($name.'.php');
        $this->init();
    }

    public function init(){
        if(!is_file($this->getDir().$this->getFileName())) return false;
        include_once $this->getDir().$this->getFileName();
        if($objData) $this->setData($objData);
    }

    public function getDir() {
        return $this->dir;
    }

    public function setDir($dir) {
        $this->dir = $dir;
    }

    public function getFileName() {
        return $this->fileName;
    }

    public function setFileName($fileName) {
        $this->fileName = $fileName;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }
}
?>
