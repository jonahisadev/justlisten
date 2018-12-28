<?php

const FLASH_RED = 0;
const FLASH_GREEN = 1;

function flash_message($type, $msg) {
?>
<div id="flash" class="center flash-msg <?php if ($type == FLASH_RED) { ?>red<?php } else { ?>green<?php } ?>">
	<h2 class="flash-x" onclick="document.getElementById('flash').parentNode.removeChild(document.getElementById('flash'))">×</h2>
	<h2><?=$msg?></h2>
</div>
<?php
}

?>