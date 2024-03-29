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

    <meta property="og:title" content="<?= $A->name ?>">
    <meta property="og:description" content="Just Listen to music by <?= $A->name ?>">
    <meta property="og:image" content="<?= CDN . $A->profile ?>.jpg">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= INDEX ?>/a/<?= $A->username ?>">
    <meta property="twitter:card" content="summary">
    <meta property="twitter:description" content="Just Listen to music by <?= $A->name ?>">
    <meta property="twitter:title" content="<?= $A->name ?>">
    <meta property="twitter:image" content="<?= CDN . $A->profile ?>.jpg">

    <title><?= $name ?></title>
    <?php include 'include/favicon.php'; ?>
    <?php include 'template/flash_msg.php'; ?>
    <?= stylesheet("style.css") ?>
</head>

<body>
    <?php include 'include/header.php'; ?>

    <div class="profile-container">
        <h1 class="title" style="margin-bottom: 5px; font-size: 36pt; margin-top: 20px;"><?= $name ?></h1>
        <?php if ($A->id == Session::get("login_id")) { ?>
        <h4 class="link" onclick="window.location.href='edit'" style="margin-top: 0px; margin-bottom: 10px;">Edit</h4>
        <?php 
    } else { ?>
        <br>
        <?php 
    } ?>

        <div class="profile-header">
            <img src="<?= CDN . $A->profile ?>.jpg" width="200px">
            <div class="profile-bio main-content">
                <p>
                    <?php if ($A->bio == null) { ?>
                    <i>No bio</i>
                    <?php 
                } else { ?>
                    <?= $A->bio ?>
                    <?php 
                } ?>
                </p>
                <div class="profile-socials-container">
                    <?php
                    $socials = $A->getSocials();
                    if ($socials != null) {
                        if (!empty($socials['ig'])) {
                            ?>
                    <a target="_blank" href="https://instagram.com/<?= $socials['ig'] ?>"><?= image("ig_logo.png") ?></a>
                    <?php 
                }
                if (!empty($socials['tw'])) { ?>
                    <a target="_blank" href="https://twitter.com/<?= $socials['tw'] ?>"><?= image("tw_logo.png") ?></a>
                    <?php 
                }
                if (!empty($socials['fb'])) { ?>
                    <a target="_blank" href="https://facebook.com/<?= $socials['fb'] ?>"><?= image("fb_logo.png") ?></a>
                    <?php	
                }
            }
            ?>
                </div>
            </div>
        </div>
        <br>
        <div class="main-content grid-container">
            <?php
            $pub_count = 0;
            for ($i = 0; $i < count($rels); $i++) {
                $R = $rels[$i];
                if ($R->privacy == Rel::PUB) {
                    ?>
            <div class="grid">
                <div class="grid-release-container">
                    <img src="<?= CDN . $R->art ?>.jpg" width="85%">
                    <a target="_blank" href="<?= BASEURL ?>/a/<?= $A->username ?>/<?= $R->url ?>">
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
    <?= script("artist.js") ?>
</body>

</html> 