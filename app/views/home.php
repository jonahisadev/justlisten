<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Just Listen</title>
	<?php include 'include/rest.php'; ?>
	<?php include 'include/favicon.php'; ?>
	<?= stylesheet("style.css") ?>
</head>
<body>
	<?php include 'include/header.php'; ?>
	<?php include 'template/flash_msg.php'; ?>
	<?php $user = User::get(Session::get("login_id")); ?>

	<div class="welcome center">
		<?php
			if (Session::hasFlash("success_msg")) {
				flash_message(FLASH_GREEN, Session::getFlash("success_msg"));
			}
		?>
		<h1>Welcome <?= $name ?>!</h1>
	</div>

	<div class="center">
		<a class="btn-large" href="new">+ New Release</a>
	</div>

	<div class="main-content">
		<div class="center">
			<?php if (count($user->getReleases()) == 0) { ?>
				<h2><i>No Releases</i></h2>
			<?php } else { ?>
			<?php

				$releases = Rel::sortByDate($user->getReleases());
				for ($i = 0; $i < count($releases); $i++) {
					$R = $releases[$i];
					include 'template/home_release.php';
				}

			?>
			<?php } ?>
		</div>
	</div>
	
	<?= csrf_field() ?>
	<?= script("rest.js") ?>
	<?= script("home.js") ?>
	<?= script("modal.js") ?>
</body>
</html>