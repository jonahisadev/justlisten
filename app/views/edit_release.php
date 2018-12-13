<?php

	$R = Rel::get($r_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Edit Release</title>
	<?php include 'include/rest.php'; ?>
	<?= stylesheet("style.css") ?>
</head>
<body onload="loadRelease(<?= $R->id ?>)">
	<?php include 'include/header.php'; ?>

	<div class="center">
		<h1>Edit Release</h1>
	</div>

	<?php 

		$action = "save";
		include 'include/release_form.php';

	?>

	<?= script("new_release.js"); ?>
	<?= script("rest.js") ?>
	<?= script("api_release.js"); ?>
	<?= script("edit_release.js"); ?>
</body>
</html>