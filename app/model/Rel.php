<?php

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
			case 1:
				return "Spotify";
			case 2:
				return "Apple Music";
			case 3:
				return "iTunes";
		}
	}

	static function action($id) {
		switch ($id) {
			case 1:
				return "Listen";
			case 2:
				return "Listen";
			case 3:
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

}

?>