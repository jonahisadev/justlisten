<?php

class User extends DAO {

	public function model() {
		$this->number("id")->primary()->inc();
		$this->string("username", 32);
		$this->string("email", 64);
		$this->string("name", 64);
		$this->string("password", 256);
		$this->string("verify", 32);
		$this->binary("releases");
		$this->string("profile", 32, "profile");
	}

	public function setReleases(array $rel) {
		if (count($rel) == 0) {
			$this->releases = NULL;
		} else {
			$this->releases = gzencode(base64_encode(serialize($rel)));
		}
	}

	public function getReleases() {
		if ($this->releases == NULL) {
			return array();
		}

		return unserialize(base64_decode(gzdecode($this->releases)));
	}

	public function addRelease($rel) {
		$arr = $this->getReleases();
		$arr[] = $rel;
		$this->setReleases($arr);
	}

	public function getRelease($url) {
		$rels = $this->getReleases();
		for ($i = 0; $i < count($rels); $i++) {
			$R = Rel::get($rels[$i]);
			if ($R->url == $url) {
				return $R;
			}
		}
		return NULL;
	}

	public function removeRelease($id, $base) {
		$rels = $this->getReleases();
		for ($i = 0; $i < count($rels); $i++) {
			if ($rels[$i] == $id) {
				$R = Rel::get($rels[$i]);
				if ($R->art != "../default") {
					unlink($base . "/res/img/user_upload/" . $R->art . ".jpg");
				}
				array_splice($rels, $i, 1);
				break;
			}
		}
		$this->setReleases($rels);
		$this->save();
	}

	public static function cleanseUsername($username) {
		$str = "";
		for ($i = 0; $i < strlen($username); $i++) {
			$c = ord(substr($username, $i, 1));
			if (($c >= ord('a') && $c <= ord('z')) || ($c >= ord('0') && $c <= ord('9'))
					|| $c == ord('_')) {
				$str .= chr($c);
			}
		}
		return $str;
	}

}

?>