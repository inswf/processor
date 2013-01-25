<?php
class Array2 {
	//数组
	protected $a;
	//行
	protected $w;
	//列
	protected $h;
	//长度
	protected $l;
	public function __construct($w, $h) {
		$this->w = $w;
		$this->h = $h;
		$this->l = $w * $h;
		$this->clear ();
	}
	public function getWidth() {
		return $this->w;
	}
	public function getHeight() {
		return $this->h;
	}
	public function getSize() {
		return $this->l;
	}
	public function fill($value) {
		$this->a = array_fill ( 0, $this->l, $value );
	}
	public function clear() {
		$this->a = array ();
	}
	public function delete($index) {
		$this->setIndex ( $index, NULL );
	}
	public function getx($index) {
		if ($index >= $this->l)
			return - 1;
		return $index % $this->w;
	}
	public function gety($index) {
		if ($index >= $this->l)
			return - 1;
		return ( int ) ($index / $this->w);
	}
	public function contains($value) {
		$list = array ();
		$len = $this->l;
		$arr = $this->a;
		$i = 0;
		while ( $len -- > 0 ) {
			if ($arr [$len] == $value) {
				$list [$i ++] = $len;
			}
		}
		return $list;
	}
	protected function getPosition($x, $y) {
		$w = $this->w;
		$h = $this->h;
		if ($x >= $w)
			return - 1;
		if ($y >= $h)
			return - 1;
		return $w * $y + $x;
	}
	public function getIndex($index) {
		if ($index >= $this->l) {
			return NULL;
		}
		return $this->a [$index];
	}
	public function setIndex($index, $value) {
		if ($index >= $this->l) {
			return false;
		}
		if ($value == NULL) {
			if (isset ( $this->a [$index] )) {
				unset ( $this->a [$index] );
			}
		} else {
			$this->a [$index] = $value;
		}
		return true;
	}
	public function set($x, $y, $value) {
		$index = $this->getPosition ( $x, $y );
		return $this->setIndex ( $index, $value );
	}
	public function get($x, $y) {
		$i = $this->getPosition ( $x, $y );
		if ($i == - 1) {
			return NULL;
		}
		return $this->a [$i];
	}
	public function dis($s,$e){
		$w=$this->w;
		$dis1=(int)($s/$w)-(int)($e/$w);
		$dis2=(int)($s%$w)-(int)($e%$w);
		if($dis1<0){
			$dis1=-$dis1;
		}
		if($dis2<0){
			$dis2=-$dis2;
		}
		return $dis1+$dis2;
	}
	public function getArray() {
		return $this->a;
	}
	public function __toString() {
		return 'Array2[size=' . $this->l . ']';
	}
}

?>