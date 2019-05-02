<?php

class Art {

	public static function meetsRequirements($filename) {
		// Is this an image?
		$FILE = fopen($filename, "r");
		list($width, $height, $type, $attr) = getimagesize($filename);

		// Check for JPEG
		// if (mime_content_type($file['tmp_name']) != "image/jpeg") {
		// 	return "File must be a JPEG image";
		// }

		// Check square
		if ($width != $height) {
			return "File must be a square";
		}

		// File must be 2MB or less
		if ($FILE['size'] > (2 * 1024 * 1024)) {
			return "File must be less than 2MB";
		}
	}

	public static function uploadToS3($local_path, $filename) {
		$aws = parse_ini_file(dirname(__FILE__) . "/../res/config/aws.ini", true);
		$s3 = new Aws\S3\S3Client([
			'region' => 'us-east-2',
			'version' => 'latest',
			'credentials' => [
				'key' => $aws['creds']['key'],
				'secret' => $aws['creds']['secret']
			]
		]);
		$result = $s3->putObject([
			'ACL' => 'public-read',
			'Bucket' => 'justlisten-user-assets',
			'Key' => "user_assets/" . $filename . ".jpg",
			'SourceFile' => $local_path
		]);

		return $result['ObjectURL'];
	}

	public static function removeFromS3($filename) {
		$aws = parse_ini_file(dirname(__FILE__) . "/../res/config/aws.ini", true);
		$s3 = new Aws\S3\S3Client([
			'region' => 'us-east-2',
			'version' => 'latest',
			'credentials' => [
				'key' => $aws['creds']['key'],
				'secret' => $aws['creds']['secret']
			]
		]);
		$result = $s3->deleteObject([
			'Bucket' => 'justlisten-user-assets',
			'Key' => 'user_assets/' . $filename . '.jpg'
		]);
		return $result['DeleteMarker'];
	}

}

?>