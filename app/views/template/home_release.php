<div class="home-release-container" id="<?= $username ?>/<?= $R->url ?>">
	<div class="home-release-col">
		<img src="<?= CDN . $R->art ?>.jpg" class="home-release-img">
	</div>
	<div class="home-release-col">
		<h3><?= $R->title ?> <?php if ($R->privacy == Rel::PRIV) { ?> <b style="color: red;">[PRIVATE]</b> <?php } ?></h3>
		<p><?= Rel::type($R->release_type) ?></p>
		<p><?= $R->getDate() ?></p>
		<p>Ⓟ <?= $R->label ?></p>
		<p><?= $R->getStats()[Stat::CLICKS] ?> clicks</p>
	</div>
	<div class="home-release-col">
		<a class="btn-large" href="../a/<?= $username ?>/<?= $R->url ?>">View</a>
	</div>
	<div class="home-release-col">
		<a class="btn-large" href="../a/<?= $username ?>/<?= $R->url ?>/edit">Edit</a>
	</div>
	<div class="home-release-col">
		<a class="btn-large" onclick="showShare(<?= $i ?>);">Share</a>
	</div>
	<div class="home-release-col">
		<a class="btn-large" href="../a/<?= $username ?>/<?= $R->url ?>/stats">Stats</a>
	</div>
	<div class="modal" id="share-modal-<?= $i ?>">
		<div class="modal-content center">
			<h1>Share <u><?= $R->title ?></u></h1>
			<input type="text" id="share-link-<?= $i ?>" value="https://jstlstn.me/<?= $R->link ?>" style="width: 50%;" />
		</div>
	</div>
</div>