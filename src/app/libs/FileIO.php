<?php
class FileIO {
	public static function isfile($path){
		if(strlen($path)<1)return false;
		$name=basename($path);
		return strlen($name)>0;
	}
	public static function isdir($path){
		return is_dir($path);
	}
	public static function haspath($path){
		if(strlen($path)<1)return false;
		return file_exists($path);
	}
	public static function getfile($path){
		if(self::isfile($path)){
			if(self::haspath($path)){
				return file_get_contents($path);
			}
		}
		return null;
	}
	public static function setfile($path,$data){
		if(self::isfile($path)){
			return file_put_contents($path, $data);
		}
		return false;
	}
	public static function rename($old,$new){
		return rename($old,$new);
	}
	public static function delete($path){
		if(self::isfile($path)){
			return unlink($path);
		}
		return false;
	}
	public static function mkdir($path){
		mkdir($path);
	}
	
}

?>