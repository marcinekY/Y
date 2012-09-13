<?
class Aktywacje  {
    public $db;
    private $tableName = 'tb_aktywacje';
    private $tableAnonse = 'tb_anons';
    
    
    function __construct() {
    }
	
	public function getAktywacja($reserve){
            if(is_array($reserve) && count($reserve)>0){
                    if($item = $this->db->getData($this->tableName,$reserve)){
                            return $item;
                    }
            }
            return false;
	}//e f getData
        
        public function getAktywacjaByHash($hash){
            if(is_null($this->db)) return false;
            
            $sql = 'SELECT * FROM `'.$this->tableName.'` WHERE `hash`=\''.$hash.'\'';
            if($items = $this->db->executeQueryString($sql)){
                return $items[0];
            }
        }
	
	public function editAktywacja($edit){
		if($edit['id']){
			if($this->db->editDataFromDataArray($this->tableName,$edit)) return true;
		}
		return false;
	}//e f setAktywacja
	
	public function generateHash($id,$email,$data_dodania_anonsu){
		if(is_numeric($id)) return md5($id.$email.$data_dodania_anonsu);
		return false;
	}//e f generateHash
	
	public function addAktywacja($data){
		if($data['id_anonsu'] && $data['hash']){
			if($this->db->addDataFromDataArray($this->tableName,$data)) return true;
		}
		return false;
	}//e f addAktywacja
	
        public function aktywujByHash($hash){
            if($actData = $this->getAktywacjaByHash($_GET['hash'])){
                if($anonsData = $this->db->getData($this->tableAnonse,array('id'=>$actData['id_anonsu']))){
//                    if($anonsData['status']==-1){
                        $actData['data_aktywacji'] = time();
                        $actData['ip'] = $_SERVER['SERVER_ADDR'];
                        $editAnons = array();
                        $editAnons['status'] = 1;
                        $editAnons['do_moderacji'] = 1;
                        if($this->db->editDataFromDataArray($this->tableAnonse,array('id'=>$actData['id_anonsu']),$editAnons)){
                            $this->db->editDataFromDataArray($this->tableName,array('hash'=>$hash),$actData);
                            return true;
                        }
//                    }
                }
            }
            return false;
        }
        
	public function aktywuj($id){
		if(is_numeric($id)){
			$data['id'] = $id;
			$data['data_aktywacji'] = time();
			if($_POST['smskod']) $data['smskod'] = $_POST['smskod'];
			$data['ip'] = $_SERVER['REMOTE_ADDR'];
			if($this->db->editAktywacja($data)) {
				if($aktywacja = $this->getAktywacja(array('id'=>$id)));
					$edit['id'] = $aktywacja[0]['id_anonsu'];
					$edit['status'] = 2;
					if($this->editData(0,$edit)) return true;
					else return 200;
				return true;
			} else return 100;
		}
		return 400;
	}//e f aktywuj /////error code: 100- blad edycji rekordu w aktywacjach; 200- blad edycji rekordu anonsu, 400- id nie jest cyfra
	
	public function deaktywuj($id){
		if(is_numeric($id)){
			$data['id'] = $id;
			$data['data_deaktywacji'] = time();
		}
	}
	
	public function delete($id){
		if(is_numeric($id)){
			if($this->delData(6,array('id'=>$id))) return true;
		} return false;
	}
	
}//e class
?>