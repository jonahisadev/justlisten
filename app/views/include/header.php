<div class="header">
	<h1><a href="<?= BASEURL ?>">Just Listen</a></h1>
	<?php if (Session::has("login_id")) { ?>
	<div class="header-menu">
		<h2><?= Session::get("login_user") ?></h2>
		<div class="header-menu-content">
			<a href="<?= BASEURL ?>">Home</a>
			<a href="<?= BASEURL ?>/a/<?= Session::get("login_user") ?>">Profile</a>
			<a href="<?= BASEURL ?>/about">About</a>
			<a target="_blank" href="https://paypal.me/jonahisadev">Donate</a>
			<a href="<?= BASEURL ?>/logout">Logout</a>
		</div>
	</div>
	<?php } ?>
</div>