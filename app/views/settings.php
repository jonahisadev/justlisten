<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Settings</title>
	<?php include 'include/favicon.php'; ?>
	<?= stylesheet("style.css") ?>
</head>
<body>
	<?php include 'include/header.php'; ?>
	<?php include 'template/flash_msg.php'; ?>

	<?php
		if (Session::hasFlash("error")) {
			flash_message(FLASH_RED, Session::getFlash("error"));
		}

		if (Session::hasFlash("success")) {
			flash_message(FLASH_GREEN, Session::getFlash("success"));
		}
	?>

	<div class="center">
		<h2>Change Password</h2>
		<form action="password" method="POST" autocomplete="off">
			<input style="width: 20%;" type="password" name="old" placeholder="Old Password"><br>
			<input style="width: 20%;" type="password" name="new1" placeholder="New Password"><br>
			<input style="width: 20%;" type="password" name="new2" placeholder="Confirm New Password"><br>
			<?= csrf_field() ?>
			<input class="btn-large" type="submit" value="Change Password">
		</form>
	</div>
</body>
</html>