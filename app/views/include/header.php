<div class="header">
	<h1 id="jl-title"><a href="<?= INDEX ?>">Just Listen</a></h1>
	<?php if (Session::has("login_id")) { ?>
	<div class="header-menu">
		<h2><?= Session::get("login_user") ?></h2>
		<div class="header-menu-content">
			<a href="<?= INDEX ?>">Home</a>
			<a href="<?= BASEURL ?>/a/<?= Session::get("login_user") ?>">Profile</a>
			<a href="<?= BASEURL ?>/about">About</a>
			<a target="_blank" href="https://paypal.me/jonahisadev">Donate</a>
			<a href="<?= BASEURL ?>/logout">Logout</a>
		</div>
	</div>
	<?php } ?>
	<?= script("cookies.js") ?>
	<?= script("header.js") ?>
</div>
<?php if (isset($_COOKIE['store'])) { ?>
<div class="modal" id="store-modal">
	<div class="modal-content center">
		<h2 class="modal-close" onclick="hideModal('store-modal')">×</h2>
		<h1>Set Default Store</h1>
		<select id="store-selector" style="width: 50%">
			<option value="0">Reset</option>
			<?php include 'stores.php'; ?>
		</select>
		<h4 class="btn-large" onclick="setStoreManually()">Set</h4>
	</div>
</div>
<?php } ?>
<?= script("modal.js") ?>