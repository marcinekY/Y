<?php

/**
 * klasa statyczna MySQL
 *
 * @author Marcinek
 */
class MySQL {
    private static $db;
    private static $showQueryStrings = true;
    private static $showResponseArray = false;
    private static $dbName;
    private static $dbUser;
    private static $dbPassword;
    private static $dbHost = 'localhost';
    private static $dbEncoding;

    public function __construct(){}
    /*
    public function  __construct($baza=null, $baza_uzytkownik=null, $baza_haslo=null, $baza_dns='localhost', $kodowanie=null) {
        if(!is_null($baza) && !is_null($baza_uzytkownik) && !is_null($baza_haslo)) {
            $this->connect($baza, $baza_uzytkownik, $baza_haslo, $baza_dns, $kodowanie);
        } elseif(is_file(E.'/libs/db/dbConfig.php')) {
            include_once E.'/libs/db/dbConfig.php';
            
            $this->db = $this->connect($dbConf['db_name'], $dbConf['db_user'], $dbConf['db_pass'], $dbConf['db_dns'], $dbConf['db_coding']);
        }
    }//ef
    */

    public static function connect(){
        if(is_null(self::$dbName) || is_null(self::$dbUser) || is_null(self::$dbPassword) || is_null(self::$dbHost)) return false;
        //die ("mysql:host=$baza_dns;dbname=$baza;port=2086"."$baza_uzytkownik"."$baza_haslo");

        if(is_null(self::$dbEncoding)) self::$dbEncoding = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        try {
            self::$db = new PDO('mysql:host='.self::$dbHost.';dbname='.self::$dbName.';port=3306',self::$dbUser,self::$dbPassword, self::$dbEncoding);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo 'DB Error!';
        }
        return self::$db;
    }//ef
    
    public static function dbQuery($query) {
    	if(is_null(self::$db) || $query==false || is_null($query)) return false;
    	if(self::$showQueryStrings) echo $query." <br>\r\n";
    	try {
    		$r = self::$db->query($query);
    	} catch (PDOException $e){
    		Logger::addError('DBQuery', $e->__toString());
    		Logger::saveLogs();
    		return false;
    	}
    	return $r;
    }
    
    /**
     * zwraca wynik zapytania SELECT
     * @param string $query - zapytanie
     * @param boolean $all - jesli true, funkcja zwraca wszystkie rekordy; standardowo zwracany jest jeden rekord
     * @return mixed 
     */
    public static function getRow($query,$all=false) {
    	if($q = self::dbQuery($query)){
    		if($all) return $q->fetchAll(PDO::FETCH_NAMED);
    		return $q->fetch(PDO::FETCH_ASSOC);
    	}
    	return false;
    }

    public static function getData($tableName, $reserve, $select=null, $order=null, $limit=null) {
        if(is_null($select)) $select = '*';
        else $select = '`'.implode('`, `',$select).'`';
        if(!is_null($order)) {
            $order = explode('.',$order);
            $method = array('ASC','DESC');
            $order = ' ORDER BY `'.$order[0].'` '.$method[$order[1]];
        }
        $reserve = self::processReserve($reserve);
        $q = 'SELECT '.$select.' FROM `'.$tableName.'`'.($reserve?' WHERE '.$reserve:'').$order.($limit?' LIMIT '.$limit:'');
        if(self::$showQueryStrings) echo $query." <br>\r\n";
        if($r = self::getRow($q,true)) {
        	if(self::$showResponseArray) print_r($r);
        	return $r;
        }
        return false;
    }    

    public static function addData($tableName,$arr){
        if(is_string($tableName) && is_array($arr)) {
            foreach($arr as $key => $value){
                $vars[] = '`'.$key.'`';
                $values[] = '\''.$value.'\'';
            }
            $q  = 'INSERT INTO `'.$tableName.'` ('.implode(', ',$vars).') VALUES ('.implode(', ',$values).')';
            if(self::$showQueryStrings) echo $query." <br>\r\n";
            if(self::dbQuery($q)) return true;
            else return false;
        }
        return false;
    }//end function
    
    public static function replaceData($tableName,$reserve,$edit) {
    	echo $tableName;
    	if(is_string($tableName) && is_array($edit)) {
    		foreach($edit as $key => $value){
                $set[] = '`'.$key.'` = \''.$value.'\'';
            }
    		echo $reserve = self::processReserve($reserve);
    		$q  = 'REPLACE INTO `'.$tableName.'` SET '.implode(', ',$set).' '.($reserve?' WHERE '.$reserve:'');
    		if(self::$showQueryStrings) echo $query." <br>\r\n";
    		if(self::dbQuery($q)) return true;
    		else return false;
    	}
    	return false;
    }

    public static function editData($tableName,$reserve,$edit){
	if(is_string($tableName) && is_array($edit)) {
            foreach($edit as $key => $value){
                $set[] = '`'.$key.'` = \''.$value.'\'';
            }
            $reserve = self::processReserve($reserve);
            $q = 'UPDATE `'.$tableName.'` SET '.implode(', ',$set).' '.($reserve?' WHERE '.$reserve:'');
            if(self::$showQueryStrings) echo $query." <br>\r\n";
            if(self::dbQuery($q)) return true;
            else return false;
	}
	return false;
    }//end function

    public function delData($tableName,$reserve){
        if(is_string($tableName) && is_array($reserve)) {
            $reserve = self::processReserve($reserve);
            $q = 'DELETE FROM `'.$tableName.'` WHERE '.$reserve;
            if(self::$showQueryStrings) echo $query." <br>\r\n";
            if(self::dbQuery($q)) return true;
            else return false;
        }
        return false;
    }//end function
    
    private static function processReserve($reserve){
        $set = array();
        if(is_array($reserve)){
            foreach($reserve as $key => $value){
                if(is_array($value))
                    //w drugim polu tablicy $value element np LIKE
                    if(strtoupper($value[1])=='BETWEEN' && is_array($value[0])){
                        $set[] = '`'.$key.'` '.strtoupper($value[1]).' '.$value[0][0].' AND '.$value[0][1];
                    } else {
                        $setOr = array();
                        foreach($value as $v){
                            $setOr[] = '`'.$key.'` = \''.$v.'\'';
                        }
                        if(count($setOr)>0) $set[] = '('.implode(') OR (', $setOr).')';
                        else $set[] = '`'.$key.'` '.strtoupper($value[1]).' \''.$value[0].'\'';
                    }
                elseif(strtoupper($value)=='NULL' || is_null($value)){
                    $set[] = '`'.$key.'` IS NULL';
                } else
                    $set[] = '`'.$key.'` = \''.$value.'\'';
            }
            $tmp = count($set);
            if(count($set)>0) $reserve = '('.($tmp>1?implode(') AND (',$set):$set[0]).')';
        }
        if(count($set)>0) $reserve = '('.($tmp>1?implode(') AND (',$set):$set[0]).')';
        return $reserve;
    }

    public static function setHost($host){
    	self::$dbHost = $host;
    }
    
    public static function setDBName($dataBaseName) {
    	self::$dbName = $dataBaseName;
    }
    
    public static function setUser($user,$password) {
    	self::$dbUser = $user;
    	self::$dbPassword = $password;
    }
    
    public static function setEncoding($pdoEncoding) {
    	self::$dbEncoding = $pdoEncoding;
    }
    
    public function getShowResponseArray() {
        return $this->showResponseArray;
    }

    public function setShowResponseArray($showResponseArray) {
        $this->showResponseArray = $showResponseArray;
    }

    public function getShowQueryStrings() {
        return $this->showQueryStrings;
    }

    public function setShowQueryStrings($showQueryStrings) {
        $this->showQueryStrings = $showQueryStrings;
    }

    public function getDb() {
        return self::$db;
    }

    public function setDb($db) {
        self::$db = $db;
    }
}
?>
