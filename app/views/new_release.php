<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>New Release</title>

	<?= stylesheet("style.css") ?>
</head>
<body>
	<?php include 'include/header.php'; ?>

	<div class="center">
		<h1>New Release</h1>
	</div>

	<form action="create" method="post" enctype="multipart/form-data" autocomplete="off">
		<div class="main-content">
			<div class="split-container">
				<div class="new-release-left">
					<div class="center">
						<?= image("default.jpg", ["id" => "art-img", "width" => "200", "class" => "img-upload", "onclick" => "selectFile()"]) ?>
						<input type="file" name="art" id="art" hidden>
					</div>

					<input type="text" id="title" name="title" placeholder="Title" />
					<input type="text" id="url" name="url" placeholder="URL" />
					<input type="text" id="date" name="date" placeholder="Release Date (DD/MM/YYYY)" />
					<input type="text" id="label" name="label" placeholder="Label" />
					<select name="type" id="type">
						<option value="0">Release Type</option>
						<option value="1">Single</option>
						<option value="2">EP</option>
						<option value="2">Album</option>
						<option value="3">Compilation</option>
					</select>
				</div>

				<div class="new-release-right">
					<div class="store" id="store-1">
						<select name="store-type-1" id="store-type-1">
							<option value="0">Store</option>
							<option value="1">Spotify</option>
							<option value="2">Apple Music</option>
							<option value="3">iTunes</option>
						</select>
						<input type="text" name="store-link-1" id="store-link-1" placeholder="Link" />
						<h3 class="minus" onclick="removeStoreLink(1)">-</h3>
					</div>
					<h3 class="plus" id="plus" onclick="addStoreLink()">+</h3>
				</div>
			</div>
			<div class="new-release-submit center">
				<input type="hidden" name="store-count" id="store-count" value="1" />
				<?= csrf_field() ?>
				<input type="submit" class="btn-large" value="Submit" />
			</div>
		</div>
	</form>

	<?= script("new_release.js") ?>
</body>
</html>