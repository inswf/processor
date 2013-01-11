<?php
class Service {
	/**
	 *
	 * @return ���ص�ǰʱ��
	 */
	public static function getTime() {
		return $_SERVER ['REQUEST_TIME'];
	}
	/**
	 * ����һ����������Ե�Ŀ��
	 *
	 * @param object $source
	 *        	Դ
	 * @param object $target
	 *        	Ŀ��
	 * @return boolean �Ƿ�ɹ�
	 */
	public static function copy($source, $target) {
		if (get_class ( $source ) == get_class ( $target )) {
			foreach ( $source as $key => $value ) {
				$target->$key = $value;
			}
			return true;
		}
		return false;
	}
	/**
	 * ȡ��һ��ֵ��У����
	 *
	 * @param string $value        	
	 * @return string
	 */
	public static function getCrc($value) {
		return dechex ( crc32 ( $value ) );
	}
	// ///////////////////////
	/**
	 *
	 * @param Message $data
	 *        	���һ�������Ϣ
	 * @return void ByteArray
	 */
	public static $output;
	public static function pushMessage(Message $data) {
		$ba = &self::$output;
		if (empty ( $ba )) {
			self::$output = new ByteArray ();
			$ba = &self::$output;
		}
		$name = get_class ( $data );
		$protocol = ( int ) Protocol::getProtocol ( $name );
		if ($protocol == 0) {
			return;
		}
		$subdata = $data->encode ();
		$len = ( int ) strlen ( $subdata );
		$ba->writeInt ( $len + 2 );
		$ba->writeShort ( $protocol );
		$ba->writeBytes ( $subdata );
		return $ba;
	}
	public static function getMessage() {
		return self::$output;
	}
	// ///////////////////////////
	// /////////////���ݴ洢////////////////////////
	private static $kvdb;
	private static function getkvdb() {
		$kv = self::$kvdb;
		if (empty ( $kv )) {
			$kv = new SaeKV ();
			self::$kvdb = $kv;
			$kv->init ();
		}
		return $kv;
	}
	public static function kvset($key, $value) {
		$kv = self::getkvdb ();
		$kv->set ( $key, $value );
	}
	public static function kvget($key) {
		$kv = self::getkvdb ();
		return $kv->get ( $key );
	}
	public static function kvdel($key) {
		$kv = self::getkvdb ();
		return $kv->delete ( $key );
	}
	// /////////////������//////////////////
	private static $counter;
	private static function getCounter() {
		$counter = self::$counter;
		if (empty ( $counter )) {
			$counter = new SaeCounter ();
			self::$counter = $counter;
		}
		return $counter;
	}
	public static function cget($key) {
		$counter = self::getCounter ();
		return $counter->get ( $key );
	}
	public static function cset($key, $value) {
		$counter = self::getCounter ();
		return $counter->set ( $key );
	}
	public static function cinc($key, $step = 1) {
		$counter = self::getCounter ();
		return $counter->incr ( $key, $step );
	}
}
//���ݷ���
class dbService{
	public static function getU_Id($id){
		$uid = Service::kvget ( $id . Config::suffix_u_id );
		if ($uid != null) {
			return unserialize ( $uid );
		}
		return null;
	}
	public static function setU_id(Uid $data){
		if ($data == null)
			return;
		$id = $data->id;
		Service::kvset ( $id . Config::suffix_u_id, serialize ( $data ) );
	}
	public static function getU_account($crc){
		$info = Service::kvget ( $crc . Config::suffix_u_account );
		if ($info != null) {
			return unserialize ( $info );
		}
		return null;
	}
	public static function setU_account(Uaccount $data){
		$crc = Service::getCrc ( $data->uid );
		$data->pass = Service::getCrc ( $data->pass );
		Service::kvset ( $crc . Config::suffix_u_account, serialize ( $data ) );
	}
}
?>