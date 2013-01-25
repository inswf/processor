<?php
class SaeKV {
	private $path='temp/';
	public function init(){
	}
	public function get($key){
		return FileIO::getfile($this->path.$key);
	}
	function replace($key, $value){
		if(FileIO::haspath($this->path.$key)){
			return self::set($key, $value);
		}
		return false;
	}
	public function set($key, $value){
		return FileIO::setfile($this->path.$key, $value);
	}
	public function delete ($key){
		return FileIO::delete($this->path.$key);
	}
}

?>