<?php
class SaeCounter {
	private $path='temp/';
	public function remove($name) {
		return FileIO::delete($this->path.$name);
	}
	public function exists($name) {
		return FileIO::haspath($this->path.$name);
	}
	public function listAll() {
	}
	public function length() {
		return 1;
	}
	public function get($name){
		return (int) FileIO::getfile($this->path.$name);
	}
	public function set($name, $value){
		return FileIO::setfile($this->path.$name, $value);
	}
	public function incr($name, $value = 1){
		$i=(int)$this->get($name);
		$i+=$value;
		$this->set($name, $i);
		return $i;
	}
	public function decr($name, $value = -1){
		return $this->incr($name,$value);
	}
}

?>