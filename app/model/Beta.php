<?php

class Beta extends DAO {

	public function model() {
		$this->string("code", 32)->primary();
	}

}

?>