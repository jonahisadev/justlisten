<?php
	$A = User::get($a_id);
	$rels = $A->getReleases();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?= $name ?></title>
	<?= stylesheet("style.css") ?>
</head>
<body>
	<?php include 'include/header.php'; ?>

	<div class="profile-container">
		<h1 class="title"><?= $name ?></h1>
		<?= image("user_upload/" . $A->profile . ".jpg", ["width" => "200px"]) ?>
		<?php if ($A->id == Session::get("login_id")) { ?>
		<h4 class="link" onclick="showEdit()">Edit</h4>
		<?php } ?>
		<div class="main-content grid-container">
			<?php
				$pub_count = 0;
				for ($i = 0; $i < count($rels); $i++) {
					$R = Rel::get($rels[$i]);
					if ($R->privacy == Rel::PUB) {
			?>
			<div class="grid">
				<div class="grid-release-container">
					<?= image("user_upload/" . $R->art . ".jpg", ["width" => "85%"]) ?>
					<a target="_blank" href="<?=BASEURL?>/a/<?=$A->username?>/<?=$R->url?>">
						<div class="art-overlay">
							<h3>Just Listen!</h3>
						</div>
					</a>
				</div>
				<h4><?= $R->title ?></h4>
			</div>
			<?php
					$pub_count++;
					}
				}

				if (count($rels) == 0 || $pub_count == 0) {
			?>
			<h2 class="no-releases"><i>No Releases :(</i></h2>
			<?php
				}
			?>

			<?php if (count($rels) == 0) { ?>
			
			<?php 
	} ?>
		</div>
	</div>

	<div class="modal" id="edit-modal">
		<div class="modal-content center">
			<h2>Edit Profile</h2>
			<input type="text" placeholder="Name" value="<?= $A->name ?>" />
		</div>
	</div>

	<?= script("artist.js") ?>
	<?= script("modal.js") ?>
</body>
</html>