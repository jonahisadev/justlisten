<?php

const FLASH_RED = 0;
const FLASH_GREEN = 1;
const FLASH_GRAY = 2;

if (!function_exists("flash_message")) {
	function flash_message($type, $msg) {
		if ($type == FLASH_RED) {
			$color = "red";
		} else if ($type == FLASH_GREEN) {
			$color = "green";
		} else if ($type == FLASH_GRAY) {
			$color = "gray";
		}
?>
<div id="flash" class="center flash-msg <?= $color ?>">
	<h2 class="flash-x" onclick="document.getElementById('flash').parentNode.removeChild(document.getElementById('flash'))">×</h2>
	<h2><?=$msg?></h2>
</div>
<?php
	}
}

?>