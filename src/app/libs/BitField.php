<?php
class BitField {
	protected $value=0;
	public function __construct($value = 0) {
		$this->value = $value;
	}
	public function has($value) {
		$key=$this->getKey($value);
		if(($this->value & $key) == $key){
			return 1;
		}
		return 0;
	}
	public function open($value) {
		$this->value |= $this->getKey($value);
	}
	public function close($value) {
		$this->value &= ~$this->getKey($value);
	}
	public function clear(){
		$this->value=0;
	}
	public function __toString(){
		return (string)$this->value;
	}
	public function get(){
		return $this->value;
	}
	protected function getKey($index){
		$index%=32;
		return 1<<$index;
	}
}
?>