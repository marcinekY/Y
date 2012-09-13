<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Error
 *
 * @author Ja
 */
class Error {
    private $error = array();

    function setError($error_name,$error) {
            $this->error[$error_name] = $error;
    }//end function
    function getError($error_name){
            if($this->error[$error_name]) return $this->error[$error_name];
            return false;
    }//end function
    function getAllErrors(){
            if(count($this->error)>0) return $this->error;
            return false;
    }//end function
}

?>
