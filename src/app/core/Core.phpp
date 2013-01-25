<?php
interface ICommand {
	function execute(Message $data);
}
class Command implements \ICommand {
	public function execute(Message $data) {
		return false;
	}
}
interface IMessage {
	function encode();
	function decode(ByteArray $data);
}
class Message implements \IMessage {
	public function encode() {
	}
	public function decode(ByteArray $data) {
		return false;
	}
}
?>