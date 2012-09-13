<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Miasta
 *
 * @author Ja
 */
class Cities {
    public $db = null;
    private $cities = array();
    private $tableName = 'tb_miasto';
    
    function __construct() {
    }//e f
    
    function getCityById($id){
        if($this->cities[$id]) return $this->cities[$id];
    }
    
    function getAllProvinces(){
        $provinces = array();
        foreach ($this->cities as $city) {
            if($provinces[$city->getProvinceId()]) continue;
            $provinces[$city->getProvinceId()] = $city;
        }
        return $provinces;
    }
    
    function getCitiesByProvinceId($provinceId){
        $r = array();
        foreach ($this->cities as $city) {
            if($city->getProvinceId()==$provinceId) $r[] = $city;
        }
        return $r;
    }//e f
    
    function getAll(){
        return $this->cities;
    }
    
    function getProvinceByName($name){
        if(is_null($this->db)) return false;
        
        $sql = 'SELECT * FROM tb_wojewodztwo WHERE `name` = \''.$name.'\'';
        if($items = $this->db->executeQueryString($sql)){
            return new Province($items[0]);
        }
        return false;
    }
    
    function setAll(){
        if(is_null($this->db)) return false;
        
        $sql = 'SELECT m.id AS m_id, w.id AS w_id, m.name AS m_name, w.name AS w_name FROM tb_miasto AS m, tb_wojewodztwo AS w WHERE m.wid = w.id ORDER BY w.name ASC';
        $this->cities = array();
        if($items = $this->db->executeQueryString($sql)){
            foreach ($items as $city) {
                $this->cities[$city['m_id']] = new City($city);
            }
        }
        return $this->cities;
    }//e f
}

class City {
    private $provinceId;
    private $province;
    private $cityId;
    private $city;
    
    function __construct($DBObjData) {
        $this->setObjFromDBArray($DBObjData);
    }
    
    function setObjFromDBArray($arr){
        if(is_array($arr)){
            if($arr['m_id']) $this->cityId = $arr['m_id'];
            if($arr['w_id']) $this->provinceId = $arr['w_id'];
            if($arr['w_name']) $this->province = $arr['w_name'];
            if($arr['m_name']) $this->city = $arr['m_name'];
        }
    }
    
    public function getProvinceId() {
        return $this->provinceId;
    }

    public function setProvinceId($provinceId) {
        $this->provinceId = $provinceId;
    }

    public function getProvince() {
        return $this->province;
    }

    public function setProvince($province) {
        $this->province = $province;
    }

    public function getCityId() {
        return $this->cityId;
    }

    public function setCityId($cityId) {
        $this->cityId = $cityId;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }
}

class Province {
    private $provinceId;
    private $province;
    
    function __construct($DBObjData) {
        $this->setObjFromDBArray($DBObjData);
    }
    
    function setObjFromDBArray($arr){
        if(is_array($arr)){
            if($arr['id']) $this->provinceId = $arr['id'];
            if($arr['name']) $this->province = $arr['name'];
        }
    }
    
    public function getProvinceId() {
        return $this->provinceId;
    }

    public function setProvinceId($provinceId) {
        $this->provinceId = $provinceId;
    }

    public function getProvince() {
        return $this->province;
    }

    public function setProvince($province) {
        $this->province = $province;
    }
}

?>
