<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of URL
 *
 * @author Ja
 */
class URL {
    private $urlArr;
    
    function getURL($set=null,$removeKeys=null){
        $url = $this->urlArr;
        if(!is_array($url)) $url = array();
        if(!is_array($set)) $set = array();
        if(!is_array($remove)) $removeKeys = array();
        foreach($url as $vName=>$v){
            if(in_array($vName, $removeKeys)) unset($url[$vName]);
        }
        foreach ($set as $k=>$v) {
            $url[$k] = $v;
        }
        return implode('/', $url);
    }
    
    public function getUrlArray() {
        return $this->urlArr;
    }

    public function setUrlArray($urlArr) {
        $this->urlArr = $urlArr;
    }
}

?>
