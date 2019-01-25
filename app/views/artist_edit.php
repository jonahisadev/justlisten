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
			<h4 class="link" onclick="showModal('art-modal')">Art Requirements</h4><br>
			<?= image("user_upload/" . $A->profile . ".jpg", ["id" => "art-img", "width" => "200", "class" => "img-upload", "onclick" => "selectFile()"]) ?>
			<input type="file" name="art" id="art" accept="image/jpeg" hidden><br><br>
			<textarea name="bio" id="bio" cols="30" rows="10" placeholder="Bio"><?= $A->bio ?></textarea><br><br>
			<?= csrf_field() ?>
			<input class="btn-large" type="submit" value="Edit" />
		</form>
	</div>

	<div class="modal" id="art-modal">
		<div class="modal-content center">
			<h1>Art Requirements</h1>
			<div style="text-align: left; width: 50%; margin-left: 25%;">
				<ul>
					<h2><li>Must be a square image</li></h2>
					<h2><li>File size must less than 2MB</li></h2>
					<h2><li>Image type must be JPEG (jpg, jpeg)</li></h2>
				</ul>
			</div>
		</div>
	</div>

	<?= script("modal.js") ?>
	<?= script("new_release.js") ?>
</body>
</html>