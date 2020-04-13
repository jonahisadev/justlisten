<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Import Releases</title>
    <?php include 'include/rest.php'; ?>
    <?php include 'include/favicon.php'; ?>
    <?= stylesheet("style.css") ?>
</head>

<body>

    <?php include 'include/header.php'; ?>

    <div class="welcome center">
        <h1>Import Your Spotify Discography</h1>
    </div>

    <div class="main-content">
        <div class="spotify-form center" style="margin-top: 15px;">
            <input type="text" id="artist_id" style="width: 50%;" placeholder="Spotify Artist URI"><br>
            <input type="hidden" id="access_token" value="<?= $ACCESS ?>">
            <input class="btn-large" type="submit" id="send_spotify" value="Import">
        </div>
        <div id="spotify-artist-info" class="center"></div>
        <div id="spotify-releases"></div>
        <div id="spotify-save" class="center" style="margin-top: 15px;" hidden>
            <input id="privacy-check" type="checkbox">Make releases private<br>

            <div id="progress">
                <div id="pbar"></div>
            </div>

            <input id="save-btn" class="center btn-large" value="Save" style="margin-top: 15px;">
        </div>
    </div>

    <?= csrf_field() ?>
    <?= script("rest.js") ?>
    <?= script("classifier.js") ?>
    <?= script("spotify.js") ?>

</body>

</html> 