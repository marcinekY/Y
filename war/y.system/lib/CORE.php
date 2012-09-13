<?php



/**
 *
 * Klasa wczytuje niezbedne biblioteki systemu
 * @author Y
 *
 */
class CORE {
	private static $classMap;
	private static $fileName = 'classMap.php';
	private static $arrayName = 'classMap';
	
	public static function loadClass($className){
		if(isset(self::$classMap[$className]) && is_file(self::$classMap[$className])){
			require_once self::$classMap[$className];
		} else {
			die('Error! Class '.$className.' not exists.');
		}
	}
	
	public static function saveMap(){
		require_once dirname(__FILE__).'/FileManagment.php';
		$file = '<?php '."\r\n".'$'.self::$arrayName.' = array('."\r\n";
		foreach (self::$classMap as $name=>$path){
			$file.='\''.$name.'\' => \''.$path.'\','."\r\n";
		}
		$file.=');';
		FileManagment::makeFile(CONFIGPATH.self::$fileName,$file);
	}
	
	public static function getClassMap(){
		if(is_null(self::$classMap)){
			if(is_file(CONFIGPATH.self::$fileName)){
				require CONFIGPATH.self::$fileName;
				$arrName = self::$arrayName;
				if($$arrName)self::$classMap = $$arrName;
			}
		}
	}
	
	public static function addClassesToMap($sDirName) {
		$oRecursiveDirectory = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $sDirName ), true );
		foreach ($oRecursiveDirectory as $oFile) {
			if(!is_file($oFile->getPathname()))
			continue;
			$aTokenAll = token_get_all(file_get_contents($oFile->getPathname()));
			$bIsClass = false;
			foreach ($aTokenAll as $iToken) {
				if (!is_string($iToken)) {
					list($iTokenID, $sTokenValue) = $iToken;
					switch ($iTokenID) {
						case T_CLASS:
							$bIsClass = true;
							break;
						case T_INTERFACE:
							$bIsClass = true;
							break;
						case T_STRING:
							if ($bIsClass) {
								self::$classMap[$sTokenValue] = $oFile->getPathname();
								$bIsClass = false;
							}
							break;
						case T_WHITESPACE:
							break;
						default:
							$bIsClass = false;
							break;
					}
				}
			}
		}
		return self::$classMap;
	}
}