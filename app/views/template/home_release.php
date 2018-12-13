<div class="home-release-container" id="<?= $username ?>/<?= $R->url ?>">
	<div class="home-release-col">
		<?= image("user_upload/" . $R->art . ".jpg", ["width" => "200"]) ?>
	</div>
	<div class="home-release-col">
		<h3><?= $R->title ?> <?php if ($R->privacy == Rel::PRIV) { ?> <b style="color: red;">[PRIVATE]</b> <?php } ?></h3>
		<p><?= Rel::type($R->release_type) ?></p>
		<p><?= $R->getDate() ?></p>
		<p>Ⓟ <?= $R->label ?></p>
		<p>0 clicks</p>
	</div>
	<div class="home-release-col">
		<a class="btn-large" href="a/<?= $username ?>/<?= $R->url ?>">View</a>
	</div>
	<div class="home-release-col">
		<a class="btn-large" href="a/<?= $username ?>/<?= $R->url ?>/edit">Edit</a>
	</div>
	<div class="home-release-col">
		<a class="btn-large" onclick="deleteRelease('<?= $username ?>/<?= $R->url ?>')">Delete</a>
	</div>
	<div class="home-release-col">
		<a class="btn-large" href="#">Stats</a>
	</div>
</div>