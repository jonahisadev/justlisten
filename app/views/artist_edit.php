<?php
	$A = User::get($a_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Edit Artist</title>
	<?= stylesheet("style.css") ?>
</head>
<body>
	<?php include 'include/header.php'; ?>
	<?php include 'template/flash_msg.php'; ?>

	<div class="center">
		<?php
			if (Session::hasFlash("error")) {
				flash_message(FLASH_RED, Session::getFlash("error"));
			}
		?>
		<h1>Edit Profile</h1>
		<form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
			<input type="text" name="name" id="name" placeholder="Name" value="<?= $A->name ?>" /><br><br>
			<?= image("user_upload/" . $A->profile . ".jpg", ["id" => "art-img", "width" => "200", "class" => "img-upload", "onclick" => "selectFile()"]) ?>
			<input type="file" name="art" id="art" hidden><br><br>
			<?= csrf_field() ?>
			<input class="btn-large" type="submit" value="Edit" />
		</form>
	</div>

	<?= script("new_release.js") ?>
</body>
</html>