<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Reset Default Store</title>
	<?= stylesheet("style.css") ?>
</head>
<body>
	<?php include 'include/header.php'; ?>

	<h1 class="center">Reset Default Store</h1>
	<div class="main-content">
		<p style="margin-left: 20%; font-size: 14pt; width: 60%;">
			Hey, sometimes you just gotta reset your default store. I totally get it, which
			is why I provided you with this helpful page! The website just now forgot what
			platform you like best, and will automatically set again when you decide to
			listen to another song. You can always return here if all else fails!
		</p>

		<p style="margin-left: 20%; font-size: 14pt; width: 60%;">
			Happy Listening!
		</p>
	</div>
	<?= script("reset.js") ?>
</body>
</html>