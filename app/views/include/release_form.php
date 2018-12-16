<form action="<?= $action ?>" method="post" enctype="multipart/form-data" autocomplete="off">
	<div class="main-content">
		<div class="split-container">
			<div class="new-release-left">
				<div class="center">
					<?= image("default.jpg", ["id" => "art-img", "width" => "200", "class" => "img-upload", "onclick" => "selectFile()"]) ?>
					<input type="file" name="art" id="art" hidden>
				</div>

				<input type="text" id="title" name="title" placeholder="Title" />
				<input type="text" id="url" name="url" placeholder="URL" />
				<input type="date" id="date" name="date" placeholder="Release Date" />
				<input type="text" id="label" name="label" placeholder="Label" />
				<select name="type" id="type">
					<option value="0">Release Type</option>
					<option value="1">Single</option>
					<option value="2">EP</option>
					<option value="3">Album</option>
					<option value="4">Compilation</option>
				</select>
				<select name="privacy" id="privacy">
					<option value="0">Privacy</option>
					<option value="1">Private</option>
					<option value="2">Public</option>
				</select>
			</div>

			<div class="new-release-right">
				<div class="store" id="store-1">
					<select name="store-type-1" id="store-type-1">
						<option value="0">Store</option>
						<?php include 'stores.php' ?>
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
			<?php if ($action == "create") { ?>
			<input type="submit" class="btn-large" value="Submit" />
			<?php } else { ?>
			<input type="submit" class="btn-large" value="Save" />
			<?php } ?>
		</div>
	</div>
</form>