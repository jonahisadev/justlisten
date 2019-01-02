<form action="<?= $action ?>" method="post" enctype="multipart/form-data" autocomplete="off">
	<div class="main-content">
		<div class="split-container">
			<div class="new-release-left">
				<div class="center">
					<h4 class="link" style="margin-top: 0px; margin-bottom: 5px;" onclick="showModal('art-modal')">Art Requirements</h4><br>
					<?= image("default.jpg", ["id" => "art-img", "width" => "200", "class" => "img-upload", "onclick" => "selectFile()"]) ?>
					<input type="file" name="art" id="art" accept="image/jpeg" hidden>
				</div>

				<input type="text" id="title" name="title" placeholder="Title" value="<?=$title?>" required/>
				<input type="text" id="url" name="url" placeholder="URL" value="<?=$url?>" required/>
				<input type="date" id="date" name="date" placeholder="Release Date" value="<?=$date?>" required/>
				<input type="text" id="label" name="label" placeholder="P-Line" value="<?=$label?>" required/>
				<select name="type" id="type">
					<option value="0" <?php if ($type == 0) { ?> selected <?php } ?>>Release Type</option>
					<option value="1" <?php if ($type == 1) { ?> selected <?php } ?>>Single</option>
					<option value="2" <?php if ($type == 2) { ?> selected <?php } ?>>EP</option>
					<option value="3" <?php if ($type == 3) { ?> selected <?php } ?>>Album</option>
					<option value="4" <?php if ($type == 4) { ?> selected <?php } ?>>Compilation</option>
				</select>
				<select name="privacy" id="privacy">
					<option value="0" <?php if ($privacy == 0) { ?> selected <?php } ?>>Privacy</option>
					<option value="1" <?php if ($privacy == 1) { ?> selected <?php } ?>>Private</option>
					<option value="2" <?php if ($privacy == 2) { ?> selected <?php } ?>>Public</option>
				</select>
			</div>

			<div class="new-release-right">
				<div class="store" id="store-1">
					<select class="store-type" name="store-type-1" id="store-type-1">
						<option value="0">Store</option>
						<?php include 'stores.php' ?>
					</select>
					<input class="store-link" type="text" name="store-link-1" id="store-link-1" placeholder="Link" required/>
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

<div class="modal" id="art-modal">
	<div class="modal-content center">
		<h1>Art Requirements</h1>
		<div style="text-align: left; width: 50%; margin-left: 25%;">
			<ul>
				<h2><li>Must be a square image</li></h2>
				<h2><li>File size must less than 2MB</li></h2>
				<h2><li>Image type must be JPEG (jpg, jpeg)</li></h2>
			</ul>
		</div>
	</div>
</div>