<?php
	$A = User::get($a_id);
	$rels = Rel::sortByDate($A->getReleases());
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?= $name ?></title>
	<?= stylesheet("style.css") ?>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-8780979666437215",
		enable_page_level_ads: true
	});
	</script>
</head>
<body>
	<?php include 'include/header.php'; ?>

	<div class="profile-container">
		<h1 class="title"><?= $name ?></h1>
		<?= image("user_upload/" . $A->profile . ".jpg", ["width" => "200px"]) ?>
		<?php if ($A->id == Session::get("login_id")) { ?><br>
		<h4 class="link" onclick="window.location.href='edit'">Edit</h4>
		<?php } ?>
		<div class="main-content grid-container">
			<?php
				$pub_count = 0;
				for ($i = 0; $i < count($rels); $i++) {
					$R = $rels[$i];
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
		</div>
	</div>

	<?php include 'include/rest.php'; ?>
	<?= script("modal.js") ?>
	<?= script("rest.js") ?>
	<?= script("new_release.js") ?>
</body>
</html>