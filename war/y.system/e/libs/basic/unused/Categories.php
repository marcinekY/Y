<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Categories
 *
 * @author Ja
 */
class Categories {
    public $db = null;
    private $categories = array();
    private $tableName = 'tb_kategoria';
    
    function __construct() {
    }//e f
    
    function getCategoryById($id){
        if($this->categories[$id]) return $this->categories[$id];
    }
    
    
    function getCategoryByAlias($alias){
        foreach ($this->categories as $cat) {
            if($cat->getAlias()==$alias) return $cat;
        }
        
        if(is_null($this->db)) return false;
        $sql = 'SELECT * FROM `'.$this->tableName.'` WHERE `alias`=\''.$alias.'\'';
        if($items = $this->db->executeQueryString($sql)){
            return new Category($items[0]);
        }
        return false;
    }//e f
    
    function getCategoriesByParentId($parentId){
        if(is_null($this->db)) return false;
        $r = array();
        $sql = 'SELECT * FROM `'.$this->tableName.'` WHERE `prod_id`=\''.$parentId.'\'';
        if($items = $this->db->executeQueryString($sql)){
            foreach ($items as $item) {
                $r[] = new Category($item);
            }
            return $r;
        }
    }
    
    function getAll(){
        return $this->categories;
    }
    
    function setAll(){
        if(is_null($this->db)) return false;
        $sql = 'SELECT * FROM `'.$this->tableName.'` ORDER BY `order` ASC';
        $this->categories = array();
        if($items = $this->db->executeQueryString($sql)){
            foreach ($items as $categoryData) {
                $this->categories[$categoryData['id']] = new Category($categoryData);
            }
        }
        return $this->categories;
    }//e f
    
    function getAllObjArray(){
        $all = $this->getAll();
        $r = array();
        foreach ($r as $value) {
            
        }
    }
    
    function getCategoryHierarchy(){
        $all = $this->getAllCategories();
        $r = array();
        $ids = array();
        if(is_array($all)){
            foreach ($all as $category){
                if(in_array($category->getId(), $ids)) continue;
                if(!is_null($category->getParent())){
                    $parentId = $category->getParent();
                    foreach($r as $k=>$cat){
                        if($cat->getId()==$parentId) {
                            $r[$k]->addChild($cat);
                            $ids[] = $cat->getId();
                        }
                    }
                    if(!in_array($category->getId(), $ids)){
                        $parentCat = $this->getCategoryById($parentId);
                        
                    }
//                    $parent = $this->get
                }
            }
        }
    }
    
}//e c


class Category {
    private $id;
    private $name;
    private $opis;
    private $tytul;
    private $parent;
    private $alias;
    private $order;
    private $status;
    private $children = array();
    
    function __construct($DBObjdata) {
        $this->setObjFromDBArray($DBObjdata);
    }
    
    function setObjFromDBArray($arr){
        if(is_array($arr)){
            if($arr['id']) $this->setId ($arr['id']);
            if($arr['name']) $this->setName ($arr['name']);
            if($arr['opis']) $this->setOpis ($arr['opis']);
            if($arr['tytul']) $this->setTytul ($arr['tytul']);
            if($arr['prod_id']) $this->setParent ($arr['prod_id']);
            if($arr['alias']) $this->setAlias ($arr['alias']);
            if($arr['order']) $this->setOrder ($arr['order']);
            if($arr['status']) $this->setStatus ($arr['status']);
        }
    }
    
    function getDBArray(){
        $r = array();
        if(!is_null($this->id)) $r['id'] = $this->id;
        if(!is_null($this->name)) $r['name'] = $this->name;
        if(!is_null($this->opis)) $r['opis'] = $this->opis;
        if(!is_null($this->tytul)) $r['tytul'] = $this->tytul;
        if(!is_null($this->parent)) $r['prod_id'] = $this->parent;
        if(!is_null($this->alias)) $r['alias'] = $this->alias;
        if(!is_null($this->order)) $r['order'] = $this->order;
        if(!is_null($this->status)) $r['status'] = $this->status;
        return $r;
    }
    
    function getObjArray(){
        $r = array();
        if(!is_null($this->id)) $r['id'] = $this->id;
        if(!is_null($this->name)) $r['name'] = $this->name;
        if(!is_null($this->opis)) $r['opis'] = $this->opis;
        if(!is_null($this->tytul)) $r['tytul'] = $this->tytul;
        if(!is_null($this->parent)) $r['parent'] = $this->parent;
        if(!is_null($this->alias)) $r['alias'] = $this->alias;
        if(!is_null($this->order)) $r['order'] = $this->order;
        if(!is_null($this->status)) $r['status'] = $this->status;
        if(count($this->children)>0) {
            foreach ($this->children as $child) {
                $r['children'][] = $child->getObjArray();
            }
        }
        return $r;
    }
    
    function addChild(Category $child){
        if(!$this->getChild($child->getId())) return;
        $this->children[] = $child;
    }
    
    function getChild($id){
        foreach ($this->children as $child) {
            if($child->getId()==$id) return $child;
        } 
        return false;
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

    public function getOpis() {
        return $this->opis;
    }

    public function setOpis($opis) {
        $this->opis = $opis;
    }

    public function getTytul() {
        return $this->tytul;
    }

    public function setTytul($tytul) {
        $this->tytul = $tytul;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function setAlias($alias) {
        $this->alias = $alias;
    }
    
    public function getOrder() {
        return $this->order;
    }

    public function setOrder($order) {
        $this->order = $order;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
}

?>
