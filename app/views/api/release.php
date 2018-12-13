<?php

	$R = Rel::get($r_id);
	header("Content-Type: application/json");

?>

{
	"id": <?= $R->id ?>,
	"art": "<?= $R->art ?>",
	"title": "<?= $R->title ?>",
	"url": "<?= $R->url ?>",
	"date": "<?= $R->getJSDate() ?>",
	"label": "<?= $R->label ?>",
	"release_type": <?= $R->release_type ?>,
	"privacy": <?= $R->privacy ?>,
	"stores": [
		<?php
			$stores = $R->getStores();
			for ($i = 0; $i < count($stores); $i++) {
				$S = $stores[$i];
		?>
		{ "name": "<?= $S[0] ?>", "link": "<?= $S[1] ?>" }<?php if ($i != count($stores)-1) { ?>,<?php } ?>
		<?php
			}
		?>
	]
}