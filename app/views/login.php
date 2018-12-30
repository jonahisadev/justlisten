<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Just Listen</title>
	<?= stylesheet("style.css") ?>
</head>
<body>
	<?php include 'include/header.php'; ?>
	<?php include 'template/flash_msg.php'; ?>

	<?php

		if (!Session::hasFlash("signup")) {
			if (Session::hasFlash("success")) {
				flash_message(FLASH_GREEN, "Success! You may now log in!");
			} else if (Session::hasFlash("empty")) {
				flash_message(FLASH_RED, "Please enter all fields");
			} else if (Session::hasFlash("bad")) {
				flash_message(FLASH_RED, "Incorrect username or password");
			} else if (Session::hasFlash("verify")) {
				flash_message(FLASH_GREEN, "Success! Please verify your account!");
			} else if (Session::hasFlash("bad_verify")) {
				flash_message(FLASH_RED, "Please verify your account first!");
			}
		} else {
			if (Session::hasFlash("empty")) {
				flash_message(FLASH_RED, "Please enter all fields");
			} else if (Session::hasFlash("passmatch")) {
				flash_message(FLASH_RED, "Passwords didn't match");
			} else if (Session::hasFlash("bademail")) {
				flash_message(FLASH_RED, "Email is already taken");
			} else if (Session::hasFlash("username")) {
				flash_message(FLASH_RED, "Username is already taken");
			} else if (Session::hasFlash("nobeta")) {
				flash_message(FLASH_RED, "Invalid beta code");
			}
		}

	?>

	<div class="login-form" id="login">
		<h1>Login</h1>
		<form action="login/" method="POST" autocomplete="off">
			<input type="text" id="username" name="username" placeholder="Username" value="<?=$l_username?>"/>
			<input type="password" id="password" name="password" placeholder="Password" />
			<input type="submit" value="Login" />
		</form>
		<h4 class="link" onclick="swapForms()">Not a member?</h4>
	</div>

	<div class="login-form" id="signup" hidden>
		<h1>Sign Up</h1>
		<form action="signup/" method="POST" autocomplete="off">
			<input type="text" id="username" name="username" placeholder="Username" value="<?=$s_username?>"/>
			<input type="text" id="name" name="name" placeholder="Artist Name" value="<?=$name?>"/>
			<input type="text" id="email" name="email" placeholder="Email" value="<?=$email?>"/>
			<input type="password" id="pass1" name="pass1" placeholder="Password" />
			<input type="password" id="pass2" name="pass2" placeholder="Confirm Password" />
			<input type="text" name="beta_code" id="beta_code" placeholder="Beta Code" value="<?=$beta_code?>" />
			<input type="submit" value="Sign Up">
		</form>
		<h4 class="link" onclick="swapForms()">Already a member?</h4>
	</div>

	<div class="center">
		<h4 class="link" onclick="window.location.href='about'">About</h4>
	</div>

	<?= script("classifier.js") ?>
	<?= script("input.js") ?>
	<?= script("login.js") ?>

	<?php
		if (Session::hasFlash("signup")) {
	?>
		<script>swapForms()</script>
	<?php
		}
	?>
</body>
</html>