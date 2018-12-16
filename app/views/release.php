<?php
	$R = Rel::get($r_id);
	$A = User::get($a_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?= script("cookies.js") ?>
	<?= script("release.js") ?>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?= $R->title ?></title>
	<?= stylesheet("release.css") ?>
</head>
<body>
	<div class="content">
		<h1 class="title"><?= $R->title ?> by <?= $A->name ?></h1>

		<div class="release-container">
			<?= image("user_upload/" . $R->art . ".jpg") ?>
			<?php
				$stores = $R->getStores();
				for ($i = 0; $i < count($R->getStores()); $i++) { 
					$S = $stores[$i];
			?>
			<div class="store-container">
				<div class="store-container-name">
					<h2><?= Rel::store($S[0]) ?></h2>
				</div>
				<a href="<?= $S[1] ?>" onclick="store(<?= $S[0] ?>)"><div class="store-container-link">
					<h2><?= Rel::action($S[0]) ?></h2>
				</div></a>
			</div>
			<?php } ?>
		</div>
		<h4>Ⓟ <?= $R->label ?> <?= date("Y", $R->date) ?></h4>
	</div>

	<div class="bg-img" style="background-image: url('<?= BASEURL ?>/app/res/img/user_upload/<?= $R->art ?>.jpg');"></div>
</body>
</html>