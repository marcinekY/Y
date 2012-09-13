<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Film
 *
 * @author Ja
 */
class Film {
    private $db = null;
    private $smarty = null;
    private $templateVideoSmall = 'videoSmall.tpl';
    private $templateVideoBig = 'video.tpl';

    private $details = null;

    private $id;
    private $details_id;
    private $video;
    private $title;
    private $category;
    private $photo;
    private $views;
    private $rate;
    private $rate_count;
    
    function __construct() {
    }
    
    function getDetailsDB($r_id) {
        if(!is_null($this->db) && is_numeric($r_id)) {
            $sql = 'SELECT * FROM `red_details` WHERE `r_id`='.$r_id;
            if($item = $this->db->executeQueryString($sql)){
                $this->setObject($item[0]);
            }
        }
    }//e f
    
    function setObject($data){
        if($data['id']) $this->id = $data['id'];
        if($data['film']) $this->video = $data['film'];
        if($data['tytul']) $this->title = $data['tytul'];
        if($data['kategoria']) $this->category = $data['kategoria'];
        if($data['zdjecie']) $this->photo = $data['zdjecie'];
        if($data['details_id']) $this->details_id = $data['details_id'];
        if($data['rate']) $this->rate = $data['rate'];
        if($data['rate_count']) $this->rate_count = $data['rate_count'];
        if($data['views']) $this->views = $data['views'];
    }//e f
    
    function setDetails(){
        if(is_null($this->details) && is_numeric($this->id)) {
            $this->getDetailsDB($this->id);
            $this->details = 1;
        }
    }//e f
    
}//e class

?>
