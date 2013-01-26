<?php
class ByteArray {
	protected $bigEndian = TRUE;
	protected $byteArray;
	protected $capacity;
	protected $limit;
	protected $mark;
	public $position;
	public function __construct($byteArray = '') {
		$this->byteArray = $byteArray;
		$this->position = 0;
		$this->mark = - 1;
		$this->init ();
	}
	private function init() {
		$this->capacity = strlen ( $this->byteArray );
		$this->limit = $this->capacity;
	}
	public function _array() {
		return $this->byteArray;
	}
	public function clear() {
		$this->limit = $this->capacity;
		$this->position = 0;
		$this->mark = - 1;
	}
	private function get($length = null) {
		if ($length === null) {
			$length = $this->limit - $this->position;
		} elseif ($length > $this->bytesAvailable ()) {
			throw new Exception ( 'bytesAvailable' );
		}
		$data = substr ( $this->byteArray, $this->position, $length );
		$this->position += $length;
		return $data;
	}
	private function set($bytes) {
		$p1 = substr ( $this->byteArray, 0, $this->position );
		$p2 = substr ( $this->byteArray, $this->position );
		$len = strlen ( $bytes );
		if ($len < strlen ( $p2 )) {
			$p2 = substr ( $p2, $len );
		} else {
			$p2 = '';
		}
		$p1 .= $bytes . $p2;
		$this->byteArray = $p1;
		$this->position += $len;
		$this->init ();
	}
	public function readBytes($length = -1, $offset = -1) {
		$limit = $this->limit;
		if ($offset == - 1) {
			$offset = $this->position;
		}
		if ($length == - 1) {
			$length = $limit - $offset;
		}
		if ($length > $limit - $offset) {
			return null;
		}
		return substr ( $this->byteArray, $offset, $length );
	}
	public function writeBytes($bytes, $offset = 0, $length = 0) {
		$len = strlen ( $bytes );
		if ($len < 1) {
			return;
		}
		if ($length < 1) {
			$length = $len;
		}
		if ($offset < 1) {
			$offset = 0;
		}
		if ($offset + $length > $len) {
			return;
		}
		$p1 = substr ( $bytes, $offset, $length );
		$this->set ( $p1 );
	}
	public function readBoolean() {
		return $this->readByte () != 0;
	}
	public function writeBoolean($value) {
		$this->writeByte ( $value != 0 );
	}
	public function readByte() {
		return ord ( $this->get ( 1 ) );
	}
	public function readUnsignedByte() {
		$data = unpack ( 'C', $this->get ( 1 ) );
		return $data [1];
	}
	public function writeByte($value) {
		$data = pack ( 'c', $value );
		$this->set ( $data );
	}
	public function readShort() {
		$data = unpack ( $this->bigEndian ? 'n' : 'v', $this->get ( 2 ) );
		return $data [1];
	}
	public function writeShort($value) {
		$data = pack ( $this->bigEndian ? 'n' : 'v', $value );
		$this->set ( $data );
	}
	public function readInt() {
		$data = unpack ( $this->bigEndian ? 'N' : 'V', $this->get ( 4 ) );
		return $data [1];
	}
	public function writeInt($value) {
		$data = pack ( $this->bigEndian ? 'N' : 'V', $value );
		$this->set ( $data );
	}
	public function readFloat() {
		$data = unpack ( 'f', $this->get ( 4 ) );
		return $data [1];
	}
	public function writeFloat($value) {
		$data = pack ( 'f', $value );
		$this->set ( $data );
	}
	public function readDouble() {
		$data = unpack ( 'd', $this->get ( 8 ) );
		return $data [1];
	}
	public function writeDouble($value) {
		$data = pack ( 'd', $value );
		$this->set ( $data );
	}
	public function readString() {
		$length = $this->readShort ();
		$value = $this->get ( $length );
		return $value;
	}
	public function writeString($value) {
		$len = strlen ( $value );
		$this->writeShort ( $len );
		$this->writeStringBytes ( $value );
	}
	public function writeStringBytes($value) {
		$len = strlen ( $value );
		$data = pack ( 'a' . $len, $value );
		$this->set ( $data );
	}
	public function readStringBytes($length) {
		return $this->get ( $length );
	}
	public function bytesAvailable() {
		return $this->limit - $this->position;
	}
	public function length() {
		return $this->limit;
	}
	public function __toString() {
		return $this->byteArray;
	}
	public function compress($level = 5) {
		$this->byteArray = gzcompress ( $this->byteArray, $level );
		$this->init ();
	}
	public function uncompress($level = 5) {
		$this->byteArray = gzuncompress ( $this->byteArray, $level );
		$this->init ();
	}
}

?>