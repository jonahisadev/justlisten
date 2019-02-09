<?php

class Email {

	public static function sendVerification($to, $name, $code) {
		$path = __DIR__ . "/../views/template/email_verify.html";
		$text = str_replace("{NAME}", $name, file_get_contents($path));
		$text = str_replace("{CODE}", $code, $text);

		$headers  = "Content-Type: text/html; charset=UTF-8\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "From: Just Listen <tfcskoap@server224.web-hosting.com>\r\n";
		$headers .= "Reply-To: Just Listen <tfcskoap@server224.web-hosting.com>\r\n";

		mail($to, "Email Verification", $text, $headers);
	}

}

?>