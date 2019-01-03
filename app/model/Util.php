<?php

class Util {

	public static function generateID($len) {
		$index = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_";
		$res = "";
		for ($i = 0; $i < $len; $i++) {
			$res .= $index[mt_rand(0, strlen($index)-1)];
		}
		return $res;
	}

}

?>