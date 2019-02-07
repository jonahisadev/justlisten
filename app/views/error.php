<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Error</title>
	<?php include 'include/favicon.php'; ?>
	<?= stylesheet("style.css") ?>
</head>
<body>
	<?php include 'include/header.php'; ?>
	<div class="center">
		<h1><i><?= $error ?></i></h1>
	</div>
</body>
</html>