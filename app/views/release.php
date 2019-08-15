<?php
$R = Rel::get($r_id);
$A = User::get($a_id);
include 'include/rest.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?= script("cookies.js") ?>
    <?= script("rest.js") ?>
    <?= script("release.js") ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $R->title ?> by <?= $A->name ?></title>

    <meta property="og:title" content="<?= $R->title ?> by <?= $A->name ?>">
    <meta property="og:description" content="Just Listen to <?= $R->title ?> by <?= $A->name ?>">
    <meta property="og:image" content="<?= CDN . $R->art ?>.jpg">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= INDEX ?>/a/<?= $A->username ?>/<?= $R->url ?>">
    <meta property="twitter:card" content="summary">
    <meta property="twitter:description" content="Just Listen to <?= $R->title ?> by <?= $A->name ?>">
    <meta property="twitter:title" content="<?= $R->title ?> by <?= $A->name ?>">
    <meta property="twitter:image" content="<?= CDN . $R->art ?>.jpg">

    <?php include 'include/favicon.php'; ?>
    <?= stylesheet("release.css") ?>
</head>

<body>
    <div class="content">
        <h1 class="title"><?= $R->title ?> by <a href="https://justlisten.me/a/<?= $A->username ?>"><?= $A->name ?></a></h1>

        <div class="release-container">
            <img src="<?= CDN . $R->art ?>.jpg">
            <?php
            $stores = $R->getStores();
            for ($i = 0; $i < count($R->getStores()); $i++) {
                $S = $stores[$i];
                ?>
                <div class="store-container">
                    <div class="store-container-name">
                        <h2><?= Rel::store($S[0]) ?></h2>
                    </div>
                    <a onclick="store(<?= $S[0] ?>, <?= $R->id ?>, '<?= $S[1] ?>')">
                        <div class="store-container-link">
                            <h2><?= Rel::action($S[0]) ?></h2>
                        </div>
                    </a>
                </div>
            <?php
        } ?>
        </div>
        <h4>Ⓟ <?= date("Y", $R->date) ?> <?= $R->label ?></h4>
    </div>

    <div class="bg-img" style="background-image: url('<?= CDN . $R->art ?>.jpg');"></div>
</body>

</html>