<form action="<?= $action ?>" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="main-content">
        <div class="split-container">
            <div class="new-release-left">
                <div class="center">
                    <h4 class="link" style="margin-top: 0px; margin-bottom: 5px;" onclick="showModal('art-modal')">Art Requirements</h4><br>
                    <?= image("default.jpg", ["id" => "art-img", "width" => "200", "class" => "img-upload", "onclick" => "selectFile()"]) ?>
                    <input type="file" name="art" id="art" accept="image/jpeg" hidden>
                </div>

                <div class="input-container">
                    <h3>Title</h3>
                    <input type="text" id="title" name="title" placeholder="Release Title" value="<?= $title ?>" required />
                </div><br>

                <div class="input-container">
                    <h3>URL Slug</h3>
                    <input type="text" id="url" name="url" placeholder="https://justlisten.me/<?= $A->username ?>/url-slug" value="<?= $url ?>" required />
                </div><br>

                <div class="input-container">
                    <h3>Release Date</h3>
                    <input type="date" id="date" name="date" placeholder="YYYY-MM-DD" value="<?= $date ?>" required />
                </div><br>

                <div class="input-container">
                    <h3>P-Line</h3>
                    <input type="text" id="label" name="label" placeholder="Label name or your artist name" value="<?= $label ?>" required />
                </div><br>

                <div class="input-container">
                    <h3 style="margin: 0;">Release Type</h3>
                    <select name="type" id="type">
                        <option value="0" <?php if ($type == 0) { ?> selected <?php } ?>></option>
                        <option value="1" <?php if ($type == 1) { ?> selected <?php } ?>>Single</option>
                        <option value="2" <?php if ($type == 2) { ?> selected <?php } ?>>EP</option>
                        <option value="3" <?php if ($type == 3) { ?> selected <?php } ?>>Album</option>
                        <option value="4" <?php if ($type == 4) { ?> selected <?php } ?>>Compilation</option>
                    </select>
                </div><br>

                <div class="input-container">
                    <h3 style="margin: 0;">Privacy</h3>
                    <select name="privacy" id="privacy">
                        <option value="0" <?php if ($privacy == 0) { ?> selected <?php } ?>></option>
                        <option value="1" <?php if ($privacy == 1) { ?> selected <?php } ?>>Private</option>
                        <option value="2" <?php if ($privacy == 2) { ?> selected <?php } ?>>Public</option>
                    </select><br>
                    <h5 style="float: right; margin: 0;">Private releases are <i>NOT</i> shown on your profile</h5>
                </div>
            </div>

            <div id="store-container" class="new-release-right">
                <h3 class="plus" id="plus" onclick="addStore()">+</h3>
            </div>

        </div>
        <div class="new-release-submit center">
            <input type="hidden" name="store-count" id="store-count" value="1" />
            <?= csrf_field() ?>
            <?php if ($action == "create") { ?>
                <input type="submit" class="btn-large" value="Create Release" />
            <?php
        } else { ?>
                <input type="submit" class="btn-large" value="Save Release" />
            <?php
        } ?>
        </div>
    </div>
</form>

<div class="modal" id="art-modal">
    <div class="modal-content center">
        <h1>Art Requirements</h1>
        <div style="text-align: left; width: 50%; margin-left: 25%;">
            <ul>
                <h2>
                    <li>Must be a square image</li>
                </h2>
                <h2>
                    <li>File size must less than 2MB</li>
                </h2>
                <h2>
                    <li>Image type must be JPEG (jpg, jpeg)</li>
                </h2>
            </ul>
        </div>
    </div>
</div>