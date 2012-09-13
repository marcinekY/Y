<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Anonse
 *
 * @author Ja
 */


class Anonse {
    public $db = null;
    private $ads;
    public $tableName = 'tb_anons';
    public $photosTableName = 'tb_zdjecia';
    public $cities;
    public $categories;


    function __construct() {
    }//e f
    
    function getAllIds(){
        if(is_null($this->db)) return false;
        $ids = array();
        if($items = $this->db->getData($this->tableName,$reserve,null,$order,$limit)){
            foreach ($items as $data) {
                $ids[] = $data['id'];
            }
        }
        return $ids;
    }
    
    function getAnonse($reserve,$limit=null,$order=null){
        if(is_null($this->db)) return false;

        $this->ads = array();
        if($items = $this->db->getData($this->tableName,$reserve,null,$order,$limit)){
            foreach ($items as $anonsData) {
                $anons = new Anons($anonsData);
                $anons = $this->addOtherData($anons);
                $this->ads[$anonsData['id']] = $anons;
            }
        }
        return $this->ads;
    }
    
    function getAnonsById($id){
        foreach ($this->ads as $a) {
            if($a->getId()==$id) return $a;
        }
        if(is_null($this->db) || !is_numeric($id)) return false;
        $sql = 'SELECT * FROM `'.$this->tableName.'` WHERE `id`='.$id;
        if($items = $this->db->executeQueryString($sql)){
            $anons = new Anons($items[0]);
            $anons = $this->addOtherData($anons);
            return $anons;
        }
        return false;
    }
    
    function getAnonsByAlias($alias){
        foreach ($this->ads as $a) {
            if($a->getAlias()==$alias) return $a;
        }
        
        if(is_null($this->db)) return false;
        $sql = 'SELECT * FROM `'.$this->tableName.'` WHERE `alias`='.$alias;
        if($items = $this->db->executeQueryString($sql)){
            $anons = new Anons($items[0]);
            $anons = $this->addOtherData($anons);
            return $anons;
        }
        return false;
    }
    
    private function addOtherData(Anons $anons){
        if(is_null($this->db)) return false;
        if($anons->hasPhoto()){
            $sql = 'SELECT * FROM `'.$this->photosTableName.'` WHERE `item_id`='.$anons->getId();
            if($items = $this->db->executeQueryString($sql)){
                foreach ($items as $zdjecie) {
                    $anons->addPhoto(new Photo($zdjecie));
                }
            }
        }
        if(!is_null($this->cities)){
            $anons->setCity($this->cities->getCityById($anons->getCityId()));
        }
        if(!is_null($this->categories)){
            $anons->setCategory($this->categories->getCategoryById($anons->getCategoryId()));
        }
        return $anons;
    }
    
    public function addVisit($id){
        if($_SESSION['v'.$id]) return false;
        if(is_null($this->db)) return false;
        
        $sql = 'UPDATE `'.$this->tableName.'` SET `visit_count` = visit_count + 1 WHERE `id`='.$id;
        if($this->db->editData($sql)){
            $_SESSION['v'.$id] = time();
            return true;
        }
    }
    
    public function delPhoto($photo){
        if(is_a($photo, 'Photo')){
            $sql = 'DELETE FROM `'.$this->photosTableName.'` WHERE `id`=\''.$photo->getId().'\'';
            if($this->db->delData($sql)){
                @unlink($photo->getUrl());
                $sql = 'SELECT * FROM `'.$this->photosTableName.'` WHERE `item_id`=\''.$photo->getItemId().'\'';
                if(!$item = $this->db->exequteQueryString($sql)){
                    $sql = 'UPDATE `'.$this->tableName.'` SET `zdjecia`=NULL WHERE `id`=\''.$photo->getItemId().'\'';
                    $this->db->editData($sql);
                }
                return true;
            }
        }
        return false;
    }

    public function createThumbs($zdjecie) {
        foreach($zdjecia as $key=>$zdjecie){
            $zdjecie['big']['url'] = FileManagment::createThumb($zdjecie['url'],800);
            $zdjecie['big']['name'] = FileManagment::getFileNameFromUrl($zdjecie['big']['url']);
            $zdjecie['big']['size'] = FileManagment::getImageSize($zdjecie['big']['url']);
            $zdjecie['small']['url'] = FileManagment::croppedThumbnail($zdjecie['url'],$this->getPhotoDir().'th[140x280]'.$zdjecie['zdjecie'],140,280);
            $zdjecie['small']['name'] = FileManagment::getFileNameFromUrl($zdjecie['small']['url']);
            $zdjecie['kadr']['url'] = FileManagment::croppedThumbnail($zdjecie['url'],$this->getPhotoDir().'th[137x137]'.$zdjecie['zdjecie'],137,137);
            $zdjecie['kadr']['name'] = FileManagment::getFileNameFromUrl($zdjecie['kadr']['url']);
            $zdjecie['name'] = $zdjecie['name'];
            $zdjecie['url'] = $zdjecie['url'];
        }
        return $zdjecie;
    }//end function
    
    public function getCities() {
        return $this->cities;
    }

    public function setCities(Cities $cities) {
        $this->cities = $cities;
    }

    public function getCategories() {
        return $this->categories;
    }

    public function setCategories($categories) {
        $this->categories = $categories;
    }
}

class Photo {
    private $id;
    private $name;
    private $url;
    private $itemId;
    private $type;
    
    function __construct($DBObjData) {
        $this->setObjFromDBArray($DBObjData);
    }
    
    function setObjFromDBArray($arr){
        if(is_array($arr)){
            if($arr['id']) $this->id = $arr['id'];
            if($arr['name']) $this->name = $arr['name'];
            if($arr['url']) $this->url = $arr['url'];
            if($arr['item_id']) $this->itemId = $arr['item_id'];
            if($arr['type']) $this->type = $arr['type'];
        }
    }
    
    function getDBArray(){
        $r = array();
        if(!is_null($this->id)) $r['id'] = $this->id;
        if(!is_null($this->name)) $r['name'] = $this->name;
        if(!is_null($this->url)) $r['url'] = $this->url;
        if(!is_null($this->itemId)) $r['item_id'] = $this->itemId;
        if(!is_null($this->type)) $r['type'] = $this->type;
        return $r;
    }
    
    function getObjArray(){
        $r = array();
        if(!is_null($this->id)) $r['id'] = $this->id;
        if(!is_null($this->name)) $r['name'] = $this->name;
        if(!is_null($this->url)) $r['url'] = $this->url;
        if(!is_null($this->itemId)) $r['itemId'] = $this->itemId;
        if(!is_null($this->type)) $r['type'] = $this->type;
        return $r;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }
    
    public function getItemId() {
        return $this->itemId;
    }

    public function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }
}


class Anons {
    private $id;
    private $alias;
    private $categoryId;
    private $category;
    private $userId;
    private $cityId;
    private $provinceId;
    private $city;
    private $title;
    private $name;
    private $description;
    private $hasPhoto = null;
    private $photos = array();
    private $email;
    private $tel;
    private $gg;
    private $status;
    private $moderation = null;
    private $visit;
    private $ip;
    private $hash;
    private $added;
    
    function __construct($DBObjdata) {
        $this->setObjFromDBArray($DBObjdata);
    }
    
    function addPhoto(Photo $photo){
        foreach ($this->photos as $zdj) {
            if($zdj==$photo) return;
        }
        $this->photos[] = $photo;
        $this->hasPhoto = true;
    }
    
    function getPhotoByUrl($url){
        foreach($this->photos as $zdj){
            if($zdj->getUrl()==$url) return $zdj;
        }
        return false;
    }
    
    function setObjFromDBArray($arr){
        if(is_array($arr)){
            if($arr['id']) $this->id = $arr['id'];
            if($arr['alias']) $this->alias = $arr['alias'];
            if($arr['k_id']) $this->categoryId = $arr['k_id'];
            if($arr['u_id']) $this->userId = $arr['u_id'];
            if($arr['m_id']) $this->cityId = $arr['m_id'];
            if($arr['w_id']) $this->provinceId = $arr['w_id'];
            if($arr['tytul']) $this->title = $arr['tytul'];
            if($arr['name']) $this->name = $arr['name'];
            if($arr['opis']) $this->description = $arr['opis'];
            if($arr['zdjecia']) $this->hasPhoto = $arr['zdjecia'];
            if($arr['email']) $this->email = $arr['email'];
            if($arr['tel']) $this->tel = $arr['tel'];
            if($arr['gg']) $this->gg = $arr['gg'];
            if($arr['status']) $this->status = $arr['status'];
            if($arr['do_moderacji']) $this->moderation = $arr['do_moderacji'];
            if($arr['visit_count']) $this->visit = $arr['visit_count'];
            if($arr['ip']) $this->ip = $arr['ip'];
            if($arr['hash']) $this->hash = $arr['hash'];
            if($arr['dodano']) $this->added = $arr['dodano'];
        }
    }
    
    function getDBArray(){
        $r = array();
        if(!is_null($this->id)) $r['id'] = $this->id;
        if(!is_null($this->alias)) $r['alias'] = $this->alias;
        if(!is_null($this->categoryId)) $r['k_id'] = $this->categoryId;
        if(!is_null($this->userId)) $r['u_id'] = $this->userId;
        if(!is_null($this->cityId)) $r['m_id'] = $this->cityId;
        if(!is_null($this->provinceId)) $r['w_id'] = $this->provinceId;
        if(!is_null($this->title)) $r['tytul'] = $this->title;
        if(!is_null($this->name)) $r['name'] = $this->name;
        if(!is_null($this->description)) $r['opis'] = $this->description;
        if(!is_null($this->hasPhoto)) $r['zdjecia'] = 1;
        if(!is_null($this->email)) $r['email'] = $this->email;
        if(!is_null($this->tel)) $r['tel'] = $this->tel;
        if(!is_null($this->gg)) $r['gg'] = $this->gg;
        if(!is_null($this->status)) $r['status'] = $this->status;
        if(!is_null($this->moderation)) $r['do_moderacji'] = $this->moderation;
        if(!is_null($this->visit)) $r['visit_count'] = $this->visit;
        if(!is_null($this->ip)) $r['ip'] = $this->ip;
        if(!is_null($this->hash)) $r['hash'] = $this->hash;
        if(!is_null($this->added)) $r['dodano'] = $this->added;
        return $r;
    }
    
    function getObjArray(){
        $r = array();
        if(!is_null($this->id)) $r['id'] = $this->id;
        if(!is_null($this->alias)) $r['alias'] = $this->alias;
        if(!is_null($this->categoryId)) $r['categoryId'] = $this->categoryId;
        if(!is_null($this->userId)) $r['userId'] = $this->userId;
        if(!is_null($this->cityId)) $r['cityId'] = $this->cityId;
        if(!is_null($this->provinceId)) $r['provinceId'] = $this->provinceId;
        if(!is_null($this->title)) $r['title'] = $this->title;
        if(!is_null($this->name)) $r['name'] = $this->name;
        if(!is_null($this->description)) $r['description'] = $this->description;
        if(!is_null($this->hasPhoto)) $r['photos'] = ($this->hasPhoto?1:null);
        if(!is_null($this->email)) $r['email'] = $this->email;
        if(!is_null($this->tel)) $r['tel'] = $this->tel;
        if(!is_null($this->gg)) $r['gg'] = $this->gg;
        if(!is_null($this->status)) $r['opis'] = $this->status;
        if(!is_null($this->moderation)) $r['moderation'] = ($this->moderation?1:null);
        if(!is_null($this->visit)) $r['visit_count'] = $this->visit;
        if(!is_null($this->ip)) $r['ip'] = $this->ip;
        if(!is_null($this->hash)) $r['hash'] = $this->hash;
        if(!is_null($this->added)) $r['dodano'] = $this->added;
        return $r;
    }
    
    public function isActive(){
        if($this->status!=-1 && is_null($this->moderation)) return true;
        return false;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function setAlias($alias) {
        $this->alias = $alias;
    }
    
    public function getCategoryId() {
        return $this->categoryId;
    }

    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }
    
    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getCityId() {
        return $this->cityId;
    }

    public function setCityId($cityId) {
        $this->cityId = $cityId;
    }

    public function getProvinceId() {
        return $this->provinceId;
    }

    public function setProvinceId($provinceId) {
        $this->provinceId = $provinceId;
    }
    
    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
    
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function hasPhoto() {
        return (is_null($this->hasPhoto)?false:true);
    }

    public function setHasPhoto($hasPhoto) {
        $this->hasPhoto = $hasPhoto;
    }

    public function getPhotos() {
        return $this->photos;
    }

    public function setPhotos($photos) {
        $this->photos = $photos;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getTel() {
        return $this->tel;
    }

    public function setTel($tel) {
        $this->tel = $tel;
    }

    public function getGg() {
        return $this->gg;
    }

    public function setGg($gg) {
        $this->gg = $gg;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getModeration() {
        return $this->moderation;
    }

    public function setModeration($moderation) {
        $this->moderation = $moderation;
    }

    public function getVisit() {
        return $this->visit;
    }

    public function setVisit($visit) {
        $this->visit = $visit;
    }

    public function getHash() {
        return $this->hash;
    }

    public function setHash($hash) {
        $this->hash = $hash;
    }

    public function getIp() {
        return $this->ip;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }

    public function getAdded() {
        return $this->added;
    }

    public function setAdded($added) {
        $this->added = $added;
    }


}

?>
