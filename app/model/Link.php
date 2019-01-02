<?php

class Link extends DAO {

	public function model() {
		$this->string("id", 10)->primary();
		$this->string("url", 32 + 64);
	}

}

?>