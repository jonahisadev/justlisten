<div class="home-release-container">
	<div class="home-release-col">
		<?= image("user_upload/" . $R->art . ".jpg", ["width" => "200"]) ?>
	</div>
	<div class="home-release-col">
		<h3><?= $R->title ?></h3>
		<p><?= Rel::type($R->release_type) ?></p>
		<p><?= $R->date ?></p>
		<p>Ⓟ <?= $R->label ?></p>
		<p>0 clicks</p>
	</div>
	<div class="home-release-col">
		<a class="btn-large" href="a/<?= $username ?>/<?= $R->url ?>">View</a>
	</div>
	<div class="home-release-col">
		<a class="btn-large" href="#">Edit</a>
	</div>
	<div class="home-release-col">
		<a class="btn-large" href="#">Delete</a>
	</div>
	<div class="home-release-col">
		<a class="btn-large" href="#">Stats</a>
	</div>
</div>