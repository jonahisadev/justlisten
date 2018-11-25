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
				for ($i = 0; $i < count($rels); $i++) {
					$R = Rel::get($rels[$i]);
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
				}
			?>
		</div>
	</div>

	<?= script("artist.js") ?>
</body>
</html>