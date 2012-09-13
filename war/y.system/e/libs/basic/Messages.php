<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(!class_exists('Logger')) include_once 'Logger.php';

/**
 * Description of Messages
 *
 * @author Ja
 */
class Messages {
	public $db;
	public $anonse;
	public $users;
	private $tableMessages = 'tb_wiadomosci';
	private $tableAnonse = 'tb_anons';
	private $tableUser = 'tb_user';
	private $zdjecia = 'tb_zdjecia';
	private $messages;
	private $logger;

	function __construct() {
		$this->logger = new Logger();
	}

	function getSelect(){
		$sql = 'SELECT `'.$this->tableMessages.'`.`id`,`'.$this->tableMessages.'`.`a_id`,`'.$this->tableMessages.'`.`from`,`'.$this->tableMessages.'`.`to`,`'.$this->tableMessages.'`.`tresc`,`'.$this->tableMessages.'`.`zalaczniki`,`'.$this->tableMessages.'`.`status`,`'.$this->tableMessages.'`.`data`, `'.$this->tableUser.'`.`name` FROM `'.$this->tableMessages.'` LEFT JOIN `'.$this->tableUser.'` ON (`'.$this->tableMessages.'`.`from`=`'.$this->tableUser.'`.`id`) ';
		return $sql;
	}

	function getMessagesByAnonsId($id){
		if(is_null($this->db)) return false;
		$sql = $this->getSelect().'WHERE `a_id`=\''.$id.'\' GROUP BY `from` ORDER BY `data` DESC';
		if($items = $this->db->executeQueryString($sql)){
			$this->messages = array();
			foreach ($items as $item) {
				$this->messages[] = new Message($item);
			}
			return $this->messages;
		}
		return false;
	}

	function getMessagesByUserId($id){
		if(is_null($this->db)) return false;

		$sql = $this->getSelect().'WHERE (`from`=\''.$id.'\' OR `to`=\''.$id.'\') GROUP BY `from` ORDER BY `data` DESC';
		if($items = $this->db->executeQueryString($sql)){
			$this->messages = array();
			foreach ($items as $item) {
				$this->messages[] = new Message($item);
			}
			return $this->messages;
		}
		return false;
	}

	function getMessageById($id){
		if(is_null($this->db)) return false;

		$sql = $this->getSelect().'WHERE `'.$this->tableMessages.'`.`id`=\''.$id.'\'';
		if($items = $this->db->executeQueryString($sql)){
			return new Message($items[0]);
		}
		return false;
	}

	function getMessagesWithUsers($user1,$user2){
		if(is_null($this->db)) return false;

		$sql = $this->getSelect().'WHERE (`from`=\''.$user1.'\' AND `to`=\''.$user2.'\') OR (`from`=\''.$user2.'\' AND `to`=\''.$user1.'\') GROUP BY `from` ORDER BY `data` ASC';
		if($items = $this->db->executeQueryString($sql)){
			$this->messages = array();
			foreach ($items as $item) {
				if(!$item['name']) {
					if(is_numeric($item['to'])){
						if($user = $this->users->getUserById($item['to'])){
							$item['name'] = $user->getName();
						}
					} else {
						if($user = $this->users->getUserByEmail($item['to'])){
							$item['name'] = $user->getName();
						}
					}
				}
				$this->messages[] = new Message($item);
			}
			return $this->messages;
		}
	}

	function sendMessage($idAnonsu,$from,$to,$message){
		if(is_null($this->db)) return false;
		if(is_null($idAnonsu) || is_null($from) || is_null($to)) return false;
		$add['a_id'] = addslashes(trim($idAnonsu));
		$add['to'] = addslashes(trim($to));
		$add['from'] = addslashes(trim($from));
		$add['tresc'] = addslashes(strip_tags(trim($message),'<b><i><u><br>'));

		if(!$anons = $this->anonse->getAnonsById($idAnonsu)){
			$this->logger->addError('anons', 'Błąd, brak ogłoszenia.');
			return false;
		}
		if($this->isEmailAddress($add['to'])){
			//identyfikator odbiorcy jest adresem email
			$messageData['nameTo'] = $messageData['email'] = $add['to'];
		} elseif($userTo = $this->users->getUserById($add['to'])) {
			$messageData['nameTo'] = $userTo->getName();
			$messageData['email'] = $userTo->getEmail();
		} else {
			$this->logger->addError('from', 'Wystąpił błąd podczas identyfikacji nadawcy.');
			return false;
		}
		if($this->isEmailAddress($add['from'])){
			//identyfikator odbiorcy jest adresem email
			$messageData['nameFrom'] = $add['from'];
			$messageData['subject'] = ucfirst_utf8($_SERVER['SERVER_NAME']).': ktoś wysłał wiadomość na Twoje konto.';
		} elseif($userTo = $this->users->getUserById($add['from'])) {
			$messageData['nameFrom'] = $anons->getName();
			$messageData['subject'] = ucfirst_utf8($_SERVER['SERVER_NAME']).': użytkownik '.$anons->getName().' odpowiedział na Twoją wiadomość.';
		} else {
			$this->logger->addError('to', 'Wystąpił błąd podczas identyfikacji odbiorcy.');
			return false;
		}
		if($this->logger->getAllErrors()) return false;
		else {
			if($this->db->addDataFromDataArray($this->tableMessages,$add)){
				$messageData['message'] = 'Witaj'.$messageData['nameTo'].'.'."\n\r\n\r".'Wiadomość z portalu '.$_SERVER['SERVER_NAME'].' od: '.$messageData['nameFrom']."\n\r\n\r".'Treść wiadomości:'."\n\r".$message."\n\r\n\r\n\r";
				if(is_a($userTo, 'User')) {
					$messageData['message'] .= 'Aby odpowiedzieć na tą wiadomość, zaloguj się na swoje konto pod adresem: http://'.$_SERVER['SERVER_NAME']."\n\r\n\r".'Adres ogłoszenia: http://'.$_SERVER['SERVER_NAME'].'/'.$anons->getId().'_'.$anons->getAlias();
				} else {
					$messageData['message'] .= 'Aby odpowiedzieć na tą wiadomość wejdź pod adres ogłoszenia podany poniżej:'."\n\r".'http://'.$_SERVER['SERVER_NAME'].'/'.$anons->getId().'_'.$anons->getAlias();
				}

				$messageData['message'] .= "\n\r\n\r".'Pozdrawiamy.'."\n\r".'Zespół TablicaTowarzyska.pl';
				self::send_mail($messageData['email'], 'no-replay@'.$_SERVER['SERVER_NAME'], $messageData['subject'], $messageData['message']);
				return true;
			}
		}
	}

	function isEmailAddress($email){
		$value = trim($email);
		$liczba_znakow = strlen($value);
		$empty = (empty($value) || $value==null || $value==''?true:false);
		$e = false;

		if($empty==true) $e = true;
		elseif(!preg_match('/^[a-zA-Z0-9\.\-\_]+\@[a-zA-Z0-9\.\-\_]+\.[a-z]{2,4}$/D', $value)) $e = true;
		if($e) return false; //$this->error->addError('email',$e);
		else return true;
		//        if($this->error->getAllErrors()) return false;
		//        return true;
	}

	/**
	 * parametry: adres odbiorcy, adres nadawcy, temat, tresc
	 * @param type $email
	 * @param type $from
	 * @param string $temat
	 * @param type $tresc
	 * @return boolean
	 */
	static function send_mail($email, $from, $temat, $tresc) {
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
		$headers .= "Content-Transfer-Encoding: 8bit\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "From: $from\r\n";
		//	$headers .= "To: $email\r\n";

		$temat="=?utf-8?B?".base64_encode($temat)."?=";

		if($email!='' && $from!='' && $temat!='' && $tresc!='') {
			mail($email, $temat, $tresc, $headers);
			return true;
		}//end if
		return false;
	}//end function

	public function getLogger() {
		return $this->logger;
	}

}

class Message {
	private $id;
	private $anonsId;
	private $from;
	public $userName;
	private $to;
	private $message;
	private $hasAnnex;
	private $status;
	private $data;

	function __construct($DBObjdata) {
		$this->setObjFromDBArray($DBObjdata);
	}

	function setObjFromDBArray($arr){
		if(is_array($arr)){
			if($arr['id']) $this->id = $arr['id'];
			if($arr['a_id']) $this->anonsId = $arr['a_id'];
			if($arr['from']) $this->from = $arr['from'];
			if($arr['name']) $this->userName = $arr['name'];
			if($arr['to']) $this->to = $arr['to'];
			if($arr['tresc']) $this->message = $arr['tresc'];
			if($arr['zalaczniki']) $this->hasAnnex = ($arr['zalaczniki']==1?true:false);
			if($arr['status']) $this->status = $arr['status'];
			if($arr['data']) $this->data = $arr['data'];
		}
	}

	function getDBArray(){
		$r = array();
		if(!is_null($this->id)) $r['id'] = $this->id;
		if(!is_null($this->anonsId)) $r['a_id'] = $this->anonsId;
		if(!is_null($this->from)) $r['from'] = $this->from;
		if(!is_null($this->to)) $r['to'] = $this->to;
		if(!is_null($this->message)) $r['tresc'] = $this->message;
		$r['zalaczniki'] = ($this->hasAnnex?1:null);
		if(!is_null($this->status)) $r['status'] = $this->status;
		if(!is_null($this->data)) $r['data'] = $this->data;
		return $r;
	}

	public function getSenderName() {
		return (is_numeric($this->from)?$this->userName:$this->from);
	}

	public function getPreview($charsCount=100){
		return substr(stripcslashes(strip_tags($this->message)), 0, $charsCount);
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getAnonsId() {
		return $this->anonsId;
	}

	public function setAnonsId($anonsId) {
		$this->anonsId = $anonsId;
	}

	public function getFrom() {
		return $this->from;
	}

	public function setFrom($from) {
		$this->from = $from;
	}

	public function getTo() {
		return $this->to;
	}

	public function setTo($to) {
		$this->to = $to;
	}

	public function getMessage() {
		return $this->message;
	}

	public function setMessage($message) {
		$this->message = $message;
	}

	public function getHasAnnex() {
		return $this->hasAnnex;
	}

	public function setHasAnnex($hasAnnex) {
		$this->hasAnnex = $hasAnnex;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function getData() {
		return $this->data;
	}

	public function setData($data) {
		$this->data = $data;
	}
}

?>
