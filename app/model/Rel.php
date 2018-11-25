<?php

class Rel extends DAO {

	public function model() {
		$this->number("id")->inc()->primary();
		$this->string("art", 32);
		$this->string("title", 256);
		$this->string("url", 64);
		$this->string("date", 10);
		$this->string("label", 128);
		$this->number("release_type");
		$this->binary("stores");
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

	static function sortByDate($rels) {
		// TODO: Do this
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