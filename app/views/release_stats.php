<?php
	$A = User::get($a_id);
	$R = Rel::get($r_id);

	$S = $R->getStats();

	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Release Stats</title>
	<?= stylesheet("style.css") ?>
</head>
<body>
	<?php include 'include/header.php'; ?>
	<h1 class="center"><u><?= $R->title ?></u></h1>
	<div class="center">
		<?= image("user_upload/" . $R->art . ".jpg", [
			"width" => "200", "class" => "stat-img"
		]) ?>
	</div>

	<div class="main-content">
		<div class="center">
			<h2><span style="color: #57E34F;"><?= $S[Stat::CLICKS] ?></span> Total Clicks</h2>
		</div>
		<div class="split-container" style="padding: 0px;">
			<div class="split-left center">
				<h2>Stores</h2>
				<div class="stat-container">
				<?php
					$arr = array_slice($S, Stat::STORE_START + 1, (Stat::STATS_ARRAY_SIZE - Stat::STORE_START), true);
					arsort($arr);
					foreach ($arr as $key => $clicks) {
						if ($clicks == 0) {
							break;
						}
						echo('<h3 class="stat">' . Stat::getStore($key));
						echo('<span style="float: right;">' . $clicks . '</span></h3><br>');
					}
				?>
				</div>
				<br>
				<h2>Operating Systems</h2>
				<div class="stat-container">
					<?php
					$arr = array_slice($S, Stat::OS_START + 1, (Stat::OTHER_OS - Stat::OS_START), true);
					arsort($arr);
					foreach ($arr as $key => $clicks) {
						if ($clicks == 0) {
							break;
						}
						echo ('<h3 class="stat">' . Stat::getOS($key));
						echo ('<span style="float: right;">' . $clicks . '</span></h3><br>');
					}
					?>
				</div>
			</div>
			<div class="split-right center">
				<h2>Browsers</h2>
				<div class="stat-container">
					<?php
					$arr = array_slice($S, Stat::BROWSER_START + 1, (Stat::OTHER_BROWSER - Stat::BROWSER_START), true);
					arsort($arr);
					foreach ($arr as $key => $clicks) {
						if ($clicks == 0) {
							break;
						}
						echo ('<h3 class="stat">' . Stat::getBrowser($key));
						echo ('<span style="float: right;">' . $clicks . '</span></h3><br>');
					}
				?>
				</div>
				<br>
				<h2>Devices</h2>
				<div class="stat-container">
					<?php
					$arr = array_slice($S, Stat::PLATFORM_START + 1, (Stat::OTHER_PLATFORM - Stat::PLATFORM_START), true);
					arsort($arr);
					foreach ($arr as $key => $clicks) {
						if ($clicks == 0) {
							break;
						}
						echo ('<h3 class="stat">' . Stat::getPlatform($key));
						echo ('<span style="float: right;">' . $clicks . '</span></h3><br>');
					}
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>