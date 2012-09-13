<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Pagination
 *
 * @author Ja
 */
class Pagination {
    private $pages = array();
    private $itemsPerSite = 20;
    private $arr = array();
    private $paginationDetails = array();
    
    function __construct() {
        $this->paginationDetails['current'] = 0;
    }

    function cutArray($arr){
        if(is_array($arr)){
            $this->pages = array_chunk($arr, $this->itemsPerSite);
        }
    }
    
    function getPaginationDetails() {
        $this->paginationDetails['count'] = count($this->pages);
        $this->paginationDetails['currentItems'] = $this->pages[$this->paginationDetails['current']];
        return $this->paginationDetails;
    }
    
    function getSiteItems($site=null) {
        if(is_numeric($site)) {
            $this->paginationDetails['current'] = $site;
        }
        if($this->pages[$this->paginationDetails['current']]) return $this->pages[$this->paginationDetails['current']];
        return false;
    }
    
    function setItemsPerSite($i) {
        if(is_numeric($i)) $this->itemsPerSite = $i;
    }
}
?>
