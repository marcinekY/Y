<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'Data.php';

/**
 * Description of PlaceManager
 *
 * @author Marcinek
 */
class DataManager {
    private $dataArray = array();
    private $dir = 'usrdir/';


    public function __construct() {
    }

    public function addData($dir,$name){
        if($dir!=null && !empty($name)) {
            $d = new Data($dir,$name);
//            print_r($d);
            if(!is_null($d) && $d->getData()!=null){
                LOG::saveLog('GETDATA:'.$name, 'add data to array', 'success');
                $this->dataArray[] = $d;
                return true;
            }
        }
        LOG::saveLog('GETDATA:'.$name, 'data "'.$name.'" not exists', 'error');
        return false;
    }
    
    public function addDataObject($dataObj){
        if(!is_a($dataObj, Data)) {           
            if($dataObj->getData()!=null){
                $this->dataArray[] = $dataObj;
                return true;
            }
        }
        return false;
    }

    public function getDataArray(){
        return $this->dataArray;
    }

    public function getNamedArray() {
        $r = array();
        foreach($this->dataArray as $data){
            $r[$data->getName()] = $data->getData();
//            $r[] = array(
//                'name' => $place->getName(),
//                'data' => $place->getData()
//            );
        }
        return $r;
    }

    public function getDir() {
        return $this->dir;
    }

    public function setDir($dir) {
        $this->dir = $dir;
    }


}
?>