<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Films
 *
 * @author Ja
 */
class Movies {
    public $db = null;
    private $movies = array();
    
    function __construct() {
        ;
    }
    
    function getMovieById($videoId) {
        if(is_null($this->db)) return false;
        $sql = 'SELECT * FROM `red` WHERE `id`=\''.$videoId.'\' ORDER BY id DESC LIMIT 1';
        if($items = $this->db->executeQueryString($sql)){
            $vDetails = $this->getDetails($items[0]['id']);
            $film = array_merge($items[0], (is_array($vDetails)?$vDetails:array()));
            $films = $this->setTitleToUrl(array($film));
//            print_r($films[0]);
            return $films[0];
        }
        return null;
    }
    
    function getMovie($videoCode) {
        if(is_null($this->db)) return false;
        $sql = 'SELECT * FROM `red` WHERE `film`=\''.$videoCode.'\' ORDER BY id DESC LIMIT 1';
        if($items = $this->db->executeQueryString($sql)){
            $vDetails = $this->getDetails($items[0]['id']);
            $movie = array_merge($items[0], (is_array($vDetails)?$vDetails:array()));
            $movies = $this->setTitleToUrl(array($movie));
//            print_r($films[0]);
            return $movies[0];
        }
        return null;
    }
    
    function getDetails($videoId){
        if(is_null($this->db)) return false;
        $sql = 'SELECT * FROM `red_details` WHERE `r_id`=\''.$videoId.'\' LIMIT 1';
            if(!$details = $this->db->executeQueryString($sql)) {
                $details['details_id'] = null;
                $details['rate'] = 0;
                $details['rate_count'] = 0;
                $details['views'] = 0;
                return $details;
            }
            return $details[0];
    }
    
    private function getUserRate($videoId,$ipAddress) {
        if(!is_numeric($videoId) || !filter_var($ipAddress, FILTER_VALIDATE_IP)) return false;
        $sql = 'SELECT * FROM `red_rate` WHERE `r_id`=\''.$videoId.'\' AND `user_ip`=\''.$ipAddress.'\'';
        if($rate = $this->db->executeQueryString($sql)) return $rate[0];
        return false;
    }
    
    function addUserRate($rate,$videoId){
        if(is_null($this->db)) return false;
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        if(!is_numeric($rate) || !is_numeric($videoId) || !filter_var($ipAddress, FILTER_VALIDATE_IP)) return false;
        if(is_numeric($rate) && ($rate>0 && $rate<6)){
            if(!$r = $this->getUserRate($videoId, $ipAddress)){ //user nigdy nie ocenial tego filmu na tej stronie
                $sql = 'INSERT INTO `red_rate`(`r_id`, `user_ip`, `rate`) VALUES (\''.$videoId.'\', \''.$ipAddress.'\', \''.$rate.'\')';
                if($insert = $this->db->addData($sql)){
                    $vDetail = $this->getDetails($videoId);
                    $allRates = $this->countRateFromDB($videoId);
                    if($vDetail['details_id']) {
                        //uaktualnij dodatkowe dane video
                        $sql = 'UPDATE `red_details` SET `rate`='.$allRates['rate'].',`rate_count`='.$allRates['count'].' WHERE `details_id`='.$vDetail['details_id'];
                        if($this->db->editData($sql)) return true;
                    } else {
                        //dodaj dodatkowe dane
                        $sql = 'INSERT INTO `red_details`(`r_id`, `rate`, `rate_count`, `views`) VALUES (\''.$videoId.'\',\''.$allRates['rate'].'\',\''.$allRates['count'].'\',\''.$vDetail['views'].'\')';
                        if($this->db->addData($sql)) return true;
//                    echo 'insert re_details'.  var_dump($insert).'<hr>';
                    }
                }
            }
        }
        return false;
    }
    
    private function countRateFromDB($videoId){
        $sql = 'SELECT SUM(rate) as sum, COUNT(rate) as count FROM `red_rate` WHERE `r_id`=\''.$videoId.'\'';
        if(!$data = $this->db->executeQueryString($sql)){
            $data['suma'] = 0;
            $data['count'] = 0;
        } else $data = $data[0];
        $data['rate'] = round($data['sum']/$data['count'],1);
        return $data;
    }
    
    function addVisit($videoId) {
        if(is_null($this->db)) return false;
        if(is_array($_SESSION['views'])) if(in_array($videoId, $_SESSION['views'])) return;
        if($vDetail = $this->getDetails($videoId)){
            print_r($vDetail);
            if($vDetail['details_id']){
                $sql = 'UPDATE `red_details` SET `views`='.++$vDetail['views'].' WHERE `details_id`='.$vDetail['details_id'];
            } else {
                $sql = 'INSERT INTO `red_details`(`r_id`, `rate`, `rate_count`, `views`) VALUES (\''.$videoId.'\',\''.$allRates['rate'].'\',\''.$allRates['count'].'\',\''.++$vDetail['views'].'\')';
            }
            if(is_string($sql)) {
                if($this->db->addData($sql)){
                    $_SESSION['views'][] = $videoId;
                    return true;
                }
            }
        }
        return false;
    }
    
    function getMoviesAndSortByDetailsTableKey($sortKey,$categoryOrginal=null){
        if(is_null($this->db)) return false;
        $sql = 'SELECT r.id, r.film, r.tytul, r.kategoria, r.zdjecie, rd.rate, rd.rate_count, rd.views FROM red as r LEFT JOIN red_details as rd on (r.id = rd.r_id) '.(!is_null($categoryOrginal)?'WHERE `r`.`kategoria` = \''.$categoryOrginal.'\'':'').' ORDER BY `rd`.`'.$sortKey.'` DESC';
        $this->movies = array();
        if($items = $this->db->executeQueryString($sql)){
//            print_r($items);
            $this->movies = $items;
        }
        return $this->movies;
    }
    
    function getMoviesByCategory($categoryOrginal){
        if(is_null($this->db)) return false;
        $sql = 'SELECT * FROM `red` WHERE `kategoria`=\''.$categoryOrginal.'\'';
        $this->movies = array();
        if($items = $this->db->executeQueryString($sql)){
            $this->movies = $items;
        }
        return $this->movies;
    }
    
    function getMovies(){
        if(is_null($this->db)) return false;
        $sql = 'SELECT * FROM `red`';
        $this->movies = array();
        if($items = $this->db->executeQueryString($sql)){
            $this->movies = $items;
        }
        return $this->movies;
    }
    
    function setTitleToUrl($movies){
        if(is_array($movies)){
            foreach($movies as $k=>$f){
                if($f['tytul']) $movies[$k]['tytul_url'] = preg_replace("'\s+'", '-', $f['tytul']);
            }
        }
        return $movies;
    }
}

?>
