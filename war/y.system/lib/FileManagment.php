<?php

/*
 * To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Static class FileManagment
 *
 * @author Ja
 */
class FileManagment {
	static function getFileNameFromUrl($url){
		return end(explode('/', $url));
	}//end function

	static function getPath($url){
		$tmp = explode('/', $url);
		$mx = count($tmp);
		for($i=0;$i<$mx-1;$i++){
			$r.=$tmp[$i];
		}
		return $r;
	}

	static public function addLineInFile($file, $line="", $mod=null){
		$fp = fopen($file, "a");
		flock($fp, 2);
		fwrite($fp, $line."\r\n");
		flock($fp, 3);
		fclose($fp);
	}//end function

	static function makeFile($file, $value=null, $mod=null){
		$path = self::getPath($file);
		if(self::checkDir($path)){
			$fp = fopen($file, "w");
			flock($fp, 2);
			fwrite($fp, $value);
			flock($fp, 3);
			fclose($fp);
			if(is_null($mod)) @chmod($file, 0777);
			else @chmod($file, $mod);
			if(is_file($file)) return true;
		}
		return false;
	}//end function

	static function makeDir($d){
		$dirs = explode('/', $d);
		for($i=0;$i<=$ile;$i++){
			$p=$i;
			//echo $dirs[$i].'<br>';
			if(!is_dir($dirs[$i])){
				mkdir($dirs[$i]);
				chmod($dirs[$i], 0777);
				$dirs[++$p]=$dirs[$i].DIRECTORY_SEPARATOR.$dirs[$p];
			} else $dirs[++$p]=$dirs[$i].DIRECTORY_SEPARATOR.$dirs[$p];
		}//end for
		if(is_dir($d)) return true; else return false;
	}//end function

	function getFilesDir($dir){
		$files = array();
		if ($dir = @opendir($dir)) {
			while($file = readdir($dir)) {
				if($file!='.' && $file!='..') $files[] = $file;
			}
			closedir($dir);
		}
		return $files;
	}//end function

	function delDir($strDir){
		//usowa element docelowy
		if(!empty($strDir)){
			if(is_file($strDir)) {
				if(unlink($strDir)) return true;
			} else $dirs[] = $strDir;
			do {
				$kat=0;
				if(is_dir($dirs[0])) {
					$files = array();
					$files = $this->getFilesDir($dirs[0]);
					$mx = count($files);
					for($i=0;$i<$mx;$i++){
						if(is_dir($files[$i])){
							$dirs[] = $dirs[0].'/'.$files[$i];
							$kat++; //przechowuje ile katalogow jest w aktualnym folderze
						} else {
							unlink($dirs[0].'/'.$files[$i]);
						}
					}
					if($kat==0){
						rmdir($dirs[0]);
						if(count($dirs)==1) $lastDir = $dirs[0];
					}
				}
				array_shift($dirs);
			} while(count($dirs)>0);
			if(rmdir($strDir)) return true;
		}
	}//end function

	static function checkDir($dir,$mod=null){
		if(empty($dir)) return;
		if(!is_dir($dir)) if(!self::makeDir($dir)) return false;
		if(!is_null($mod)) @chmod($mod,$dir);
		return $dir;
	}

	function fileName($file){
		$name =array($_GET['group'],$file);
		if(!is_null($this->includeF)) $name[] = $this->includeF;
		$this->includeF++;
		return 'static/'.implode('_',$name).'.php';
	}//end function

	function putStaticFile($fileName,$data){
		$file = fopen($fileName,'w+');
		fputs($file,$data,strlen($data)+1);
		chmod($fileName,0777);
		return $fileName;
	}//end function

	static function readFile($path){
		if(!is_file($path)) return false;
		if(!is_readable($path)) return false;
		if($file = fopen($path, "r")){
			$data = fread($file, filesize($path));
			if ($data === FALSE) return false; //odczyt danyych si� nie powiodl
			fclose($file);
		}//end if
		return $data;
	}//end function

	public static function createThumb($src,$size,$height=false,$over=false){

		if(is_file($src) && is_numeric($size)){
			$thumb = $this->fileNamePrefix($src, 'th['.$size.($height==true?'h':'w').']');
			if($over==false && is_file($thumb)) return $thumb;
			if(is_file($thumb)) unlink($thumb);
			if($thFile = $this->resizeImage($src,substr($thumb,0,-4),$size,$height)) return $thFile;
		} return false;
	}//end function

	static function uploadImage($array, $destination){
		if(is_uploaded_file($array['tmp_name'])){
			if(move_uploaded_file($array['tmp_name'],$destination)){
				chmod($destination,0777);
				return $destination;
			}
		} return false;
	}//end function

	public static function getImageSize($imgUrl){
		if(is_file($imgUrl)){
			$is = getimagesize($imgUrl);
			$r = array('width'=>$is[0], 'height'=>$is[1], 'string'=>$is[3]);
			return $r;
		}
		return false;
	}//ef


	function resizeImage($sourceImg, $destinationImg, $size=160, $height=false){
		//rozszerzenie do destinationImg dodaje sie samo
		//$sourceImg = str_replace(' ', '%20', $sourceImg);
		if (!function_exists('mime_content_type')) {
			function mime_content_type($f) {
				$f = escapeshellarg($f);
				return trim( `file -bi $f` );
			}
		}
		//echo getimagesize($sourceImg);
		$imageType = mime_content_type($sourceImg);
		$imageType = explode('/',$imageType);
		//$imageType = strtolower(end(explode('.',$sourceImg)));
		if($imageType[0]=='image' && preg_match('#(jpeg|gif)#',$imageType[1],$imgType)){
			$imgType = $imgType[1];
			if(file_get_contents($sourceImg)) {
				ini_set("memory_limit","30M");
				$image = ($imgType=='jpeg'?imagecreatefromjpeg($sourceImg):imagecreatefromgif($sourceImg));
				$imageSizeBig = getimagesize($sourceImg);
				if($height==true) $imageSizeSmall=array (($size/$imageSizeBig[1])*$imageSizeBig[0],$size);
				else $imageSizeSmall=array ($size,($size/$imageSizeBig[0])*$imageSizeBig[1]);
				$image_p = imagecreatetruecolor($imageSizeSmall[0],$imageSizeSmall[1]);
				imagecopyresampled($image_p,$image,0,0,0,0,$imageSizeSmall[0],$imageSizeSmall[1],$imageSizeBig[0],$imageSizeBig[1]);
				if($imgType=='jpeg') {
					if(imagejpeg($image_p,$destinationImg.'.jpg',90)) return $destinationImg.'.jpg';
				} else {
					if(imagegif($image_p,$destinationImg.'.gif',90)) return $destinationImg.'.gif';
				}
			}
			else return false;
		}
	}//ef

	public static function croppedThumbnail($imgSrc,$dpath,$thumbnail_width,$thumbnail_height) { //$imgSrc is a FILE - Returns an image resource.
		//getting the image dimensions
		if(is_file($dpath)) return $dpath;
		list($width_orig, $height_orig) = getimagesize($imgSrc);
		$myImage = imagecreatefromjpeg($imgSrc);
		$ratio_orig = $width_orig/$height_orig;

		if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
			$new_height = $thumbnail_width/$ratio_orig;
			$new_width = $thumbnail_width;
		} else {
			$new_width = $thumbnail_height*$ratio_orig;
			$new_height = $thumbnail_height;
		}

		$x_mid = $new_width/2;  //horizontal middle
		$y_mid = $new_height/2; //vertical middle

		$process = imagecreatetruecolor(round($new_width), round($new_height));

		imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
		$thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
		imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);
		@imagejpeg($thumb,$dpath,90);
		imagedestroy($process);
		imagedestroy($myImage);
		return $dpath;
	}//ef

	function resizeImg($src_im, $dpath, $maxd, $square=false) {
		if(is_file($dpath)) return $dpath;
		$src_im=@imagecreatefromjpeg($src_im);
		$src_width = imagesx($src_im);
		$src_height = imagesy($src_im);
		$src_w=$src_width;
		$src_h=$src_height;
		$src_x=0;
		$src_y=0;
		if($square){
			$dst_w = $maxd;
			$dst_h = $maxd;
			if($src_width>$src_height){
				$src_x = ceil(($src_width-$src_height)/2);
				$src_w=$src_height;
				$src_h=$src_height;
			}else{
				$src_y = ceil(($src_height-$src_width)/2);
				$src_w=$src_width;
				$src_h=$src_width;
			}
		}else{
			if($src_width>$src_height){
				$dst_w=$maxd;
				$dst_h=floor($src_height*($dst_w/$src_width));
			}else{
				$dst_h=$maxd;
				$dst_w=floor($src_width*($dst_h/$src_height));
			}
		}
		$dst_im=@imagecreatetruecolor($dst_w,$dst_h);
		@imagecopyresampled($dst_im, $src_im, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		@imagejpeg($dst_im,$dpath);
		@imagedestroy($src_im);
		//return $dst_im;
		return $dpath;
	}

	function fileNamePrefix($path, $prefix){
		return substr($path,0,strrpos($path,"/")+1).$prefix.substr($path,strrpos($path,"/")+1);
	}//end function
}

?>
