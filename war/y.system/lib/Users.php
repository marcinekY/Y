<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class_exists('Messages');
class_exists('MySQL');

/**
 * Klasa Users
 * udostepnia funkcje do zarzadzania uzytkownikami
 *
 * @author Ja
 */
class Users {
	private static $user;
	private static $tableName = 'users';


	function __construct() {
		if(self::isLogin() && $_SESSION['user']) self::$user = unserialize ($_SESSION['user']);
	}

	static function getUserById($id){
		$sql = 'SELECT * FROM `'.self::$tableName.'` WHERE `id`='.$id;
		if($item = MySQL::getRow($sql)){
			self::$user = new User($item);
			return self::$user;
		}
		return false;
	}

	static function getUserByEmail($email){
		$sql = 'SELECT * FROM `'.self::$tableName.'` WHERE `email`=\''.$email.'\'';
		if($item = MySQL::getRow($sql)){
			self::$user = new User($item);
			return self::$user;
		}
		return false;
	}

	static function resetPassword($email){
		$newPass = $this->generatePassword(8);

		$sql = 'UPDATE `'.self::$tableName.'` SET `password`=\''.md5($newPass).'\' WHERE `email`=\''.$email.'\'';
		if($this->db->editData($sql)){
			if($u = self::getUserByEmail($email)){
				$mail['temat'] = 'Twoje has�o na '.$_SERVER['SERVER_NAME'].' zosta�o zresetowane.';
				$mail['tresc'] = 'Witaj '.$u->getName()."\r\n".'Twoje has�o na '.$_SERVER['SERVER_NAME']." zosta�o zresetowane.\r\n\r\n".'Twoje nowe has�o to:'."\r\n".$newPass."\r\n\r\n\r\n".'Zapami�taj swoje nowe has�o lub zapisz w bezpiecznym miejscu. Bez niego logowanie na konto b�dzie niemo�liwe.'."\r\n\r\n".'Pozdrawiamy.'."\r\n".'Zesp� '.$_SERVER['SERVER_NAME'];
				$mail['email'] = $email;
				$mail['from'] = 'no-replay@'.$_SERVER['SERVER_NAME'];
				Messages::send_mail($mail['email'], $mail['from'], $mail['temat'], $mail['tresc']);
				return true;
			}
		}
	}

	function createUser($data){
		if(is_null($this->db)) return false;

		$data['password'] = (!$data['password']?$this->generatePassword(8):$data['password']);
		$data['email'] = $data['login'];

		if($this->validate($data)){
			$add['email'] = $data['email'];
			$add['mod'] = 2;
			$add['password'] = md5($data['password']);
			$add['name'] = $data['name'];

			if($this->db->addDataFromDataArray($this->tableName,$add)) {
				$u = $this->db->getData($this->tableName,$add);
				$mail['temat'] = 'Konto na '.$_SERVER['SERVER_NAME'].' zostało utworzone';
				$mail['tresc'] = 'Dzień dobry.'."\r\n".'Właśnie zostało utworzone Twoje konto na portalu '.$_SERVER['SERVER_NAME']."\r\n\r\n".'Twoje dane do logowania to:'."\r\n\r\n".'Login: '.$data['email']."\r\n".'Hasło: '.$data['password']."\r\n\r\n\r\n".'Zapamiętaj swoje hasło lub zapisz w bezpiecznym miejscu. Bez tych danych nie będziesz mógł się zalogować.'."\r\n\r\n".'Pozdrawiamy.'."\r\n".'Zespół '.$_SERVER['SERVER_NAME'];
				$mail['email'] = $data['email'];
				$mail['from'] = 'no-replay@'.$_SERVER['SERVER_NAME'];
				Messages::send_mail($mail['email'], $mail['from'], $mail['temat'], $mail['tresc']);
				return $this->user = new User($u[0]);
			}
		}
		return false;
	}

	function validate($data){
		if(!is_array($data)) { Logger::addError('validate','Błąd danych wejściowych.'); return false; }
		foreach($data as $key => $value) {
			$value = trim($value);
			$liczba_znakow = strlen($value);
			$string = (is_string($value)?true:false);
			$digit = (is_numeric($value)?true:false);
			$empty = (empty($value) || $value==null || $value==''?true:false);
			$e = false;
			switch($key) {
				case 'name':
					if($empty==true) $e = 'Imię jest wymagane.';
					elseif($string==false) $e = 'Imię musi być tekstem.';
					elseif($liczba_znakow<3) $e = 'Wymagane min 3 znaki';
					elseif($liczba_znakow>=24) $e = 'Za duża liczba znaków (max 50).';
					if($e!=false) Logger::addError('name',$e);
					break;
				case 'email':
					if($empty==true) $e = 'Wpisz adres e-mail.';
					elseif(!preg_match('/^[a-zA-Z0-9\.\-\_]+\@[a-zA-Z0-9\.\-\_]+\.[a-z]{2,4}$/D', $value)) $e = 'Podany ciąg znaków nie jest adresem e-mail.';
					elseif($liczba_znakow>150) $e = 'E-mail jest za długi.';
					elseif($this->getUserByEmail($value)) $e = 'Podany login już istnieje w bazie danych.';
					if($e!=false) Logger::addError('email',$e);
					break;
				case 'password':
					if($empty==true) $e = 'Podaj hasło.';
					elseif($liczba_znakow<6) $e = 'Hasło jest zbyt któtkie. Użyj minimum 6 znaków.';
					if($e!=false) Logger::addError('password',$e);
					break;
				case 'regulamin':
					if($empty==true) $e = 'To pole jest wymagane';
					if($e!=false) Logger::addError('regulamin',$e);
					break;
			}
		}//end for
		if(Logger::getAllErrors()) return false;
		return true;
	}

	static function isLogin(){
		return (session_id()==$_SESSION['logged']?true:false);
	}

	static function login($login, $pass){
		if(empty ($login) || empty ($pass)) return false;

		$sql = 'SELECT * FROM `'.self::$tableName.'` WHERE `email`=\''.$login.'\' AND `password`=\''.$pass.'\'';
		if($item = MySQL::getRow($sql)){
			if(session_id()=="") session_start();
			self::$user = new User($item);
			if(self::$user->isActive()!=1) Redirect::redirect('noactive');
			$_SESSION['user'] = serialize(self::$user);
			$_SESSION['logged'] = session_id();
			$sql = 'UPDATE `'.self::$tableName.'` SET `last_login`=CURRENT_TIMESTAMP, `last_ip`=\''.$_SERVER['REMOTE_ADDR'].'\' WHERE `id`=\''.self::$user->getId().'\'';
			MySQL::dbQuery($sql);
			return true;
		}
		return false;
	}

	static function logout(){
		$_SESSION['loged'] = false;
		self::$user = null;
		session_destroy();
	}

	function generatePassword($length=9, $strength=0) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}

		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}


	static function getUser() {
		return self::$user;
	}

	static function setUser($user) {
		self::$user = $user;
	}
}

class User {
	private $id;
	private $name;
	private $email;
	private $password;
	private $isActive;
	private $extras;
	private $groups;
	private $lastLogin;
	private $lastIp;
	private $added;

	function __construct($DBObjData) {
		$this->setObjFromDBArray($DBObjData);
	}

	function setObjFromDBArray($arr){
		if(is_array($arr)){
			if($arr['id']) $this->id = $arr['id'];
			if($arr['name']) $this->name = $arr['name'];
			if($arr['email']) $this->email = $arr['email'];
			if($arr['password']) $this->password = $arr['password'];
			if($arr['active']) $this->isActive = ($arr['active']==1?true:false);
			if($arr['extras']) $this->extras = json_decode($arr['extras']);
			if($arr['groups']) $this->groups = json_decode($arr['groups']);
			if($arr['last_login']) $this->lastLogin = $arr['last_login'];
			if($arr['last_ip']) $this->lastIp = $arr['last_ip'];
			if($arr['added']) $this->added = $arr['added'];
		}
	}

	function getDBArray(){
		$r = array();
		if(!is_null($this->id)) $r['id'] = $this->id;
		if(!is_null($this->name)) $r['name'] = $this->name;
		if(!is_null($this->email)) $r['email'] = $this->email;
		if(!is_null($this->password)) $r['password'] = $this->password;
		$r['active'] = ($this->isActive?1:null);
		if(!is_null($this->extras)) $r['extras'] = json_encode($this->extras);
		if(!is_null($this->groups)) $r['groups'] = json_encode($this->groups);
		if(!is_null($this->lastLogin)) $r['last_login'] = $this->lastLogin;
		if(!is_null($this->lastIp)) $r['last_ip'] = $this->lastIp;
		if(!is_null($this->added)) $r['added'] = $this->added;
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

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function isActive() {
		return $this->isActive;
	}

	public function setActive($bool) {
		$this->isActive = $bool;
	}
	
	public function getExtras() {
		return $this->extras;
	}

	public function setExtras($extras) {
		$this->extras = $extras;
	}
	
	public function getGroups() {
		return $this->groups;
	}

	public function setGroups($groups) {
		$this->groups = $groups;
	}

	public function getLastLogin() {
		return $this->lastLogin;
	}

	public function setLastLogin($lastLogin) {
		$this->lastLogin = $lastLogin;
	}

	public function getLastIp() {
		return $this->lastIp;
	}

	public function setLastIp($lastIp) {
		$this->lastIp = $lastIp;
	}

	public function getAdded() {
		return $this->added;
	}

	public function setAdded($added) {
		$this->added = $added;
	}
}

?>
