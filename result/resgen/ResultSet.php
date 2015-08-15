<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once("$root/utils/stylelink.php")
?>

<div class="searchitem">
	<?php
		require_once 'indres/generateResultItem.php';
		echo generateResultItem(0, 0, 0, 0, "SFW");
		for ($iterator = 0; $iterator < 50; ++$iterator)
			echo generateResultItem(0, rand(0, 300), rand(0, 25), rand(0, 150), "SFW");
	?>
</div>
