<?php

	$A = User::get($a_id);
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
<body <?php if (!$error) { ?>onload="loadRelease(<?= $R->id ?>)" <?php } ?>>
	<?php include 'include/header.php'; ?>
	<?php include 'template/flash_msg.php'; ?>

	<div class="center">
		<?php
			if ($error) {
				flash_message(FLASH_RED, $error);
			}
		?>
		<h1>Edit Release</h1>
	</div>

	<?php 

		$action = "save";
		include 'include/release_form.php';

	?>

	<div class="center">
		<h4 class="link" style="color: red; font-size: 16pt; margin-bottom: 20px;" onclick='deleteRelease("<?=$A->username?>/<?=$R->url?>");'>Delete</h4>
	</div>

	<?= script("rest.js") ?>
	<?= script("classifier.js") ?>
	<?= script("new_release.js") ?>
	<?= script("api_release.js") ?>
	<?= script("edit_release.js") ?>
	<?= script("modal.js") ?>

	<?php
		if ($error) {
			$stores = Session::getFlash("stores");
			$str = '{ "stores": [ ';
			for ($i = 0; $i < count($stores); $i++) {
				$str .= '{ "name": "' . $stores[$i][0] . '", "link": "' . $stores[$i][1] . '" }';
				if ($i != count($stores) - 1) {
					$str .= ", ";
				}
			}
			$str .= " ] }";

			echo ('<script id="backendPersist">backendPersistStores(\'' . $str . '\', ' . $R->id . ')</script>');
		}
	?>
</body>
</html>