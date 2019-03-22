<?php

class Art {

	public static function meetsRequirements($file) {
		// Is this an image?
		list($width, $height, $type, $attr) = getimagesize($file);

		// Check for JPEG
		// if (mime_content_type($file['tmp_name']) != "image/jpeg") {
		// 	return "File must be a JPEG image";
		// }

		// Check square
		if ($width != $height) {
			return "File must be a square";
		}

		// File must be 2MB or less
		if ($file['size'] > (2 * 1024 * 1024)) {
			return "File must be less than 2MB";
		}
	}

}

?>