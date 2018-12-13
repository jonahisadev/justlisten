<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>New Release</title>

	<?= stylesheet("style.css") ?>
</head>
<body>
	<?php include 'include/header.php'; ?>

	<div class="center">
		<h1>New Release</h1>
	</div>

	<?php 
	
		$action = "create";
		include 'include/release_form.php'; 
	
	?>

	<?= script("new_release.js") ?>
</body>
</html>