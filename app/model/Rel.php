<?php

include 'Stat.php';
include 'Store.php';

class Rel extends DAO {

	const PRIV = 1;
	const PUB = 2;

	public function model() {
		$this->number("id")->inc()->primary();
		$this->string("art", 32);
		$this->string("title", 256);
		$this->string("url", 64);
		$this->string("date", 10);
		$this->string("label", 128);
		$this->number("release_type");
		$this->binary("stores");
		$this->number("privacy");
		$this->binary("stats");
		$this->string("link", 10);
	}

	static function type($id) {
		switch ($id) {
			case 1:
				return "Single";
			case 2:
				return "EP";
			case 3:
				return "Album";
			case 4:
				return "Compilation";
		}
	}

	static function store($id) {
		switch ($id) {
			case Store::SPOTIFY:
				return "Spotify";
			case Store::APPLE:
				return "Apple Music";
			case Store::ITUNES:
				return "iTunes";
			case Store::SOUNDCLOUD:
				return "Soundcloud";
			case Store::YOUTUBE:
				return "YouTube";
			case Store::DEEZER:
				return "Deezer";
			case Store::AMAZON:
				return "Amazon";
			case Store::GPLAY:
				return "Google Play";
			case Store::BANDCAMP:
				return "Bandcamp";
		}
	}

	static function action($id) {
		switch ($id) {
			case Store::SPOTIFY:
				return "Listen";
			case Store::APPLE:
				return "Listen";
			case Store::ITUNES:
				return "Buy";
			case STORE::SOUNDCLOUD:
				return "Listen";
			case Store::YOUTUBE:
				return "Watch";
			case Store::DEEZER:
				return "Listen";
			case Store::AMAZON:
				return "Buy";
			case Store::DEEZER:
				return "Buy";
			case Store::GPLAY:
				return "Buy";
			case Store::BANDCAMP:
				return "Buy";
		}
	}

	static function priv($type) {
		switch ($type) {
			case 1:
				return "Private";
			case 2:
				return "Public";
		}
	}

	private static function dateCompare(Rel $a, Rel $b) {
		if ($a->date == $b->date) {
			return 0;
		}
		return ($a->date > $b->date) ? -1 : 1;
	}

	static function sortByDate($rels) {
		$R = [];
		for ($i = 0; $i < count($rels); $i++) {
			$R[] = Rel::get($rels[$i]);
		}
		usort($R, "Rel::dateCompare");
		return $R;
	}

	public function getDate() {
		return date("m/d/Y", $this->date);
	}

	public function getJSDate() {
		return date("Y-m-d", $this->date);
	}

	public function setStores(array $stores) {
		$this->stores = gzencode(base64_encode(serialize($stores)));
	}

	public function getStores() {
		if ($this->stores == NULL) {
			return array();
		}

		return unserialize(base64_decode(gzdecode($this->stores)));
	}

	public function setStats(array $stats) {
		$this->stats = gzencode(base64_encode(serialize($stats)));
	}

	public function getStats() {
		if ($this->stats == NULL) {
			$arr = [Stat::STATS_ARRAY_SIZE];
			for ($i = 0; $i < Stat::STATS_ARRAY_SIZE; $i++) {
				$arr[$i] = 0;
			}
			return $arr;
		}

		return unserialize(base64_decode(gzdecode($this->stats)));
	}

	public function logStat($store_id) {
		if (!isset($_SERVER['HTTP_USER_AGENT'])) {
			return;
		}

		$info = get_browser(NULL, TRUE);
		$B = $info['browser'];
		$OS = $info['platform'];
		$P = $info['device_type'];

		$stats = $this->getStats();
		$stats[Stat::CLICKS]++;

		// BROWSER
		if ($B == "Chrome") {
			$stats[Stat::CHROME]++;
		} else if ($B == "Firefox") {
			$stats[Stat::FIREFOX]++;
		} else if ($B == "Opera") {
			$stats[Stat::OPERA]++;
		} else if ($B == "Safari") {
			$stats[Stat::SAFARI]++;
		} else if ($B == "Edge") {
			$stats[Stat::EDGE]++;
		} else {
			$stats[Stat::OTHER_BROWSER]++;
		}

		// OS
		if (substr($OS, 0, 3) == "Win") {
			$stats[Stat::WINDOWS]++;
		} else if ($OS == "MacOSX") {
			$stats[Stat::MAC]++;
		} else if ($OS == "Linux") {
			$stats[Stat::LINUX]++;
		} else if ($OS == "iOS") {
			$stats[Stat::IOS]++;
		} else if ($OS == "Android") {
			$stats[Stat::ANDROID]++;
		} else {
			$stats[Stat::OTHER_OS]++;
		}

		// PLATFORM
		if ($P == "Desktop") {
			$stats[Stat::DESKTOP]++;
		} else if ($P == "Mobile Phone") {
			$stats[Stat::MOBILE]++;
		} else {
			$stats[Stat::OTHER_PLATFORM]++;
		}

		// STORE
		$stats[Stat::STORE_START + $store_id]++;

		$this->setStats($stats);
		$this->save();
	}

	public static function cleanseURL($url) {
		$str = "";
		for ($i = 0; $i < strlen($url); $i++) {
			$c = ord(substr($url, $i, 1));
			if (($c >= ord('A') && $c <= ord('Z')) || ($c >= ord('a') && $c <= ord('z')) ||
					($c >= ord('0') && $c <= ord('9')) || $c == ord('-') || $c == ord('_')) {
				$str .= chr($c);
			}
		}
		return $str;
	}

}

?>