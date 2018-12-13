<?php

	$A = User::getBy("username", "tenfootcircle");
	$rels = $A->getReleases();
	print_r($rels); echo("<br>");

	$R = Rel::get($rels[1]);
	echo($R->id);

?>