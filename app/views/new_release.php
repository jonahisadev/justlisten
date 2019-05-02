<?php

$A = User::get($a_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>New Release</title>
	<?php include 'include/rest.php'; ?>
	<?php include 'include/favicon.php'; ?>
	<?= stylesheet("style.css") ?>

	<script src="https://cdn.jonahisadev.me/vv-0.1.1/vv_util.js"></script>
	<script src="https://cdn.jonahisadev.me/vv-0.1.1/vv.js"></script>

	<!-- Store Options (ES6 Requirement) -->
	<script>
		var STORES = '<option value="0">Store</option>\n';
		STORES += `<?php include 'include/stores.php'; ?>`;
	</script>
</head>

<body onload="addStore(2)">
	<?php include 'include/header.php'; ?>
	<?php include 'template/flash_msg.php'; ?>

	<div class="center">
		<?php
		if ($error) {
			flash_message(FLASH_RED, $error);
		}
		?>
		<h1>New Release</h1>
	</div>

	<?php

	$action = "create";
	include 'include/release_form.php';

	?>

	<?= script("new_release.js") ?>

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

		echo ('<script id="backendPersist">backendPersistStores(\'' . $str . '\', -1)</script>');
	}
	?>
</body>

</html>