<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormAnons
 *
 * @author Ja
 */

if(!class_exists('Anonse')) include_once 'Anonse.php';
if(!class_exists('Logger')) include_once 'Logger.php';
if(!class_exists('User')) include_once 'Users.php';
if(!class_exists('Aktywacje')) include_once 'Aktywacje.php';
if(!class_exists('FileManagment')) include_once 'FileManagment.php';

class FormAnons extends Anonse {
    private $isEditMode = false;
    private $anonsData = array();
    private $anons;
    private $user;
    private $files = array();
    private $step = 1;
    public $logger;
    public $aktywacje;
    
    
    function __construct() {
        parent::__construct();
        $this->logger = new Logger();
        $this->anons = new Anons(null);
        $this->aktywacje = new Aktywacje();
        if($_SESSION['user']) $this->user = unserialize($_SESSION['user']);
    }
    
    function editAnons($data){
        $this->anonsData = $data;
        if($this->validate()) {
            if(is_null($this->user)) $this->logger->addError ('add', 'Nie jesteś zalogowany lub Twoja sesja wygasła! Nie możesz dodać ogłoszenia. Zaloguj się.');
            
            $this->addAnonsForm_Step1();
            if($this->logger->getAllErrors()) return false;
            
            $dbData = $this->anons->getDBArray();
            
        }
    }
    
    function addAnons($data){
        //to jest wymagane dla validatora danych - jesli checkbox nie jest zaznaczony to zmienna w post nie istnieje
        $data['regulamin'] = $data['regulamin'];
        $data['name'] = $data['name'];
        
        $this->anonsData = $data;
        if($this->validate()) {
            
            if(is_null($this->user)) $this->logger->addError ('add', 'Nie jesteś zalogowany lub Twoja sesja wygasła! Nie możesz dodać ogłoszenia. Zaloguj się.');
            $this->addAnonsForm_Step1();
            $dbData = $this->anons->getDBArray();
            $double = $dbData;
            unset ($double['dodano']);
            unset ($double['visit_count']);
            unset ($double['ip']);
            unset ($double['hash']);
            unset ($double['status']);
            unset ($double['do_moderacji']);
            if($this->logger->getAllErrors()) return false;
            if(!$this->db->getData($this->tableName,$double)){
                if($this->db->addDataFromDataArray($this->tableName,$dbData)) {
                    if($item = $this->db->getData($this->tableName,$double)){
                        $this->anons->setId($item[0]['id']);
                        $hash = $this->aktywacje->generateHash($item[0]['id'], $item[0]['email'], $item[0]['dodano']);
                        $this->anons->setHash($hash);
                        if($this->db->editDataFromDataArray($this->tableName,array('id'=>  $this->anons->getId()),array('hash'=>  $this->anons->getHash()))){
                            $akt['id_anonsu'] = $this->anons->getId();
                            $akt['hash'] = $this->anons->getHash();
                            $akt['dodano'] = $this->anons->getAdded();
                            if($this->aktywacje->addAktywacja($akt)){
                                $added = true;
                            }
                        } else $this->logger->addError ('add', 'Anons został dodany, ale wystąpiły błędy. Spróbuj jeszcze raz.');
                    } else $this->logger->addError ('add', 'Próba dodania nowego anonsu nie powiodła się.');
                } else $this->logger->addError ('add', 'Próba dodania nowego anonsu nie powiodła się.');
            } else $this->logger->addError ('add', 'Taki anons już istnieje w bazie danych.');
            if($added){
                if($this->anons->hasPhoto()){
                    $photos = $this->anons->getPhotos();
                    foreach ($photos as $photo) {
                        $photo->setItemId($this->anons->getId());
                        $pData = $photo->getDBArray();
                        if(!$this->db->getData($this->photosTableName,$pData)){
                            $this->db->addDataFromDataArray($this->photosTableName,$pData);
                        }
                    }
                } else {
                    $sql = 'DELETE FROM `'.$this->photosTableName.'` WHERE `item_id`='.$this->anons->getId().' AND `type`=\'a\'';
                    $this->db->delData($sql);
                }
                return $this->anons;
            }

                    
//                    if($this->isEditMode()){
//                        if($this->db->editDataFromDataArray($this->tableName,$dbData)){
//                            $this->step++;
//                            return true;
//                        }
//                    }
//                    if($this->db->addDataFromDataArray($this->tableName,$dbData)) {
//                        $this->step++;
//                        return true;
//                    }

            
            
        }
    }
    
    function addAnonsForm_Step1(){
        $data = $this->anonsData;
        if($data['id']) {
            $this->anons->setId($data['id']);
            $this->setEditMode(true);
        } else $this->setEditMode(false);

        if($data['title']) $this->anons->setTitle($data['title']);
        if($data['opis']) $this->anons->setDescription($data['opis']);
        if($data['kategoria']) $this->anons->setCategoryId ($data['kategoria']);
        if($data['wojewodztwo']) $this->anons->setProvinceId($data['wojewodztwo']);
        if($data['miasto']) $this->anons->setCityId($data['miasto']);
        if($data['name']) $this->anons->setName($data['name']);
        if($data['zdjecie']) {
            $pData['url'] = $data['zdjecie'];
            $pData['name'] = FileManagment::getFileNameFromUrl($data['zdjecie']);
            $pData['type'] = 'a';
            if($data['id']) $pData['item_id'] = $data['id'];
            $this->anons->addPhoto(new Photo($pData));
        }
        if($data['zdjecie2']) {
            $pData['url'] = $data['zdjecie2'];
            $pData['name'] = FileManagment::getFileNameFromUrl($data['zdjecie2']);
            $pData['type'] = 'a';
            if($data['id']) $pData['item_id'] = $data['id'];
            $this->anons->addPhoto(new Photo($pData));
        }
        if($data['zdjecie3']) {
            $pData['url'] = $data['zdjecie3'];
            $pData['name'] = FileManagment::getFileNameFromUrl($data['zdjecie3']);
            $pData['type'] = 'a';
            if($data['id']) $pData['item_id'] = $data['id'];
            $this->anons->addPhoto(new Photo($pData));
        }
        $this->anons->setEmail($this->user->getEmail());
        $this->anons->setUserId($this->user->getId());
        $this->anons->setVisit(0);
        $this->anons->setStatus(-1);
        $this->anons->setIp($_SERVER['REMOTE_ADDR']);
        $this->anons->setAlias(urldecode($this->anons->getTitle()));
    }
    
    function addPhoto($_files){
        if(is_null($this->user)) {
            $this->logger->addError('add', 'Nie jesteś zalogowany lub Twoja sesja wygasła! Nie możesz dodać ogłoszenia. Zaloguj się.');
            return false;
        }
        if($_files['zdjecie']['size']<524288){
            $path = 'usr/'.$this->user->getId().'/';
            FileManagment::checkDir($path);
            do {
                $numer = rand(1000,99999);
            } while(is_file($path.$numer.'.jpg'));
            
            if($zdjecie = FileManagment::uploadImage($_files['zdjecie'],$path.$numer.'.jpg')){
                return $zdjecie;
            }
        } else $this->logger->addError('zdjecie','rozmaiar pliku ze zdjęciem nie może być większy niż 512KB');
        return false;
    }

    /**
    sprawdza, czy podane dane są poprawne
    @return boolean
    */
    function validate() {
        $data = $this->anonsData;
        if(!is_array($data)) { $this->logger->addError('validate','Błąd danych wejściowych.'); return false; }
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
                    elseif($liczba_znakow>=50) $e = 'Za duża liczba znaków (max 50).';
                    if($e!=false) $this->logger->addError('name',$e);
                break;
                case 'title':
                    if($empty==true) $e = 'Tutuł ogłoszenia jest wymagany.';
                    elseif($string==false) $e = 'Tytuł musi być tekstem.';
                    elseif($liczba_znakow<10) $e = 'Wymagane min 10 znaków';
                    elseif($liczba_znakow>=50) $e = 'Za duża liczba znaków (max 50).';
                    if($e!=false) $this->logger->addError('title',$e);
                break;
                case 'kategoria':
                    if($empty==true) $e = 'Wybierz kategorię.';
                    elseif($digit==false) $e = 'Kategoria musi być liczbą.';
                    elseif(!$this->categories->getCategoryById($value)) $e = 'Błędna kategoria. Kategoria o id <strong>'.$value.'</strong> nie istnieje.';
                    if($e!=false) $this->logger->addError('kategoria',$e);
                break;
                case 'wojewodztwo':
                    if($empty==true) $e = 'Wybierz województwo.';
                    elseif($digit==false) $e = 'Wybierz wojewodztwo.';
                    if($e!=false) $this->logger->addError('wojewodztwo',$e);
                break;
                case 'miasto':
                    if($empty==true) $e = 'Wybierz miejscowość w której mieszkasz.';
                    elseif($digit==false) $e = 'Wybierz miasto.';
                    if($e!=false) $this->logger->addError('miasto',$e);
                break;
                case 'opis':
                        if($empty==true) $e = 'Wprowadź treść ogłoszenia.';
//                        elseif($liczba_znakow<5) $e = 'Podany opis jest za krótki.';
                        if($e!=false) $this->logger->addError('opis',$e);
                break;
                case 'regulamin':
                    if($empty==true) $e = 'To pole jest wymagane';
                    if($e!=false) $this->logger->addError('regulamin',$e);
                break;
            }
        }//end for
        $data['alias'] = urldecode($data['title']);

        if($this->logger->getAllErrors()) return false;
        return true;
    } //end function
    
     public function isEditMode() {
         return $this->isEditMode;
     }

     public function setEditMode($isEditMode) {
         $this->isEditMode = $isEditMode;
     }

     public function getPostVars() {
         return $this->postVars;
     }

     public function setPostVars($postVars) {
         $this->postVars = $postVars;
     }

     public function getFiles() {
         return $this->files;
     }
     
     public function getAnons() {
         return $this->anons;
     }

     public function setAnons($anons) {
         $this->anons = $anons;
     }

     public function getStep() {
         return $this->step;
     }

     public function setStep($step) {
         $this->step = $step;
     }


}




?>
