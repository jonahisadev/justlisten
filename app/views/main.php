<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Just Listen</title>
    <?php include 'include/favicon.php'; ?>
    <?= stylesheet("main.css") ?>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-8780979666437215",
            enable_page_level_ads: true
        });
    </script>
</head>

<body>

    <div class="header">
        <h1>Just Listen</h1>
        <?php if (Session::has("login_id")) { ?>
        <h3>Hey <?= Session::get("login_name") ?>, here's your <a href="<?= INDEX ?>/dashboard">Dashboard</a></h3>
        <?php 
	} else { ?>
        <h3>Already a member? <a href="<?= INDEX ?>/dashboard">Login</a></h3>
        <?php 
	} ?>
    </div>

    <div class="parallax one">
        <div class="parallax-text">
            <h1>Just Listen</h1>
        </div>
    </div>

    <div class="container">
        <div class="container-copy">
            <h1>All Of Your Music In One Place</h1>
            <p>
                Stop linking to all of your music profiles. Take all of your fans to one place.
                Don't worry about keeping track of all your platforms. Let your fans Just Listen.
            </p>
        </div>
        <?= image("ss-1.png") ?>
    </div>

    <div class="parallax two">
        <div class="parallax-text">
            <h1>Easy Interface</h1>
        </div>
    </div>

    <div class="container">
        <div class="container-copy">
            <h1>No Lag. Pure Speed.</h1>
            <p>
                Some websites have frustratingly laggy interfaces. We want you to get your music ready
                as soon as possible, as easily as possible. We don't want you to dread setting up
                your landing pages. So don't.
            </p>
        </div>
        <?= image("ss-2.png") ?>
    </div>

    <div class="parallax three">
        <div class="parallax-text">
            <h1>Beautiful Landing Pages</h1>
        </div>
    </div>

    <div class="container">
        <div class="container-copy">
            <h1>Simple to Use and Great to Look At</h1>
            <p>
                Send your fans to beautiful landing pages. Regardless of desktop or mobile usage,
                your fans will love to come back to your profile for more.
            </p>
        </div>
        <?= image("ss-3.png") ?>
    </div>

    <div class="parallax four">
        <div class="parallax-text">
            <h1>It Gets Better</h1>
        </div>
    </div>

    <div class="container">
        <h1>Extra Features You'll Love</h1>
        <div class="container-three">
            <div class="row">
                <h2>Remember Platforms</h2>
                <p>
                    By default, Just Listen remembers the specific platform your fans use. Once a fan
                    of yours goes to a platform through your landing pages, Just Listen remembers, and
                    the next time they click on a release, Just Listen skips the landing page, and takes
                    them straight to their favorite platform!
                </p>
            </div>
            <div class="row">
                <h2>Easy Stats</h2>
                <p>
                    Yeah fancy graphs and charts are cool, but even with modern technology, they slow down
                    your browser. Get your stats immediately with no loading screens at Just Listen. Find
                    your most popular platforms, devices, and browsers to aid in your marketing!
                </p>
            </div>
            <div class="row">
                <h2>Link Shortening</h2>
                <p>
                    Every release automatically comes with a short link. If you need less characters in your URL,
                    get your release's short link from the share button on your dashboard!
                </p>
            </div>
        </div>

        <!-- <h1>So How Does That Sound?</h1> -->
        <?php if (!Session::has("login_id")) { ?>
        <a class="btn-large" href="<?= INDEX ?>/dashboard">Sign Me Up!!</a>
        <?php 
	} else { ?>
        <a class="btn-large" href="<?= INDEX ?>/dashboard">Dashboard</a>
        <?php 
	} ?>
    </div>

    <div class="footer">
        <h3>© 2019 Just Listen</h3>
    </div>

</body>

</html> 